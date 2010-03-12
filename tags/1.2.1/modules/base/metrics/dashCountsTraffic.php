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

/**
 * Dashboard Count Metrics
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_dashCountsTraffic extends owa_metric {
	
	function owa_dashCountsTraffic($params = null) {
		
		return owa_dashCountsTraffic::__construct($params);
		
	}
	
	function __construct($params) {
	
		return parent::__construct($params);
	}
	
	function calculate() {
		
		$this->db->selectColumn("count(distinct session.visitor_id) as unique_visitors, 
								 sum(session.is_new_visitor) as new_visitor, 
								 sum(session.is_repeat_visitor) as repeat_visitor,
								 count(session.id) as sessions, 
							     sum(session.num_pageviews) as page_views,
							     (sum(session.num_pageviews) / count(session.id)) as pages_per_visit");
									
		$this->db->selectFrom('owa_session', 'session');
		
		$this->db->join(OWA_SQL_JOIN_LEFT_OUTER, 'owa_referer', 'referer', 'referer_id', 'referer.id');		

		$ret = $this->db->getOneRow();
		
		$ret = $this->zeroFill($ret);

		return $ret;
		
	}
	
	
}


?>