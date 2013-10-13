<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header();
?>

	<h1 class="pageTitle">404 - Error!</h1>
	<div class="pageContent clearfix">
		<img id="woops" class="floatLeft" alt="Harris" src="<?php bloginfo('template_url'); ?>/assets/404-woops.png" />
		<p class="errorMessage">Looks like we have a problem. The page you are looking for is not here. If you are searching for something please use our search bar in the top right corner of the page. If you just want to browse please use the navigation at the top. If you are looking to reach Harris please visit our <a href="<?php bloginfo('url'); ?>/contact">contact page</a>.</p>
	</div>

<?php get_footer(); ?>