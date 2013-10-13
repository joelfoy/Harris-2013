<?php   
class ICanLocalize{
    private $settings;
    
    function __construct(){          
        $this->settings = get_option('iclt_settings');
        define('FAILED_REQUESTS_COUNT',$this->get_failed_requests_count());
        
        if($_POST['Submit']){            
            add_action('init',array($this,'save_settings'));           
        }
        add_action('init', array($this,'ajax_responses'));
        add_action('admin_notices', array($this,'admin_notices'));
        if($this->settings['languages']){
            add_action('save_post',array($this,'send_translation_request'));
        }
        add_action('delete_post',array($this,'delete_post_actions'));
        add_action('admin_menu',array($this,'management_page'));
        
        if($this->settings['languages']){
            add_action('admin_head',array($this,'post_edit_options'));        
            add_action('admin_head',array($this,'page_edit_options'));        
        }
        
        add_action('admin_head',array($this,'js_scripts'));  
        if(0 < get_option('__iclt_batch_status')){              
            define('TRIGGER_MASS_TRANSLATION',TRUE);
            add_action('admin_head',array($this,'trigger_mass_translation_job'));      
        }
        
        if($this->settings['languages']){
            if(preg_match('#/wp-admin/edit\.php#',$_SERVER['REQUEST_URI'])){
                add_filter('manage_posts_columns',array($this,'add_posts_management_column'));
                add_action('manage_posts_custom_column',array($this,'add_content_for_posts_management_column'));            
            }
            if(preg_match('#/wp-admin/edit-pages\.php#',$_SERVER['REQUEST_URI'])){
                add_filter('manage_pages_columns',array($this,'add_posts_management_column'));
                add_action('manage_pages_custom_column',array($this,'add_content_for_posts_management_column'));
            }
        }
        
        add_filter('xmlrpc_methods',array($this, 'add_custom_xmlrpc_methods'));
        
        if(!$this->settings['iclt_blog_language'] && $this->settings['languages']){
            $this->settings['iclt_blog_language'] = $this->settings['languages'][0]['from_name'];
        }                        
        update_option('iclt_settings',$this->settings);
        
    }
    
