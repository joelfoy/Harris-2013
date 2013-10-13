<?php
/*
Plugin Name: Easy Post Types - Image Field
Plugin URI:
Description: Custom Type ImageField
Author: New Signature
Version: 1.0.0
Author URI: http://newsignature.com/
*/

include dirname(__FILE__)."/javascript.php";
require_once dirname(__FILE__).'/classes/wp_image_form_field/wp_image_form_field.class.php';

define ( 'CUSTOM_IMAGEFIELD_TEMPLATEPATH', dirname(__FILE__));

define ('IMAGE_FIELD_TITLE', '_title');
define ('IMAGE_FIELD_ALTERNATE', '_alternate');

define ('IMAGE_FIELD_THUMBNAIL_WIDTH', 80);
define ('IMAGE_FIELD_THUMBNAIL_HEIGHT', 80);

define ('IMAGE_FIELD_MEDIUM_WIDTH', 320);
define ('IMAGE_FIELD_MEDIUM_HEIGHT', 240);

class CustomFields_ImageField {

    public $mainContentType;
    public $root;
    public $httpRoot;

    public function getId() {
        return "imagefield";
    }

    public function __toString()
    {
        return "Easy Post Types : Image Field";
    }

    public function  __construct() {
        $this->root=dirname(__FILE__).'/';
        $this->httpRoot = plugins_url( '', __FILE__).'/';
        $uploadDir = wp_upload_dir();
        // if ($uploadDir['basedir'])
        load_plugin_textdomain('cct', false, dirname( plugin_basename( __FILE__ ) )  );
        add_action( 'init', array($this, 'init' ));
        add_action( 'admin_init', array($this, 'admin_init'));
        add_action('admin_print_scripts', array($this, 'admin_print_scripts'));
        add_action('ct_load_types', array($this, 'load_type'));
        add_action('wp_ajax_imgfield_remove_image', array($this,'ajax_removeImage'));
        add_action('wp_ajax_imgfield_add_image', array($this,'ajax_addImage'));
        add_action('admin_head', array($this, 'addJs'));
        add_image_size('ept_thumbnail', IMAGE_FIELD_THUMBNAIL_WIDTH, IMAGE_FIELD_THUMBNAIL_HEIGHT, true);
        add_image_size('ept_medium', IMAGE_FIELD_MEDIUM_WIDTH, IMAGE_FIELD_MEDIUM_HEIGHT, true);
        add_image_size('ept_original', 0, 0, true);
        
        $image_field = WP_Image_Form_Field::singleton();
        $image_field->dispatch();
        
    }

    public function addJs() {
        $js = new ImageField_Javascript();
        $js->create($this);
   }
   
    public function extra($post_values) {
        return array(
            'show_label'    => $post_values['show_label'],
            'icon_size'     => $post_values['icon_size'],
            'medium_size'   => $post_values['medium_size'],
            'crop'          => $post_values['crop'],
            'kwidth'        => $post_values['kwidth'],
            'kheight'       => $post_values['kheight'],
            );
    }

    public function createImageSize($name, $file, $ext, $uploadDir, $width, $height, $size, $extra) {
        global $_wp_additional_image_sizes;
        switch (strtolower($ext)) {
            case 'jpg' :
            case 'jpeg':
                $src_img=@imagecreatefromjpeg($name);
                break;
            case 'png' :
                $src_img=@imagecreatefrompng($name);
                if($src_img) {
	                imagealphablending($src_img, true); // setting alpha blending on
	                imagesavealpha($src_img, true); // save alphablending setting (important)
                }
                break;
            case 'gif' :
                $src_img=@imagecreatefromgif($name);
                break;
        }

        if ($src_img===false) return false;
        $old_x=imageSX($src_img);
        $old_y=imageSY($src_img);

        if (isset($_wp_additional_image_sizes[$size])) {
            $width=$_wp_additional_image_sizes[$size]['width'];
            $height=$_wp_additional_image_sizes[$size]['height'];
            if (empty($width) ||$width==0 || empty($height) || $height==0) {
                $width=IMAGE_FIELD_THUMBNAIL_WIDTH;
                $height=IMAGE_FIELD_THUMBNAIL_HEIGHT;
                $size='ept_thumbnail';
            }
        }
        else {
            $width=IMAGE_FIELD_THUMBNAIL_WIDTH;
            $height=IMAGE_FIELD_THUMBNAIL_HEIGHT;
        }

        if ($size=='ept_original')
            $filename = dirname($name).'/'.$file.'.'.$ext;
        else
            $filename = dirname($name).'/'.$file.'_'.$size.'.'.$ext;

        if ($extra['crop']=='yes') {
            if ($extra['kwidth']=='yes') {
                $hw_ratio = $old_x/$old_y;
                $ratio = $width/$height;

                if ($hw_ratio>$ratio) {
                    $cropx = ($old_x - ($old_y *$ratio))/2;
                    $cropy=0;
                }elseif ($hw_ratio <$ratio) {
                    $cropx=0;
                    $cropy=($old_y -($old_x/$ratio))/2;
                }else {
                    $cropx=0;
                    $cropy=0;
                }
            }
            if ($extra['kheight']=='yes') {
                $hw_ratio = $old_y/$old_x;
                $ratio = $height/$width;

                if ($hw_ratio>$ratio) {
                    $cropx = ($old_x - ($old_y *$ratio))/2;
                    $cropy=0;
                }elseif ($hw_ratio <$ratio) {
                    $cropx=0;
                    $cropy=($old_y -($old_x/$ratio))/2;
                }else {
                    $cropx=0;
                    $cropy=0;
                }
            }
        } else {

            if (($extra['kwidth']=='yes' && $extra['kheight']=='yes') ||
                ($extra['kwidth']!='yes' && $extra['kheight']!='yes')) {
                $cropx=0;
                $cropy=0;
            }elseif ($extra['kwidth']=='yes') {
                $ratio=$old_x/$width;
                $height=$old_y/$ratio;
                $cropx=0;
                $cropy=0;
            }elseif ($extra['kheight']=='yes') {
                $ratio=$old_y/$height;
                $width=$old_x/$ratio;
                $cropx=0;
                $cropy=0;
            }

        }

        $dst_img=ImageCreateTrueColor($width,$height);
	imagecopyresampled($dst_img,$src_img,0,0,$cropx,$cropy,$width,$height,$old_x-2*$cropx,$old_y-2*$cropy);
        switch (strtolower($ext)) {
            case 'jpg' :
            case 'jpeg':
                imagejpeg($dst_img, $filename);
                break;
            case 'png' :
                imagepng($dst_img, $filename);
                break;
            case 'gif' :
                imagegif($dst_img, $filename);
                break;
        }
    }

