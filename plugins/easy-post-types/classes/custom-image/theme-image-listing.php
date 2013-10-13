<?php
$image_field = WP_Image_Form_Field::singleton();
?>

<?php /*
<?php if (is_array($values['value'])) : ?>
    <div class="list-images">
        <ul>
            <?php $index=0; foreach($values['value'] as $key=>$image) : ?>
            <li>
                <?php echo $image[IMAGE_FIELD_TITLE] ?>
                <?php $res = $this->getImage($image['value'], $values['field_name'], $values['posttype'], $values['extra']['icon_size']); echo $res['html']; ?>
                <span class="remove"><a href="Javascript:imageField.removeImage({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','index':'<?php echo $index; ?>','image':'<?php echo $values['field_name']; ?>','postid':'<?php echo $values['postid']; ?>'});" id="remove_image">remove</a></span>
            </li>
            <?php $index++; endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

*/ ?>

<?php if (is_array($values['value'])) : ?>
    <div class="list-images">
        <ul>
            <?php $index=0; foreach($values['value'] as $key=>$image) : ?>
            
            <li>
              <?php
$additional = array(
  'url' => $this->mainContentType->ajaxUrl,
  'postid' => $post->ID,
  'posttype' => $post->post_type,
  'index' => $index,
  /*'image' => $values['field_name'],
  'title':'<?php echo $values['field_name'].IMAGE_FIELD_TITLE; ?>',
       'alt':'<?php echo $values['field_name'].IMAGE_FIELD_ALTERNATE; ?>',*/
  'extra' => $values['extra'],
);


$res =$this->getImage($image['value'], $values['field_name'], $values['posttype'], 'wp-image-form-field-preview'); 
$img = array(
  'src' => $res['url'],
  'attrs' => array(),
);

$image_field->image_field($values['field_name'], array('label'=>'Feature', 'img' => $img, 'change' => false, 'additional'=> $additional));
?>
            </li>
            <?php $index++; endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
