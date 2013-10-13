<?php
  class ICLQuery{
      private $site_id; 
      private $access_key;
      private $languages;
      private $error = null;
      
      function __construct($settings){             
             if(!is_array($settings)){
                 $this->error = __('Plugin configuration missing or corrupt');
             }else{
                $this->site_id = $settings['site_id'];
                $this->access_key = $settings['access_key'];
                if(is_array($settings['languages'])){
                    $this->languages = $settings['languages'];
                }
             }
      } 
      
      public function setting($setting){
          return $this->$setting;
      }
      
      public function error(){
          return $this->error;
      }
      
      public function get_languages(){
        $request =  ICL_API_ENDOINT . 'websites/' . $this->site_id . '.xml?accesskey=' . $this->access_key;
        $response = $this->_request($request);
        if(-1 == $response['info']['status']['attr']['error_code']){
            return false;
        }
        $lgs = array();
        if($response && !empty($response['info']['website']['translation_languages'])){
            $res = $response['info']['website']['translation_languages']['translation_language'];
            if($res['attr']){ //one language
                $languages[0] = $res['attr'];
            }else{
                foreach($res as $r){
                    $languages[] = $r['attr'];
                }            
            }
            foreach($languages as $l){
                $lgs[] = array(
                    'from_id' => $l['from_language_id'],
                    'from_name' => $l['from_language_name'],
                    'to_id' => $l['to_language_id'],
                    'to_name' => $l['to_language_name']
                );
            }
        }
        return $lgs;
      }
      
      public function submit_post_translation($post_id, $post_title, $permalink, $languages, $timestamp, $is_update=0){                                                       
          if(ICLT_DEBUG_MODE) iclt_debug_func_start();                      
          if(!$languages) return;
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests.xml';

          $parameters['accesskey'] = $this->access_key;
          $parameters['doc_count'] = 1;          
          $parameters['title'] = $post_title;          
          $parameters['permlink'] = $permalink;          
          $parameters['list_type'] = 'post';          
          $parameters['list_id'] = $timestamp;          
          $command = $is_update?'update_post':'new_post';
          
          $i = 1;
          foreach($languages as $f=>$l){
              if(!isset($from_name)){
                $from_name = $l['from_name'];
              }
              $parameters['to_language'.$i] = $l['to_name'];
              $i++;
          }
          $parameters['orig_language'] = $from_name;
          $parameters['file1[description]'] = 'cms_request_details';          
          
          
          $call = '<cms_request_details type="wordpress-xml-rpc" command="'.$command.'" post_id="'.$post_id.'" from_lang="'.$parameters['orig_language'].'" is_content_updated="'.$is_update.'">'.PHP_EOL;
          $call .= "\t".'<cms_target_languages>'.PHP_EOL;
          foreach($languages as $l){
            $call .= "\t\t".'<cms_target_language lang="' . $l['to_name'] . '" />'.PHP_EOL;
          }
          $call .= "\t".'</cms_target_languages>'.PHP_EOL;
          $call .= '</cms_request_details>';
          
          $file = tempnam("/tmp", "iclt_cms_request_details__") . ".xml.gz";                    
          $fh = fopen($file,'wb') or die('File create error');
          fwrite($fh,gzencode($call));
          fclose($fh);
          
          $res = $this->_request($request_url, 'POST' , $parameters, array('file1[uploaded_data]'=>$file));
          $cms_request_id = $res['info']['result']['attr']['id'];
          if(ICLT_DEBUG_MODE){
              iclt_debug_log("Request url: " . $request_url);        
              iclt_debug_log("Request call: " . $call);        
              if($fh){
                  iclt_debug_log("Upload file created: " . $file);        
              }else{
                  iclt_debug_log("Upload file NOT created: " . $file);        
              }
              iclt_debug_func_end();
          } 
          return $cms_request_id;
      }

      public function submit_page_translation($post_id, $post_title, $permalink, $languages, $is_update=0){
          if(ICLT_DEBUG_MODE) iclt_debug_func_start();                      
          if(!$languages) return;
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests.xml';
          $parameters['accesskey'] = $this->access_key;
          $parameters['doc_count'] = 1; 
          $parameters['title'] = $post_title;          
          $parameters['permlink'] = $permalink;          
          $command = $is_update?'update_page':'new_page';                   
          
          $i = 1;
          foreach($languages as $f=>$l){
              if(!isset($from_name)){
                $from_name = $l['from_name'];
              }
              $parameters['to_language'.$i] = $l['to_name'];
              $i++;
          }
          $parameters['orig_language'] = $from_name;
          $parameters['file1[description]'] = 'cms_request_details';          
          
          
          $call = '<cms_request_details type="wordpress-xml-rpc" command="'.$command.'" page_id="'.$post_id.'" from_lang="'.$parameters['orig_language'].'" is_content_updated="'.$is_update.'">'.PHP_EOL;
          $call .= "\t".'<cms_target_languages>'.PHP_EOL;
          foreach($languages as $l){
            $call .= "\t\t".'<cms_target_language lang="' . $l['to_name'] . '" />'.PHP_EOL;
          }
          $call .= "\t".'</cms_target_languages>'.PHP_EOL;
          $call .= '</cms_request_details>';

          
          $file = tempnam("/tmp", "iclt_cms_request_details__") . ".xml.gz";                    
          $fh = fopen($file,'wb') or die('File create error');
          fwrite($fh,gzencode($call));
          fclose($fh);
          
          $res = $this->_request($request_url, 'POST' , $parameters, array('file1[uploaded_data]'=>$file));
          
          $cms_request_id = $res['info']['result']['attr']['id'];
          
          if(ICLT_DEBUG_MODE){
              iclt_debug_log("Request url: " . $request_url);        
              iclt_debug_log("Request call: " . $call);        
              if($fh){
                  iclt_debug_log("Upload file created: " . $file);        
              }else{
                  iclt_debug_log("Upload file NOT created: " . $file);        
              }
              iclt_debug_func_end();
          } 
          
          return $cms_request_id;
      }
      
      public function retry_translation($cms_request_id){
          if(ICLT_DEBUG_MODE) iclt_debug_func_start();                      
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests/'.$cms_request_id.'/retry.xml';
          $parameters['accesskey'] = $this->access_key;
          $res = $this->_request($request_url, 'POST' , $parameters);          
          $cms_request_id = $res['info']['result']['attr']['id'];
          if(ICLT_DEBUG_MODE) iclt_debug_log("Cms request id " . $cms_request_id);        
          if(ICLT_DEBUG_MODE) iclt_debug_func_end();                      
          return $cms_request_id;
      }
      
      public function update_languages($cms_request_id, $languages){
          if(empty($languages)) return;
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests/'.$cms_request_id.'/update_languages.xml';
          $incr = 1;
          foreach($languages as $l){
            $parameters['to_language'.$incr] = $l['to_name'];
            $incr++;    
          }
          $parameters['accesskey'] = $this->access_key;              
          $res = $this->_request($request_url, 'POST' , $parameters);          
      }
      
      public function get_cms_request_status($cms_request_id){
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests/'.$cms_request_id.'.xml?accesskey=' . $this->access_key;
          $c = new IcanSnoopy();
          $res = $this->_request($request_url);
          $cms_request_status = intval($res['info']['cms_request']['attr']['status']);
          return $cms_request_status;     
      }
      
      public function get_cms_requests(){
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests.xml?accesskey=' . $this->access_key;
          $c = new IcanSnoopy();
          $res = $this->_request($request_url);
          if(!isset($res['info']['pending_cms_requests']['cms_request'])){
              return false;
          }
          if($res['info']['pending_cms_requests']['cms_request']['attr']){
              $buf = $res['info']['pending_cms_requests']['cms_request'];
              unset($res['info']['pending_cms_requests']['cms_request']);
              $res['info']['pending_cms_requests']['cms_request'][0] = $buf;
          }
          return $res['info']['pending_cms_requests']['cms_request'];     
      }

      public function get_cms_request($cms_request_id){          
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests/'.$cms_request_id.'.xml?accesskey=' . $this->access_key;          
          $res = $this->_request($request_url);
          return $res['info']['cms_request']['attr'];     
      }
      
      function cancel_translation_request($cms_request_id){
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests/'.$cms_request_id.'.xml?_method=delete';
          $parameters['accesskey'] = $this->access_key;              
          $res = $this->_request($request_url, 'POST' , $parameters);                              
          if(!$res){
              if($this->error=='Cannot locate request'){
                  $resp = array(1,$this->error);
              }else{
                  $resp = array(0,$this->error);
              }              
          }elseif(intval($res['info']['status']['attr']['error_code']) == 0){
                  $resp = array(1,'OK');
          }else{
                  $resp = array(0, $res['info']['result']['attr']['message']);
          }           
          return $resp;               
      }
      
      //for debugging/development
      public function set_cms_request_status($cms_request_id, $status){
          $request_url = ICL_API_ENDOINT . 'websites/'.$this->site_id.'/cms_requests/'.$cms_request_id . '/update_status.xml';
          $parameters['accesskey'] = $this->access_key;
          $parameters['status'] = $status;
          $res = $this->_request($request_url, 'POST' , $parameters);
          return true;          
      }
      
      function _request($request,$method='GET', $formvars=null, $formfiles=null){
        $c = new IcanSnoopy();
        $c->_fp_timeout = 3;
        $de = ini_get('display_errors');
        ini_set('display_errors','off');        
        $url_parts = parse_url($request);
        $https = $url_parts['scheme']=='https';
        if($method=='GET'){            
            $c->fetch($request);  
            if((!$c->results || $c->timed_out) && $https){
                $c->fetch(str_replace('https://','http://',$request));  
            }          
        }else{
            $c->set_submit_multipart();          
            $c->submit($request, $formvars, $formfiles);            
            if((!$c->results || $c->timed_out) && $https){
                $c->submit(str_replace('https://','http://',$request), $formvars, $formfiles);  
            }                      
        }
        if($c->error || $c->timed_out){
            $this->error = __('Connection to ICanLocalize is temporary not available. It should be 
back in a few minutes');
            return false;
        }
        ini_set('display_errors',$de);  
        $results = xml2array($c->results,1);                
        if($results['info']['status']['attr']['err_code']=='-1'){
            $this->error = $results['info']['status']['value'];            
            return false;
        }
        return $results;
      }
      
  }
?>
