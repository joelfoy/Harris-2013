<?php

/**
 * Basic framework for Wordpress plugins
 * Handles some actions that are very commonly used in
 * Wordpress plugins
 * 
 * @see Plugin API
 * http://codex.wordpress.org/Plugin_API
 * 
 * @see Action Reference
 * http://codex.wordpress.org/Plugin_API/Action_Reference
 * 
 * @see Filter Reference
 * http://codex.wordpress.org/Plugin_API/Filter_Reference
 * 
 * @example Call method from a class instance in a add_action or add_filter -> add_action(self::FILER_... , array(&$class_instance, 'methodname'));
 * 
 * @version 0.2
 * @author Wim
 */

if(!class_exists("WpBase")){

abstract class WpBase {
	
	/**
	 * Database holder
	 * @var Database
	 */
	private $_database;
	
	/**
	 * The plugin main file
	 * @var string
	 */
	 private $_file;
	
	/**
	 * Normal action constants
	 */
	const ACTION_NORMAL_MUPLUGINS_LOADED			= "muplugins_loaded";
	const ACTION_NORMAL_LOAD_TEXTDOMAIN				= "load_textdomain";
	const ACTION_NORMAL_UPDATE_OPTION				= "update_option";
	const ACTION_NORMAL_PLUGINS_LOADED				= "plugins_loaded";
	const ACTION_NORMAL_SANITIZE_COMMENT_COOKIES	= "sanitize_comment_cookies";
	const ACTION_NORMAL_SETUP_THEME					= "setup_theme";
	const ACTION_NORMAL_AUTH_COOKIE_MALFORMED		= "auth_cookie_malformed";
	const ACTION_NORMAL_SET_CURRENT_USER			= "set_current_user";
	const ACTION_NORMAL_INIT						= "init";
	const ACTION_NORMAL_WIDGETS_INIT				= "widgets_init";
	const ACTION_NORMAL_PARSE_REQUEST				= "parse_request";
	const ACTION_NORMAL_SEND_HEADERS				= "send_headers";
	const ACTION_NORMAL_PRE_GET_POSTS				= "pre_get_posts";
	const ACTION_NORMAL_POST_SELECTION				= "posts_selection";
	const ACTION_NORMAL_WP							= "wp";
	const ACTION_NORMAL_TEMPLATE_REDIRECT			= "template_redirect";
	const ACTION_NORMAL_GET_HEADER					= "get_header";
	const ACTION_NORMAL_WP_HEAD						= "wp_head";
	const ACTION_NORMAL_WP_ENQUEUE_SCRIPTS			= "wp_enqueue_scripts";
	const ACTION_NORMAL_WP_PRINT_STYLES				= "wp_print_styles";
	const ACTION_NORMAL_WP_PRINT_SCRIPTS			= "wp_print_scripts";
	const ACTION_NORMAL_LOOP_START					= "loop_start";
	const ACTION_NORMAL_THE_POST					= "the_post";
	const ACTION_NORMAL_LOOP_END					= "loop_end";
	const ACTION_NORMAL_GET_FOOTER					= "get_footer";
	const ACTION_NORMAL_WP_FOOTER					= "wp_footer";
	const ACTION_NORMAL_WP_PRINT_FOOTER_SCRIPTS		= "wp_print_footer_scripts";
	
	/**
	 * Admin action constants
	 */
	const ACTION_ADMIN_PLUGINS_LOADED				= "plugins_loaded";
	const ACTION_ADMIN_SANITIZE_COMMENT_COOKIES		= "sanitize_comment_cookies";
	const ACTION_ADMIN_AUTH_COOKIE_MALFORMED		= "auth_cookie_malformed";
	const ACTION_ADMIN_AUTH_COOKIE_VALID			= "auth_cookie_valid";
	const ACTION_ADMIN_SET_CURRENT_USER				= "set_current_user";
	const ACTION_ADMIN_INIT							= "init";
	const ACTION_ADMIN_ADMIN_INIT					= "admin_init";
	const ACTION_ADMIN_MENU_INIT					= "admin_menu";
	const ACTION_ADMIN_PARSE_REQUEST				= "parse_request";
	const ACTION_ADMIN_SEND_HEADERS					= "send_headers";
	const ACTION_ADMIN_ADMIN_HEAD					= "admin_head";
	const ACTION_ADMIN_ADMIN_FOOTER					= "admin_footer";
	const ACTION_ADMIN_ADMIN_PRINT_SCRIPTS			= "admin_print_scripts";
	
	/**
	 * Option constants that can be retrieved with get_option(CONSTANT);
	 */
	const OPTION_ACTIVE_PLUGINS						= "active_plugins";
	const OPTION_ADMIN_EMAIL						= "admin_email";
	const OPTION_SITE_URL							= "siteurl";
	const OPTION_BLOG_NAME							= "blogname";
	const OPTION_BLOG_DESCRIPTION					= "blogdescription";
	const OPTION_DATE_FORMAT						= "date_format";
	const OPTION_TIME_FORMAT						= "time_format";
	
	/**
	 * Filter constants
	 */
	const FILTER_THE_CONTENT						= "the_content";
	
	public function __construct($file){
		
		// Get database 
		$this->_database = $this->getDatabase();
		
		$this->_file = $file;
	}
	
	/**
	 * Make sure a plugin is loaded first
	 * 
	 * @example
	 * add_filter( 'pre_update_option_active_plugins', array($wplogger, 'updateList') );
	 * -> updateList function will get the array of active plugins as first parameter
	 * -> Give the current pluginname ( plugin_basename( __FILE__ ) ) and the active plugin list
	 * -> to this function an they will get reordered
	 * 
	 * @param string $plugin_name	Name of the plugin you want to load first -> plugin_basename( __FILE__ )
	 * @param array $plugin_list	List of active plugins
	 * @return array
	 */
	public function forceLoadFirst($plugin_name, $plugin_list){
		
		// If the current plugin is not active
		// just return the plugin list
        if ( !in_array( $plugin_name, $plugin_list )) return $plugin_list;
        
        
        $new_plugin_list = array();
        
        // Add the current plugin at the first place
        array_push( $new_plugin_list, $plugin_name );
        
        // Add all the other plugins to the list
        foreach ( $plugin_list as $selected_plugin )
        {
            if ( $selected_plugin != $plugin_name ) $new_plugin_list[] = $selected_plugin;
        }
        
        // Return new list
        return $new_plugin_list;
	}
	
	/**
	 * Get the current plugin name
	 * 
	 * @return string
	 */
	public function pluginName(){
		$parts = explode("/", plugin_basename( $this->_file ));
		return $parts[0];
	}
	
	/**
	 * Get the current opened url
	 * 
	 * @return string
	 */
	public function currentUrl($strip=array()) {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") $pageURL .= "s";
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
	    	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}else {
	    	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		$parts = explode("&", $pageURL);
		$clean_parts = array();
		foreach($parts as $part){
			$key_value = explode("=", $part);
			if(!in_array($key_value[0], $strip)){
				$clean_parts[] = $part;	
			}
		}
		
	 	return implode("&", $clean_parts);
	}
	
	/**
	 * Get the current plugin directory url
	 * return the url without trailing slash
	 * 
	 * @return string
	 */
	public function pluginUrl($add_name=true){
		if(!$add_name){
			return WP_PLUGIN_URL;
		}else{
			return WP_PLUGIN_URL . "/" . $this->pluginName();	
		}
	}
	
	/**
	 * Get the current plugin directory path
	 * return the path without trailing slash
	 * 
	 * @return string
	 */
	public function pluginDir($add_name=true){
		if(!$add_name){
			return WP_PLUGIN_DIR;
		}else{
			return WP_PLUGIN_DIR . "/" . $this->pluginName();	
		}
	}
	
	/**
	 * Get the upload url from wordpress
	 * 
	 * @return string
	 */
	private function uploadUrl(){
		$upload_dir_info = wp_upload_dir();
		return $upload_dir_info['baseurl'];
	}
	
	/**
	 * Get the upload dir from wordpress
	 * 
	 * @return string
	 */
	private function uploadDir(){
		$upload_dir_info = wp_upload_dir();
		return $upload_dir_info['basedir'];
	}
	
	/**
	 * Get the absolute root path to the 
	 * wordpress install directory
	 * This is without trailing slash
	 * 
	 * @return string
	 */
	public function wordpressDir(){
		return ABSPATH;
	}

	/**
	 * Get the total table name
	 * this adds the prefix to the name
	 * 
	 * @param string	$table
	 * @return string
	 */
	public function tableName($table){
		return self::getDatabase()->prefix . $table;
	}
	
	/**
	 * Get the database object
	 * 
	 * @return Database
	 */
	public function getDatabase(){
		if(!isset($this->_database) || $this->_database == ""){
			global $wpdb;
			$this->_database = $wpdb;
			return $this->_database;
		}else{
			return $this->_database;
		}
	}
	
	/**
	 * Check if a database exists
	 * 
	 * @param string $ptable
	 * @return bool
	 */
	public function tableExists($ptable){
		return (self::getDatabase()->get_var("SHOW TABLES LIKE '" . $ptable . "'") == $ptable );
	}
	
	/**
	 * Create table and check if the table exists
	 * This functions uses the dbDelta
	 * The advantage of this is that it can change the 
	 * structure of a table if it is changed
	 * 
	 * @param string $create	The SQL create statement
	 * @param string $ptable		Fill in this if you want the method to check if the table is created
	 * @return bool
	 */
	public function tableCreate($create, $ptable=null){
		require_once( self::wordpressDir() . 'wp-admin/includes/upgrade.pgp');
		dbDelta($create);
		if($table == null) return true;
		return self::tableExists($ptable);
	}
	
	/**
	 * Delete a table
	 * 
	 * @param string $ptable
	 * @return bool
	 */
	public function tableDelete($ptable){
		$database = self::getDatabase();
		$database->query("DROP TABLE '" . $database->escape($ptable) . "'");
		return !self::tableExists($ptable);
	}
	
	/**
	 * Writes a logtext to a file in the plugin root directory
	 * 
	 * @todo Correct code for writing to browser javascript console
	 * @param string $value
	 */
	public function log($value){
		$logfile = self::pluginDir() . "/base.log";
		$content = file_get_contents( $logfile );
		$content .= $ip . " - [" . date("d-m-y h:i:s") . "] " . $value . "\n";
		file_put_contents($logfile, $content);
	}
	
	/**
	 * Set opions in the database
	 * with this method you can save/update an array/object in the WP database
	 * 
	 * @param string $name	Unique name to save the data to. For example use the plugin name
	 * @param * $data
	 * @return void
	 */
	public function saveOptions($name, $data){
    	if (!get_option($name)){
      		add_option($name, $data);
    	}else{
      		update_option($name, $data);
    	}
	}
	
	/**
	 * Get options from the database
	 * 
	 * @param string $name
	 * @return *
	 */
	public function getOptions($name){
		if (!get_option($name)){
			return false;
		}else{
			return get_option($name);
		}
	}
	
	/**
	 * Delete options from the database
	 * 
	 * @param string $name
	 * @return bool
	 */
	public function deleteOptions($name){
		delete_option($name);
		return !get_option($name);
	}
	
	/**
	 * Check if we are in the backend for the moment
	 * 
	 * @return bool
	 */
	public function inBackend(){
		if( strstr($_SERVER['REQUEST_URI'], 'wp-admin/') ) return true;
		return false;
	}
	
	/**
	 * Parse a template file
	 * 
	 * @param string $file	The template file you want to use
	 * @param array $data	Data that you want to use in the template
	 * @return void
	 */
	public function loadTemplate($file, $data=array()){
		
		// Make variables
		extract( $data );
		
		// Check if template exists
		if( file_exists($file) ){
			ob_start();
			include($file);
			$parsed = ob_get_contents();
			ob_end_clean();
			echo $parsed;
		} else {
			echo "Template doesn't exist.";
		}
	}
	
	/**
	 * Call validation methods for the coresponding post data fields
	 *
	 * @param array $data
	 * @param array $validators
	 * @return array
	 */
	public function validateFields($data, $validators){
		$results = array();
		foreach($data as $key => $value){
			if(count($validators[$key]) > 0){
				$results[$key] = "";
				foreach($validators[$key] as $validator){
					$validator_name = "valid" . ucfirst($validator);
					if(method_exists($this, $validator_name)){
						$valid = $this->$validator_name($value);
						if(!$valid){
							$results[$key] = " form-invalid";
							break;
						}
					}
				}
			}
		}
		return $results;
	}
	
	/**
	 * Check based on the result array of validateFields if
	 * a form is valid or not
	 *
	 * @param array $validation_results
	 * @return bool
	 */
	public function isFormValid($validation_results){
		foreach($validation_results as $key => $value){
			if($value != ""){
				return false;
			}
		}
		return true;
	}
}

}