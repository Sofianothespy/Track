<?php

//
// Open Web Analytics - An Open Source Web Analytics Framework
//
// Copyright 2006 Peter Adams. All rights reserved.
//
// Licensed under GPL v2.0 http://www.gnu.org/copyleft/gpl.html
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// $Id$
//

if(!class_exists('owa_observer')) {
	require_once(OWA_DIR.'owa_observer.php');
}	

/**
 * Conversion Event handlers
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.4.0
 */

class owa_conversionHandlers extends owa_observer {
    	
    /**
     * Notify Event Handler
     *
     * @param 	unknown_type $event
     * @access 	public
     */
    function notify($event) {
		
		$update = false;
		$conversion_info = $this->checkForConversion($event);
		
		if ($conversion_info) {
	    	$s = owa_coreAPI::entityFactory('base.session');
			
			$new_id = $s->generateId(trim( strtolower( $event->get('campaign') ) ) );
			$s->getByPk('id', $event->get('session_id'));
			$id = $s->get('id'); 
			
			// only record one goal of a particular type per session
			if ($id) {
				//record conversion
				if ( !empty( $conversion_info['conversion'] ) ) {
					$goal_column = 'goal_'.$conversion_info['conversion'];
					$already = $s->get( $goal_column );
					if ( $already != true )	{
						// there is a goal conversion					
						$s->set( $goal_column , true );
						owa_coreAPI::debug( "$goal_column was achieved." );
					} else {
						owa_coreAPI::debug( 'Not updating session. Goal was already achieved in same session.' );
						return OWA_EHS_EVENT_HANDLED;
					}
					
					// set goal value
					$goal_value_column = 'goal_'.$conversion_info['conversion'].'_value';
					$value = '';
					
					// pull dynamic value from commerce transaction total if set otherwise
					// use static value 
					if ( $event->get('ct_total' ) ) {
						$value = $event->get( 'ct_total' );
					} else {
						$value = $conversion_info['value'];
					}
					$existing_value = $s->get( $goal_value_column );
					// Allow a value to be set if one has not be set already.
					// this is needed to support dynamic values passed by commerce transaction events
					if ( ! empty( $value ) && empty( $existing_value ) ) {
						$s->set( $goal_value_column, owa_lib::prepareCurrencyValue( $value ) );
						$update = true;
					}	
				}
				//record goal start
				if ( !empty($conversion_info['start'] ) ) {
					$goal_start_column = 'goal_'.$conversion_info['start'].'_start';
					$already_started = $s->get( $goal_start_column );
					
					if ( $already_started != true ) {
						
						$s->set( $goal_start_column, true );
						$update = true;
						owa_coreAPI::debug( "$goal_start_column was started." );
						
					} else {
						owa_coreAPI::debug( "$goal_start_column was already started." );
					}
				}
				
				//update object
				if ( $update ) {
					
					// summarize goal conversions
					$s->set('num_goals', $this->countGoalConversions($s));
				
					// summarize goal conversion value
					$s->set('goals_value', $this->sumGoalValues($s));
				
					// summarize goal starts
					$s->set('num_goal_starts', $this->countGoalStarts($s));
				
					$ret = $s->update();
					if ( $ret ) {
						// create a new_conversion event so that the total conversion 
						// metrics can be resummarized
						$dispatch = owa_coreAPI::getEventDispatch();
						$ce = $dispatch->makeEvent( 'new_conversion' );
						$ce->set( 'session_id', $event->get( 'session_id' ) );
						$dispatch->asyncNotify( $ce );
						return OWA_EHS_EVENT_HANDLED;
					} else {
						return OWA_EHS_EVENT_FAILED;
					}
											
				} else {
					return OWA_EHS_EVENT_HANDLED;
				}
				
			} else {
				owa_coreAPI::debug("Conversion processing aborted. No session could be found.");
				return OWA_EHS_EVENT_FAILED;
			}
				
		} else {
			owa_coreAPI::debug('No goal start or conversion detected.');
			return OWA_EHS_EVENT_HANDLED;
		}
    }
        
