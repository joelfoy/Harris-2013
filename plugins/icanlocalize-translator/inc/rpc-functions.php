<?php
function ICanLocalizeSetTranslationStatus($args){
        if(ICLT_DEBUG_MODE) iclt_debug_func_start();        
        global $wpdb;        
        $user_login  = $args[0];
        $user_pass   = $args[1];
        
        $cms_request_id = mysql_real_escape_string($args[2]);
        $status_id = intval($args[3]);
        $cms_request_status_message = mysql_real_escape_string($args[4]);      
        
        if(ICLT_DEBUG_MODE) iclt_debug_log(sprintf("CMS request id: %s | status id: %s | cms request messageL %s",
            $cms_request_id,$status_id,$cms_request_status_message));        
        
        if ( !get_option( 'enable_xmlrpc' ) ) {
            return sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php'));
        }
        if (!user_pass_ok($user_login, $user_pass)) {
            return 'Bad user/pass combination';
        }
                
        if(!$cms_request_id || !$status_id) return 0;
        $post_id = $wpdb->get_var("SELECT post_id FROM {$wpdb->prefix}translation_requests WHERE cms_request_id='{$cms_request_id}'");
        
        $translated = $status_id==CMS_REQUEST_DONE?1:0;
        $wpdb->update($wpdb->prefix.'translation_requests', 
            array('cms_request_status'=>$status_id,'translated'=>$translated, 'cms_request_status_message'=>$cms_request_status_message), 
            array('post_id'=>$post_id)
        );
        
        if($status_id==CMS_REQUEST_DONE || $status_id==CMS_REQUEST_FAILED){
            // delete the item from the batch table
            $wpdb->query("DELETE FROM {$wpdb->prefix}translation_jobs WHERE post_id=".$post_id);
        }
        if(ICLT_DEBUG_MODE) iclt_debug_log('Post id: ' . $post_id);
        if(ICLT_DEBUG_MODE) iclt_debug_func_end();        
        return intval($post_id);
}  
 
function ICanLocalizeSetLanguagesInfo($args){
        if(ICLT_DEBUG_MODE) iclt_debug_func_start();        
        global $wpdb, $iclt;
        
        $user_login  = $args[0];
        $user_pass   = $args[1];
        
        $post_id = $args[2];                
        $link_info_for_language = $args[3];
        
        if ( !get_option( 'enable_xmlrpc' ) ) {
            return sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php'));
        }
        if (!user_pass_ok($user_login, $user_pass)) {
            return 'Bad user/pass combination';
        }
                                
        if($post_id){
            $plugin_settings = $iclt->get_settings();                
            $post_language = $plugin_settings['languages'][0]['from_name']; 
            update_post_meta($post_id,'_ican_language',$post_language);
            update_post_meta($post_id,'_ican_link_info_for_language',$link_info_for_language);
        }
        if(ICLT_DEBUG_MODE) iclt_debug_log('Post id: ' . $post_id);
        if(ICLT_DEBUG_MODE) iclt_debug_func_end();        
        return intval($post_id);
}       

