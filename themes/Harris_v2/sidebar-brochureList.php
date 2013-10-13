<div class="productSidebar">
	
	<h4><?php the_title(); ?> Machine List</h4>
	<ul class="machineList sidebar-list">
	<?php
		wp_list_pages('title_li=&child_of='.$post->ID.'');
	?>
	</ul>
	
	
	<?php
			$brochures = get_post_meta($post->ID, 'brochure', FALSE);
			$brochure_links = get_post_meta($post->ID, 'brochure_link', FALSE);
			if($brochures[0] == "") { ?>
			<!-- There is nothing to see here -->
			<?php } else { ?>
			                 
			<?php } ?>
			<?php $brochures = get_post_meta($post->ID, 'brochure', FALSE); 
			if($brochures[0] == "") { ?>
			<!-- Nothing to see here -->
			<?php } else { ?>
			<h4>Brochures for <?php the_title(); ?></h4>
			<ul class="brochureList">
			<?php foreach($brochures as $brochure):
			$temp = explode("|", $brochure); ?>
				<li class="brochure"><a href="<?php echo bloginfo('url') .'/wp-content/assets/brochures/'?><?php echo $temp[1] ?>"><?php echo $temp[0] ?></a></li>
			<?php endforeach; ?>
			</ul>
	<?php } ?>
</div>

