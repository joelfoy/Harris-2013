<?php
  $iclt_log_file = dirname(__FILE__) . '/debug.txt';
  $iclt_db_snapshots_folder = dirname(__FILE__) . '/db_snapshots_folder';
  
  $iclt_fh = @fopen($iclt_log_file, 'a') or die("Can't create debug file");
  if(!isset($iclt_debug_session_id)){
    $iclt_debug_session_id = substr(md5(rand(1,999999)),0,6);  
    fprintf($iclt_fh, "\n%s\tSTART DEBUG --------------------------------%s\n", date('Ymd H:i:s'), $iclt_debug_session_id);
    fprintf($iclt_fh, "%s[%s]\t%s \n", date('Ymd H:i:s'),$iclt_debug_session_id, $_SERVER['REQUEST_URI'].'?'.$_SERVER['QUERY_SSTRING']);
  }
  
  if(!file_exists($iclt_db_snapshots_folder)){
      mkdir($iclt_db_snapshots_folder);
  }
  
  function iclt_debug_func_start(){
      global $iclt_fh, $iclt_debug_session_id;
      $bt = debug_backtrace();
      fprintf($iclt_fh, "%s[%s]\tFunction %s - start\n", date('Ymd H:i:s'), $iclt_debug_session_id, $bt[1]['function']);
  }
  
  function iclt_debug_func_end(){
      global $iclt_fh, $iclt_debug_session_id;
      $bt = debug_backtrace();
      fprintf($iclt_fh, "%s[%s]\tFunction %s - end\n", date('Ymd H:i:s'), $iclt_debug_session_id, $bt[1]['function']);      
  }
  
  function iclt_debug_log($message){
      global $iclt_fh, $iclt_debug_session_id;
      if(is_array($message)){
          ob_start();
          print_r($message);
          $message = ob_get_contents();
          ob_end_clean();
      }
      fprintf($iclt_fh, "%s[%s]\tMessage: %s\n", date('Ymd H:i:s'), $iclt_debug_session_id, $message);            
  }
  
  function iclt_debug_db_snapshot($title){
      global $iclt_fh, $iclt_debug_session_id, $wpdb, $iclt_db_snapshots_folder;
      iclt_debug_log('Create db snapshot: ' . $iclt_debug_session_id . '-' . $title . '.sql');
      $mysqldump = "/usr/bin/mysqldump";
      $wpdb->query("LOCK TABLES WRITE");
      
      $tables = join(' ', $wpdb->get_col("SHOW TABLES LIKE '{$wpdb->prefix}%'"));      
      
      shell_exec($mysqldump . ' -h ' . DB_HOST . ' -u ' . DB_USER . ' -p' . DB_PASSWORD . ' ' . DB_NAME . ' ' . $tables . ' > ' . 
        $iclt_db_snapshots_folder . '/' . $iclt_debug_session_id . '-' . $title . '.sql');
      $wpdb->query("UNLOCK TABLES");
      
  }
  
  
?>
