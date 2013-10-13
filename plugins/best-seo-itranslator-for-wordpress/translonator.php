<?php
include_once('../../../wp-load.php');
include_once (dirname(__file__).'/header.php');
include_once (dirname(__file__).'/itranslator.php');
if(in_array($_GET['lang'], $itrLangs)) {
    if(itr_checkCache($_GET['dir'],$_GET['lang'])) {
        $tmp=itr_getFromFile($_GET['dir'], $_GET['lang']);
        header('Content-Type: text/html; charset=utf-8');
        echo $tmp['html'];
    }
    else {
        $text=TranslateIt(get_bloginfo('url').'/'.$_GET['dir'], itrBL, $_GET['lang']);
        $text=itr_replaceAnchors($text,$_GET['dir'],$_GET['lang']);
        if(checkTranslation($text)) {
            if(!itr_checkExist(itr_dirHasher($_GET['dir']))) {
                itr_makeDir($_GET['dir']);
            }
            if(itr_checkCache($_GET['dir'], $_GET['lang'])===false) {
                itr_SaveTrans(serialize(array('title'=>itr_newTitle($text),'html'=>$text)), $_GET['lang'], $_GET['dir']);
            }
            echo $text;
        }
        else {
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Retry-After: 3600');
            die('Please return to this page in some minutes.');
        }
    }
}
else {
    header('HTTP/1.1 404 Not Found');
    die('Language not supported.');
}
?>