function ICanLocalizeValidate($args){ 
        $user_login  = $args[0];
        $user_pass   = $args[1];
        
        if ( !get_option( 'enable_xmlrpc' ) ) {
            return array('err_code'=>3, 'err_str'=>sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php')));
        }
        
        if (!user_pass_ok($user_login, $user_pass)) {
            return 2; //ERROR - user or password don’t match
        }
        
        $user = set_current_user( 0, $user_login );
        
        if($user->caps['editor'] || $user->caps['administrator']){
            return 0; //OK - user exists and has editor privileges (is editor or admin
        }else{
            return 1; //ERROR - user exists but cannot edit
        }
    
}  

function ICanLocalizeSendToTranslation($args){
        global $wpdb, $iclt;
        $user_login  = $args[0];
        $user_pass   = $args[1];
        $post_id     = intval($args[2]);
        $from_language = $args[3];
        $to_languages  = explode(',',$args[4]);
        
        
        if ( !get_option( 'enable_xmlrpc' ) ) {             
            return array('err_code'=>3, 'err_str'=>sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php')));
        }
        
        if (!user_pass_ok($user_login, $user_pass)) {         
            return array('err_code'=>2, 'err_str'=>sprintf( __( 'ERROR - user or password don’t match')));
        }        
                
        $iclt_settings = $iclt->get_settings();
        $iclq = new ICLQuery($iclt_settings);
        
        if($from_language && $to_languages){
            foreach($to_languages as $tl){
                $languages[] = array(
                    'from_name'=>$from_language,
                    'to_name'=>$tl
                );
            }
        }else{
            $languages = $iclt_settings['languages'];
        }
                
        $res = $wpdb->get_row("SELECT cms_request_id, needs_update 
            FROM {$wpdb->prefix}translation_requests WHERE post_id={$post_id} AND cms_request_status<>'6'");                    
        if($res->cms_request_id){
            return array('err_code'=>4, 'err_str'=>__('This post has already been submitted to translation'));
        }
        $is_update = $res->needs_update;
        $permalink = get_permalink($post_id);        
        $item = $wpdb->get_row("SELECT post_title, post_type, post_content, post_date_gmt FROM {$wpdb->posts} WHERE ID={$post_id}");                        
        if($item->post_type=='post'){
            $post_timestamp = strtotime($item->post_date_gmt) + (get_option('gmt_offset') * 3600);
            $cms_request_id = $iclq->submit_post_translation($post_id,$item->post_title,$permalink, $languages, $post_timestamp, $is_update);
        }else{
            $cms_request_id = $iclq->submit_page_translation($post_id,$item->post_title,$permalink, $languages, $is_update);
        }  
        if($cms_request_id){
        
            $_tags = (array)get_the_tags($post_id);
            foreach($_tags as $t){ $_ts[] = $t->name; }
            sort($_ts, SORT_STRING);
            $tags = join(',',$_ts);
            
            $_categories = (array)get_the_terms($post_id,'category'); 
            foreach($_categories as $c){ $_cs[] = $c->term_taxonomy_id; }        
            sort($_cs, SORT_NUMERIC);                  
            $categories = join(',',$_cs);
            
            $current_checksum = md5($item->post_content.$item->post_title.join(',',(array)$post_tags).join(',',(array)$post_categories));
            
            if($wpdb->get_var("SELECT id FROM {$wpdb->prefix}translation_requests WHERE post_id=".$post_id)){
                $wpdb->query("UPDATE {$wpdb->prefix}translation_requests SET 
                                cms_request_id='{$cms_request_id}',
                                cms_request_status='1', 
                                content_checksum = '{$current_checksum}', 
                                needs_update = '0', 
                                cms_request_languages = '" . mysql_real_escape_string(serialize($languages)) . "'
                                date = NOW()    
                             WHERE post_id=".$post_id);                                
            }else{
                $wpdb->query("INSERT INTO {$wpdb->prefix}translation_requests
                    (post_id,cms_request_id,cms_request_status,content_checksum,needs_update,date,cms_request_languages)
                VALUES('{$post_id}','{$cms_request_id}','1','{$current_checksum}','0',NOW(),'" . mysql_real_escape_string(serialize($languages)) . "')");
            }  
            $wpdb->query("DELETE FROM {$wpdb->prefix}translation_jobs WHERE post_id=".$post_id);
                        
            return array('err_code'=>0, 'err_str'=>$cms_request_id);
        }else{
            return array('err_code'=>1, 'err_str'=>$iclq->error());
        }
}

function ICanLocalizeListPosts($args){
        global $wpdb;
        $user_login  = $args[0];
        $user_pass   = $args[1];
        $from_date   = date('Y-m-d H:i:s',$args[2]);
        $to_date     = date('Y-m-d H:i:s',$args[3]);
        
        if ( !get_option( 'enable_xmlrpc' ) ) {
            return array('err_code'=>3, 'err_str'=>sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php')));
        }
        
        if (!user_pass_ok($user_login, $user_pass)) {
            return array('err_code'=>2, 'err_str'=>__('user or password don\'t match'));
        }        
        
        $res = (array)$wpdb->get_results("SELECT p1.ID, post_title, post_content, post_date, cms_request_status 
                FROM {$wpdb->posts} p1 LEFT JOIN {$wpdb->prefix}translation_requests p2 ON p1.ID=p2.post_id
                WHERE 
                    post_type = 'post' AND 
                    p1.post_date > '{$from_date}' AND p1.post_date < '{$to_date}' ORDER BY post_date ASC",ARRAY_A);
        foreach($res as $k=>$v){
            $_cats = (array)get_the_terms($v['ID'],'category');
            $cats = array();
            foreach($_cats as $cv){
                $cats[] = $cv->name;
            }
            $res[$k]['cms_request_status'] = intval($v['cms_request_status']);
            $res[$k]['words'] = count(explode(' ',strip_tags($v['post_content'])));
            $res[$k]['categories'] = $cats;
            unset($res[$k]['post_content']);
        }
        return array('err_code'=>0, 'posts'=>$res);
    
}

function ICanLocalizeGetCategories($args){
        global $wpdb;
        $user_login  = $args[0];
        $user_pass   = $args[1];
        
        if ( !get_option( 'enable_xmlrpc' ) ) {
            return array('err_code'=>3, 'err_str'=>sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php')));
        }
        
        if (!user_pass_ok($user_login, $user_pass)) {
            return array('err_code'=>2, 'err_str'=>__('user or password don\'t match'));
        }        
        
        $categories_struct = array();
  
        if ( $cats = get_categories('get=all') ) {
            foreach ( $cats as $cat ) {
                $struct['id'] = $cat->term_id;
                $struct['parent_id'] = $cat->parent;
                $struct['description'] = $cat->description;
                $struct['name'] = $cat->name;
                $struct['slug'] = $cat->slug;
                
                $categories_struct[] = $struct;
            }
        }
        return $categories_struct;
}

function ICanLocalizeCancelTranslationRequest($args){
        global $wpdb, $iclt;
        $user_login  = $args[0];
        $user_pass   = $args[1];
        $request_id  = $args[2];
        
        if ( !get_option( 'enable_xmlrpc' ) ) {             
            return array('err_code'=>3, 'err_str'=>sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php')));
        }
        
        if (!user_pass_ok($user_login, $user_pass)) {         
            return array('err_code'=>2, 'err_str'=>sprintf( __( 'ERROR - user or password don\'t match')));
        } 
        
        if(!$request_id){
            return array('err_code'=>4, 'err_str'=>sprintf( __( 'ERROR - you need to provide a cms_request_id')));
        }
        
        return $iclt->cancel_translation_request($request_id, true);       
    
}

/* backwards compatibility */
if(!function_exists('admin_url')){
    function admin_url($path = '') {
        $url = site_url('wp-admin/', 'admin');

        if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
            $url .= ltrim($path, '/');

        return $url;
    }     
}
if(!function_exists('site_url')){
    function site_url($path = '', $scheme = null) {
        // should the list of allowed schemes be maintained elsewhere?
        $orig_scheme = $scheme;
        if ( !in_array($scheme, array('http', 'https')) ) {
            if ( ('login_post' == $scheme) && ( force_ssl_login() || force_ssl_admin() ) )
                $scheme = 'https';
            elseif ( ('login' == $scheme) && ( force_ssl_admin() ) )
                $scheme = 'https';
            elseif ( ('admin' == $scheme) && force_ssl_admin() )
                $scheme = 'https';
            else
                $scheme = ( is_ssl() ? 'https' : 'http' );
        }

        $url = str_replace( 'http://', "{$scheme}://", get_option('siteurl') );

        if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
            $url .= '/' . ltrim($path, '/');

        return apply_filters('site_url', $url, $path, $orig_scheme);
    } 
}
if(!function_exists('force_ssl_admin')){
    function force_ssl_admin($force = '') {
        static $forced;

        if ( '' != $force ) {
            $old_forced = $forced;
            $forced = $force;
            return $old_forced;
        }

        return $forced;
    }
} 
if(!function_exists('force_ssl_login')){
    function force_ssl_login($force = '') {
        static $forced;

        if ( '' != $force ) {
            $old_forced = $forced;
            $forced = $force;
            return $old_forced;
        }

        return $forced;
    }     
}
if(!function_exists('is_ssl')){
    function is_ssl() {
        return ( isset($_SERVER['HTTPS']) && 'on' == strtolower($_SERVER['HTTPS']) ) ? true : false; 
    }
}
?>