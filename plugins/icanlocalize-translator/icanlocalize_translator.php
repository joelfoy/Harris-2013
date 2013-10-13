<?php
/*
Plugin Name: ICanLocalize Translator
Plugin URI: http://sitepress.org/wordpress-translation/
Description: Sends pages and posts for professional translation by ICanLocalize. To configure the plugin, you'll need an setup an account at <a href="http://www.icanlocalize.com">www.icanlocalize.com</a>. <a href="options-general.php?page=iclt">Configure &raquo;</a>.
Author: ICanLocalize
Author URI: http://www.icanlocalize.com
Version: 1.3.1
*/

/*
    This file is part of ICanLocalize Translator.

    ICanLocalize Translator is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    ICanLocalize Translator is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ICanLocalize Translator.  If not, see <http://www.gnu.org/licenses/>.
*/

define('ICLT_PATH', dirname(__FILE__));
require ICLT_PATH . '/inc/template-functions.php';

if(!is_admin() && ltrim($_SERVER['REQUEST_URI'],'/')!='xmlrpc.php') return;

define('ICLT_URL', $_SERVER['REQUEST_URI']);
define('ICLT_PLUGIN_URL', '/'. PLUGINDIR . '/'. basename(dirname(__FILE__)));
require ICLT_PATH . '/inc/icanlocalize.class.php';
require ICLT_PATH . '/inc/rpc-functions.php';
require ICLT_PATH . '/inc/icanlocalize_constants.php';
require ICLT_PATH . '/inc/icanlocalize_api.php';
require ICLT_PATH . '/inc/version.php';
require ICLT_PATH . '/inc/activation.php';
require ICLT_PATH . '/upgrade_schema.php';
require ICLT_PATH . '/lib/xml2array.php';
require ICLT_PATH . '/lib/Snoopy.class.php';

if(ICLT_DEBUG_MODE && file_exists(dirname(__FILE__) . '/debug.php')){
    include_once dirname(__FILE__) . '/debug.php';
}

$iclt = new ICanLocalize();

register_activation_hook( __FILE__, 'iclt_translator_activate' );

// LOCALIZE THE PLUGIN
$incalocalize_translator_domain   = 'incalocalize_translator';
$incalocalize_translator_is_setup = 0;
function fabfunc_setup(){
   global $incalocalize_translator_domain, $incalocalize_translator_is_setup;
   if($incalocalize_translator_is_setup) {
      return;
   } 
   load_plugin_textdomain($incalocalize_translator_domain, PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)), dirname(plugin_basename(__FILE__)));
}
?>