    public function getImage($name, $field_name, $post_type, $size=null){
        global $_wp_additional_image_sizes;

        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $post_type, $field_name);
        $uploadDir = wp_upload_dir();
        $fileInfo = pathinfo($name);
        
        /*$parts=explode("/",$name);
        $file=$parts[sizeof($parts)-1];
        $fparts = split("\.", $file);
        $file='';
        $dot='';
        foreach($fparts as $key=>$part) {
            $file .= $dot.$fparts[$key];
            if ($key>=sizeof($fparts)-2) break;
            $dot='.';
        }
        //$file=$fparts[0];
        $ext=$fparts[sizeof($fparts)-1];*/
        $ext = $fileInfo['extension'];
        $file = $fileInfo['filename'];
        $original_image_file = $uploadDir['basedir'].'/'.$name;
 

        /*$index=0;
        foreach($parts as $key => $part) {
            $index++;
            if ($index==sizeof($parts)) break;
            $fullname .= '/'.$part;
        }*/
        $fullname = '/'.$fileInfo['dirname'];
        

        if ($size==null) {
            $size='ept_thumbnail';
        }

        if (isset($_wp_additional_image_sizes[$size])) {
            $width=$_wp_additional_image_sizes[$size]['width'];
            $height=$_wp_additional_image_sizes[$size]['height'];
            if (empty($width) || empty($height)) {
                $width=IMAGE_FIELD_THUMBNAIL_WIDTH;
                $height=IMAGE_FIELD_THUMBNAIL_HEIGHT;
                $size='ept_thumbnail';
            }
        }
        else {
            $width=IMAGE_FIELD_THUMBNAIL_WIDTH;
            $height=IMAGE_FIELD_THUMBNAIL_HEIGHT;
        }

        if ($size=='ept_original') {
            $filename = $uploadDir['baseurl'].'/'.$name;
        }
        else {
            $filename = $uploadDir['baseurl'].$fullname.'/'.$file.'_'.$size.'.'.$ext;
        }
        

        if ($size=='ept_original') {
            $filen = $uploadDir['basedir'].'/'.$name;
        }
        else {
            $filen = $uploadDir['basedir'].$fullname.'/'.$file.'_'.$size.'.'.$ext;
        }

        if (file_exists($filen)) {
            return array('url' => $filename, 'html' => '<img src="'.$filename.'" />');
        }

        if (strpos($name, "http")===false) {
           $info = wp_upload_dir();
           $url = $info['baseurl'].'/';
           $name = $url.$name;
        }

