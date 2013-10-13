<?php

ini_set("memory_limit","80M");
ini_set('log_errors','1');			// We need to log them otherwise this script will be pointless!
ini_set('error_log','error_log.txt');
define('itrVersion',1);
global $itrLangs;
$itrBL=get_option('itrBlogLanguage');
$itrCD=get_option('itrCacheDuration');
$itrTL=get_option('itrBlogTransArray');
//$itrTLexp=explode();
define('itrBL',get_option('itrBlogLanguage'));
define('itrCacheDir',WP_PLUGIN_DIR.'/best-seo-itranslator-for-wordpress/cache');
define('HTACCESS_INSTRUCTIONS','#itritritr
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^trans/(.+?)/(.*?)$ wp-content/plugins/best-seo-itranslator-for-wordpress/translonator.php?act=doTranslatePage&lang=$1&dir=$2 [NC,L]
</IfModule>
#enditritritr
');
function itr_getFlag($code) {
    return WP_PLUGIN_URL.'/best-seo-itranslator-for-wordpress/flags/flags_'.$code.'.png';
}
function itr_optionsPage() {
    $location = get_option('siteurl') . '/wp-admin/options-general.php?page=best-seo-itranslator-for-wordpress/options-itranslator.php';
    return $location;
}
function itr_SaveTrans($content,$lang,$dir) {
    $fname=itrCacheDir.'/'.itr_dirHasher($dir).'/'.$lang.'.cache';
    $h=fopen($fname,'w+');
    fwrite($h, $content);
    fclose($h);
    return true;
}
function itrHasHAinstr() {
    $exists=file_exists(ABSPATH.'/.htaccess');
    if(!$exists) return false;
    $handle=@fopen(ABSPATH.'/.htaccess','r');
    $contents = '';
    while (!feof($handle)) {
        $contents .= fread($handle, 8192);
    }
    fclose($handle);
    $out=preg_match('/#itritritr([\s\S]+?)#enditritritr/Ui',$contents);
    return
    $out;
}
function itrtoggleHAinstr($act) {
    $out=false;
    $exists=file_exists(ABSPATH.'/.htaccess');
    if($act==1) {
        if(!itrHasHAinstr() && $exists) {
            $handle=@fopen(ABSPATH.'/.htaccess','r');
            $contents = '';
            while (!feof($handle)) {
                $contents .= fread($handle, 8192);
            }
            $handle=@fopen(ABSPATH.'/.htaccess','w+');
            if(@fwrite($handle,HTACCESS_INSTRUCTIONS.$contents)) $out=true;
            @fclose($handle);
        }
        else {
            $handle=@fopen(ABSPATH.'/.htaccess','w+');
            if(@fwrite($handle,HTACCESS_INSTRUCTIONS)) $out=true;
            @fclose($handle);
        }
    }
    elseif($act==-1 && itrHasHAinstr()) {
        $handle=@fopen(ABSPATH.'/.htaccess','a+');
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        $backup=$contents;
        $contents=preg_replace('/#itritritr([\s\S]+)#enditritritr/Ui','',$contents);
        $handle=@fopen(ABSPATH.'/.htaccess','w+');
        if(fwrite($handle,strlen($contents)==0?$backup:$contents)) $out=true;
        @fclose($handle);
    }
    else
        return false;
    return $out;
}
function itrFolderSize($d ="." ) {
// © kasskooye and patricia benedetto
    $h = @opendir($d);
    if($h==0)return 0;

    while ($f=readdir($h)) {
        if ( $f!= "..") {
            $sf+=filesize($nd=$d."/".$f);
            if($f!="."&&is_dir($nd)) {
                $sf+=itrFolderSize($nd);
            }
        }
    }
    closedir($h);
    return $sf-4096 ;
}
function itrDeleteCache($path) {
    if (is_dir($path)) {
        if (version_compare(PHP_VERSION, '5.0.0') < 0) {
            $entries = array();
            if ($handle = opendir($path)) {
                while (false !== ($file = readdir($handle))) $entries[] = $file;
                closedir($handle);
            }
        }else {
            $entries = scandir($path);
            if ($entries === false) $entries = array();
        }

        foreach ($entries as $entry) {
            if ($entry != '.' && $entry != '..') {
                @itrDeleteCache($path.'/'.$entry);
            }
        }

        return rmdir($path);
    }else {
        return unlink($path);
    }
}
function itrFormatSize($dsize) {
    if (strlen($dsize) <= 9 && strlen($dsize) >= 7) {
        $dsize = number_format($dsize / 1048576,1);
        return "$dsize MB";
    } elseif (strlen($dsize) >= 10) {
        $dsize = number_format($dsize / 1073741824,1);
        return "$dsize GB";
    } else {
        $dsize = number_format($dsize / 1024,1);
        return "$dsize KB";
    }
}
function itr_checkCache($dir,$lang) {
    global $itrCD;
    $fileDir=itrCacheDir.'/'.itr_dirHasher($dir).'/'.$lang.'.cache';
    if(file_exists($fileDir) && (filemtime($fileDir)+$itrCD)>time()) {
        return
        true;
    }
    else
        return
        false;
}
function itr_newTitle($text) {
    preg_match('/<title>(.*?)<\/title>/Ui',$text,$match);
    return $match[1];
}
function itr_dirHasher($dir) {
    return md5($dir).substr(sha1($dir),0,5);
}
function itr_checkExist($dir) {
    if(is_dir(itrCacheDir.'/'.itr_dirHasher($dir))) return true; else return false;
}
function itr_checkLangExist($dir,$lang) {
    if(file_exists(itrCacheDir.'/'.itr_dirHasher($dir).'/'.$lang.'.cache')) return true; else return false;
}
function itr_makeDir($dir) {
    if(@mkdir(itrCacheDir.'/'.itr_dirHasher($dir))) return true; else return false;
}
function itr_getFromFile($dir,$lang) {
    $text=file_get_contents(itrCacheDir.'/'.itr_dirHasher($dir).'/'.$lang.'.cache');
    $tmp=unserialize($text);
    return $tmp;
}
function itr_replaceAnchors($text,$dir,$lang='') {
    if($lang!='') {
        $text=preg_replace('@<link\srel=canonical\shref=[^>]+\s/>@','<link rel="canonical" href="'.get_bloginfo('url').'/trans/'.$lang.'/'.$dir.'" />',$text);
    }
    $newTitle=itr_newTitle($text);
    $text=preg_replace('@<meta\sname=description\scontent=[^>]+\s/>@','<meta name="description" content="'.$newTitle.'" />',$text);
    $text=preg_replace('@<meta\sname=keywords\scontent=[^>]+\s/>@','<meta name="keywords" content="'.$newTitle.'" />',$text);
    $text=preg_replace('/href=http:\/\/translate\.googleusercontent\.[a-zA-Z]{2,3}.*?u=(.*?)&amp[^>]+/','href="$1"',$text);
    if(get_option('itrShowOriginalPost')==1)
    $text=preg_replace('/<body([^>]*)>/','<body$1><div style="margin:20px auto;width:940px;padding:10px;background:#FFFBCC;border:1px solid #E6DB55">This is a translated page. The original can be found here: <a href="'.get_bloginfo("url").'/'.$dir.'">'.get_bloginfo("url").'/'.$dir.'</a></div>',$text);
    return $text;
}
function itr_showBar($content,$retBuild=false) {
    if(is_single()) {
        global $itrLangs;
        $perRow=8;
        $i=1;
        $baseURL=get_bloginfo('url');
        $requri=preg_replace('/\/trans\/(.+)?\//Ui','',$_SERVER['REQUEST_URI']);
        $requri=(substr($requri,0,1)=='/'?'':'/').$requri;
        $build='';
        $tmp=explode('+',get_option('itrBlogTransArray'));
        foreach($itrLangs as $key=>$val) {
            if(get_option('itrBlogLanguage')!=$val && in_array($val,$tmp)) {
                $build.='<a href="'.$baseURL.'/trans/'.$val.$requri.'"><img border="0" src="'.itr_getFlag($val).'" title="'.$key.'" /></a>&nbsp;';
                if($i%$perRow==0) $build.='<br />';
                $i++;
            }
        }
        $build='<div onclick="jQuery(\'#itrTransBar\').slideToggle(1000)" style="cursor:pointer;font-size:11px;color:#444;margin:10px 0 6px 0;">Translate this post</div><div id="itrTransBar" style="width:100%">'.$build.'</div>';
        if($retBuild===true)
            return $build;
        else
            return $content.$build;
    }
    else
        return $content;
}
?>
