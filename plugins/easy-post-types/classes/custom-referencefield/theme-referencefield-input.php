<?php
global $post;
?>

<h1><?php echo $values['name']; ?></h1>

<?php include "templates/list-posts-header.php"; ?>

<div class="textsearch">
    <input type="text" id="texttosearch" name="texttosearch" />
    <div class="buttons">
        <a href="Javascript:referenceField.searchPost({'url':'<?php echo $this->mainContentType->ajaxUrl; ?>','field_name':'<?php echo $values['field_name']; ?>','type':'<?php echo $post->post_type; ?>','postid':'<?php echo $post->ID; ?>','page':'1'});"><?php _e('Search','cct'); ?></a>
        <a href=""><?php _e('Show all','cct'); ?></a>
    </div>
</div>

<div class="selection">
    <span class="title"><?php _e('Status','cct'); ?></span>
    <ul>
        <li><?php _e('Published','cct'); ?><input type="checkbox" name="status-published" checked="checked" /></li>
        <li><?php _e('Draft','cct'); ?><input type="checkbox" name="status-draft" /></li>
    </ul>
</div>
<?php
    $values['type']=$post->post_type;
    $n=new Queries();
    $values['posts']=$n->getSearchList('', $values['extra']['reference_type'], $values['selected'], false, true);
    include "templates/list-posts.php";
?>
