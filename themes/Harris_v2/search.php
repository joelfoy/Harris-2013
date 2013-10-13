<?php
/**
 * Harris Search Results
 * 
 */

get_header(); ?>

	<?php if (have_posts()) : ?>
		<h1 class="pageTitle">Search Results for "<?php the_search_query(); ?>"</h1> 
		<div class="pageContent">
		<?php while (have_posts()) : the_post(); ?>
		
			<div <?php post_class('search-result') ?>>
				<span class="view-machine"><a href="<?php the_permalink(); ?>" >View Machine!</a></span>
				<h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
				<?php //this collects the "short description" from the page 
				$page_shortDescription = get_post_meta($post->ID, 'page_shortDescription', TRUE); ?>
				<?php if($page_shortDescription) { ?>
					<p class="search-descript"><?php echo $page_shortDescription ?></p>
					<?php // get product thumbs
					$product_thumb = get_post_meta($post->ID, 'product_thumb', FALSE);
					if ($product_thumb[0] == "") { ?>
					<!-- There are no product shots at this time -->
					<?php } else { ?>
						<div class="product_thumbs">
							<ul>
								<?php $count = 0; ?>
								<?php foreach ($product_thumb as $product_thumb): 
								if( $count == 6 )break;
								$temp_thumb = explode("|", $product_thumb); ?>
									<li class="prodThumb"><a class="lightbox" href="<?php echo $temp_thumb[1]; ?>" title="<?php echo $temp_thumb[2]; ?>" rel="thumbs"><img class="thumb" src="<?php echo bloginfo('url').'/wp-content/images/product_thumbnails'.$temp_thumb[0]; ?>" alt="<?php echo $temp_thumb[2]; ?>" /><span class="enlarge"></span></a></li>
								<?php $count++; ?>
								<?php endforeach; ?>
							</ul>
						</div>
						
					<?php } ?> 
				<?php } ?>
			</div>
		
		<?php endwhile; ?>
		</div>
		

	<?php else : ?>
	<h1 class="pageTitle">Search Results</h1>
	<div class="pageContent">
		<h2>We could not find what you are searching for...</h2>
		<p class="intro">If you can't find what you were looking for please see if the information below helps.</p>
		<div class="sitemapLinks">
						<h3>Main Pages</h3>
						<ul class="pageList">
							<?php wp_list_pages('title_li=&depth=1&exclude=190'); ?>
						</ul>
						<div class="equipmentList">
							<h3>Equipment</h3>
							<div class="columnHalf_left">
								<h4>NonFerrous Equipment</h4>
								<h5>Vertical Balers</h5>
								<ul>
									<?php wp_list_pages('title_li=&include=23'); ?>
								</ul>
								<h5>TransPak System</h5>
								<ul>
									<?php wp_list_pages('title_li=&include=29'); ?>
								</ul>
								<h5>Horizontal Balers</h5>
								<ul>
									<?php wp_list_pages('title_li=&child_of=25'); ?>
								</ul>
								<h5>Two Ram Balers</h5>
								<ul>
									<?php wp_list_pages('title_li=&child_of=27'); ?>
								</ul>
							</div>
							<div class="columnHalf_right">
								<h4>Ferrous Equipment</h4>
								<h5>Three Compression Balers</h5>
								<ul>
									<?php wp_list_pages('title_li=&child_of=31'); ?>
								</ul>
								<h5>Baler/Logger</h5>
								<ul>
									<?php wp_list_pages('title_li=&child_of=91'); ?>
								</ul>
								<h5>Shears</h5>
								<ul>
									<?php wp_list_pages('title_li=&child_of=33'); ?>
								</ul>
								<h5>Baler/Logger/Shears</h5>
								<ul>
									<?php wp_list_pages('title_li=&child_of=93'); ?>
								</ul>
								<h5>Shredders</h5>
								<ul>
									<?php wp_list_pages('title_li=&include=96'); ?>
								</ul>
							</div>
						</div>
						<div class="salesPages">
							<h3>Sales Pages</h3>
							<ul>
								<?php wp_list_pages('title_li=&child_of=63&exclude=151'); ?>
							</ul>
						</div>
						<div class="companyPages">
							<h3>Company Pages</h3>
							<ul>
								<?php wp_list_pages('title_li=&child_of=3'); ?>
							</ul>
						</div>
						<div class="supportPages">
							<h3>Support Pages</h3>
							<ul>
								<?php wp_list_pages('title_li=&child_of=8'); ?>
							</ul>
						</div>
					</div>
		
	</div>
	
	<?php endif; ?>

<?php get_footer(); ?>