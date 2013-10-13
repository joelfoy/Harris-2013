<?php
/*
	Template Name: Products
*/
?>
<?php get_header(); ?>
<!-- product page -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php
	if ( is_subpage()) { // This is a subpage ?>
	<?php// if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h1 class="pageTitle"><?php the_title(); ?></h1>
			<?php $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=1"); ?>
			<?php $machineName = get_the_title(); 
					$machineName = str_replace(" ", '', $machineName); ?>					  
					<?php if ($children) { ?>
					  <ul class="childPages">
					  	<?php echo $children; ?>
					  	
					  	<li class="page_item contactButton"><a href="<?php echo get_permalink(151); ?>?machineName=<?php echo $machineName ?>">Contact Now!</a></li>
					  </ul>
					  <?php } else { ?>
					  <ul class="childPages">
					  <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
					  	<li class="page_item contactButton"><a href="<?php echo get_permalink(151); ?>?machineName=<?php echo $machineName ?>">Contact Now!</a></li>
					  </ul> <?php } ?>
			<?php 
			//this collects and displays the "MAIN IMAGE" for the product or page
			$page_mainImage = get_post_meta($post->ID, 'page_mainImage', TRUE); 
			$page_shortDescription = get_post_meta($post->ID, 'metaDescription', TRUE);?>
			<?php if($page_mainImage) { ?>
				<?php $temp_mainImage = explode("|", $page_mainImage); ?> 
				<img class="mainImage" src="<?php echo bloginfo('url').'/wp-content/images/page_mainImages'.$temp_mainImage[0]; ?>" alt="<?php echo $temp_mainImage[1]; ?> - <?php echo $page_shortDescription ?>" /> <?php } ?>
				
			<?php
			//this will display a list of thumbnail images that, when clicked, will display a lightbox with a product image
			$product_thumb = get_post_meta($post->ID, 'product_thumb', FALSE); 
			//$product_thumb_link = get_post_meta($post->ID, 'product_thumb_link', FALSE);
				if ($product_thumb[0] == "") { ?>
				<!-- There is nothing to see here -->
			<?php } else { ?>
				<div class="product_thumbs">
					<ul>
						<?php foreach ($product_thumb as $product_thumb): 
						$temp_thumb = explode("|", $product_thumb); ?>
						<li class="prodThumb"><a class="lightbox" href="<?php echo $temp_thumb[1]; ?>" title="<?php echo $temp_thumb[2]; ?>" rel="thumbs"><img class="thumb" src="<?php echo bloginfo('url').'/wp-content/images/product_thumbnails'.$temp_thumb[0]; ?>" alt="<?php echo $temp_thumb[2]; ?>" /><span class="enlarge"></span></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				
			<?php } ?> 
			<div class="pageContent clearfix">
					<?php //get product specific sidebar
					if (is_page(array(23,236,238,240,242,244,260,52,58,54,56,60,50,74,76,29,116,285,287,289,291,293,96,609,1023,1139,1141,1137,1143,1498,1859))) { get_sidebar('product'); } ?>	
					<?php //if is a product main page, Two Rams, Horizontals, Ferrous Balers, BLS, BL, etc.
					if (is_page(array(25,27,31,33,91,93,1132))) { get_sidebar('brochureList'); } 
					if (is_page(array(1768, 1786))) { get_sidebar('contactFormKatana'); } ?>
				<div class="content">	  
					<?php the_content(); ?>
				</div>
				<?php
					//display MACHINE SPEC information
					$product_specs = get_post_meta($post->ID, 'specs', TRUE);
					if ($product_specs) {
						//echo "<hr class='hr' />";
						echo "<div class='machine-specs'>";
						echo "<h4 class='specificationHeader'>Machine Specifications*</h4>";
						echo $product_specs;
						echo "<p id='spec-legal'><small>*General specifications are subject to change without notice. Please consult a sales representative for exact specifications for your machine or quoted machine. Performance rates and production rates are subject to material input density, feed rates, and other variables of production outside the control of Harris Equipment.</small></p>";
						echo "</div>";
					}
					?>
					
				<?php if (!is_page(array(1768, 1786))) { ?>
				<div class="contactButton contactFooter"><a href="<?php echo get_permalink(151); ?>?machineName=<?php echo $machineName ?>">Contact Now!</a></div>
				<?php } ?>	
			</div>
		
		</div>
	
	<?php } else { // ALL PRODUCTS MAIN PAGE ?>
	    <div class="post" id="post-<?php the_ID(); ?>">
			<h1 class="pageTitle"><?php the_title(); ?></h1>
			<?php $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&include=23,25,27,29,31,33,91,93,96,1132");
			if ($children) { ?>
					  <ul class="prodList">
					  	<?php echo $children; ?>
					  </ul>
					  <?php } ?>
		
		</div>
		
	<?php } ?>

<?php endwhile; endif; ?>
<!-- content stuff -->


<?php get_footer(); ?>