<!-- This is for Video display .v1 -->
<?php //collect and display product video if there is one.
		$product_video = get_post_meta($post->ID, 'product_video', TRUE); 
		$video_thumb = get_post_meta($post->ID, 'video_thumb', TRUE); 
		if($product_video && $video_thumb) { ?>
		<h4><?php the_title(); ?> Video</h4>
		<a href="<?php echo $product_video; ?>" class="video" rel="#overlay"><img class="vid_Thumb" alt="Harris Video" src="<?php echo bloginfo('url').$video_thumb; ?>" /></a>
	<?php } ?>
	
<!-- Feedburner Subscription Code -->
	<form style="border:1px solid #ccc;padding:3px;text-align:center;" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=harrisequip/OxIO', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><p>Enter your email address:</p><p><input type="text" style="width:140px" name="email"/></p><input type="hidden" value="harrisequip/OxIO" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Subscribe" /><p>Delivered by <a href="http://feedburner.google.com" target="_blank">FeedBurner</a></p></form>
<!-- end Feedburner Subscription Code -->