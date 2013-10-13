<span class="label"><?php echo $values['name']; ?></span>
<?php if($values['extra']['multiline'] == 'yes'): ?>
  <textarea id="txtarea_<?php echo $values['field_name']; ?>" name="<?php echo $values['field_name']; ?>"><?php echo $values['value']; ?></textarea>
<?php else: ?>
  <input type="text" name="<?php echo $values['field_name']; ?>" value="<?php echo $values['value']; ?>" size="40" />
<?php endif; ?>