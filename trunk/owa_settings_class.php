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

require_once('owa_db.php');

/**
 * Settings
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */
class owa_settings {
	
	/**
	 * Databse access object
	 *
	 * @var unknown_type
	 */
	var $db;
	
	var $properties;
	
	var $e;
	
	function owa_settings() {
		
		$this->properties = $this->get_settings();
		$this->e = owa_error::get_instance();
		return;
	}
	
	
	/**
	 * Returns the configuration
	 *
	 * @return 	array
	 * @access 	public
	 * @static 
	 */
	function &get_settings() {
	
		static $OWA_CONFIG;
		
		if(!isset($OWA_CONFIG)):
			
			// get base config
			$OWA_CONFIG = &owa_settings::get_default_config();
			
			//load overrides from config file
			include_once ($OWA_CONFIG['config_file_path']);
			
		endif;

		return $OWA_CONFIG;
	}
	
	/**
	 * Returns default settings array
	 *
	 * @return array
	 */
	function get_default_config() {
		
		return array(
	
			'ns'							=> 'owa_',
			'visitor_param'					=> 'v',
			'session_param'					=> 's',
			'last_request_param'			=> 'last_req',
			'first_hit_param'				=> 'first_hit',
			'feed_subscription_param'		=> 'sid',
			'source_param'					=> 'from',
			'site_id'						=> '1',
			'session_length'				=> '1800',
			'debug_to_screen'				=> false,
			'requests_table'				=> 'requests',
			'sessions_table'				=> 'sessions',
			'referers_table'				=> 'referers',
			'ua_table'						=> 'ua',
			'os_table'						=> 'os',
			'documents_table'				=> 'documents',
			'optinfo_table'					=> 'optinfo',
			'hosts_table'					=> 'hosts',
			'config_table'					=> 'configuration',
			'version_table'					=> 'version',
			'data_store'					=> 'db',
			'debug_level'					=> '1',
			'db_type'						=> '',
			'db_name'						=> OWA_DB_NAME,
			'db_user'						=> OWA_DB_USER,
			'db_password'					=> OWA_DB_PASSWORD,
			'db_host'						=> OWA_DB_HOST,
			'resolve_hosts'					=> true,
			'log_feedreaders'				=> true,
			'log_robots'					=> false,
			'log_sessions'					=> true,
			'delay_first_hit'				=> true,
			'async_db'						=> false,
			//'restore_db_conn'				=> true,
			'async_log_dir'					=> OWA_BASE_DIR . '/logs/',
			'async_log_file'				=> 'events.txt',
			'async_lock_file'				=> 'owa.lock',
			'async_error_log_file'			=> 'events_error.txt',
			'notice_email'					=> '',
			'error_handler'					=> 'production',
			'error_log_file'				=> OWA_BASE_DIR . '/logs/errors.txt',
			'search_engines.ini'			=> OWA_BASE_DIR . '/conf/search_engines.ini',
			'query_strings.ini'				=> OWA_BASE_DIR . '/conf/query_strings.ini',
			'os.ini'						=> OWA_BASE_DIR . '/conf/os.ini',
			'robots.ini'					=> OWA_BASE_DIR . '/conf/robots.ini',
			'db_class_dir'					=> OWA_BASE_DIR . '/plugins/db/',
			'templates_dir'					=> OWA_BASE_DIR . '/reports/templates/',
			'plugin_dir'					=> OWA_BASE_DIR . '/plugins/',
			'install_plugin_dir'			=> OWA_BASE_DIR . '/plugins/install/',
			'geolocation_lookup'            => true,
			'geolocation_service'			=> 'hostip',
			'report_wrapper'				=> '',
			//'schema_version'				=> '1.0',
			'config_file_path'				=> OWA_BASE_DIR . '/conf/owa_config.php',
			'fetch_config_from_db'			=> true
			
			);
	}
	
	/**
	 * Save Config to database
	 *
	 * @param unknown_type $settings
	 */
	function save($settings) {
		
		$config = &owa_settings::get_settings();
		$this->db = &owa_db::get_instance();
		
		$check = $this->db->query(
			sprintf("SELECT settings from %s where id = '%s'",
					$config['ns'].$config['config_table'],
					$settings['site_id']
					));
					
		if (empty($check)):			
		
		$this->db->query(
			sprintf("
			INSERT into %s (id, settings) VALUES ('%s', '%s')",
			$config['ns'].$config['config_table'],
			$settings['site_id'],
			serialize($settings))
			
		);
		
		else:
		
		$this->db->query(
			sprintf("
			UPDATE %s SET settings = '%s' where id = '%s')",
			$config['ns'].$config['config_table'],
			serialize($settings),
			$settings['site_id']
			)
			
		);
		
		endif;
		
		return;
	}
	
	/**
	 * Fetch Config from database
	 *
	 * @return array
	 */
	function fetch($site_id = 1) {
		
		$config = &owa_settings::get_settings();
		$this->db = &owa_db::get_instance();
		
		$sql = sprintf("
				SELECT settings from %s
				WHERE
				id = '%s'",
				$config['ns'].$config['config_table'],
				$site_id);
		
		$settings = unserialize($this->db->get_row($sql));
		
		return $settings;
	}

}

?>
