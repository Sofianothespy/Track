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
 * Visitor Entity
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_impression extends owa_entity {
	/*

	var $id = array('data_type' => OWA_DTD_BIGINT, 'is_primary_key' => true); // BIGINT,
	var $visitor_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $session_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $tag_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $placement_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $campaign_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $ad_group_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $ad_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $site_id = array('data_type' => OWA_DTD_VARCHAR255); // VARCHAR(255),
	var $last_impression_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $last_impression_timestamp = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $timestamp = array('data_type' => OWA_DTD_BIGINT); // BIGINT,
	var $year = array('data_type' => OWA_DTD_INT); // INT,
	var $month = array('data_type' => OWA_DTD_INT); // INT,
	var $day = array('data_type' => OWA_DTD_INT); // INT,
	var $dayofyear = array('data_type' => OWA_DTD_INT); // INT,
	var $weekofyear = array('data_type' => OWA_DTD_INT); // INT,
	var $hour = array('data_type' => OWA_DTD_TINYINT2); // tinyINT,
	var $minute = array('data_type' => OWA_DTD_TINYINT2); // tinyINT,
	var $msec = array('data_type' => OWA_DTD_BIGINT); // INT,
	var $url = array('data_type' => OWA_DTD_VARCHAR255); // VARCHAR(255),
	var $ua_id = array('data_type' => OWA_DTD_BIGINT); // BIGINT
	var $ip_address = array('data_type' => OWA_DTD_VARCHAR255); // VARCHAR(255),
	var $host = array('data_type' => OWA_DTD_VARCHAR255); // VARCHAR(255),
	var $host_id = array('data_type' => OWA_DTD_VARCHAR255); // VARCHAR(255),
	
	*/
	function owa_impression() {
			
		return owa_impression::__construct();	
	}
	
	function __construct() {
	
		$this->setTableName('impression');
		// properties
		$this->properties['id'] = new owa_dbColumn;
		$this->properties['id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['id']->setPrimaryKey();
		$this->properties['visitor_id'] = new owa_dbColumn;
		$this->properties['visitor_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['session_id'] = new owa_dbColumn;
		$this->properties['session_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['tag_id'] = new owa_dbColumn;
		$this->properties['tag_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['placement_id'] = new owa_dbColumn;
		$this->properties['placement_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['campaign_id'] = new owa_dbColumn;
		$this->properties['campaign_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['ad_group_id'] = new owa_dbColumn;
		$this->properties['ad_group_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['ad_id'] = new owa_dbColumn;
		$this->properties['ad_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['site_id'] = new owa_dbColumn;
		$this->properties['site_id']->setDataType(OWA_DTD_VARCHAR255);
		$this->properties['last_impression_id'] = new owa_dbColumn;
		$this->properties['last_impression_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['last_impression_timestamp'] = new owa_dbColumn;
		$this->properties['last_impression_timestamp']->setDataType(OWA_DTD_BIGINT);
		$this->properties['timestamp'] = new owa_dbColumn;
		$this->properties['timestamp']->setDataType(OWA_DTD_BIGINT);
		$this->properties['year'] = new owa_dbColumn;
		$this->properties['year']->setDataType(OWA_DTD_INT);
		$this->properties['month'] = new owa_dbColumn;
		$this->properties['month']->setDataType(OWA_DTD_INT);
		$this->properties['day'] = new owa_dbColumn;
		$this->properties['day']->setDataType(OWA_DTD_INT);
		$this->properties['dayofyear'] = new owa_dbColumn;
		$this->properties['dayofyear']->setDataType(OWA_DTD_INT);
		$this->properties['weekofyear'] = new owa_dbColumn;
		$this->properties['weekofyear']->setDataType(OWA_DTD_INT);
		$this->properties['hour'] = new owa_dbColumn;
		$this->properties['hour']->setDataType(OWA_DTD_TINYINT2);
		$this->properties['minute'] = new owa_dbColumn;
		$this->properties['minute']->setDataType(OWA_DTD_TINYINT2);
		$this->properties['msec'] = new owa_dbColumn;
		$this->properties['msec']->setDataType(OWA_DTD_BIGINT);
		$this->properties['url'] = new owa_dbColumn;
		$this->properties['url']->setDataType(OWA_DTD_VARCHAR255);
		$this->properties['ua_id'] = new owa_dbColumn;
		$this->properties['ua_id']->setDataType(OWA_DTD_BIGINT);
		$this->properties['ip_address'] = new owa_dbColumn;
		$this->properties['ip_address']->setDataType(OWA_DTD_VARCHAR255);
		$this->properties['host_id'] = new owa_dbColumn;
		$this->properties['host_id']->setDataType(OWA_DTD_VARCHAR255);
		$this->properties['host'] = new owa_dbColumn;
		$this->properties['host']->setDataType(OWA_DTD_VARCHAR255);
	}
	
	
	
}



?>