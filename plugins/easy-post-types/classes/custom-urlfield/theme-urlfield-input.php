<?php $name=$values['field_name'];?>
<span class="label"><?php echo $values['name']; ?> <?php _e('Text','cct'); ?></span>
<input type="text" name="<?php echo $values['field_name']; ?>" value="<?php echo $values['value'][$name]; ?>" size="20" />
<span class="label"><?php echo $values['name']; ?> <?php _e('Link','cct'); ?></span>
<input type="text" name="<?php echo $values['field_name'].CUSTOM_URLFIELD_LINKNAME; ?>" value="<?php echo $values['value'][$name.CUSTOM_URLFIELD_LINKNAME]; ?>" size="20" />
<span class="label"><?php echo $values['name']; ?> <?php _e('Target','cct'); ?></span>
<select name="<?php echo $values['field_name'].CUSTOM_URLFIELD_LINKOPEN; ?>">
    <option value="_blank">_blank</option>
    <option value="_self">_self</option>
    <option value="_parent">_parent</option>
</select>

