<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery( "#reference-fields-list" ).sortable({
             update: function(event, ui) { 
                var data = {values:{}}; 
                jQuery.each(ui.item.parent().find('tr'),function(key, value){
                    var id=ui.item.parent().find('tr').eq(key).find('td').eq(0).attr('id');
                    data['values'][id]=id;
                }); 
                data['url']='<?php echo $this->mainContentType->ajaxUrl; ?>';
                data['postid']=<?php echo $values['postid']; ?>;
                data['field_name']='<?php echo $values['field_name']; ?>';
                referenceField.orderPosts(data);
             }

        });
        jQuery( "#reference-fields-list" ).disableSelection();

    });
</script>
<table id="reference-table-posts-<?php echo $values['field_name'];?>" class="widefat tag fixed" cellspacing="0">
    <thead class="content-types-list">
      <tr>
        <th><?php _e('Order', 'cct'); ?></th>
        <th><?php _e('Title', 'cct'); ?></th>
        <th><?php _e('Type', 'cct'); ?></th>
        <th><?php _e('Status', 'cct'); ?></th>
        <th><?php _e('Actions', 'cct'); ?></th>
      </tr>
    </thead>
    <tbody id="reference-fields-list" >
        <?php include "list-row-header.php"; ?>
    </tbody>
  </table>

