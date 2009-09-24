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

require_once(OWA_BASE_DIR.'/owa_view.php');
require_once(OWA_BASE_DIR.'/owa_reportController.php');

/**
 * Dashboard Report Spy Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_reportDashboardSpyController extends owa_reportController {

	function owa_reportDashboardSpyController($params) {
			
		return  owa_reportDashboardSpyController::__construct($params);
	}
	
	function __construct($params) {
	
		return parent::__construct($params);
	}
	
	function action() {
				
		$this->setTitle('Latest Visits Spy');
		//$this->setView('base.report';
		$this->setSubview('base.reportDashboardSpy');	
		
		return;	
		
	}
	
}
		
/**
 * View
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_reportDashboardSpyView extends owa_view {
	
	function owa_reportDashboardSpyView() {		
		
		return owa_reportDashboardSpyView::__construct();
	}
	
	function __construct() {
	
		return parent::__construct();
	}
	
	function construct($data) {
				
		// load body template
		
		$this->body->set_template('report_dashboard_spy.tpl');		
		
		//$this->setJs('includes/jquery/jquery.js');
		$this->setJs('includes/jquery/spy.js');
		$this->setJs('owa.spy.js');
				
		return;
	}
	
	
}


?>