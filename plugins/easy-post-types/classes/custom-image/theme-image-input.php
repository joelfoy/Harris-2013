<?php global $post; ?>
<?php
$image_field = WP_Image_Form_Field::singleton();

$additional = array(
  'url' => $this->mainContentType->ajaxUrl,
  'postid' => $post->ID,
  'posttype' => $post->post_type,
  /*'image' => $values['field_name'],
  'title':'<?php echo $values['field_name'].IMAGE_FIELD_TITLE; ?>',
       'alt':'<?php echo $values['field_name'].IMAGE_FIELD_ALTERNATE; ?>',*/
  'extra' => $values['extra'],
);
?>
 <div id="image-listing_<?php echo $values['field_name']; ?>">
   <?php include "theme-image-listing.php"; ?>
</div>
<div class="add-image-field">
<?php
$image_field->image_field($values['field_name'], array('add_text'=> __('Add %s', 'ept'), 'label'=>$values['field_name'], 'additional'=> $additional));
?></div>

<?php
/*
<span class="label"><?php echo $values['name']; ?></span>
<input type="text" value="" name="<?php echo $values['field_name']; ?>" id="<?php echo $values['field_name']; ?>" />
<a href="<?php echo $this->httpRoot.'media.php'; ?>?width=640&amp;height=523&ref=<?php echo $values['field_name']; ?>" class="button thickbox button-highlighted browse-attachments">Browse Images</a>
<span class="label"><?php _e('Title'); ?></span>
<input type="text" name="<?php echo $values['field_name'].IMAGE_FIELD_TITLE; ?>" />
<span class="label"><?php _e('Alternate'); ?></span>
<input type="text" name="<?php echo $values['field_name'].IMAGE_FIELD_ALTERNATE; ?>" />
<div class="submit" id="add_image"><a href="Javascript:imageField.addImage({
       'url':'<?php echo $this->mainContentType->ajaxUrl; ?>',
       'postid':'<?php echo $post->ID; ?>',
       'posttype':'<?php echo $post->post_type; ?>',
       'image':'<?php echo $values['field_name']; ?>',
       'title':'<?php echo $values['field_name'].IMAGE_FIELD_TITLE; ?>',
       'alt':'<?php echo $values['field_name'].IMAGE_FIELD_ALTERNATE; ?>',
       'extra':<?php echo str_replace('"',"'", json_encode($values['extra'])); ?>
       });">Add Image</a></div>
       */ ?>