    function ajax_responses(){         
        if(!$_POST['ajx_action']){
            return;
        }
        global $wpdb;
        $iclq = new ICLQuery($this->settings);        
        switch($_POST['ajx_action']){
            case 'update_languages':                 
                $languages = $iclq->get_languages();           
                $this->settings['languages'] = $languages;
                if(!$this->settings['iclt_blog_language']){
                    $this->settings['iclt_blog_language'] = $languages[0]['from_name'];
                }                
                update_option('iclt_settings',$this->settings);
                if(!is_array($languages) ||  !count($languages)) die(__('No language preference set'));
                foreach($this->settings['languages'] as $l){
                    $lpairs[] = $l['from_name'] . ' &raquo; ' . $l['to_name'];
                    $blog_lang_options[$l['from_name']] = 1;
                }
                echo join('<br />',$lpairs);
                ?>
                <hr style="border:none;border-top:solid 1px #fff" />
               Blog language <select name="iclt_blog_language">
                    <?php foreach($blog_lang_options as $k=>$v): ?>
                    <option value="<?php echo $k ?>" <?php if($this->settings['iclt_blog_language']==$k):?>selected="selected"<?php endif?>>
                        <?php echo $k ?></option>
                    <?php endforeach; ?>                        
                </select>            
                <?php            
                break;
            case 'get_pending_requests': 
                $statuses = array(
                    0=>__('pending'), 
                    CMS_REQUEST_WAITING_FOR_PROJECT_CREATION=>__('Waiting for translator'), 
                    CMS_REQUEST_PROJECT_CREATION_REQUESTED=>__('pending'), 
                    CMS_REQUEST_CREATING_PROJECT=>__('pending'), 
                    CMS_REQUEST_RELEASED_TO_TRANSLATORS=>__('Translation in progress'), 
                    CMS_REQUEST_TRANSLATED=>__('Translated'), 
                    CMS_REQUEST_DONE=>__('Translatin complete'), 
                    CMS_REQUEST_FAILED=>'<acronym style="cursor:help" title="%cms_request_status_message%">'.__('error').'</acronym>');
                $posts = $wpdb->get_results("
                    SELECT post_id, post_title, cms_request_id, cms_request_status, cms_request_status_message 
                    FROM {$wpdb->prefix}translation_requests p1 
                    JOIN {$wpdb->posts} p2 ON p1.post_id=p2.ID 
                    WHERE cms_request_status < ".CMS_REQUEST_FAILED." AND cms_request_status >= ".CMS_REQUEST_WAITING_FOR_PROJECT_CREATION."                      
                         AND cms_request_id > 0
                ");                    
                $failed_posts = $wpdb->get_results("
                    SELECT post_id, post_title, cms_request_id, cms_request_status, cms_request_status_message 
                    FROM {$wpdb->prefix}translation_requests p1 
                    JOIN {$wpdb->posts} p2 ON p1.post_id=p2.ID 
                    WHERE cms_request_status = '".CMS_REQUEST_FAILED."'                      
                ");
                if($failed_posts){    
                    ?>
                    <style>
                    #iclt_failed_requests_table{border-collapse: collapse;margin-left:4px;background-color: #fdd;}
                    #iclt_failed_requests_table th{ border:none; width:auto; padding: 3px 5px 2px 5px;}
                    #iclt_failed_requests_table td{ border:1px solid #FFF ; padding: 3px 5px 2px 5px; background-color: #fdd;}
                    </style>
                    <?php                    
                    echo '<table id="iclt_failed_requests_table" cellpadding="0" cellspacing="0">';
                    echo '<th>' . __('Title') . '</th>';
                    echo '<th>' . __('Error') . '</th>';
                    echo '<th>&nbsp;</th>';
                    echo '<th>&nbsp;</th>';
                    foreach($failed_posts as $post){
                        echo '<tr>';
                        echo '<td valign="top" width="40%"><a href="'.get_edit_post_link($post->post_id).'">'. $post->post_title . '</a></td>';
                        echo '<td>'.$post->cms_request_status_message.'</td>';
                        echo '<td width="5%"><a href="'.get_permalink($post->post_id).'">'.__('View').'</a></td>';
                        if($post->cms_request_status <= CMS_REQUEST_WAITING_FOR_PROJECT_CREATION){
                            echo '<td width="5%"><input type="button" class="button" onclick="iclt_cancel_request('.$post->cms_request_id.',this)" value="'.__('Cancel').'"/></td>';
                        }else{
                            echo '<td width="5%">&nbsp;</td>';
                        }                            
                        echo '<tr>';
                    }
                    echo '</table>';
                }                
                if($posts){    
                    ?>
                    <style>
                    #iclt_pending_requests_table{border-collapse: collapse;margin-left:4px;}
                    #iclt_pending_requests_table th{ border:none; width:auto; padding: 3px 5px 2px 5px;}
                    #iclt_pending_requests_table td{ border:1px solid #FFF ; padding: 3px 5px 2px 5px;}
                    </style>
                    <?php                    
                    echo '<table id="iclt_pending_requests_table" style="" cellpadding="0" cellspacing="0">';
                    echo '<th>' . __('Title') . '</th>';
                    echo '<th>' . __('Status') . '</th>';
                    echo '<th>&nbsp;</th>';
                    echo '<th>&nbsp;</th>';
                    foreach($posts as $post){
                        echo '<tr>';
                        echo '<td width="40%"><a href="'.get_edit_post_link($post->post_id).'">'. $post->post_title . '</a></td>';
                        echo '<td>'.str_replace('%cms_request_status_message%',$post->cms_request_status_message,$statuses[$post->cms_request_status]).'</td>';
                        echo '<td width="5%"><a href="'.get_permalink($post->post_id).'">'.__('View').'</a></td>';
                        if($post->cms_request_status <= CMS_REQUEST_WAITING_FOR_PROJECT_CREATION){
                            echo '<td width="5%"><input type="button" class="button" onclick="iclt_cancel_request('.$post->cms_request_id.',this)" value="'.__('Cancel').'"/></td>';
                        }else{
                            echo '<td width="5%">&nbsp;</td>';
                        }
                        echo '<tr>';
                    }
                    echo '</table>';
                }else{
                    echo '<p>' . __('No pending requests') . '</p>';
                }   
                break;
            case 'get_page_translation_status':
                echo intval($wpdb->get_var("SELECT cms_request_status FROM {$wpdb->prefix}translation_requests WHERE post_id='".intval($_POST['page_id'])."'"));
                break;
            case 'manage_translation_batch':
                if($_POST['op']=='add'){
                    //check whether parent page is translated
                    $res = $wpdb->get_row("SELECT post_type, post_parent FROM {$wpdb->posts} WHERE ID=".intval($_POST['id']));
                    if($res->post_type=='page' && $res->post_parent > 0){
                        $translated = intval($wpdb->get_var("SELECT translated FROM {$wpdb->prefix}translation_requests WHERE post_id='".$res->post_parent."'"));                                        
                        if(!$translated){
                            $parent = $wpdb->get_row("SELECT post_title, guid FROM {$wpdb->posts} WHERE ID=".$res->post_parent);
                            echo '-1#'.__('Error - not added!').'#';
                            echo __('Before you submit this page to translation make sure that it\'s parent is translated first.');
                            echo '<br />';
                            echo '<a href="'.get_edit_post_link($res->post_parent).'">'.$parent->post_title.'</a> <a href="'.$parent->guid.'">['.__('view').']</a>';
                            exit;
                        }
                    }
                    $wordcount = count(explode(' ',strip_tags($wpdb->get_var("SELECT post_content FROM {$wpdb->posts} WHERE ID='".intval($_POST['id'])."'"))));
                    $wpdb->query("INSERT INTO {$wpdb->prefix}translation_jobs(post_id,word_count,date_added) VALUES('".intval($_POST['id'])."','{$wordcount}',NOW())");
                    echo mysql_insert_id();     
                    echo '#';               
                }else{
                    //remove child pages as well
                    // get children that are in the batch queue
                    $res = $wpdb->get_results("
                        SELECT post_id 
                        FROM {$wpdb->prefix}translation_jobs p1 
                        LEFT JOIN {$wpdb->posts} p2 ON p1.post_id=p2.ID 
                        WHERE p2.post_parent=".intval($_POST['id']));
                    foreach($res as $r){
                        $cids[] = $r->post_id;
                    }
                    $eliminate = join(',',(array)$cids);                    
                    $wpdb->query("DELETE FROM {$wpdb->prefix}translation_jobs WHERE post_id='".intval($_POST['id'])."'");
                    echo mysql_affected_rows().'#'.$eliminate;                                        
                }
                $doc_count = intval($wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}translation_jobs"));
                $wrd_count = intval($wpdb->get_var("SELECT SUM(word_count) FROM {$wpdb->prefix}translation_jobs"));
                echo "#"; //separator
                if(preg_match('#/wp-admin/edit(-pages)?\.php#',$_SERVER['REQUEST_URI'])){
                    echo '<br />';
                }
                if($doc_count==0){
                    $cart_empty='-outline';
                    $start_but_disabled='disabled="disabled"';
                }else{
                    $cart_empty='';
                    $start_but_disabled='';
                }
                echo '<img src="'.ICLT_PLUGIN_URL.'/img/RO-Mx1-24_shopping-cart'.$cart_empty.'.png" height="24" width="24" alt="Cart" />';
                echo sprintf(__('%d document(s) with %d words in the translation cart.'), $doc_count, $wrd_count);
                if(preg_match('#/wp-admin/(edit|tools)(-pages)?\.php#',$_SERVER['REQUEST_URI']) && $doc_count > 0){
                     echo '<a href="tools.php?page=iclt">['.__('view').']</a>';
                     echo '<input class="iclt_start_batch2 button" type="button" value="'.__('Start').'" '.$start_but_disabled.' onclick="location.href=\'tools.php?page=iclt&start=1\'" />';
                }
                break;
            case "start_translation_batch":
                update_option('__iclt_batch_status',1);
                echo '1#'.__('Started');
                break;                
            case "stop_translation_batch":
                update_option('__iclt_batch_status',0);
                echo '1#'.__('Stopped');
                break;                                
            case "get_translation_batch_status":                
                $st = get_option('__iclt_batch_status');                
                if($st > 0){
                    // process next element in queue                
                    list($post_id, $items_left) = $this->process_batch_job_item();                
                    echo '1#'. sprintf(__('Running: %s items left'),$items_left) . "#".$post_id;
                    $doc_count = intval($wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}translation_jobs"));
                    $wrd_count = intval($wpdb->get_var("SELECT SUM(word_count) FROM {$wpdb->prefix}translation_jobs"));
                    echo "#"; //separator
                    if($doc_count==0){
                        $cart_empty='-outline';
                        $start_but_disabled='disabled="disabled"';
                    }else{
                        $cart_empty='';
                        $start_but_disabled='';
                    }
                    echo '<img src="'.ICLT_PLUGIN_URL.'/img/RO-Mx1-24_shopping-cart'.$cart_empty.'.png" height="24" width="24" alt="Cart" />';
                    echo sprintf(__('%d document(s) with %d words in the translation cart.'), $doc_count, $wrd_count);
                    //echo '<input class="iclt_start_batch2 button" type="button" value="'.__('Start').'" '.$start_but_disabled.' />';                    
                }else{
                    echo '0#'.__('Stopped');
                }                
                break;
            case 'set_translate_to_values':
                $post_id = $_POST['post_id'];
                if($post->ID){
                    $post_request = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}translation_requests WHERE post_id=".$post->ID);
                    $el = unserialize($post_request->cms_request_languages);
                    if($el){
                        foreach($el as $ele){
                            $enabled_languages[] = $ele['to_name'];            
                        }
                    }
                }    
                
                foreach($this->settings['languages'] as $lt){
                    if($lt['from_name']!=$_POST['lang']) continue;
                    $to_langs[] = $lt['to_name'];
                } 
                echo __('Translate_to:');                 
                foreach($to_langs as $l){
                    ?> <input class="iclt_trans_lang" type="checkbox" name="target_languages[]" value="<?php echo $l ?>" 
                        <?php if(!is_array($enabled_languages) || in_array($l,$enabled_languages)): ?>checked="checked"<?php endif; ?>
                        /><?php echo $l; ?>&nbsp;&nbsp;<?php                    
                }
                break;
            case 'cancel_request':
                $res = $this->cancel_translation_request(intval($_POST['request_id']));
                echo intval($res[0]) . '|' . $res[1];
                break;                 
            default:
                echo "";
        }    
        exit;
    }
    
    function save_settings(){
        $nonce = wp_create_nonce('update-incalocalize');
        if($nonce != $_POST['_wpnonce']) return;        
        $iclt_settings['site_id'] = intval($_POST['iclt_site_id']);        
        $iclt_settings['access_key'] = mysql_real_escape_string($_POST['iclt_access_key']);
        $iclt_settings['iclt_blog_language'] = mysql_real_escape_string($_POST['iclt_blog_language']);
        $iclt_settings['no_translation_confirmation'] = intval(!$_POST['no_translation_confirmation']);
        $iclt_settings['translate_new_contents_when_published'] = intval($_POST['translate_new_contents_when_published']);
        
        //get languages
        $iclq = new ICLQuery($iclt_settings);
        $languages = $iclq->get_languages();
        
        if($languages===false){
            $_GET['iclt_error_message'] = __('Invalid site id and/or access key');
        }else{
            if(is_array($languages)){
                $iclt_settings['languages'] = $languages;
            }
        }
        update_option('iclt_settings',$iclt_settings);        
        $this->settings = $iclt_settings;
        $_GET['updated']=true;   
        
    }
    
    function get_settings(){
        return $this->settings;
    }
    
    function admin_notices(){
        if($_GET['iclt_error_message']){
        ?><div id="message" class="error"><p><b><?php echo __('Error') ?>:</b> <?php echo __($_GET['iclt_error_message']) ?></p></div><?php            
        }
    }
    
    function send_translation_request($pid){ 
        if($_SERVER['HTTP_USER_AGENT']=='Incutio XML-RPC' || $_SERVER['REQUEST_URI']=='/xmlrpc.php' || !$_POST['post_ID']) return;
        if(!defined('__TRANSLATION_REQUEST_SENT')){
            define('__TRANSLATION_REQUEST_SENT',TRUE);
        }else{            
            return;
        }        
        if(ICLT_DEBUG_MODE) iclt_debug_func_start();        
        
        // the translation controls were enabeled and the translation was selected
        $is_translation_enabled = isset($_POST['translate_when']);
        
        // ignore specific cases when translation is not needed
        if($_POST['deletemeta'] || $_POST['iclt_translation_request_confirmed']=='false'){
            if(ICLT_DEBUG_MODE){
              if($_POST['deletemeta']) $iclt_tmp_message = 'is delete meta';
              elseif($_POST['iclt_translation_request_confirmed']=='false') $iclt_tmp_message = 'translation prompt not confirmed';
              iclt_debug_log($iclt_tmp_message . ' - exit');  
              if(ICLT_DEBUG_MODE) iclt_debug_func_end();                
            } 
            return;        
        } 
                
        global $wpdb;
        
        $post_id = $_POST['post_ID'];
        $post_parent = $_POST['post_parent'];
        $post_type = $_POST['post_type'];
        $post_status = $_POST['post_status'];
        $post_title = $_POST['post_title'];        
        $post_content = $_POST['content'];
        $post_date_gmt = $wpdb->get_var("SELECT post_date_gmt FROM {$wpdb->posts} WHERE ID=".$post_id);
        
        // store user specific preference on when to translate the post
        if($is_translation_enabled){
            if(in_array($_POST['translate_when'],array(1,2))){
                if(ICLT_DEBUG_MODE) iclt_debug_log('Save post \'Save on\' preference - 1');        
                update_post_meta($post_id,'_iclt_translate_on',1);
            }else{
                if(ICLT_DEBUG_MODE) iclt_debug_log('Save post \'Save on\' preference - 0');        
                update_post_meta($post_id,'_iclt_translate_on',0);
            }
        }        
        
        if($wpdb->get_var("SELECT id FROM {$wpdb->prefix}translation_jobs WHERE post_id=".$post_id)){
            $wordcount = count(explode(' ',strip_tags($_POST['content'])));
            $wpdb->update($wpdb->prefix.'translation_jobs',array('word_count'=>$wordcount),array('post_id'=>$post_id));
            if(ICLT_DEBUG_MODE) iclt_debug_log('Update word count - ' . $wordcount);        
        }
        
        $_exp = explode(',',$_POST['tags_input']);
        foreach($_exp as $_t){
            $post_tags[] = trim($_t);
        }
        if(is_array($post_tags)){
            sort($post_tags, SORT_STRING);
        }        
        $post_categories = $_POST['post_category'];
        if(is_array($post_categories)){
            sort($post_categories, SORT_NUMERIC);
        }else{
            $post_categories = array(get_option('default_category'));
        }
        
        $post_request = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}translation_requests WHERE post_id=".$post_id);
        $previous_checksum = $post_request->content_checksum;
        $current_checksum = md5($post_content.$post_title.join(',',(array)$post_tags).join(',',(array)$post_categories));
        
        if($previous_checksum && $previous_checksum != $current_checksum){            
            $wpdb->update($wpdb->prefix.'translation_requests', array('needs_update'=>1),array('post_id'=>$post_id));
            $content_changed = true;
            if(ICLT_DEBUG_MODE) iclt_debug_log('Content changed - post needs update');               
        }   
        
        if(isset($_POST['iclt_needs_translation_update']) || ($post_request->cms_request_status==CMS_REQUEST_DONE && $content_changed)){
            $is_update = 1;  
        }else{
            $is_update = 0;
        }
        $iclq = new ICLQuery($this->settings);
        
        //test whether the parent page is translated
        if($post_type=='page' && $post_parent > 0){             
             $p_cms_request_status = $wpdb->get_var("SELECT cms_request_status FROM {$wpdb->prefix}translation_requests WHERE post_id=".$post_parent);
             if($p_cms_request_status != CMS_REQUEST_DONE){   
                if(ICLT_DEBUG_MODE) iclt_debug_log('Parent not translated - exit');                                
                if(ICLT_DEBUG_MODE) iclt_debug_func_end();               
                return;                        
             }
        }
        
        foreach((array)$_POST['target_languages'] as $to_lang){
            $this_languages[] = array('from_name'=>$_POST['iclt_post_language'],'to_name'=>$to_lang);            
        }
        $custom_languages = mysql_real_escape_string(serialize($this_languages));
        
        if($post_request->cms_request_status == CMS_REQUEST_DONE && !$is_update && $is_translation_enabled){
            if( (!$post_request->cms_request_languages && $this_languages != $this->settings['languages']) || 
                (is_array(unserialize($post_request->cms_request_languages)) && $this_languages!=unserialize($post_request->cms_request_languages)) ){
                  $iclq->update_languages($post_request->cms_request_id,$this_languages);  
                  $wpdb->update($wpdb->prefix.'translation_requests', array('cms_request_languages'=>mysql_real_escape_string(serialize($this_languages))),
                    array('post_id'=>$post_id));
                    if(ICLT_DEBUG_MODE) iclt_debug_log('Update languages - exit');                                
                    if(ICLT_DEBUG_MODE) iclt_debug_func_end();               
                    return;
            }
        }
        
        // this post is scheduled to be translated when it's published
        if($_POST['translate_when']==1 && 'publish' != $post_status ){
            if(ICLT_DEBUG_MODE) iclt_debug_log("Post to be translated when published. Current status {$post_status}");                                
            if(ICLT_DEBUG_MODE) iclt_debug_func_end();               
            return;
        }
        // don't translate yet OR don't update translation
        if($_POST['translate_when']==3 || $_POST['translate_when']==4){
            if(ICLT_DEBUG_MODE) iclt_debug_log("Post not to be translated");                                
            if(ICLT_DEBUG_MODE) iclt_debug_func_end();                           
            return;
        }
                
        //get the permalink
        list($permalink, $post_name) = get_sample_permalink($post_id, $post_title);
        $permalink = str_replace(array('%pagename%','%postname%'), $post_name, $permalink);        
        
        // just in case (don't create requests for attachments)
        if(!in_array($post_type, array('post','page'))){
            if(ICLT_DEBUG_MODE) iclt_debug_log("This is not post/page");                                
            if(ICLT_DEBUG_MODE) iclt_debug_func_end();                                       
            return;
        } 
        
        // if no languages are set, get out
        if(!is_array($this_languages) && count($this->settings) && !$is_update && $is_translation_enabled){            
            if(ICLT_DEBUG_MODE) iclt_debug_log("No languages set - exit");                                
            if(ICLT_DEBUG_MODE) iclt_debug_func_end();                                       
            return;
        }
        if(!$is_translation_enabled) return;
        
        /*****************************************************************************************************************************************/
        // does the post have a previous request?
        if($post_request->cms_request_status == CMS_REQUEST_FAILED){
            if(ICLT_DEBUG_MODE) iclt_debug_db_snapshot('before-retry');
            if(ICLT_DEBUG_MODE) iclt_debug_log("Is retry");                                
            $iclq->retry_translation($post_request->cms_request_id);
            $wpdb->update($wpdb->prefix.'translation_requests',array('cms_request_status'=>1),array('cms_request_id'=>$post_request->cms_request_id));
            if(ICLT_DEBUG_MODE) iclt_debug_db_snapshot('after-retry');
        }    
        /*****************************************************************************************************************************************/            
        elseif(0 == intval($post_request->cms_request_status)){             // no previous request - make a new request for this post/page       
            if(ICLT_DEBUG_MODE) iclt_debug_log("No previous request");                        
            if(ICLT_DEBUG_MODE) iclt_debug_db_snapshot('before-submit');
            if($post_type=='post'){
                $post_timestamp = strtotime($post_date_gmt) + (get_option('gmt_offset') * 3600);
                $cms_request_id = $iclq->submit_post_translation($post_id,$post_title, $permalink, $this_languages, $post_timestamp, $is_update);
            }else{
                $cms_request_id = $iclq->submit_page_translation($post_id,$post_title, $permalink, $this_languages, $is_update);
            }            
            if(ICLT_DEBUG_MODE) iclt_debug_log("New request sent {$cms_request_id}");                        
            if(!$cms_request_id){                
                if(ICLT_DEBUG_MODE) iclt_debug_log("No cms request id returned");                                
                $needs_update_due_to_fail = 1;
                $current_checksum = '';
            }else{
                $needs_update_due_to_fail = 0;
            }
    
            if($post_request){
                $wpdb->query("UPDATE {$wpdb->prefix}translation_requests SET 
                                cms_request_id='{$cms_request_id}',
                                cms_request_status='1', 
                                content_checksum = '{$current_checksum}', 
                                needs_update = '{$needs_update_due_to_fail}', 
                                cms_request_languages='$custom_languages',
                                date = NOW()    
                             WHERE post_id=".$post_id);  
                if(ICLT_DEBUG_MODE) iclt_debug_log("Update existing translation entry: " . $post_request->id);                        
            }else{                
                $wpdb->query("INSERT INTO {$wpdb->prefix}translation_requests
                    (post_id, cms_request_id, cms_request_status, content_checksum, needs_update, cms_request_languages, date)
                    VALUES('{$post_id}','{$cms_request_id}','1','{$current_checksum}','{$needs_update_due_to_fail}','{$custom_languages}',NOW())");
                if(ICLT_DEBUG_MODE) iclt_debug_log("Add new translation request to the translations table: " . mysql_insert_id());                        
            }
            if(ICLT_DEBUG_MODE) iclt_debug_db_snapshot('after-submit');
        /*****************************************************************************************************************************************/    
        }else{            
            // a previous request exists
            if(ICLT_DEBUG_MODE) iclt_debug_log("A previous request exists. Status: " . $post_request->cms_request_status);                        
            if(ICLT_DEBUG_MODE) iclt_debug_db_snapshot('before-submit-with-previous-request');
            //check if the status of the request on the translation server
            if($post_request->cms_request_status != CMS_REQUEST_DONE){
                $post_request->cms_request_status = $iclq->get_cms_request_status($post_request->cms_request_id);                        
                if(ICLT_DEBUG_MODE) iclt_debug_log("Read translation status from the server: " . $post_request->cms_request_status);
            }            
            if($post_request->cms_request_status == CMS_REQUEST_DONE){
                if(ICLT_DEBUG_MODE) iclt_debug_log("Translation complete. Mark it as translated");                        
                $wpdb->update($wpdb->prefix.'translation_requests', array('translated'=>'1', 'cms_request_status'=>CMS_REQUEST_DONE), 
                    array('post_id'=>$post_id));
            }            
            // if the request was completed or somewhow it couldn't be found in the system, make a new request
            // $post_request->cms_request_id===0 is the case of a previous error on the server
            if(($post_request->cms_request_status == CMS_REQUEST_DONE  && ($content_changed || $is_update)) || $post_request->cms_request_id==='0'){
                if(ICLT_DEBUG_MODE) iclt_debug_log("Content was changed. Make a new request.");                        
                if($post_type=='post'){
                    $post_timestamp = strtotime($post_date_gmt) + (get_option('gmt_offset') * 3600);
                    $cms_request_id = $iclq->submit_post_translation($post_id, $post_title, $permalink, $this_languages, $post_timestamp, $is_update);
                }else{
                    $cms_request_id = $iclq->submit_page_translation($post_id, $post_title, $permalink, $this_languages, $is_update);                    
                }  
                if(!$cms_request_id){                
                    if(ICLT_DEBUG_MODE) iclt_debug_log("No cms request id returned");                                
                    $needs_update_due_to_fail = 1;
                    $current_checksum = '';
                }else{
                    $needs_update_due_to_fail = 0;
                    if(ICLT_DEBUG_MODE) iclt_debug_log("CMS request id returned: {$cms_request_id}");                                        
                }
                
                //store a MD5 checksum of the content                
                $wpdb->query("UPDATE {$wpdb->prefix}translation_requests SET 
                                cms_request_id='{$cms_request_id}',
                                cms_request_status='1', 
                                content_checksum = '{$current_checksum}', 
                                needs_update = '{$needs_update_due_to_fail}', 
                                cms_request_languages='$custom_languages',
                                date = NOW()    
                             WHERE post_id=".$post_id);                
            }
            if(ICLT_DEBUG_MODE) iclt_debug_db_snapshot('after-submit-with-previous-request');
        }   
        /*****************************************************************************************************************************************/
        
        // if the post was added to the mass translation queue - remove it from there now     
        $wpdb->query("DELETE FROM {$wpdb->prefix}translation_jobs WHERE post_id=".$post_id);
        if(ICLT_DEBUG_MODE) iclt_debug_func_end();        
    }
    
    function delete_post_actions($post_id){
        global $wpdb;
        $req_id = $wpdb->get_var("SELECT cms_request_id FROM {$wpdb->prefix}translation_requests WHERE post_id=".$post_id);
        $this->cancel_translation_request(intval($req_id));
    }
    
    function management_page(){
        add_options_page('ICanLocalize Translator','ICanLocalize Translator','10', 'iclt' , array($this,'management_page_content'));
        add_management_page(__('Translation Cart'),__('Translation Cart'),'10', 'iclt' , array($this,'mass_translation_page_content'));
    }  
    
    function management_page_content(){
        $iclq = new ICLQuery($this->settings);
        if(!$iclq->error()){
            $languages = $iclq->get_languages(); //use this to validate curent settings
        }
        if($_GET['iclt_error_message'] || $iclq->error()){
            $help_icon_image = 'RO-Mx1-24_circle-red-i.png';
            $help_bg_style = ';background-color:#ffd3d3;';
        }else{
            $help_icon_image = 'RO-Mx1-24_circle-help-1.png';
            $help_bg_style = '';            
        }                
        include ICLT_PATH.'/options_interface.php';
        
    }
    function mass_translation_page_content(){
        $jobs = $this->get_batch_jobs();
        include ICLT_PATH . '/mass_translation_interface.php';
    }    
    
    function post_edit_options(){
        add_meta_box('icltdiv', __('Translating options'), array($this,'meta_box'), 'post', 'normal', 'high');
    }
    
    function page_edit_options(){
        add_meta_box('icltdiv', __('Translating options'), array($this,'meta_box'), 'page', 'normal', 'high');
    }
    
    function meta_box($post){            
        global $wpdb;
        
        if($post->ID){ 
            $is_translation = get_post_meta($post->ID,'_ican_from_language',true);
            if($is_translation){
                ?>
                <table width="100%"><tr><td width="50%" valign="top">
                    <tr>
                        <td align="center"><?php echo sprintf(__('%s translation'),get_post_meta($post->ID,'_ican_language',true)) ?></td>
                    </tr>
                </table>
                <?php
                return;
            }        
        }

        ?>
        <input type="hidden" id="iclt_translation_request_confirmed" name="iclt_translation_request_confirmed" value="true" />
        <?php
        
        $settings = get_option('iclt_settings');
        $iclq = new ICLQuery($settings);
                
        if($post->ID){
            $post_request = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}translation_requests WHERE post_id=".$post->ID);
        }    
        $content_modified = intval($post_request->needs_update);
                                                  
        if($content_modified){
            ?><input type="hidden" name="iclt_needs_translation_update" value="1" /><?php
        }
        
        //test whether the parent page is translated
        if(is_object($post->post_parent)){
            $post_parent_id = $post->post_parent->ID;
        }else{
            $post_parent_id = $post->post_parent;
        }        
        if($post->post_type=='page' && $post->post_parent > 0){
            $p_cms_request_status = intval($wpdb->get_var("SELECT cms_request_status FROM {$wpdb->prefix}translation_requests WHERE post_id='{$post_parent_id}'"));            
            if($p_cms_request_status < CMS_REQUEST_DONE){
               $pp_not_translated = 'disabled="disabled"'; 
               echo '<p>' . __('Parent post not translated!') . '</p>';    
            }
        }
                
        $el = unserialize($post_request->cms_request_languages);
        if($el){
            foreach($el as $ele){
                $enabled_languages[] = $ele['to_name'];            
            }
            $post_from_language = $el[0]['from_name'];
        }
        $languages = $settings['languages'];            
        //existing post/page
        if($post->ID){ 
            $cms_request_id = $post_request->cms_request_id;
            if(!is_null($cms_request_id)){
                $cms_request_status = $post_request->cms_request_status;
                if($cms_request_status == CMS_REQUEST_DONE || $cms_request_id==0){
                    if($content_modified){
                        $translation_status = __('Translation needs update');
                    }else{                                               
                        $translation_status = __('Translation complete');
                    }                    
                }
                elseif($cms_request_status == CMS_REQUEST_FAILED){
                    $translation_status =  __('Translation failed');  
                    $translation_status_message = '<strong style="color:#f00;">'.$post_request->cms_request_status_message.'</strong>';
                }else{
                    $chkbox_disabled = 'disabled="disabled"';
                    if($content_modified && $cms_request_status > CMS_REQUEST_TRANSLATED){
                        $translation_status = __('Translation needs update');
                    }else{
                        if($cms_request_status==CMS_REQUEST_WAITING_FOR_PROJECT_CREATION){
                            $translation_status = __('Waiting for translator');
                        }elseif($cms_request_status==CMS_REQUEST_RELEASED_TO_TRANSLATORS){
                            $translation_status = __('Translation in progress');
                        }elseif($cms_request_status==CMS_REQUEST_TRANSLATED){
                            $translation_status = __('Translated');
                        }
                    }
                }
            }else{
                $translation_status = __('Not translated');
            }
        }else{ //new post/page
            $translation_status = __('Not translated');            
        }
        ?>
        <table width="100%"><tr><td width="50%" valign="top">
        
        <?php 
            foreach($languages as $lt){
                $blog_lang_options[$lt['from_name']][] = $lt['to_name'];
            } 
        ?>
        Language: <select name="iclt_post_language" 
            onchange="set_translate_to_values(this.value, <?php echo intval($post->ID)?>)"
            <?php echo $pp_not_translated ?>  <?php echo $chkbox_disabled ?>>
        <?php foreach($blog_lang_options as $k=>$v): ?>
        <?php if(($chkbox_disabled || $pp_not_translated) && $post_from_language!=$k) continue; ?>
        <option value="<?php echo $k ?>"  
            <?php if($post_from_language==$k): ?>selected="selected"<?php endif; ?>
            <?php if(!isset($post_from_language) && $this->settings['iclt_blog_language']==$k):?>selected="selected"<?php endif?>>
            <?php echo $k ?></option>
        <?php endforeach; ?>            
        </select>
        
        <?php
        if(is_array($blog_lang_options[$this->settings['iclt_blog_language']]) && count($blog_lang_options[$this->settings['iclt_blog_language']])){
            ?>
            <div id="translate_post_to"> <?php echo __('Translate_to:') ?> 
            <?php 
                if(!isset($post_from_language)){
                    $to_languages = $blog_lang_options[$this->settings['iclt_blog_language']];
                }else{
                    $to_languages = $blog_lang_options[$post_from_language];
                }
            ?>
            <?php foreach($to_languages as $l): ?>
            <input class="iclt_trans_lang" type="checkbox" name="target_languages[]" value="<?php echo $l ?>" <?php echo $pp_not_translated  ?>  <?php echo $chkbox_disabled ?>
                <?php if(!is_array($enabled_languages) || in_array($l,$enabled_languages)): ?>checked="checked"<?php endif; ?>/>
                <?php echo $l ?>&nbsp;&nbsp;
            <?php endforeach; ?>
            </div>
            <?php
        }else{
            echo  __('No language preference set') ;
        }     
        ?>
        </td>
        <td align="right">
        <?php if($cms_request_status == CMS_REQUEST_DONE || $cms_request_status==0 || 
                ($content_modified && $cms_request_status > CMS_REQUEST_TRANSLATED) || 
                $cms_request_status == CMS_REQUEST_FAILED || $cms_request_id === '0'): ?>
        <?php             
            $translate_on = get_post_meta($post->ID,'_iclt_translate_on',true);
            if(''==$translate_on){
                $translate_on = $this->settings['translate_new_contents_when_published'];
            }
        ?>
        <select id="translate_when" name="translate_when" style="margin-bottom:5px;" <?php echo $pp_not_translated  ?>>
            <?php if($post->post_status=='draft'):?>
            <option value="1"><?php echo __('Translate when published') ?></option>
            <?php endif;?>
            <option value="2"><?php echo __('Translate on next save') ?></option>
            <?php if(!$cms_request_id):?>
            <option value="3" <?php if(!$translate_on):?>selected="selected"<?php endif;?>><?php echo __('Don\'t translate yet') ?></option>
            <?php endif;?>
            <?php if($cms_request_id):?>
            <option value="4" <?php if(!$translate_on):?>selected="selected"<?php endif;?>><?php echo __('Don\'t update translation') ?></option>
            <?php endif;?>
        </select>        
        <br />
        <?php endif; ?>
        <?php echo __('Translation status') ?>: <i><?php echo $translation_status ?></i>        
        </td></tr>
        <tr>
            <td colspan="2"><?php echo $translation_status_message ?></td>
        </tr>
        </table>
        <?php        
        
    }
        
    //on the options page and on the category edit page
    function js_scripts(){
        ?>   
        <script type="text/javascript">
        <?php if(preg_match('#^/wp-admin/(edit|options-general)\.php#i',$_SERVER['REQUEST_URI'])) :?>       
        function update_lng(site_id,access_key){
            jQuery('#the_languages').html('loading...');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=update_languages&iclt_site_id="+site_id+"&iclt_access_key="+access_key+"&_wpnonce=<?php echo wp_create_nonce('update-incalocalize')?>",
                success: function(msg){
                    jQuery('#the_languages').html(msg);
                }
            });
        } 
        <?php endif; ?>
        
        <?php if(preg_match('#^/wp-admin/(post|page)(-new)?\.php#i',$_SERVER['REQUEST_URI'])) :?>       
        function set_translate_to_values(new_lang,post_id){
            jQuery('#translate_post_to').html('loading...');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=set_translate_to_values&lang="+new_lang+"&post_id="+post_id,
                success: function(msg){
                    jQuery('#translate_post_to').html(msg);
                }
            });
        }   
        <?php //function for prompting users to confirm post/page translation ?>     
        <?php if(!$this->settings['no_translation_confirmation']): ?>     
        addLoadEvent(function(){     
            var publish_pressed = false;
            jQuery('#publish').click(function(){
                publish_pressed = true;
            });
            jQuery('#post').submit(function(){
                    if(jQuery('#translate_when').attr('disabled')){
                        return;
                    }
                    var tw = jQuery('#translate_when').attr('value');
                    var ps = jQuery('#post_status').attr('value');
                    if(tw !=1 && tw !=2){return};      
                    if(ps=='draft' && tw==1 && !publish_pressed){return};                                        
                    <?php 
                        global $wpdb;
                        $post_id = $_GET['post']; 
                        if($post_id){
                            $translated = $wpdb->get_var("SELECT translated FROM {$wpdb->prefix}translation_requests WHERE post_id={$post_id}");
                        }
                        if($translated){
                            $conf_text = __('Are you sure you want to update this document\\\'s translation?');
                        }else{
                            $conf_text = __('Are you sure you want to send this document to translation?');
                        }
                    ?>
                    var resp = confirm('<?php echo $conf_text ?>');
                    jQuery('#iclt_translation_request_confirmed').attr('value',resp);    
                }        
            )        
        });
        <?php endif; ?>
        <?php endif; ?>
        
