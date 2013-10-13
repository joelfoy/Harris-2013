<?php get_header(); ?>
	<h1 class="pageTitle">Blog</h1>
				<?php
					  $children = wp_list_pages("title_li=&child_of=3&echo=0&exclude=151");
					  if ($children) { ?>
					  <ul class="childPages">
					  	<?php echo $children; ?>
					  </ul>
					  
				<?php } ?>
	
	<div class="pageContent clearfix">
	<?php get_sidebar(); ?>
	
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
			
			
				<div class="blogpost" id="post-<?php the_ID(); ?>">
					<h2 class="entryTitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<p class="date"><?php the_time('F jS, Y') ?></p>
	
				
					<?php the_excerpt(); ?>
					
					<p class="moreLink"><a href="<?php the_permalink() ?>">Read More &raquo;</a></p>
				
					<p><small><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></small></p>
				</div>
			
			
		<?php endwhile; ?>
		
			<ul>
				<li><?php next_posts_link('&laquo; Older Entries') ?></li>
				<li><?php previous_posts_link('Newer Entries &raquo;') ?></li>
			</ul>
			
			
			
			
	<?php else : ?>
	
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
		<p>Please use the search bar in the upper right corner.</p>
	
	<?php endif; ?>
	
	</div>
<?php get_footer(); ?>