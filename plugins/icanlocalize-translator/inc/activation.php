<?php
function iclt_translator_activate(){
    global $wpdb;            
    if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}translation_jobs'") != $wpdb->prefix.'translation_jobs'){
        $wpdb->query("
            CREATE TABLE `{$wpdb->prefix}translation_jobs` (  
                `id` bigint(20) unsigned NOT NULL auto_increment,
                `post_id` bigint(20) unsigned NOT NULL default '0',
                `word_count` int(10) unsigned NOT NULL default '0',
                `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
                PRIMARY KEY  (`id`),
                UNIQUE KEY `post_id` (`post_id`)
            ) 
        ");
    }                                                                                                                                          
    
    if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}translation_requests'") != $wpdb->prefix.'translation_requests'){
        $wpdb->query("
            CREATE TABLE `{$wpdb->prefix}translation_requests` (
                `id` bigint(20) unsigned NOT NULL auto_increment,
                `post_id` bigint(20) unsigned NOT NULL default '0',
                `cms_request_id` bigint(20) unsigned NOT NULL default '0',
                `cms_request_status` enum('0','1','2','3','4','5','6','7') NOT NULL default '0',
                `cms_request_status_message` varchar(255) NOT NULL default '',
                `content_checksum` varchar(32) NOT NULL default '',
                `needs_update` tinyint(1) NOT NULL default '0',
                `translated` tinyint(1) NOT NULL default '0',
                `cms_request_languages` text NOT NULL default '',
                `date` datetime NOT NULL default '0000-00-00 00:00:00',
                PRIMARY KEY  (`id`),\n  UNIQUE KEY `post_id` (`post_id`,`cms_request_id`)
            )             
        ");
    }
    
    delete_option('iclt_version');
    add_option('iclt_version',ICLT_CURRENT_VERSION,'',true);
}  
?>