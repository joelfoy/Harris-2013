<?php
if (!empty($values['selected'])) :
  $index=0;  
  foreach($values['selected'] as $id => $pst) : $item = $this->loadPost($id, $values['extra']['reference_type']); ?>
  <tr>
      <td id="<?php echo $id; ?>" position="<?php echo $index++; ?>"></td>
      <td><?php echo $item[0]->post_title ?></td>
      <td><?php echo $item[0]->post_type; ?></td>
      <td><?php echo $item[0]->post_status; ?></td>
      <td><a href="Javascript:referenceField.removePost({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','type':'<?php echo $values['type']; ?>','field_name':'<?php echo $values['field_name']; ?>','postid':'<?php echo $values['postid']; ?>','refid':'<?php echo $item[0]->ID; ?>'});"><?php _e('Remove','cct'); ?></a><a href=""><?php _e('Edit','cct'); ?></a></td>
  </tr>
  <?php
  endforeach;
endif;