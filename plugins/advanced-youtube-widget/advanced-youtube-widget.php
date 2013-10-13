<?php 
/*

Plugin Name: Advanced Youtube Widget
Plugin URI: http://www.appchain.com/advanced-youtube-widget/
Description: Get youtbe video updates based on a account or search terms
Author: Turcu Ciprian
License: GPL
Version: 1.0.5
Author URI: http://www.appchain.com

*/
function advanced_youtube_widget_WidgetShow($args) {

    extract( $args );
    //get the array of values
    $xArrOptions =  unserialize(get_option('advanced_youtube_widget_options'));
    $xTitle = $xArrOptions[0];
    $xValue = $xArrOptions[1];
    $xType = $xArrOptions[2];
    $xCount = $xArrOptions[3];
    $xWidth = $xArrOptions[4];
    $xHeight = $xArrOptions[5];
    $sType = $xArrOptions[6];
    ?>
<script type="text/javascript" src="http://swfobject.googlecode.com/svn/trunk/swfobject/swfobject.js"></script>
<script type="text/javascript">
    function showMyVideos2(data) {
        var feed = data.feed;
        var entries = feed.entry || [];
        var html = ['<ul class="videos">'];
        for (var i = 0; i < entries.length; i++) {
            var entry = entries[i];
            var title = entry.title.$t.substr(0, 20);
            var thumbnailUrl = entries[i].media$group.media$thumbnail[0].url;
            var playerUrl = entries[i].media$group.media$content[0].url;
            var xStart = playerUrl.indexOf("/v/") + 3;
            var xEnd = playerUrl.indexOf("&");
            playerUrl = 'http://www.youtube.com/watch?v=' + playerUrl.substr(xStart,xEnd);

            xEnd = playerUrl.indexOf("?f");
            playerUrl =  playerUrl.substr(0,xEnd);


            html.push('<li onclick="document.location=\''+playerUrl+'\';">',
            '<span class="titlec"><a href="'+playerUrl+'">', title, '...</a></span><br /><img src="',
            thumbnailUrl, '" width="<?php echo $xWidth;?>" height="<?php echo $xHeight;?>"/>', '</span></li>');
        }
        html.push('</ul><br style="clear: left;"/>');
        document.getElementById('videos2').innerHTML = html.join('');
    }
</script>

    <?php
    if($xType==0) {
        ?><?php  echo $before_widget;?>
        <?php echo $before_title.$xTitle.$after_title;?>

<div id="playerContainer">
    <object id="player"></object>
</div>
<div id="videos2"></div>
<script type="text/javascript" src="http://gdata.youtube.com/feeds/api/videos?q=&author=<?php echo $xValue;?>&orderby=<?php echo $sType ?>&alt=json-in-script&callback=showMyVideos2&max-results=<?php echo $xCount;?>&format=5"></script> 
        <?php echo $after_widget;?>
    <?php
    }else {
        ?>
        <?php  echo $before_widget;?>
        <?php echo $before_title.$xTitle.$after_title;?>

<div id="playerContainer">
    <object id="player"></object>
</div>
<div id="videos2"></div>
<script type="text/javascript" src="http://gdata.youtube.com/feeds/api/videos?q=<?php echo $xValue;?>&orderby=<?php echo $sType ?>&alt=json-in-script&callback=showMyVideos2&max-results=<?php echo $xCount;?>&format=5"></script> 
        <?php echo $after_widget;?>
    <?php
    }
}
function advanced_youtube_widget_WidgetInit() {
// Tell Dynamic Sidebar about our new widget and its control
    register_sidebar_widget(array('Advanced YouTube Widget', 'widgets'), 'advanced_youtube_widget_WidgetShow');
    register_widget_control(array('Advanced YouTube Widget', 'widgets'), 'advanced_youtube_widget_WidgetForm');

}
function advanced_youtube_widget_WidgetForm() {

    $sort_opts = array(
        "relevance",
        "published",
        "viewCount",
        "rating"
    );

    if($_POST['advanced_youtube_widget_value']!="") {
        $xArrOptions[0]=  $_POST['advanced_youtube_widget_title'];
        $xArrOptions[1]=  $_POST['advanced_youtube_widget_value'];
        $xArrOptions[2]=  $_POST['advanced_youtube_widget_type'];
        $xArrOptions[3]=  $_POST['advanced_youtube_widget_count'];
        $xArrOptions[4]=  $_POST['advanced_youtube_widget_width'];
        $xArrOptions[5]=  $_POST['advanced_youtube_widget_height'];
        $xArrOptions[6]=  $_POST['advanced_youtube_widget_sort'];
        update_option('advanced_youtube_widget_options', serialize($xArrOptions));
    }

    $xArrOptions = unserialize(get_option('advanced_youtube_widget_options'));

    //if there are no values

    $xTitle = $xArrOptions[0];
    $xValue = $xArrOptions[1];
    $xType =  $xArrOptions[2];
    $xCount = $xArrOptions[3];
    $xWidth = $xArrOptions[4];
    $xHeight = $xArrOptions[5];
    $sType =  $xArrOptions[6];

    if($xTitle=="") {
        $xTitle = "Follow Us on youtube:";
    }
    if($xWidth=="") {
        $xWidth = "130";
    }
    if($xHeight=="") {
        $xHeight = "97";
    }
    if($sType=="") {
        $sType = "relevance";
    }

    ?>
Title:<br/><input type="text" name="advanced_youtube_widget_title" value="<?php echo $xTitle;?>" /><br/><br/>
<h3>Video Sizes:</h3>
Width:<input type="text" style="width:50px;" name="advanced_youtube_widget_width" value="<?php echo $xWidth;?>" />
Height:<input type="text" style="width:50px;" name="advanced_youtube_widget_height" value="<?php echo $xHeight;?>" /><br/><br/>

Account/Search:<br/><input type="text" name="advanced_youtube_widget_value" value="<?php echo $xValue;?>" /><br/><br/>
Type:<br/><select name="advanced_youtube_widget_type" >
    <option value="0" <?php if($xType==0) {echo "selected";}?> >Account</option>
    <option value="1" <?php if($xType==1) {echo "selected";}?> >Search</option>
</select><br/><br/>

Sort Order:<br/><select name="advanced_youtube_widget_sort">
        <?php

        reset($sort_opts);
        foreach($sort_opts as $opt) {

            ?>
    <option value="<?php echo $opt ?>" <?php if($sType==$opt) {echo "selected";}?> ><?php echo ucfirst($opt) ?></option>
        <?php

        }

        ?>
</select><br/><br/>

Number of updates:<br/><select name="advanced_youtube_widget_count" >
        <?php $j=1;
        while($j<=35) {
            ?>
    <option value="<?php echo $j;?>" <?php if($xCount==$j) {echo "selected";}?> ><?php echo $j;?></option>
            <?php
            $j++;
        }
        ?>
</select><br/>

<?php 
}
// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('plugins_loaded', 'advanced_youtube_widget_WidgetInit');
?>