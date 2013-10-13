<div class="wrap">   
    <h2><img src="<?php echo ICLT_PLUGIN_URL ?>/img/32_own.png" height="32" width="32" alt="Icon" align="left" style="margin-right:6px;" /><?php echo __('ICanLocalize Translator Settings') ?></h2> 
    <form action="" method="post">
    <?php wp_nonce_field('update-incalocalize') ?>
    
    
    <?php if(isset($iclq) && $e=$iclq->error()): ?>
    <div id="message" class="error">
    <p><b><?php echo __('Error') ?>:</b> <?php echo $e ?></p>
    </div>    
    <?php endif; ?>
    
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row">&nbsp;</th>
                <td>
                    <div style="background:url(<?php echo ICLT_PLUGIN_URL ?>/img/<?php echo $help_icon_image ?>);background-repeat:no-repeat;padding:4px 4px 4px 32px;border:solid 1px #eee;float:left;background-position:4px 4px;height:24px;<?php echo $help_bg_style ?>">
                    <?php echo __('Need help? Visit'); ?> <a href="http://design.icanlocalize.com/wordpress-translation/using-icanlocalize-translator/">ICanLocalize Translation Getting Started Guide</a>.
                    </div>                
                </td>
            </tr>                    
            <tr valign="top">
                <th scope="row"><?php echo __('Site ID') ?></th>
                <td><input id="iclt_site_id" name="iclt_site_id" class="code" type="text" size="20" value="<?php echo $this->settings['site_id'] ?>" /></td>
            </tr>    
            <tr valign="top">
                <th scope="row"><?php echo __('Access Key') ?></th>
                <td><input id="iclt_access_key" name="iclt_access_key" class="code" type="text" size="40" value="<?php echo $this->settings['access_key'] ?>" /></td>
            </tr>  
            <?php if(!$e): ?>              
            <tr valign="top">
                <th scope="row"><?php echo __('Languages settings') ?></th>
                <td>
                    <div id="the_languages" style="width:200px;float:left;">
                    
                    <?php 
                    if(is_array($this->settings['languages']) && count($this->settings['languages'])){                        
                        foreach($this->settings['languages'] as $l){
                            $lpairs[] = $l['from_name'] . ' &raquo; ' . $l['to_name'];
                            $blog_lang_options[$l['from_name']] = 1;
                        }
                        echo join('<br />',$lpairs);
                    }else{
                        echo __('No language preference set');
                    }                    
                    ?>                    
                    <?php if($this->settings['languages']): ?>
                    <hr style="border:none;border-top:solid 1px #fff" />
                   Blog language <select name="iclt_blog_language">
                        <?php foreach($blog_lang_options as $k=>$v): ?>
                        <option value="<?php echo $k ?>" <?php if($this->settings['iclt_blog_language']==$k):?>selected="selected"<?php endif?>>
                            <?php echo $k ?></option>
                        <?php endforeach; ?>                        
                    </select>
                    <?php endif; ?>
                    </div>
                    <input class="button" type="button" id="update_languages" value="<?php echo __('Update languages from server')?>" 
                        onclick="update_lng('<?php echo $this->settings['site_id'] ?>','<?php echo $this->settings['access_key'] ?>')" />               
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">&nbsp;</th>
                <td>                    
                    <input type="checkbox" name="no_translation_confirmation" value="1"
                    <?php if(!$this->settings['no_translation_confirmation']):?>checked="cehecked"<?php endif;?>/> 
                    <?php echo __('Notify before sending translation jobs.')?>
                    &nbsp;&nbsp;&nbsp;                    
                    <input type="checkbox" name="translate_new_contents_when_published" value="1"
                    <?php if($this->settings['translate_new_contents_when_published']):?>checked="cehecked"<?php endif;?>/> 
                    <?php echo __('Translate new contents when published.')?>                    
                </td>
            </tr>              
            <?php endif ?>                
            <tr valign="top">
                <th scope="row"><?php echo __('Plugin version') ?></th>
                <td><?php echo get_option('iclt_version') ?></td>
            </tr>                
            
        </tbody>
    </table>
    
    <p class="submit">    
    <input class="button" type="submit" value="Save Changes" name="Submit"/>
    </p>
    </form>

    <?php if(!$e): ?>
    <h3 id="translations_in_progress"><?php echo __('Translations in progress') ?></h3>
    <table class="form-table">
        <tbody>                
            <tr>                
                <td>
                    <div id="iclt_pending_requests" style="max-height:400px;overflow:auto">
                    <script type="text/javascript">
                    jQuery(document).ready(function(){
                        jQuery('#iclt_pending_requests').html('loading...');
                    });
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo ICLT_URL ?>",
                        data: "ajx_action=get_pending_requests",
                        success: function(msg){
                            jQuery('#iclt_pending_requests').html(msg);
                        }
                    });
                    </script>
                </td>
            </tr>
            
        </tbody>
    </table>
    <?php endif ?>                     
</div>