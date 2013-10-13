<?php
if (!empty($values['posts']['results'])) :
  foreach($values['posts']['results'] as $id => $item) : ?>
  <tr>
      <td><a href="Javascript:referenceField.addPost({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','type':'<?php echo $values['type']; ?>','field_name':'<?php echo $values['field_name']; ?>','postid':'<?php echo $values['postid']; ?>','refid':'<?php echo $item->ID; ?>'});"><?php _e('Add','cct'); ?></a></td>
      <td><?php echo $item->post_title; ?></td>
      <td><?php echo $item->post_type; ?></td>
      <td><?php echo $item->post_status; ?></td>
      <td><?php echo $item->post_date; ?></td>
  </tr>
  <?php
  endforeach;
endif;