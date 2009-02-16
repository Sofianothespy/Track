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
 * Visitors List
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_visitorsUserAgentCount extends owa_metric {
	
	function owa_visitorsUserAgentCount($params = null) {
	
		return owa_visitorsUserAgentCount::__construct($params);	
	}
	
	function __construct($params = null) {
	
		return parent::__construct($params);
	}
	
	function calculate() {
	
		$this->db = owa_coreAPI::dbSingleton();
		$this->db->selectColumn("count(distinct sessions.session_id) as count, ua.ua as ua, ua.browser_type");
		$this->db->selectFrom('owa_session', 'sessions');
		$this->db->join(OWA_SQL_JOIN_LEFT_OUTER, 'owa_ua', 'ua', 'ua_id');
		$this->db->groupBy('ua.browser_type');
		$this->db->orderBy('count', $this->getOrder());
		
		$ret = $this->db->getOneRow();

		return $ret;
	
	}
	
	
}


?>