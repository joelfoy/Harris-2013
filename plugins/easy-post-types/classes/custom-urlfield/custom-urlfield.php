<?php
/*
Plugin Name: Easy Post Types - UrlField
Plugin URI:
Description: Custom Type Urlfield
Author: New Signature
Version: 1.0.0
Author URI: http://newsignature.com/
*/

define( 'CUSTOM_URLFIELD_TEMPLATEPATH', dirname(__FILE__));
define( 'CUSTOM_URLFIELD_LINKNAME', '_link');
define( 'CUSTOM_URLFIELD_LINKOPEN', '_linkopen');

class CustomFields_UrlField {

    public $mainContentType;
    public $root;
    public $httpRoot;

    public function getId() {
        return "urlfield";
    }

    public function __toString()
    {
        return "Easy Post Types : URL Field";
    }

    public function  __construct() {
        $this->root=dirname(__FILE__).'/';
        $this->httpRoot = plugins_url( '', __FILE__).'/';
        
        load_plugin_textdomain('cct', false, dirname( plugin_basename( __FILE__ ) )  );
        add_action( 'init', array($this, 'init' ));
        add_action('ct_load_types', array($this, 'load_type'));
    }

    public function extra($post_values) {
        return array(
            'show_label'=>$post_values['show_label']
            );
    }

    public function includeTemplate($name, $values=array()) {
        $path=CUSTOM_URLFIELD_TEMPLATEPATH.'/'.$name;
        if (file_exists($path))
            include($path);
        else
            include($this->root . $name);
    }


    public function load_type($cf) {
        $cf->registerType($this);
        $this->mainContentType=$cf;
    }
    public function getRoot() {
        return $this->root;
    }

    public function getName() {
        return 'URL Field';
    }

    public function load_fields($fields) {
        return get_post_meta($fields['postid'], $fields['fields']['field_name'], true);
    }

    public function save_fields($fields) {
        $name=$fields['fields']['field_name'];
        $value=array($name => $fields['original'][$name], 
                     $name.CUSTOM_URLFIELD_LINKNAME => $fields['original'][$name.CUSTOM_URLFIELD_LINKNAME],
                     $name.CUSTOM_URLFIELD_LINKOPEN => $fields['original'][$name.CUSTOM_URLFIELD_LINKOPEN] );
        update_post_meta($fields['postid'], $fields['fields']['field_name'], $value);
    }

    public function theme($post, $name, $options=null)  {
        $value=$this->load_fields(array('postid'=>$post->ID, 'field_name'=>$name));
        $value=unserialize($value[$name][0]);
        if ($options['raw']==true) return $value;
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $post->post_type, $name);
        
        $values=array('label' => $fieldInfo['info']['name'], 'name'=>$name, 'value'=>$value, 'extra' => $fieldInfo['extra']);

        $template=$options['template'];

        $this->mainContentType->include_template($this, $name, $template, $values, $options);
    }

    public function themeList($post, $name) {
        $value=$this->load_fields(array('postid'=>$post->ID, 'field_name'=>$name));
        $value=unserialize($value[$name][0]);
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $post->post_type, $name);

        $values=array('label' => $fieldInfo['info']['name'], 'name'=>$name, 'value'=>$value, 'extra' => $fieldInfo['extra']);

        $this->includeTemplate('theme-urlfield-list.php', $values);
    }

    public function theme_admin($values) {
        $this->includeTemplate('theme-urlfield-admin.php', $values);
    }

    public function theme_input($values) {
        $this->includeTemplate('theme-urlfield-input.php', $values);
    }

    public function init() {
        if(is_admin()) {
          wp_enqueue_style($this->getId().'-style', $this->httpRoot. 'style.css');
        }
    }
}
$cf_urlfield= new CustomFields_UrlField();
