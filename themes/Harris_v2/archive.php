<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header();
?>


	<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1 class="pageTitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h1 class="pageTitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1 class="pageTitle">Archive for <?php the_time('F jS, Y'); ?></h1>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1 class="pageTitle">Archive for <?php the_time('F, Y'); ?></h1>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1 class="pageTitle">Archive for <?php the_time('Y'); ?></h1>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1 class="pageTitle">Author Archive</h1>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1 class="pageTitle">Blog Archives</h1>
	<?php } ?>

<div class="pageContent clearfix">
		<?php	//Get SIDEBAR 
			get_sidebar(); ?>
		<div class="archive-post-container">
			
		<?php while (have_posts()) : the_post(); ?>
		
		
		
		<div class="blogpost">
			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<?php if(!is_tag()) { ?><p class="date"><?php the_time('l, F jS, Y') ?></p> <?php } ?>
			<?php the_excerpt() ?>
			<p class="moreLink"><a href="<?php the_permalink() ?>">Read More &raquo;</a></p>
			<p><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
		</div>

		<?php endwhile; ?>
		
		</div>
		

	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2>No posts found.</h2>");
		}
		get_search_form();

	endif;
?>

</div>
<?php get_footer(); ?>