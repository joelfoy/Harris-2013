<div class="wrap">
    <h2><?php echo __('Translation Cart') ?></h2>
    <!--<form action="" method="post">-->
    <?php wp_nonce_field('update-incalocalize-mass') ?>
    <div class="subsubsub"></div>
    <table class="widefat">
        <thead>
            <tr>
                <th scope="col" width="140">Date</th>
                <th scope="col">Title</th>
                <th scope="col" width="20">Type</th>
                <th scope="col" width="20">Status</th>                
                <th scope="col" width="10">&nbsp;</th>
            </tr>
        </thead>    
        <tbody>  
            <?php if($jobs):?>
            <?php foreach($jobs as $job): ?>  
            <?php 
                if ( '0000-00-00 00:00:00' == $job->post_date) {
                    $date =  __('Unpublished');
                }else{
                    $date = date(__('Y/m/d g:i:s A'),strtotime($job->post_date));
                }
            ?>
            <tr id="iclt_mass_tr_<?php echo $job->post_id ?>">
                <td nowrap><?php echo $date; ?></td>
                <td><a href="<?php echo get_edit_post_link($job->post_id) ?>"><?php echo $job->post_title?$job->post_title:'(no title)'; ?></a></td>
                <td><?php echo $job->post_type?></td>
                <td><?php echo $job->post_status?></td>                
                <td><div class="iclt_add_to_bt"><a id="iclt-bt-<?php echo $job->post_id ?>" href="javascript:;" class="rem" rel="mass" title="<?php echo __('Remove from batch translation') ?>"><?php echo __('rem') ?></a></div></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4" align="center">Empty</td>
            </tr>            
            <?php endif; ?>
        </tbody>
    </table>
    <p class="submit">    
    <input id="iclt_start_batch" class="button" type="submit" value="<?php echo __('Start') ?>" name="Submit" 
        <?php if(defined('TRIGGER_MASS_TRANSLATION') || !$jobs): ?>disabled="disabled"<?php endif; ?>/>
    <input id="iclt_stop_batch" class="button" type="submit" value="<?php echo __('Stop') ?>" name="Stop" 
        <?php if(!defined('TRIGGER_MASS_TRANSLATION')): ?>style="display:none<?php endif; ?>" />
    <span id="iclt_batch_status"></span>
    </p>
    <!--</form>-->
</div>
