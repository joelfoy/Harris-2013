<?php
$types=get_post_types();
if (!is_array($values['extra']['reference_type']))
    $values['extra']['reference_type']=array();
?>
<table>
  <tbody>
    <tr>
      <th><?php _e('Label :','cct'); ?></th>
      <td>
        <select name="show_label">
            <option <?php echo $values['extra']['show_label']=='yes'?"selected":""; ?> value="yes"><?php _e('Show Label','cct'); ?></option>
            <option <?php echo $values['extra']['show_label']=='no'?"selected":""; ?> value="no"><?php _e('Do Not Show Label','cct'); ?></option>
        </select>
      </td>
    </tr>
    <tr>
      <th><?php _e('Reference Types:','cct'); ?></th>
      <td>
        <select name="reference_type[]" multiple="multiple">
            <?php foreach($types as $key => $type) : ?>
            <option <?php echo in_array($type, $values['extra']['reference_type'])?"selected":""; ?> value="<?php echo $type; ?>"><?php echo $type; ?></option>
            <?php endforeach; ?>
        </select>
      </td>
    </tr>
  </tbody>
</table>
