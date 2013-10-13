<?php $name=$values['name']; ?>
<?php if ($values['extra']['show_label']=='yes') : ?>
    <span class="label"><?php echo $values['label']; ?></span>
<?php endif; ?>
<span class="field">
    <a target="<?php echo $values['value'][$name.CUSTOM_URLFIELD_LINKOPEN]; ?>" href="<?php echo $values['value'][$name.CUSTOM_URLFIELD_LINKNAME]; ?>"><?php echo $values['value'][$name]; ?></a>
</span>