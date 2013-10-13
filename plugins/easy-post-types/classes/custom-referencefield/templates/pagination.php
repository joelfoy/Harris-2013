<?php
if ($values['posts']['info']['records']<=CUSTOM_REFERENCEFIELD_POSTPERPAGE) return;

$pages = ($values['posts']['info']['records'] / CUSTOM_REFERENCEFIELD_POSTPERPAGE)+1;

$start = ($values['posts']['info']['start']/CUSTOM_REFERENCEFIELD_POSTPERPAGE) + 1;

if ($pages>5) {
    if ($start>5) {
        $begin=$start-4;
        ?>
            <span class="backward">
                <a href="Javascript:referenceField.searchPost({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','field_name':'<?php echo $values['field_name']; ?>','type':'<?php echo $values['type']; ?>','postid':'<?php echo $values['postid']; ?>', 'page':'<?php echo $begin-1; ?>'});"><?php echo '<<'; ?></a>
            </span>
        <?php
    }
    else
        $begin=1;
} else
    $begin=1;

$count=0;
for ($i=$begin;$i<$start && $count++<=3;$i++) : ?>
    <span class="before">
        <a href="Javascript:referenceField.searchPost({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','field_name':'<?php echo $values['field_name']; ?>','type':'<?php echo $values['type']; ?>','postid':'<?php echo $values['postid']; ?>', 'page':'<?php echo $i; ?>'});"><?php echo $i; ?></a>
    </span>
<?php endfor; ?>

<span class="active"><?php print $start ?></span>


<?php
for ($i=$start+1;$i<=$pages && $count++<=3;$i++): ?>

    <span class="after">
        <a href="Javascript:referenceField.searchPost({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','field_name':'<?php echo $values['field_name']; ?>','type':'<?php echo $values['type']; ?>','postid':'<?php echo $values['postid']; ?>', 'page':'<?php echo $i; ?>'});"><?php echo $i; ?></a>
    </span>

<?php endfor; ?>

<?php
if ($pages>5) {
    if (($pages-1)>$start) : ?>
    <span class="forward">
        <a href="Javascript:referenceField.searchPost({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','field_name':'<?php echo $values['field_name']; ?>','type':'<?php echo $values['type']; ?>','postid':'<?php echo $values['postid']; ?>', 'page':'<?php echo $start+1; ?>'});"><?php echo '>>'; ?></a>
    </span>

    <?php endif;
}
?>
