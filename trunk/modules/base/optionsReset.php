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

require_once(OWA_BASE_CLASSES_DIR.'owa_adminController.php');

/**
 * Options Reset Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_optionsResetController extends owa_adminController {
	
	function owa_optionsResetController($params) {
		$this->owa_adminController($params);
		$this->priviledge_level = 'admin';
		
		return;
	}

	function action() {
		
		$config = owa_coreAPI::entityFactory('base.configuration');
		
		$config->getByPk('id', $this->c->get('base', 'configuration_id'));
		
		$settings = unserialize($config->get('settings'));
		
		if (!empty($settings)):
		
			$settings['base'] = array();
			$config->set('settings', serialize($settings));
			$config->update();
		endif;
		
		$this->e->notice($this->getMsg(2503));
	
		$data = array();
		
		$data['do'] = 'base.optionsGeneral';
		$data['view_method'] = 'redirect';
		//$data['configuration'] = $nbsettings;
		$data['status_code'] = 2503;
		
		return $data;
	
	}
	
}


?>