        $res=$this->createImageSize($original_image_file, $file, $ext, $uploadDir, $width, $height, $size, $fieldInfo['extra']);
        if ($res===false)
            return array('url' => 'error_image', 'html' => __('Image Error', 'cct'));
        return array('url' => $filename, 'html' => '<img src="'.$filename.'" />');
    }

    public function ajax_removeImage() {
        global $post;
        $res = get_post_meta($_POST['postid'], $_POST['field_name'], true);

        if (is_array($res))
            array_splice($res, $_POST['index'], 1);
        else
            $res=array();
        update_post_meta($_POST['postid'], $_POST['field_name'], $res);
        $values['value']=$res;
        $values['postid']=$_POST['postid'];
        $values['field_name']=$_POST['field_name'];
        include "theme-image-listing.php";

        exit();
    }

    public function ajax_addImage() {
        global $post;
        $r=$this->load_fields(array('postid'=>$_POST['postid'], 'fields'=>array('field_name' => $_POST['field_name'])));
        $result=array_merge($r, array (array(
                'value' => $_POST['image'],
                IMAGE_FIELD_TITLE => $_POST['title'],
                IMAGE_FIELD_ALTERNATE => $_POST['alt']
                )) );
        update_post_meta($_POST['postid'], $_POST['field_name'], $result);
        $values['value']=$result;
        $values['posttype']=$_POST['posttype'];
        $values['postid']=$_POST['postid'];
        $values['extra']=$_POST['extra'];
        $values['field_name']=$_POST['field_name'];
        include "theme-image-listing.php";

        exit();
    }


    public function load_type($cf) {
        $cf->registerType($this);
        $this->mainContentType=$cf;
    }
    public function getRoot() {
        return $this->root;
    }

    public function getName() {
        return 'Image Field';
    }

    public function load_fields($fields) {
        $res = get_post_meta($fields['postid'], $fields['fields']['field_name'], true);
        if (!is_array($res))
            $res=array();
        return $res;
    }

    public function save_fields($fields) {
    }

    public function includeTemplate($name, $values=array()) {
        $path=CUSTOM_IMAGEFIELD_TEMPLATEPATH.'/'.$name;
        if (file_exists($path))
            include($path);
        else
            include($this->root . $name);
    }


    private function getImages($value, $name, $post_type) {
        $images = array();
        $imgs=get_intermediate_image_sizes();
        foreach($imgs as $key => $img) {
            $images[$img] = $this->getImage($value, $name, $post_type, $img);
        }
        return $images;
    }

    public function theme($post, $name, $options=null) { 
        global $post;
        global $_wp_additional_image_sizes;
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $post->post_type, $name);
        $values=array('label' => $fieldInfo['info']['name'], 'name'=>$name, 'value'=>$value, 'extra' => $fieldInfo['extra']);
        $values['existing']=$this->load_fields(array('postid'=>$post->ID,'fields'=>array('field_name'=>$name)));
        $values['options']=$options;

        if (!empty($values['existing'])) {
            foreach($values['existing'] as $key=>$image) {
                $images = $this->getImages($image['value'], $name, $post->post_type);
                if (!empty($options)) {
                    foreach($options as $key=>$size) {
                        if (!isset($_wp_additional_image_sizes[$size['size']])) {
                            $_wp_additional_image_sizes[$size['size']]['width']=$size['width'];
                            $_wp_additional_image_sizes[$size['size']]['height']=$size['height'];
                        }
                        $images[$size['size']]=$this->getImage($image['value'], $name, $post->post_type, $size['size']);
                    }
                }
                if (strpos($image['value'],"http")===false) {
                    $info = wp_upload_dir();
                    $url = $info['baseurl'].'/';
                    $image['value'] = $url . $image['value'];
                }
                $values['images'][]=array('value'=>$image, 'size'=> $images);
            }
        }
        if ($options['raw']===true) {
            return $values;
        }

        $template=$options['template'];
        $this->mainContentType->include_template($this, $name, $template, $values, $options);
    }

    public function themeList($post, $name) {
        $value=$this->load_fields(array('postid'=>$post->ID, 'fields'=>array('field_name'=>$name)));
        $fieldInfo=$this->mainContentType->getFieldInfo($this->getId(), $post->post_type, $name);

        $values=array('label' => $fieldInfo['info']['name'], 'name'=>$name, 'value'=>count($value), 'extra' => $fieldInfo['extra']);
        $this->includeTemplate('theme-image-list.php', $values);
    }

    public function theme_admin($values=array()) {
        $this->includeTemplate('theme-image-admin.php', $values);
    }

    public function prepareArray($input, $value) {
        $options=array();
        $items=split("\n", $input);
        foreach($items as $item) {
            $pieces=split("\|", $item);
            $options[$pieces[0]]=array('key'=>$pieces[0], 'value'=>$pieces[1], 'selected' => $value==$pieces[0]?"selected":"");
        }
        return $options;
    }

    public function prepareArrayCode($input, $value) {
        $options=array();
        $items=eval($input);
        foreach($items as $key => $item) {
            $options[$key]=array('key'=>$key, 'value'=>$item, 'selected' => $value==$key?"selected":"");
        }
        return $options;
    }

    public function theme_input($values) {
        global $post;
        $values['postid']=$post->ID;
        $values['existing']=$this->load_fields(array('postid'=>$post->ID, 'fields'=>array('field_name'=>$values['field_name'])));
        $this->includeTemplate('theme-image-input.php', $values);
    }

    public function init() {
        if(is_admin()) {
          wp_enqueue_style($this->getId().'-style', $this->httpRoot. 'style.css');
        }
    }
    
    
    public function admin_print_scripts() {
      global $pagenow;
      if($pagenow == 'post.php' || $pagenow == 'post-new.php') {
        wp_enqueue_script('custom-imagefield', $this->httpRoot . 'custom-imagefield.js');
      }
    }
    
    
    public function admin_init() {
      
    }
}
$cf_imagefield= new CustomFields_ImageField();