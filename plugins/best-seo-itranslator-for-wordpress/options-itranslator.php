<?php
include_once (dirname(__file__).'/header.php');
if(!empty($_POST['itr_save'])) {
    if(!get_option('itrShowOriginalPost')) add_option('itrShowOriginalPost',1);
    $langs=implode("+",$_POST['itrTransArray']);
    if(get_option('itrBlogLanguage')) update_option('itrBlogLanguage',$_POST['blogLanguage']);
    else add_option('itrBlogLanguage',$_POST['blogLanguage']);
    if(get_option('itrBlogTransArray')) update_option('itrBlogTransArray',$langs);
    else add_option('itrBlogTransArray',$langs);
    $itrCDd=$_POST['itrCacheDuration'];
    if(is_numeric($itrCDd)) {
        if(get_option('itrCacheDuration')) update_option('itrCacheDuration',$itrCDd);
        else add_option('itrCacheDuration',3600);
    }
    else {
        $err.='Cache duration should be a positive integer (number in seconds).';
    }
    $_out='iTranslator has successfully saved your options.';
}
if(!empty($_POST['itr_delete_cache'])) {
    if(itrDeleteCache(itrCacheDir)) $_out.='Cache deleted.<br />';
    else $err.='Failed to delete cache.<br />';
    if(!file_exists(itrCacheDir)) mkdir(itrCacheDir);
}
if(!empty($_POST['itr_addHA'])) {
    if(itrtoggleHAinstr(1)) $_out.='Successfully added instructions in the .htaccess file.';
    else $err.='Could not modify the file .htaccess';
}
if(!empty($_POST['itr_removeHA'])) {
    if(itrtoggleHAinstr(-1)) $_out.='Successfully removed instructions from the .htaccess file.';
    else $err.='Could not modify the file .htaccess';
}
if(!empty($_POST['itr_show_trans'])) {
    update_option('itrShowOriginalPost',$_POST['showtrans']);
}
if(!is_readable(itrCacheDir) || !is_writable(itrCacheDir)) {
    if(!@chmod(itrCacheDir,0755)) $err.='Cache folder is not readable/writable by the plugin script. Please set permissions value to 0755 to the cache folder (inside iTranslator\'s plugin folder) with your own ftp client.<br />';
}
global $itrBL,$itrCD;
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        //
    });
</script>
<style type="text/css">
    #blogLanguage option {
        padding:4px;
        background:#EDEDDD;
    }
    #itrLatestPosts {
        margin:10px 0;
    }
</style>
<div class="wrap">
    <h2><?php _e('iTranslator v'); echo itrVersion; ?></h2>
    <?php if(!empty($err)) { ?>
    <div class="error fade">
        <p><?php echo $err; ?></p>
    </div>
    <?php }
    else if(!empty($_out)) { ?>
    <div class="updated fade">
        <p><?php echo $_out; ?></p>
    </div>
        <?php } ?>
    <h3>
        .htaccess instructions
    </h3>
    <form name="itrform" id="itrform" method="POST" action="<?php //_e(itr_optionsPage()); ?>">
        <?php
        if(itrHasHAinstr()) {
            ?>
        Instructions have been added in the .htaccess file.
        <input class="button" type="submit" name="itr_removeHA" value="Remove instructions" />
        <?php }
        else {
            ?>
        <div style="color:red;font-weight:600">
            <p>
                Instructions have not been added in the .htaccess file.
                <input class="button" type="submit" name="itr_addHA" value="Add instructions" />
            </p>
        </div>
        <?php }
        ?>
    </form>
    <form name="itrform" id="itrform" method="POST" action="<?php _e(itr_optionsPage()); ?>">
        <?php wp_nonce_field('update-options'); ?>
        <h3>My blog is written in:
            <select id="blogLanguage" name="blogLanguage">
                <?php
                if($itrBL!='') {
                    $itrLangsFlipped=array_flip($itrLangs);
                    ?>
                <option value="<?php echo $itrBL; ?>" selected><?php echo $itrLangsFlipped[$itrBL]; ?></option>
                <?php }
                else {
                    ?>
                <option value="auto" selected>Auto detect</option>
                <?php } ?>
                <?php foreach($itrLangs as $key=>$val) { ?>
                <option value="<?php _e($val); ?>"><?php _e($key); ?></option>
                <?php } ?>
            </select>
        </h3>

        <h3>Translate my blog in: </h3>
        <?php
        $tmp=get_option('itrBlogTransArray');
        $tmp=explode("+",$tmp);
        $i=0;
        foreach($itrLangs as $key=>$val) { ?>
        <div style="padding:4px;float:left;width:140px">
            <input type="checkbox" value="<?php _e($val); ?>" name="itrTransArray[<?php echo $i; ?>]" <?php if($val==$itrBL) { ?>disabled<?php } elseif(in_array($val,$tmp) && $val!=$itrBL) { ?>checked<?php } ?>/>              <img border="0" src="<?php _e(itr_getFlag($val)); ?>" />
                <?php _e($key); ?>
        </div>
            <?php $i++;
            if($i%3==0) { ?><div style="clear:both"></div><?php } } ?>
        <div style="clear:both"></div>
        <h3>
            Cache duration
        </h3>
        Generate new translation after each <input type="text" name="itrCacheDuration" value="<?php echo get_option('itrCacheDuration'); ?>"/> seconds (default is 3600 seconds)
        <br /><br />
        <input class="button" type="submit" name="itr_save" value="<?php _e('Save options') ?> &raquo;" />
    </form>
    <form name="itrform" id="itrform" method="POST" action="<?php _e(itr_optionsPage()); ?>">
        <h3>
            Cache details
        </h3>
        <input type="hidden" name="itrDeleteCache" value="1"/>
        Cache size:
        <?php
        echo itrFormatSize(itrFolderSize(itrCacheDir));
        ?>&nbsp;&nbsp;&nbsp;<input class="button" type="submit" name="itr_delete_cache" value="Delete cache" />
    </form>
        <h3>
            Optional
        </h3>
    <form name="itrform" id="itrform" method="POST" action="">
        Show link to original post at the top of the page?
        Yes <input type="radio" name="showtrans" value="1" <?php if(get_option('itrShowOriginalPost')=='1') echo 'checked'; ?>> | No <input type="radio" name="showtrans" value="0" <?php if(get_option('itrShowOriginalPost')=='0') echo 'checked'; ?>>
        <input class="button" type="submit" name="itr_show_trans" value="Save" />
    </form>
</div>