        <?php if(preg_match('#^/wp-admin/page(-new)?\.php#i',$_SERVER['REQUEST_URI'])) :?>       
        addLoadEvent(function(){            
            var parentid = 0;            
            jQuery('#parent_id').after('<span style="color:#999;padding:6px" id="__ctltmpmsg"></span>');
            jQuery('#parent_id').change(function(){
                jQuery('#parent_id').attr('disabled','disabled');
                               
                parentid = jQuery('#parent_id').attr('value');                
                if(parentid > 0){
                    jQuery('#__ctltmpmsg').html('<?php echo __('checking page translation status') ?>');
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo ICLT_URL ?>",
                        data: "ajx_action=get_page_translation_status&page_id="+parentid,
                        success: function(msg){
                            jQuery('#parent_id').removeAttr('disabled');                            
                            if(0 == msg){
                                jQuery('#__ctltmpmsg').html('<?php echo __('Parent page not translated.')?>');
                                jQuery('#translate_when').attr('disabled','disabled');
                                jQuery('.iclt_trans_lang').attr('disabled','disabled');                                
                            }else{
                                jQuery('#__ctltmpmsg').html('');
                                jQuery('#translate_when').removeAttr('disabled');
                                jQuery('.iclt_trans_lang').removeAttr('disabled');                                                               
                            }
                        }
                    });
                }else{
                    jQuery('#parent_id').removeAttr('disabled');                                                                                         
                    jQuery('#translate_when').removeAttr('disabled');
                    jQuery('.iclt_trans_lang').removeAttr('disabled');                                                                                   
                    jQuery('#__ctltmpmsg').html('');
                }
            });                        
        });
        <?php endif; ?>
        </script>            
        <?php if(preg_match('#^/wp-admin/(edit|edit-pages|tools)\.php#i',$_SERVER['REQUEST_URI']) || defined('TRIGGER_MASS_TRANSLATION')) :?>       
        <?php 
            global $wpdb;
            $doc_count = intval($wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}translation_jobs"));
            $wrd_count = intval($wpdb->get_var("SELECT SUM(word_count) FROM {$wpdb->prefix}translation_jobs"));
            $pnd_count = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}translation_requests WHERE cms_request_status < " . CMS_REQUEST_DONE . " AND cms_request_id > 0"));
            if($doc_count==0){
                $cart_empty='-outline';
                $start_but_disabled='disabled="disabled"';
            }else{
                $cart_empty='';
                $start_but_disabled='';
            }                        
            $sufi = '';
            if($_GET['page']!=iclt){
                $prefi = '<br />';
                $sufi  = '<a href="tools.php?page=iclt">['.__('view').']</a>';
                $sufi .= '<input class="iclt_start_batch2 button" type="button" value="'.__('Start').'" '.$start_but_disabled.' />';
            }  
            $errbox .= '<div id="iclt_error_pop"><div style="font-weight:bold"></div><div></div><center><strong><a href="javascript:;" onclick="iclt_close_error_pop()">'.__('close').'</a></strong></center></div>';                      
        ?>
        <style>
        #iclt_error_pop{
            display:none;position:absolute;padding:4px;background-color:#FFCCCC;border:1px solid #FF8F8F;color:#111;
        }               
        .iclt_center_box{
            min-width:200px;min-height:100px;
            left:50%;top:50%;
        }
        </style>
        <script type="text/javascript">            
        var ajximg;
        addLoadEvent(function(){        
            ajximg = new Image(12,12);
            ajximg.src = '<?php echo ICLT_PLUGIN_URL ?>/img/ajax-loader.gif';                
            jQuery(".iclt_add_to_bt a").click(manage_translation_batch);            
            jQuery("th:contains('<?php echo __('Translation')?>')").attr('width','100');
            jQuery(".subsubsub").append('<span id="iclt_subsubsub"><?php if($doc_count) echo $prefi . '<img src="'.ICLT_PLUGIN_URL.'/img/RO-Mx1-24_shopping-cart'.$cart_empty.'.png" height="24" width="24" alt="Cart" />' . sprintf(__('%d document(s) with %d words in the translation cart.'), $doc_count, $wrd_count) ?> <?php if($doc_count) echo $sufi; echo $errbox; ?></span>');
            <?php if($pnd_count): ?>
            jQuery(".subsubsub").append('<br /><?php echo sprintf(__('%d translation(s) in progress. <a href="options-general.php?page=iclt#translations_in_progress">View status or cancel jobs &raquo;</a>'),$pnd_count);?>');
            <?php endif; ?>
            jQuery("#iclt_start_batch").click(start_batch_translation);
            jQuery("#iclt_stop_batch").click(stop_batch_translation);            
            jQuery(".iclt_start_batch2").click(go_to_start_batch_translation);
            <?php if(basename($_SERVER['SCRIPT_NAME'])=='tools.php' && $_GET['page']=='iclt' && $_GET['start']==1): ?>
            start_batch_translation();
            <?php endif; ?>
        });
        var add_to_translation_batch_req_sent = new Array();
        var rem_from_translation_batch_req_sent = new Array();
        function manage_translation_batch(){            
            var id = jQuery(this).attr('id').replace(/iclt-bt-/,'');
            var op = jQuery(this).attr('class'); 
            if(op=='add'){
                if(add_to_translation_batch_req_sent[id]) return;
                add_to_translation_batch_req_sent[id]=1;
            }else{
                if(rem_from_translation_batch_req_sent[id]) return;
                rem_from_translation_batch_req_sent[id]=1;                
            }
            var thisa = jQuery(this);
            thisa.html('<img src="'+ajximg.src+'" width="12" height="12" />');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=manage_translation_batch&id="+id+"&op="+op,
                success: function(msg){ 
                    mes = msg.split('#');                                      
                    if(-1 == mes[0]){                                        
                      add_to_translation_batch_req_sent[id] = 0;                      
                      jQuery("#iclt_error_pop").addClass('iclt_center_box');                 
                      jQuery("#iclt_error_pop div").eq(0).html(mes[1]);                      
                      jQuery("#iclt_error_pop div").eq(1).html(mes[2]);                                                                  
                      jQuery("#iclt_error_pop").show();                      
                      jQuery("#iclt_error_pop").css('left', window.innerWidth/2 - parseInt(jQuery("#iclt_error_pop").css('width'))/2);               
                      thisa.html('<?php echo __('add')?>');
                    }
                    else 
                    if(0 == mes[0]){
                        thisa.parent().after('<br clear="all" /><small><?php echo __('Error')?></small>');
                    }else{
                        jQuery("#iclt_subsubsub").html(mes[2]);
                        thisa.removeClass(op);
                        if(op=='add'){
                            thisa.html('<?php echo __('rem')?>');                            
                            thisa.attr('title','<?php echo __('Remove from batch translation') ?>');
                            jQuery("#ajxrespiclt-"+id).html('<?php echo __('Added to batch')?>');                            
                            thisa.addClass('rem');
                            rem_from_translation_batch_req_sent[id]=0;
                        }else{
                            if('mass' == thisa.attr('rel')){
                                thisa.parent().parent().parent().fadeOut();
                            }else{
                                thisa.html('<?php echo __('add')?>');
                                thisa.attr('title','<?php echo __('Add to batch translation') ?>');
                                jQuery("#ajxrespiclt-"+id).html('<?php echo __('Removed from batch')?>');                            
                                thisa.removeClass('rem');
                                thisa.addClass('add');                                
                            }
                            if(mes[1]){
                                eliminate = mes[1].split(',');
                                for(i=0;i<eliminate.length;i++){
                                    eliminate_children_recursive(eliminate[i]);    
                                }
                            }
                            add_to_translation_batch_req_sent[id]=0;
                        }
                    }
                }
            });
            
        }
        function iclt_close_error_pop(){
            jQuery("#iclt_error_pop div.eq(0)").html('');
            jQuery("#iclt_error_pop div.eq(1)").html('');
            jQuery("#iclt_error_pop").fadeOut();            
        }
        function eliminate_children_recursive(id){
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=manage_translation_batch&id="+id+"&op=rem",
                success: function(msg){ 
                    add_to_translation_batch_req_sent[id]=0; 
                    mes = msg.split('#');     
                    thisa = jQuery("#iclt-bt-"+id);
                    if('mass' == thisa.attr('rel')){
                                thisa.parent().parent().parent().fadeOut();
                    }else{
                        thisa.html('<?php echo __('add')?>');
                        thisa.attr('title','<?php echo __('Add to batch translation') ?>');
                        jQuery("#ajxrespiclt-"+id).html('<?php echo __('Removed from batch')?>');                            
                        thisa.removeClass('rem');
                        thisa.addClass('add');
                    }                    
                    jQuery("#iclt_subsubsub").html(mes[2]);
                    if(mes[1]){
                        eliminate = mes[1].split(',');
                        for(i=0;i<eliminate.length;i++){
                            eliminate_children_recursive(eliminate[i]);    
                        }
                    }
                }
            });            
        }
        
        var is_stop_batch_translation = false;
        function start_batch_translation(){
            is_stop_batch_translation = false;
            jQuery("#iclt_batch_status").html('<?php echo __('Starting') ?>');             
            jQuery("#iclt_start_batch").attr('disabled','disabled');    
            jQuery("#iclt_stop_batch").fadeIn();
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=start_translation_batch",
                success: function(msg){
                    spl = msg.split('#');
                    jQuery("#iclt_batch_status").html(spl[1]);             
                    if(spl[0] > 0){
                        window.setTimeout(get_batch_translation_status,5000);
                    }else{
                        jQuery("#iclt_start_batch").removeAttr('disabled');                           
                        jQuery("#iclt_stop_batch").hide();
                    } 
                }
            });                                                
            return false;
        }
        
        var iclt_chk_st_to;
        function get_batch_translation_status(){
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=get_translation_batch_status",
                success: function(msg){
                    spl = msg.split('#');
                    jQuery("#iclt_batch_status").html(spl[1]);             
                    jQuery("#iclt_mass_tr_status").html(spl[1]);                                 
                    if(spl[0] > 0 && !is_stop_batch_translation){
                        iclt_chk_st_to = window.setTimeout(get_batch_translation_status,5000);
                    }else{
                        jQuery("#iclt_start_batch").removeAttr('disabled');                           
                        jQuery("#iclt_stop_batch").hide();
                    }
                    jQuery("#iclt_mass_tr_"+spl[2]).fadeOut();
                    jQuery("#iclt_subsubsub").html(spl[3]);
                }
            });                                    
        }
                
        function stop_batch_translation(){            
            is_stop_batch_translation = true;
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=stop_translation_batch",
                success: function(msg){
                    spl = msg.split('#');
                    jQuery("#iclt_batch_status").html(spl[1]);             
                    if(spl[0] > 0){
                        jQuery("#iclt_start_batch").removeAttr('disabled');                           
                        jQuery("#iclt_stop_batch").hide();
                        window.clearTimeout(iclt_chk_st_to);
                    }else{
                        ;                        
                    }                     
                }
            });                                                            
        }
        function go_to_start_batch_translation(){
            location.href='tools.php?page=iclt&start=1';
            return false;
        }
        </script>            
        <?php endif; ?>
        <?php if(FAILED_REQUESTS_COUNT > 0): ?>
        <script type="text/javascript">
        addLoadEvent(function(){        
           jQuery("#dashmenu").append('<li><a  style="color:#f99" href="options-general.php?page=iclt"><?php echo __('Failed translation requests:') . ' ' . FAILED_REQUESTS_COUNT ?></a></li>');
        });
        </script>
        <?php endif; ?>
        
        <script type="text/javascript">
        function iclt_cancel_request(req_id, al){
            if(!confirm('<?php echo __('Are you sure you want to cancel this request?')?>')) return;
            thisa = al;
            jQuery.ajax({
                type: "POST",
                url: "<?php echo ICLT_URL ?>",
                data: "ajx_action=cancel_request&request_id="+req_id,
                success: function(msg){
                    spl=msg.split('|');
                    if(parseInt(spl[0]) < 1){
                        alert('Error: ' + spl[1]);
                    }else{
                        thisa.parentNode.parentNode.style.display='none';
                    }                    
                }
            });                                                            
        }
        </script>        
        
        
        <?php        
    }
        
    function add_posts_management_column($columns){
        
        global $wp_query, $wpdb, $iclt_posts_statuses;        
        $columns['translation_status'] = __('Translation');
        
        if(!defined('ICLT_RUN_ONCE_PREPARE_DATA_16081980')){
            // prepare data        
            if(empty($wp_query->posts)) return array();
            
            foreach ( $wp_query->posts as $a_post ){
                $post_ids[] = $a_post->ID;
            }        
            $pids = join(',',$post_ids);

            $res = $wpdb->get_results("
                        SELECT post_id, cms_request_id, cms_request_status, cms_request_status_message, needs_update 
                        FROM {$wpdb->prefix}translation_requests WHERE post_id IN ({$pids})");
            foreach($res as $r){
                $reqs[$r->post_id] = $r;            
            }                   
            $res = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}translation_jobs WHERE post_id IN({$pids})");
            foreach($res as $r){
                $req_btch[$r->post_id] = 1;            
            } 
            $res = $wpdb->get_results("
                SELECT p1.post_id, p1.meta_value FROM {$wpdb->postmeta} p1
                    JOIN {$wpdb->postmeta} p2 ON p1.post_id=p2.post_ID
                WHERE p1.post_id IN({$pids}) AND p1.meta_key='_ican_language' AND p2.meta_key='_ican_from_language'");
            foreach($res as $r){
                $req_trslt[$r->post_id] = $r->meta_value;            
            } 
            
            
            foreach($post_ids as $p){
                $add_but = 0;
                if(isset($req_trslt[$p])){
                    $st = sprintf(__('%s translation'),$req_trslt[$p]);                
                }elseif( ($reqs[$p]->needs_update  && $reqs[$p]->cms_request_status > CMS_REQUEST_TRANSLATED) || $reqs[$p]->cms_request_id==='0'){
                    $st = __('Needs update');                
                    $add_but = 1;
                }elseif($reqs[$p]->cms_request_status == CMS_REQUEST_DONE){
                    $st = __('Translated');
                }elseif($reqs[$p]->cms_request_status == CMS_REQUEST_FAILED){
                    $st = '<acronym style="cursor:help" title="'. $reqs[$p]->cms_request_status_message.'">' . __('Failed') . '</acronym>';
                    $add_but = 1;
                }elseif($reqs[$p] && $reqs[$p]->cms_request_status < CMS_REQUEST_DONE && $reqs[$p]->cms_request_id > 0){                    
                    if($reqs[$p]->cms_request_status==CMS_REQUEST_WAITING_FOR_PROJECT_CREATION){
                        $st = __('Waiting for translator');
                    }elseif($reqs[$p]->cms_request_status==CMS_REQUEST_RELEASED_TO_TRANSLATORS){
                        $st = __('Translation in progress');
                    }elseif($reqs[$p]->cms_request_status==CMS_REQUEST_TRANSLATED){
                        $st = __('Translated');
                    }
                    
                }else{
                    $st = __('Not translated');
                    $add_but = 1;
                }
                if($add_but){       
                    if(isset($req_btch[$p])){
                        $class = 'rem';
                        $title = __('Remove from batch translation');                    
                        $text  = __('rem');
                        $sm_text = __('Added to batch');
                    }else{
                        $class = 'add';
                        $title = __('Add to batch translation');
                        $text  = __('add');
                        $sm_text = '';
                    }
                    $st = '<div style="float:left">' . $st . '</div>';
                    $st .= '<div class="iclt_add_to_bt" style="float:right;"><a id="iclt-bt-'.$p.'" class="'.$class.'" href="javascript:;" title="'.$title.'">'.$text.'</a></div>';
                    $st .= '<br clear="all" /><small id="ajxrespiclt-'.$p.'">'.$sm_text.'</small>';
                }                        
                $iclt_posts_statuses[$p] = $st;
            }
            define('ICLT_RUN_ONCE_PREPARE_DATA_16081980',true);
        }
        
        return $columns;
    }
    
    function add_content_for_posts_management_column(){
        global $id, $iclt_posts_statuses;
        echo $iclt_posts_statuses[$id];
    }
    
    function add_custom_xmlrpc_methods($methods){
        $methods['ictl.setTranslationStatus'] = 'ICanLocalizeSetTranslationStatus';
        $methods['ictl.setLanguagesInfo'] = 'ICanLocalizeSetLanguagesInfo';        
        $methods['ictl.icanValidate'] = 'ICanLocalizeValidate';
        $methods['ictl.sendToTranslation'] = 'ICanLocalizeSendToTranslation';
        $methods['ictl.listPosts'] = 'ICanLocalizeListPosts';
        $methods['ictl.getCategories'] = 'ICanLocalizeGetCategories';
        $methods['ictl.cancelTranslationRequest'] = 'ICanLocalizeCancelTranslationRequest';
        return $methods;
    }
    
    function get_batch_jobs(){
        global $wpdb;
        $res = $wpdb->get_results("
            SELECT post_date, post_title, post_content, post_type, post_status, p2.post_id, p3.needs_update 
            FROM {$wpdb->posts} p1 
            RIGHT JOIN {$wpdb->prefix}translation_jobs p2 ON p1.ID=p2.post_id 
            LEFT JOIN {$wpdb->prefix}translation_requests p3 ON p2.post_id=p3.post_id
        ");
        foreach($res as $k=>$row){
            $res[$k]->permalink = get_permalink($res[$k]->post_id);
        }
        return $res;
    }
    
    // processes the next element in the jobs queue
    // returns true(1) if there are any more fields left
    function process_batch_job_item(){
        global $wpdb;
        
        $now = time();
        $last_job_time = get_option('__iclt_batch_last_job_time');
        if($now - $last_job_time < 5){            
            return array(0, intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}translation_jobs")));    
        }else{
            update_option('__iclt_batch_last_job_time',$now);    
        }
                
        $res = $wpdb->get_results("
            SELECT p1.post_id, p2.post_title, p2.post_date, p2.post_type, p3.needs_update, p3.cms_request_languages 
            FROM {$wpdb->prefix}translation_jobs p1 
                JOIN {$wpdb->posts} p2 ON p1.post_id=p2.ID
                LEFT JOIN {$wpdb->prefix}translation_requests p3 ON p1.post_id=p3.post_id
            ORDER BY p1.id ASC LIMIT 2
            ");  
        if(!$res){
            $ret_val = 0;
        }else{
            $item = $res[0];
            $permalink = get_permalink($item->post_id);
            $is_update = intval($item->needs_update);
            $languages = unserialize($item->cms_request_languages);
            if(!$languages){
                $languages = $this->settings['languages'];
                $blog_language = $this->settings['iclt_blog_language'];                
                foreach($languages as $k=>$l){
                    if($l['from_name']!=$blog_language){
                        unset($languages[$k]);
                    }
                }
            }            
            $iclq = new ICLQuery($this->settings);
            if($item->post_type=='post'){
                $post_timestamp = strtotime($item->post_date_gmt) + (get_option('gmt_offset') * 3600);
                $cms_request_id = $iclq->submit_post_translation($item->post_id,$item->post_title,$permalink, $languages, $post_timestamp, $is_update);
            }else{
                $cms_request_id = $iclq->submit_page_translation($item->post_id,$item->post_title,$permalink, $languages, $is_update);
            }  
            
            if($cms_request_id){
                
                $_tags = (array)get_the_tags($item->post_id);
                foreach($_tags as $t){ $_ts[] = $t->name; }
                sort($_ts, SORT_STRING);
                $tags = join(',',$_ts);
                
                $_categories = (array)get_the_terms($item->post_id,'category'); 
                foreach($_categories as $c){ $_cs[] = $c->term_taxonomy_id; }        
                sort($_cs, SORT_NUMERIC);                  
                $categories = join(',',$_cs);
                
                $current_checksum = md5($post_content.$post_title.join(',',(array)$post_tags).join(',',(array)$post_categories));
                
                if($wpdb->get_var("SELECT id FROM {$wpdb->prefix}translation_requests WHERE post_id=".$item->post_id)){
                    $wpdb->query("UPDATE {$wpdb->prefix}translation_requests SET 
                                    cms_request_id='{$cms_request_id}',
                                    cms_request_status='1', 
                                    content_checksum = '{$current_checksum}', 
                                    needs_update = '0', 
                                    date = NOW()    
                                 WHERE post_id=".$item->post_id);                                
                }else{
                    $wpdb->query("INSERT INTO {$wpdb->prefix}translation_requests(post_id,cms_request_id,cms_request_status,content_checksum,needs_update,date)
                    VALUES('{$item->post_id}','{$cms_request_id}','1','{$current_checksum}','0',NOW())");
                } 
                
                $wpdb->query("DELETE FROM {$wpdb->prefix}translation_jobs WHERE post_id=".$item->post_id);               
            }else{
                $ret_val = 1;
            }
            
            if($res[1]){
                $ret_val = 1;
            }else{
                $ret_val = 0;
            }
        }
        update_option('__iclt_batch_status',$ret_val);
        return array($item->post_id, intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}translation_jobs")));    
    }
    
    function trigger_mass_translation_job(){
        ?>
        <script type="text/javascript">                                    
        addLoadEvent(function(){
                get_batch_translation_status();
                jQuery("#dashmenu").append('<li style="color:#fff"><?php echo __('Mass translation status:') ?> <span id="iclt_mass_tr_status"></span><a href="edit.php?page=iclt">[<?php echo __('manage')?>]</a></li>');
        });
        </script>
        <?php
        
    }
    
    function get_failed_requests_count(){
        global $wpdb;
        return intval($wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}translation_requests WHERE cms_request_status='".CMS_REQUEST_FAILED."'"));
    }
    
    function cancel_translation_request($request_id, $local = false){
        global $wpdb, $iclq;        
        $res = array(1,'OK');
        
        $rw = $wpdb->get_row("SELECT post_id, cms_request_status FROM {$wpdb->prefix}translation_requests WHERE cms_request_id=".$request_id);        
        $pid = $rw->post_id;        
        if($rw->cms_request_status > CMS_REQUEST_WAITING_FOR_PROJECT_CREATION){
            $res = array(0, __('Can\'t delete. Translation already started'));
        }else{

            if(!isset($iclq) || !$iclq){
                $iclq = new ICLQuery($this->settings);        
            }
            if(!$local){
                $res = $iclq->cancel_translation_request($request_id);            
                if(!$res[0]){
                    return $res;
                }
            }
            
            $wpdb->query("DELETE FROM {$wpdb->prefix}translation_requests WHERE cms_request_id=".$request_id);
            if(!mysql_affected_rows()){
                return array(0, __('Translation request not found'));
            }
            $wpdb->query("DELETE FROM {$wpdb->prefix}translation_jobs WHERE post_id=".$pid);
        }
        
        return $res;
        
    }
} ?>