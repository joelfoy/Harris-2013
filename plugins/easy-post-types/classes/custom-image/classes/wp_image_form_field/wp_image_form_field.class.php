<?php

class WP_Image_Form_Field {
  
  private static $instance;
  private $has_dispatched = false;
  private $uid = 1;
  private $url;
  
  private function __construct() {
    $this->url = plugins_url( '', __FILE__ ). '/';
  }
  
  
  private function field_uid($name) {
    $i = $this->uid;
    $this->uid++;
    return 'wpimageformfield-'.$i.'-'.$name;
  }
  
  /**
   * Get the instances of the singleton of the 
   */
  public static function singleton () {
  	if (!self::$instance) {
  		$c = __CLASS__;
  		self::$instance = new $c();
  	}
  	
  	return self::$instance;
  }
  
  
  /**
   * Dispatch the class to attach hooks
   */
  function dispatch() {
    if(!$this->has_dispatched) {
      add_action('admin_init', array($this, 'admin_init'));
      add_action('admin_print_styles', array($this, 'admin_print_styles'));
      add_action('admin_print_scripts', array($this, 'admin_print_scripts'));
      add_image_size( 'wp-image-form-field-preview', 150, 100 );
      
      global $pagenow;
      if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) {
				add_filter( 'image_send_to_editor', array( $this ,'image_send_to_editor'), 1, 8 );
				add_filter( 'gettext', array( $this, 'replace_insert_button_text' ), 1, 3 );
				add_filter('admin_head', array($this, 'check_if_deleted'));
				add_filter('admin_print_footer_scripts', array($this, 'fix_form_actions'),100);
				//add_filter( 'media_upload_tabs', array( $this, 'media_upload_tabs' ) );
			}
    }
    $this->has_dispatched = true;
  }
  
  
  /**
   * Create the image form field
   *
   * This prints out the HTML for adding an image form field that uses the WP media library
   *
   * @param $name string - the form field name to pass the image attachment ID to
   * @param $options array (optional) - various options configuring the image field
   *    'id'           => 0 - The attachment ID of the image to prepopulate the field with
   *    'delete'       => true - Show the delete button when there is an image
   *    'change'       => true - Show the change button
   *    'insert_text'  => 'Insert' - The text to use in the button to insert image
   *    'change_text'  => 'Change' - the text to use in the change button
   *    'add_text'     => 'Add' - the text to use in the add button
   *    'delete_text'  => 'Delete' - the text to use in the delete button
   *    'label'        => 
   *    'preview_size' => 'image-field-preview' - The image size to use for the preview
   *    'img'          => null - an array of default image to show
   *    'additional'   => array of additional data
   */
  function image_field($name, $options=array()) {
    // Setup the options
    $options = array_merge(
      array(
        'id' => 0,
        'delete' => true,
        'change' => true,
        'insert_text' => __('Insert %s'),
        'change_text' => __('Change'),
        'add_text' => __('Add'),
        'delete_text' => __('Delete'),
        'preview_size' => 'wp-image-form-field-preview',
        'label' => ''
      ),
      $options);
    
    // Ensure the image size exists, get the dimensions
    global $_wp_additional_image_sizes;
    if(!isset($_wp_additional_image_sizes[$options['preview_size']])) {
      $options['preview_size'] = 'wp-image-form-field-preview';
    }
    $height = $_wp_additional_image_sizes[$options['preview_size']]['height'];
    $width = $_wp_additional_image_sizes[$options['preview_size']]['width'];
    
    $field_id = $this->field_uid($name);
    
    //NOTE #1: the widget id is added here to allow uploader to only return array if this is used with image widget so that all other uploads are not harmed.
    $media_upload_iframe_query = array(
      'type' => 'image',
      'wp_image_field' => true,
      'preview_size' => $options['preview_size'],
      'insert_text' => sprintf($options['insert_text'], $options['label']),
    );
    global $post;
    $media_upload_iframe_query['post_id'] = $post->ID;
    
    $media_upload_iframe_query = http_build_query($media_upload_iframe_query, '', '&amp;');
    $media_upload_iframe_src = admin_url('media-upload.php?'.$media_upload_iframe_query); 
		$image_upload_iframe_src = apply_filters('image_upload_iframe_src', $media_upload_iframe_src);
		
    $image = '';
    $image_showing = false;
    if(!empty($options['img'])) {
      $image = $this->get_image($options['img']['src'], $options['img']['attrs']);
      $image_showing = true;
    } elseif(!empty($options['id'])) {
      $image_info = $this->get_image_information($options['id']);
      $preview = $image_info->sizes[$options['preview_size']];
      $image = $this->get_image($preview->src, array('height' => $preview->height, 'width' => $preview->width));
      $image_showing = true;
    }
    
    $image_icon = '<img src="' . admin_url( 'images/media-button-image.gif' ) . '" alt="" align="absmiddle" /> ';
    $delete_icon = '<span class="wp-image-form-field--delete-icon" style="background-image: url('.admin_url( 'images/xit.gif' ).');" > </span> ';
    
    
    ?>
      <div class="wp-image-form-field <?php echo $image_showing? 'wp-image-form-field-with-image' : 'wp-image-form-field-without-image' ?>" 
        style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>px;"
        id="<?php echo $field_id; ?>">
        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo empty($options['id'])? '': $options['id']; ?>" />
        <div class="wp-image-form-field--image" style="line-height: <?php echo $height; ?>px"><?php echo $image;?></div> 
        <div class="wp-image-form-field--buttons">
          <a href="<?php echo $image_upload_iframe_src; ?>&amp;TB_iframe=true" class="button wp-image-form-field--add wp-image-form-field--open-media-library thickbox"><?php echo $image_icon . sprintf($options['add_text'], $options['label']); ?></a>
          <?php if($options['change']): ?>
            <a href="<?php echo $image_upload_iframe_src; ?>&amp;image_id=&amp;tab=library&amp;TB_iframe=true" class="button wp-image-form-field--change wp-image-form-field--open-media-library thickbox"><?php echo $image_icon . sprintf($options['change_text'], $options['label']); ?></a>
          <?php endif; ?>
          <?php if($options['delete']): ?>
            <a href="#" class="button delete wp-image-form-field--delete"><?php echo $delete_icon . sprintf($options['delete_text'], $options['label']); ?></a>
          <?php endif; ?>
        </div>
      </div>
      <?php if(!empty($options['additional'])): ?>
        <script type="text/javascript">
          jQuery('#<?php echo $field_id; ?>').data('additional', <?php echo json_encode($options['additional']); ?>);
        </script>
      <?php endif; ?>
    <?php
    
  }
  
  
  
  /**
   * Get image information
   *
   * Retrieve all information about the image from the $ID
   */
  public function get_image_information($id) {
    
    $id = (int) $id;
    $meta = wp_get_attachment_metadata($id);
    $sizes = $meta['sizes'];
    unset($meta['sizes']);
    $upload_dir = wp_upload_dir();
    
    $image = get_post($id);
    if(empty($image)) {
      return null;
    }
    $image = clone $image;
    
    $image->src = wp_get_attachment_url($id);
    
    
    
    foreach($meta as $key => $value) {
      $image->$key = $value;
    }
    
    $image->sizes = array();
    foreach($sizes as $size => $info) {
      $img = wp_get_attachment_image_src($id, $size);
      $image->sizes[$size] = new stdclass;
      $image->sizes[$size]->src = $img[0];
      $image->sizes[$size]->filename = $info['file'];
      $image->sizes[$size]->width = $info['width'];
      $image->sizes[$size]->height = $info['height'];
      $image->sizes[$size]->crop = $img[3];
      
      if ( $intermediate = image_get_intermediate_size($id, $size) ) {
        $image->sizes[$size]->file = $upload_dir['basedir'].'/'.$intermediate['path'];
      } 
    }
    
    if(isset($image->image_meta)) {
      $image->image_meta = (object) $image->image_meta;
    }
    
    return $image;
  }
  
  
  
  // 
  /**
   * Binds to the admin_print_styles event to add the stylesheet needed for this class
   */
  public function admin_print_styles() {
   wp_enqueue_style('wp-image-form-field', $this->url.'wp-image-form-field.css');
  }
  
  
  /**
   * Binds to the admin_print_styles event to add the stylesheet needed for this class
   */
  public function admin_print_scripts() {
    global $pagenow;
    wp_enqueue_script('wp-image-form-field-script', $this->url.'wp-image-form-field.js', array('jquery'), 1, true);

    if (('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) && isset($_GET['tab']) && $_GET['tab'] == 'library') {
	    wp_enqueue_script( 'wp-image-form-field-media', $this->url.'media-alter.js', array('jquery'), false, true );
	  }
  }
  
  
  
  /**
   * Binds to the admin_init event
   */
  public function admin_init() {
    $this->fix_async_upload_image();
  }
  
  
  
  /**
	 * Fixes an issue with the media uploader
	 *
	 * Without this fix, an uploaded image cannot be inserted into the widget right away. You would
	 * have to upload the image, then close the thickbox, reopen the media thickbox and then insert 
	 * the image.
	 * 
	 * Credit for logic to Shane & Peter, Inc. (Peter Chester)
	 */
  private function fix_async_upload_image() {
    global $pagenow;
		if(('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) && isset($_REQUEST['attachment_id'])) {
			$GLOBALS['post'] = get_post($_REQUEST['attachment_id']);
		}
	}
	
		/**
	 * Somewhat hacky way of replacing "Insert into Post" with "Insert into Widget"
	 *
	 * @param string $translated_text text that has already been translated (normally passed straight through)
	 * @param string $source_text text as it is in the code
	 * @param string $domain domain of the text
	 * @return void
	 */
	public function replace_insert_button_text( $translated_text, $source_text, $domain ) {
	  
    if ($this->is_our_context() && 'Insert into Post' == $source_text) {
      if(isset($_REQUEST['insert_text'])) {
        return $_REQUEST['insert_text'];
      } elseif(isset($_REQUEST['_wp_http_referer']) && preg_match('#insert_text=.+&#', $_REQUEST['_wp_http_referer'])) {
        $query = parse_url($_REQUEST['_wp_http_referer']);
        $query = $query['query'];
        parse_str($query, $query);
        return $query['insert_text'];
      }
    }
		return $translated_text;
	}
  
  
  /**
	 * Callback for hook image_send_to_editor
	 * 
	 * This instead of filtering the output for return, this instead attaches values via Javascript
	 * to be retrieved on the other side.
	 *
	 * Credit for logic to Shane & Peter, Inc. (Peter Chester)
	 */
	public function image_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt = '' ) {
		// Normally, media uploader return an HTML string (in this case, typically a complete image tag surrounded by a caption).
		// Don't change that; instead, send custom javascript variables back to opener.
		// Check that this is for the widget. Shouldn't hurt anything if it runs, but let's do it needlessly.
		if ($this->is_our_context()) {
			if($alt=='') {
			  $alt = $title;
			}
			
			if(isset($_REQUEST['_wp_http_referer'])) {
        $query = parse_url($_REQUEST['_wp_http_referer']);
        $query = $query['query'];
        parse_str($query, $query);
        
        $query = array_merge($_REQUEST, $query);
      } else {
        $query = $_REQUEST;
      }
			
			$img =  $this->get_image_information($id);
			$size = isset($query['preview_size'])? $query['preview_size'] : 'wp-image-form-field-preview';
			if(isset($img->sizes[$size]) && !empty($img->sizes[$size]->src)) {
        $imgHTML = $this->get_image($img->sizes[$size]->src, array('width' => $img->sizes[$size]->width, 'height' => $img->sizes[$size]->height));
			} else {
			  global $_wp_additional_image_sizes;
			  $imgHTML = $this->get_image($img->src, array('width' => $_wp_additional_image_sizes[$size]['width'], 'height' => $_wp_additional_image_sizes[$size]['height']));
			}
			
			
			?>
			<script type="text/javascript">
				// send image variables back to opener
				var win = window.dialogArguments || opener || parent || top;
				win.WPImageFormField = win.WPImageFormField || {};
				if( win.WPImageFormField.returnMedia ){
					win.WPImageFormField.returnMedia( 
						'<?php echo addslashes($html) ?>', 
						'<?php echo $id ?>',
						'<?php echo addslashes($alt) ?>',
						'<?php echo addslashes($caption) ?>',
						'<?php echo addslashes($title) ?>',
						'<?php echo $align ?>',
						'<?php echo $url ?>',
						'<?php echo $size ?>',
						'<?php echo addslashes($imgHTML); ?>',
						<?php echo json_encode($img); ?>
					);
				}
			</script>
			
			<?php
		}
		return $html;
	}
	
	
	/**
	 *
	 */
	public function check_if_deleted() {
	  if ($this->is_our_context() && !empty($_REQUEST['deleted'])) {
	    ?>
	    <script type="text/javascript">
	      var win = window.dialogArguments || opener || parent || top;
	      win.WPImageFormField = win.WPImageFormField || {};
	      if(win.WPImageFormField.imageDeleted) {
	        win.WPImageFormField.imageDeleted();
	      }
	    </script>
	    <?php
	  }
	}
	
	
	/**
	 * A a result of multiple form submissions, the tokens used to check if is_our_context are lost.
	 * Modifying the forms to not avoid this from happening
	 */
	public function fix_form_actions() {
	  if($this->is_our_context()) {
	    if(isset($_REQUEST['_wp_http_referer'])) {
        $query = parse_url($_REQUEST['_wp_http_referer']);
        $query = $query['query'];
        parse_str($query, $query);
        
        $query = array_merge($_REQUEST, $query);
      } else {
        $query = $_REQUEST;
      }
      ?>
      <script type="text/javascript">
        // send image variables back to opener
        WPImageFormField = WPImageFormField || {};
        
        if( WPImageFormField.fixFormActions ){
          WPImageFormField.fixFormActions({
            'wp_image_field': 1,
            'preview_size'  : '<?php echo addslashes($query['preview_size']) ?>',
            'insert_text'   : '<?php echo addslashes($query['insert_text']) ?>'
          });
        }
      </script>
      <?php
    }
	}
  
  /**
   * Check if the media library will be returning to us instead of the default
   */
  private function is_our_context() {  
    if(isset($_REQUEST['_wp_http_referer'])) {
      $query = parse_url($_REQUEST['_wp_http_referer']);
      $query = $query['query'];
      parse_str($query, $query);
      
      $query = array_merge($_REQUEST, $query);
      return !empty($query['wp_image_field']);
    } else {
      return !empty($_REQUEST['wp_image_field']);
    }
  }
  
  
  /**
	 * Create an the HTML for an image
	 *
	 * A helper for generating the HTML for an image.
	 *
	 * @param $src string - the src for the image
	 * @param $attrs array (optional) - an array of attributes to add to the image
	 * @return HTML
	 */
	function get_image( $src, $attrs=array() ){
		$o .= '<img src="' . $src . '" ';
		$o .= 'alt="' . ( isset($attrs['alt'])? $attrs['alt'] : '' ) . '" ';
		unset( $attrs['alt'] );
		
		foreach( $attrs as $k => $v ){
			if( is_array( $v ) ){
				$v = implode( $v );
			}
			
			$o .= $k . '="'. $v . '" ';
		}
		
		$o .= ' />';
		return $o;
	}
}

