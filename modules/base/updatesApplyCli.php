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
 * Updates Application Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_updatesApplyCliController extends owa_cliController {
	
	function __construct($params) {
		define('OWA_UPDATING', true);
		return parent::__construct($params);
	}

	function action() {
		
		// fetch list of modules that require updates
		$s = &owa_coreAPI::serviceSingleton();
		
		if ($this->isParam('listpending')) {
			
			return $this->listPendingUpdates();
		}
		
		if ($this->getParam('apply')) {
			
			return $this->apply($this->get('apply'));
		}
		
		if ($this->getParam('rollback')) {
			
			return $this->rollback($this->get('rollback'));
		}
		
		$modules = $s->getModulesNeedingUpdates();
		//print_r($modules);
		//return;
		
		// foreach do update in order
		
		$error = false;
		
		foreach ($modules as $k => $v) {
		
			$ret = $s->modules[$v]->update();
			
			if ($ret != true):
				$error = true;
				break;
			endif;
		
		}
		
		if ($error === true):
			$this->set('error_msg', $this->getMsg(3307));
			$this->setView('base.error');
			$this->setViewMethod('delegate');			
		else:
			
			// add data to container
			$this->set('status_code', 3308);
			$this->set('do', 'base.optionsGeneral');
			$this->setViewMethod('redirect');
		 
		endif;		
		
		return;
	
	
	}
	
	function listPendingUpdates() {
		
		$s = &owa_coreAPI::serviceSingleton();
		$modules = $s->getModulesNeedingUpdates();
		if ($modules) {
			echo sprintf("Updates pending include: %s",print_r($modules, true));
		} else {
			echo "No updates pending";
		}
	}
	
	function apply($update) {
	
		list($module, $seq) = explode('.', $update);
		$u = owa_coreAPI::updateFactory($module, $seq);
		$u->apply();
	}
	
	function rollback($update) {
		list($module, $seq) = explode('.', $update);
		$u = owa_coreAPI::updateFactory($module, $seq);
		$u->rollback();
	}
	
}

?>