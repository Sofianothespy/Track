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

require_once(OWA_BASE_DIR.'/owa_reportController.php');
require_once(OWA_BASE_DIR.'/owa_view.php');

if (!class_exists('Services_JSON')) {
	require_once(OWA_INCLUDE_DIR.'JSON.php');
}


/**
 * Overlay Report Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_getDomstreamController extends owa_reportController {

	function action() {
		
		// Fetch document object
		$d = owa_coreAPI::entityFactory('base.domstream');
		$d->load($this->getParam('domstream_id'));
		$json = new Services_JSON();
		$d->set('events', $json->decode($d->get('events')));
		$this->set('json', $d->_getProperties());
		// set view stuff
		$this->setView('base.json');	
	}
}

?>