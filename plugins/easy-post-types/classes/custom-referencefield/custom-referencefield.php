<?php
/*
Plugin Name: Easy Post Types - TextField
Plugin URI:
Description: Custom Type Textfield
Author: New Signature
Version: 1.0.0
Author URI: http://newsignature.com/
*/

include dirname(__FILE__)."/javascript.php";
include_once dirname(__FILE__)."/classes/queries.php";

define( 'CUSTOM_REFERENCEFIELD_TEMPLATEPATH', dirname(__FILE__));
define( 'CUSTOM_REFERENCEFIELD_POSTPERPAGE', 2);

class CustomFields_ReferenceField {

    public $mainContentType;
    public $root;
    public $httpRoot;

    public function getId() {
        return "referencefield";
    }

    public function __toString()
    {
        return "Easy Post Types : Reference Field";
    }

    public function  __construct() {
        $this->root=dirname(__FILE__).'/';
        $this->httpRoot = plugins_url( '', __FILE__).'/';
        
        load_plugin_textdomain('cct', false, dirname( plugin_basename( __FILE__ ) )  );
        add_action( 'init', array($this, 'init' ));
        add_action('wp_ajax_referencefield_add_postitem', array($this,'ajax_addPost'));
        add_action('wp_ajax_referencefield_remove_postitem', array($this,'ajax_removePost'));
        add_action('wp_ajax_referencefield_search_posts', array($this,'ajax_searchPost'));
        add_action('wp_ajax_referencefield_refresh_posts', array($this,'ajax_refreshPost'));
        add_action('wp_ajax_referencefield_order_posts', array($this,'ajax_orderPost'));
        
        
        add_action('ct_load_types', array($this, 'load_type'));
        add_action('admin_head', array($this, 'addJs'));
   }

   
    public function ajax_refreshPost() {
        $fields['postid']=$_POST['postid'];
        $fields['fields']['field_name']=$_POST['field_name'];
        $r = $this->load_fields($fields);
        $fields['value']=$r;
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $_POST['type'], $_POST['field_name']);
        $values['selected']=$r;
        $values['extra']['reference_type']=$fieldInfo['extra']['reference_type'];
        $values['type']=$_POST['type'];
        $values['field_name']=$_POST['field_name'];
        $values['postid']=$_POST['postid'];
        include "templates/list-posts-header.php";

        exit();
        
    }

    public function ajax_orderPost() {
        $fields['postid']=$_POST['postid'];
        $fields['fields']['field_name']=$_POST['field_name'];
        $fields['value']=$_POST['values'];
        $this->internalSave($fields);
        exit();
        
    }
    
    public function ajax_addPost() {
        $fields['postid']=$_POST['postid'];
        $fields['fields']['field_name']=$_POST['field_name'];
        $r = $this->load_fields($fields);
        $r[$_POST['refid']]=$_POST['refid'];
        $fields['value']=$r;
        $this->internalSave($fields);

        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $_POST['type'], $_POST['field_name']);
        $values['selected']=$r;
        $values['extra']['reference_type']=$fieldInfo['extra']['reference_type'];
        $values['postid']=$_POST['postid'];
        $values['type']=$_POST['type'];
        $values['field_name']=$_POST['field_name'];
        $query = new Queries();
        $res = $query->getSearchList($_POST['text'], $fieldInfo['extra']['reference_type'], $r, $_POST['draft']=='true'?true:false, $_POST['published']=='true'?true:false);
        $values['posts']=$res;

        include "templates/list-search-items.php";
        exit();
    }

    public function ajax_removePost() {
        $name=$_POST['field_name'];
        $type=$_POST['type'];
        $fields['postid']=$_POST['postid'];
        $fields['fields']['field_name']=$_POST['field_name'];
        $r = $this->load_fields($fields);
        unset($r[$_POST['refid']]);
        $fields['value']=$r;
        $this->internalSave($fields);
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $_POST['type'], $_POST['field_name']);
        $values['selected']=$r;
        $values['extra']['reference_type']=$fieldInfo['extra']['reference_type'];
        $values['type']=$type;
        $values['field_name']=$name;
        $values['postid']=$_POST['postid'];
        include "templates/list-posts-header.php";

        exit();
    }

    public function ajax_searchPost() {
        $postid=$_POST['postid'];
        $text=$_POST['text'];
        $name=$_POST['field_name'];
        $type=$_POST['type'];

        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $type, $name);
        $query = new Queries();

        $fields['postid']=$postid;
        $fields['fields']['field_name']=$name;
        $val = $this->load_fields($fields);
        
        $res = $query->getSearchList($text, $fieldInfo['extra']['reference_type'], $val, $_POST['draft']=='true'?true:false, $_POST['published']=='true'?true:false, empty($_POST['page'])?1:$_POST['page']);
        $values['posts']=$res;
        $values['postid']=$postid;
        $values['type']=$type;
        $values['field_name']=$name;
        $values['info']=$res['info'];
        $values['selected']=$val;
        include "templates/list-search-items.php";
        exit();
    }

    public function addJs() {
        $js = new ReferenceField_Javascript();
        $js->create($this);
    }


    public function extra($post_values) {
        return array(
            'show_label'        => $post_values['show_label'],
            'reference_type'    => $post_values['reference_type']
            );
    }

    public function includeTemplate($name, $values=array()) {
        $path=CUSTOM_REFERENCEFIELD_TEMPLATEPATH.'/'.$name;
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
        return 'Reference Field';
    }

    public function load_fields($fields) {
        $res = get_post_meta($fields['postid'], $fields['fields']['field_name'], true);
        if (!is_array($res))
            $res=array();
        return $res;
    }

    public function internalSave($fields) {
        update_post_meta($fields['postid'], $fields['fields']['field_name'], $fields['value']);
    }
    
    public function save_fields($fields) {
    }

    public function theme($post, $name, $options=null)  {
        $value=$this->load_fields(array('postid'=>$post->ID, 'field_name'=>$name));
        if ($options['raw']==true) return $value[$name][0];
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $post->type, $name);
        
        $values=array('label' => $fieldInfo['info']['name'], 'name'=>$name, 'value'=>$value[$name][0], 'extra' => $fieldInfo['extra']);

        $template=$options['template'];

        $this->mainContentType->include_template($this, $name, $template, $values, $options);
    }

    public function themeList($post, $name) {
        $value=$this->load_fields(array('postid'=>$post->ID, 'field_name'=>$name));
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $post->type, $name);

        $values=array('label' => $fieldInfo['info']['name'], 'name'=>$name, 'value'=>$value[$name][0], 'extra' => $fieldInfo['extra']);

        $this->includeTemplate('theme-referencefield-list.php', $values);
    }

    public function theme_admin($values) {
        $this->includeTemplate('theme-referencefield-admin.php', $values);
    }

    public function loadPost($id, $types) {
        $n=new Queries();
        $items=$n->getPost($id, $types);
        return $items[$id];
    }

    public function theme_input($values) {
        global $post;
        $fields['postid']=$post->ID;
        $fields['fields']=$values;
        $val = $this->load_fields($fields);
        $values['selected']=$val;
        $values['postid']=$post->ID;
        $values['type']=$post->post_type;
        $this->includeTemplate('theme-referencefield-input.php', $values);
    }

    public function init() {
    	  if(is_admin()) {
	        wp_enqueue_script('custom-referencefield', $this->httpRoot . 'custom-referencefield.js');
	        wp_enqueue_style($this->getId().'-style', $this->httpRoot. 'style.css');
    	  }
    }
}
$cf_referencefield= new CustomFields_ReferenceField();