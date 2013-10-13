<?php

/*
Plugin Name: Extended Google Analytics
Plugin URI: http://www.sitebase.be
Description: With this plugin you can very easely add Google analytics to your website. It will also add tracking events for outbound links and download links.
Author: Sitebase
Version: 1.1
Requires at least: 2.7
Author URI: http://www.sitebase.be
License: GPL
*/

if(!class_exists("ExtendedAnalytics")){
	
	// Include library
	require_once "libraries/WPBase.php";
	
	class ExtendedAnalytics extends WpBase {
		
		const NAME = "ExtendedAnalytics";
		
		private $_form_field_validator = array(
				"track_code" => array("required"),
				"campaign_url" => array("required"),
				"campaign_source" => array("required"),
				"campaign_medium" => array("required"),
				"campaign_name" => array("required")
		);
		
		public function __construct(){
			parent::__construct(__FILE__);
			
			// Add Menu item
			add_action( self::ACTION_ADMIN_MENU_INIT	, array(&$this, 'addToAdmin') );
			add_action(self::ACTION_NORMAL_WP_HEAD		, array(&$this, 'addToHead'));
			add_action(self::ACTION_NORMAL_WP_PRINT_SCRIPTS			, array(&$this, 'loadSiteScripts'));

			
		}
		
		/**
		 * Add options to the menu
		 *
		 * @return void
		 */
		public function addToAdmin(){
			$plugin_page = add_options_page('Extended Analytics Options', 'Extended Analytics', 'manage_options', 'extended-analytics', array(&$this, "adminPageShow"));
			
			add_action('admin_print_scripts-' . $plugin_page, array(&$this, 'loadAdminScripts'));
			add_action('admin_print_styles-' . $plugin_page, array(&$this, 'loadAdminStyles'));

		}
		
		/**
		 * Add javascript to head
		 */
		public function addToHead(){

			// Get plugin options
			$options = self::getOptions( self::NAME );
			
			// Add analytics tracking
			$analytics = "";
			if(isset($options['track_code']) && !empty($options['track_code'])){

				// Generate download extension list
				$extensions = explode(",", $options['track_download_ext']);
				$extension_list = "";
				foreach($extensions as $extension){
					$extension_list .= '"' . trim($extension) . '",';
				}
				$extension_list = substr($extension_list, 0, -1);

				$analytics = "\n" . 'jQuery(document).ready(function($)
{
	$.jAnalytics("' . $options['track_code'] . '", {enableDownloadTrack: ' . $options['track_download'] . ',
				enableEmailTrack: ' . $options['track_mailto'] . ',
				enableOutboundTrack : ' . $options['track_outbound'] . ',
				trackFiles:	[' . $extension_list . ']});
});';	
			}
			
			$adsense = "";
			if(isset($options['track_adsense']) && !empty($options['track_adsense'])){
				$adsense =  "\n" . 'window.google_analytics_uacct = "' . $options['track_code'] . '";';
			}

			echo '<script type="text/javascript">' . $analytics  . $adsense . "\n</script>\n";
		}
		
		public function loadAdminScripts(){
			wp_enqueue_script('jquery');
			wp_enqueue_script( "extendedanalytics-script",  self::pluginUrl() . '/assets/extendedanalytics.js', array("jquery")); 	
		}
		
		public function loadAdminStyles(){
			wp_enqueue_style( "extendedanalytics-style",  self::pluginUrl() . '/assets/extendedanalytics.css', null, '2.0'); 
		}
		
		public function loadSiteScripts(){
			if(!$this->inBackend()){
				wp_enqueue_script('jquery');
				wp_enqueue_script( "extendedanalytics-script",  self::pluginUrl() . '/assets/extendedanalytics.js', array("jquery"), '4.0'); 	
			}
		}
		
		/**
		 * Show admin page
		 */
		public function adminPageShow(){

			// Add selected page
			$data['page'] = isset($_GET['tab']) && in_array($_GET['tab'], array("settings", "faq", "campaign")) ? $_GET['tab'] : "settings";
			// Do validation
			$validation_results = $this->validateFields($_POST, $this->_form_field_validator);
			$data['validation'] = $validation_results;
			
			// Call form handlers if needed
			if($this->isFormValid($validation_results) && isset($_POST['generate'])) $this->handleFormCampaign($data);
			if($this->isFormValid($validation_results) && isset($_POST['save-settings'])) $this->handleFormSettings($data);
			if($this->isFormValid($validation_results) && isset($_POST['save-adsense'])) $this->handleFormAdsense($data);
			
			// Merge in options
			$options = $this->getOptions( self::NAME );
			if(is_array($options)){
				$data = array_merge( $data, $options );	
			}

			// Add post data
			$data = array_merge($data, $_POST);
			
			$this->loadTemplate(self::pluginDir() . "/views/index.php", $data);
		}
		
		/**
		 * Handles campaign tool
		 */
		private function handleFormCampaign(&$data){

			$track_url = "";
			$splitter = strstr($_POST['campaign_url'], "?") ? "&" : "?";
			if(isset($_POST['campaign_url']) && !empty($_POST['campaign_url'])) $track_url .= $_POST['campaign_url'];
			if(isset($_POST['campaign_source']) && !empty($_POST['campaign_source'])) $track_url .= $splitter . "utm_source=" . $_POST['campaign_source'];
			if(isset($_POST['campaign_medium']) && !empty($_POST['campaign_medium'])) $track_url .= "&utm_medium=" . $_POST['campaign_medium'];
			if(isset($_POST['campaign_term']) && !empty($_POST['campaign_term'])) $track_url .= "&utm_term=" . $_POST['campaign_term'];
			if(isset($_POST['campaign_content']) && !empty($_POST['campaign_content'])) $track_url .= "&utm_content=" . $_POST['campaign_content'];
			if(isset($_POST['campaign_name']) && !empty($_POST['campaign_name'])) $track_url .= "&utm_campaign=" . $_POST['campaign_name'];
			
			$data['campaign_result'] = $track_url;
			
		}
		
		/**
		 * Handles form settings save
		 */
		private function handleFormSettings(&$data){
			
			// Get options that are saved in the database
			$options = $this->getOptions( self::NAME );
			
			// Merge array if needed
			if(is_array($options)){
				$options = array_merge( $options, $_POST);	
			}else{
				$options = $_POST;	
			}
			
			// Add fix for checkboxes
			if(!isset($_POST['track_outbound'])) $options['track_outbound'] = "false";
			if(!isset($_POST['track_mailto'])) $options['track_mailto'] = "false";
			if(!isset($_POST['track_download'])) $options['track_download'] = "false";
			
			// Save new settings
			$this->saveOptions( self::NAME, $options);
			
			// Set success
			$data['settings_success'] = true;
			
		}
		
		/**
		 * Handles adsense form
		 */
		private function handleFormAdsense(&$data){
			
			// Get options that are saved in the database
			$options = $this->getOptions( self::NAME );
			
			// Merge array if needed
			if(is_array($options)){
				$options = array_merge( $options, $_POST);	
			}else{
				$options = $_POST;	
			}
			
			// Add fix for checkboxes
			if(!isset($_POST['track_adsense'])) $options['track_adsense'] = "false";
			
			// Save new settings
			$this->saveOptions( self::NAME, $options);
			
			// Set success
			$data['adsense_success'] = true;
			
		}
		
		/**
		 * Required form validator
		 */
		public function validRequired($value){
			if($value != ""){
				return true;	
			}
			return false;
		}

	}
	
	// Create class instance
	$_GLOBALS['analytics'] = new ExtendedAnalytics();
	
}