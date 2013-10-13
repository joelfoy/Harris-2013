<?php
/*
Plugin Name: iTranslator
Plugin URI: http://iwebdevel.com/?p=216
Description: Translate your blog in 40 languages and increase traffic to your site.
Version: 2009.9.28
Author: Dragos Mocrii
Author URI: http://trustler.com/p/Dragos
*/
include_once (dirname(__file__).'/header.php');

$itrLangs=array(
    "Albanian" => "sq",
    "Arabic" => "ar",
    "Bulgarian" => "bg",
    "Catalan" => "ca",
    "Chinese" => "zh-CN",
    "Croatian" => "hr",
    "Czech" => "cs",
    "Danish" => "da",
    "Dutch" => "nl",
    "English" => "en",
    "Estonian" => "et",
    "Filipino" => "tl",
    "Finnish" => "fi",
    "French" => "fr",
    "Galician" => "gl",
    "German" => "de",
    "Greek" => "el",
    "Hebrew" => "iw",
    "Hindi" => "hi",
    "Hungarian" => "hu",
    "Indonesian" => "id",
    "Italian" => "it",
    "Japanese" => "ja",
    "Korean" => "ko",
    "Latvian" => "lv",
    "Lithuanian" => "lt",
    "Maltese" => "mt",
    "Norwegian" => "no",
    "Polish" => "pl",
    "Portuguese" => "pt",
    "Romanian" => "ro",
    "Russian" => "ru",
    "Serbian" => "sr",
    "Slovak" => "sk",
    "Slovenian" => "sl",
    "Spanish" => "es",
    "Swedish" => "sv",
    "Thai" => "th",
    "Turkish" => "tr",
    "Ukrainian" => "uk",
    "Vietnamese" => "vi"

);
function getData($url,$ref='') {
    if($url!='localhost' && $url!='http://localhost') {
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,3);
        curl_setopt($ch, CURLOPT_REFERER,$ref);
        $result['data']=curl_exec($ch);
        $result['error']=curl_error($ch);
        curl_close($ch);
        return $result;
    }
    else return $result['error']='err';
}

function getToken1($text) {
    preg_match('/<a href="(.*?)">(.*?)<\/a>/Uis',$text,$match);
    return $match[1];
}
function getToken2($text) {
    preg_match('/<a href="(.*?)">(.*?)<\/a>/Uis',$text,$match);
    return $match[1];
}
function TranslateIt($url,$from,$to) {
//the very first url
    $vfirst='http://translate.google.com/translate_t?sl='.$from.'&tl='.$to;
    //first
    $url2='http://translate.google.com/translate?hl='.$from.'&ie=UTF-8&sl='.$from.'&tl='.$to.'&u='.$url.'&prev=_t';
    $data1=getData($url2,$vfirst);
    //echo htmlspecialchars($data1['data']).'<br /><br />';
    $token1=str_replace('&amp;','&',getToken1($data1['data']));
    //echo '<br /><br />Token1: '.str_replace('&amp;','&',$token1).'<br /><br />';
    //step two
    $url3='http://translate.google.com/translate_n?hl='.$from.'&ie=UTF-8&sl='.$from.'&tl='.$to.'&u='.$url.'&prev=_t';
    $data2=getData($url3,$url2);
    //echo htmlspecialchars($data2['data']).'<br /><br />';
    //step three
    $url4='http://translate.google.com'.$token1;
    $data3=getData($url4,$url3);
    //echo htmlspecialchars($data3['data']).'<br /><br />';
    $token2=str_replace('&amp;','&',getToken2($data3['data']));
    //echo '<br /><br />Token2: '.$token2.'<br /><br />';
    //step four
    $url5=$token2;
    $data4=getData($url5);
    header('Content-Type: text/html; charset=utf-8');
    return $data4['data'];
}

function checkTranslation($text) {
    if(!stripos($text, '<meta name="iTranslator" content="true" />') && !stripos($text, '<meta name=iTranslator content=true />'))
    return false; else return true;
}

function itr_add_menu() {
    $dir = dirname(__FILE__).DIRECTORY_SEPARATOR;
    $file = $dir. 'options-itranslator.php';
    add_options_page('iTranslator Options', 'iTranslator', 8, $file);
}
function itr_addMeta() {
    echo '<meta name="iTranslator" content="true" />';
}
function widget_bsitr_init() {

  if(!function_exists('register_sidebar_widget')) { return; }
  function widget_itranslator($args) {
    echo itr_showBar('',true);
  }
  register_sidebar_widget('BSiTranslator','widget_itranslator');

}
add_action('plugins_loaded', 'widget_bsitr_init');
add_action('admin_menu', 'itr_add_menu');
add_action('wp_head', 'itr_addMeta');
add_filter('the_content','itr_showBar',300);

?>
