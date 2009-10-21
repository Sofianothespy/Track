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

require_once(OWA_BASE_DIR.'/owa_lib.php');
require_once(OWA_BASE_DIR.'/owa_view.php');
require_once(OWA_BASE_DIR.'/owa_reportController.php');

/**
 * Anchortext Report Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_reportAnchortextController extends owa_reportController {
	
	function owa_reportAnchortextController($params) {
		
		$this->owa_reportController($params);
		$this->priviledge_level = 'viewer';
		
		return;
	}
	
	function action() {
		
		$data = array();
		
		$data['params'] = $this->params;
		
		// Load the core API
		$api = &owa_coreAPI::singleton($this->params);
		
		$data['top_anchors'] = $api->getMetric('base.topReferingAnchors', array(
	
			'constraints'		=> array('site_id'	=> $this->params['site_id']),
			'limit'				=> 30
		
		));
		
		$data['summary_stats_data'] = $api->getMetric('base.dashCountsTraffic', array(
		
			'result_format'		=> 'single_row',
			'constraints'		=> array('site_id'	=> $this->params['site_id'],
										'referer.is_searchengine' => array('operator' => '!=', 'value' => true),
										'session.source' => array('operator' => '=', 'value' => ''),
										'session.referer_id' => array('operator' => '!=', 'value' => '0'))
										
		
		));
		
		$data['view'] = 'base.report';
		$data['subview'] = 'base.reportAnchortext';
		$data['view_method'] = 'delegate';
		$data['nav_tab'] = 'base.reportTraffic';
		
		return $data;
		
	}
}


/**
 *  Anchortext Report View
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_reportAnchortextView extends owa_view {
	
	function owa_reportAnchortextView() {
		
		$this->owa_view();
		$this->priviledge_level = 'view';
		
		return;
	}
	
	function construct($data) {
		
		// Assign Data to templates
		
		$this->body->set('headline', 'Inbound Link Text');
		
		$this->body->set('anchors', $data['top_anchors']);
		$this->body->set('summary_stats', $data['summary_stats_data']);
	
		
		$this->body->set_template('report_anchortext.tpl');
		
		return;
	}
	
	
}


?>