    function checkForConversion($event) {
    
    	$goal_info = array('conversion' => '', 'value' => '', 'start' => '');
    	$goals = owa_coreAPI::getSetting('base', 'goals');
    	
    	if (empty($goals)) {
    		return;
    	}
    	
    	$is_match = false;
    	
    	foreach ($goals as $num => $goal) {
    		
    		if (!empty($goal)) {
    			
    			if (array_key_exists('goal_status', $goal) && $goal['goal_status'] === 'active') {
    				switch ($goal['goal_type']) {
		    			
		    			case 'url_destination':
		    				
		    				$match = $this->checkUrlDestinationGoal($event, $goal);
		    				$start = $this->checkGoalStart($event, $goal);
		    				break;
		    				
		    			case 'pages_per_visit':
		    				
		    				$match = $this->checkPagesPerVisitGoal($event, $goal);
		    				break;
		    				
		    			case 'visit_duration':
		    				
		    				$match = $this->checkPagesPerVisitGoal($event, $goal);
		    				break;
		    		}
		    		
		    		if ($match) {
		    			$goal_info['conversion'] = $match;
		    		}
		    		
		    		if ($start) {
		    			$goal_info['start'] = $start;
		    		}
		    		
		    		//check for dynamic value from commerce transaction
		    		$commerce = $event->get( 'commerce_transaction' );
		    		if ($commerce) {
		    			$goal_value =  $commerce['total_amount'];
		    		} else {
		    			// else just use the static value if one is set.
		    			if ( array_key_exists('goal_value', $goal) ) {
		    				$goal_value = $goal['goal_value'];
		    			}			
		    		}
		    		
		    		$goal_info['value'] = $goal_value;
    			} else {
    				owa_coreAPI::debug("Goal $num not active.");
    			}
	    	}
    	}
    	owa_coreAPI::debug('conversion info: '.print_r($goal_info, true));
    	return $goal_info;
    }
    
    function checkPagesPerVisitGoal($event, $goal) {
    	
    	$num = $event->get('npvs');
	    $operator = $goal['details']['operator'];
	    $req = $goal['details']['num_pageviews'];
	    
	    switch ($operator) {
	    	
	    	case '=':
	    		 if ($num === $req) {
	    		 	return $goal['goal_number'];
	    		 }
	    		 		
	    	case '<':
	    		if ($num < $req) {
	    		 	return $goal['goal_number'];
	    		 }
	    		
	    	case '>':
	    		if ($num > $req) {
	    		 	return $goal['goal_number'];
	    		 }
	    }
	    
	    return false;
    }
    
    function checkVisitDurationGoal($event, $goal) {
    	
    	$num = $event->get('session_duration');
	    $operator = $goal['details']['operator'];
	    $req = $goal['details']['duration'];
	    
	    switch ($operator) {
	    	
	    	case '=':
	    		 if ($num === $req) {
	    		 	return $goal['goal_number'];
	    		 }
	    		 		
	    	case '<':
	    		if ($num < $req) {
	    		 	return $goal['goal_number'];
	    		 }
	    		
	    	case '>':
	    		if ($num > $req) {
	    		 	return $goal['goal_number'];
	    		 }
	    }
	    
	    return false;
    }
    
    function checkUrlDestinationGoal($event, $goal) {
    	$match = '';
    	$page_uri = $event->get('page_uri');
	    				
		switch ($goal['details']['match_type']) {
			
			case 'exact':
				
				if ( $page_uri === $goal['details']['goal_url'] ) {
					$match = $goal['goal_number'];
				}	
				break;
			
			case 'begins':
				
				$length = strlen( $goal['details']['goal_url'] );
				$check = strpos( $page_uri, $goal['details']['goal_url']);
				if ( $check === 0 ) {
					$match = $goal['goal_number']; 
				}
				break;
				
			case 'regex':
				
				$pattern = sprintf('@%s@i', $goal['details']['goal_url']);
				$check = preg_match( $pattern, $page_uri );
				if ( $check > 0 ) {
					$match = $goal['goal_number'];
				}
				break;
		}
		
		return $match;
    }
    
    function checkGoalStart($event, $goal) {
		$page_uri = $event->get('page_uri');    	
    	// check for goal start
		if ( array_key_exists( 'funnel_steps', $goal['details'] ) ) {
			// check the first step
			$step = $goal['details']['funnel_steps'][1];
			$pattern = sprintf('@%s@i', $step['url']);
			$check = preg_match($pattern, $page_uri );
			if ($check > 0) {
				return $goal['goal_number'];
			}
		}
    }
    
    function countGoalConversions($session) {
    	
    	$goals = owa_coreAPI::getSetting('base', 'goals');
    	$num = count($goals);
    	$count = 0;
    	for ($i = 0;$i < $num;$i++) {
    		$col_name = 'goal_'.$i;
    		$count = $count + $session->get($col_name);
    		
    	}
    	owa_coreAPI::debug('session total goal count: '.$count);
    	return $count;
    }
	
	function countGoalStarts($session) {
	
		$goals = owa_coreAPI::getSetting('base', 'goals');
    	$num = count($goals);
    	$count = 0;
    	for ($i = 0;$i < $num;$i++) {
    		$col_name = 'goal_'.$i.'_start';
    		$count = $count + $session->get($col_name);
    	}
    	owa_coreAPI::debug('session total goal starts: '.$count);
    	return $count;
    }
    
    function sumGoalValues($session) {
    	
    	$goals = owa_coreAPI::getSetting('base', 'goals');
    	$num = count($goals);
    	$sum = 0;
    	for ($i = 0;$i < $num;$i++) {
    		$col_name = 'goal_'.$i.'_value';
    		$sum = $sum + $session->get($col_name);
    	}
    	owa_coreAPI::debug('session total goal value: '.$sum);
    	return $sum;
    }
}

?>