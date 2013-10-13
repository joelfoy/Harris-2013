<div class="productSidebar">
	
	<?php //Product Video
		//get product video, if it exists, and display it
		$product_video = get_post_meta($post->ID, 'product_video', TRUE);
		if(!$product_video) { ?>
		<!-- No video at this time -->
		<?php } else { ?>
		<h4><?php the_title(); ?> Video</h4>
		<?php 
		$video = explode("|", $product_video); 
		$page_shortDescription = get_post_meta($post->ID, 'page_shortDescription', TRUE);
		?>
		<a href="<?php echo $video[1] ?>" class="video" rel="#overlay"><img class="vid_Thumb" alt="Harris Video - <?php echo $page_shortDescription; ?>" src="<?php echo bloginfo('url').'/wp-content/images/video_Thumbs'.$video[0]; ?>" /></a>
	<?php } ?>

	<?php //Machine Brochures
	$brochures = get_post_meta($post->ID, 'brochure', FALSE); 
	if($brochures[0] == "") { ?>
	<!-- No Brochures on File -->
	<?php } else { ?>
	<h4>Brochures for <?php the_title(); ?></h4>
	<ul class="brochureList sidebar-list">
	<?php foreach($brochures as $brochure):
	$temp_brochure = explode("|", $brochure); ?>
		<li class="brochure"><a href="<?php echo bloginfo('url').'/wp-content/assets/brochures/'.$temp_brochure[1] ?>"><?php echo $temp_brochure[0] ?></a></li>
	<?php endforeach; ?>
	</ul>
	<?php } ?>
	
	<?php //Materials Processed
	$materials = get_post_meta($post->ID, 'material', TRUE);
	if(!$materials) { ?>
	<!-- Nothing Processed -->
	<?php } else { ?>
	<h4>Materials Designed to Process</h4>
	<ul class="materialList sidebar-list">
	<?php
	$temp_material = explode("|", $materials);
	foreach($temp_material as $material): ?>
		<li class="material"><?php echo $material ?></li>
	<?php endforeach; ?>	
	</ul>
	<?php } ?>
	
	<?php //Facilities
	$facilities = get_post_meta($post->ID, 'facilities', TRUE);
	if(!$facilities) { ?>
	<!-- No Facilities Provided -->
	<?php } else { ?>
	<h4>Designed for these Facilities</h4>
	<ul class="facilitiesList sidebar-list">
	<?php
	$temp_facility = explode("|", $facilities);
	foreach($temp_facility as $facility): ?>
		<li class="facility"><?php echo $facility ?></li>
	<?php endforeach; ?>	
	</ul>
	<?php } ?>
	
</div>