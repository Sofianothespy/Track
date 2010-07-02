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
 * Feeds Report Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_reportFeedsController extends owa_reportController {
		
	function action() {
	
		$this->set('metrics', 'feedReaders');
		$this->set('resultsPerPage', 30);
		$this->set('trendChartMetric', 'feedReaders');
		$this->set('trendTitle', 'There were <%= this.d.resultSet.aggregates.feedReaders.value %> readers of all feeds.');
		$this->set('dimensions', 'feedType');	
		// view stuff
		$this->setView('base.report');
		$this->setSubview('base.reportFeeds');
		$this->setTitle('Feeds');	
	}
}

/**
 * Feeds Report View
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_reportFeedsView extends owa_view {
	
	function render($data) {
	
		// Assign Data to templates
	
		$this->body->set('feed_trend', $this->get('feed_trend'));
		$this->body->set('feed_counts', $this->get('feed_counts'));
		$this->body->set('feed_chart_data', $this->get('feed_chart_data'));
		$this->body->set_template('report_feeds.tpl');
	}	
}

?>