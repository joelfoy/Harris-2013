<?php
if(false == get_option('iclt_version')){
    update_option('iclt_version',ICLT_CURRENT_VERSION);
}  
$old_version = floatval(get_option('iclt_version'));
$cur_version = floatval(ICLT_CURRENT_VERSION);

if($cur_version == $old_version || !$old_version) return;

update_option('iclt_version',ICLT_CURRENT_VERSION);

/* 
VERSION 0.2 
added a new value to 'cms_request_status' field in *_translation_requests
added a new field (cms_request_status_message) to *_translation_requests
*/
if($old_version < 0.2){
    $wpdb->query("
        ALTER table {$wpdb->prefix}translation_requests  
        CHANGE `cms_request_status` `cms_request_status` ENUM( '0', '1', '2', '3', '4', '5', '6', '7' )  NOT NULL DEFAULT '0'        
    ");
    $wpdb->query("ALTER table {$wpdb->prefix}translation_requests  
        ADD COLUMN `cms_request_status_message` VARCHAR( 255 ) NOT NULL DEFAULT '' AFTER `cms_request_status`
    ");    
}
/* 
VERSION 0.3
*/
if($old_version < 0.3){
    @unlink(ICLT_PATH . '/icanlocalize.class.php');
    @unlink(ICLT_PATH . '/icanlocalize_constants.php');
    @unlink(ICLT_PATH . '/icanlocalize_api.php');
    @unlink(ICLT_PATH . '/version.php');
    
}
/* 
VERSION 0.4
*/
if($old_version < 0.4){
    $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_key='_ican_language' WHERE meta_key='_ican_original_language'");
}

?>
