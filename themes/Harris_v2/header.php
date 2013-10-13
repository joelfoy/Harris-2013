<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> xmlns:fb="http://ogp.me/ns/fb#">

	<head profile="http://gmpg.org/xfn/11">
		
		<title>
			<?php if (is_page('home')) { echo bloginfo('description');
			} elseif (is_404()) {
			echo '404 Not Found';
			} elseif (is_category()) {
			echo 'Category:'; wp_title('');
			} elseif (is_search()) {
			echo 'Search Results';
			} elseif ( is_day() || is_month() || is_year() ) {
			echo 'Archives:'; wp_title('');
			} else {
				//get SEO title from page post meta
				$seo_title = get_post_meta($post->ID, 'seo-title', TRUE); 
				if($seo_title) { 
				echo $seo_title; 
				} else
				echo wp_title('');
			}
			?> | Harris
		</title>

	    <meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
		
		<?php // ROBOTS Info
			if(is_search()) { ?>
			<meta name="robots" content="noindex, nofollow" /> 
	    <?php } ?>

		<!-- Google+ -->
		<link href="https://plus.google.com/112182459114194584606" rel="publisher" />
				
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style/css/print.css" media="print" />
		<!--[if gt IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style/css/ie.css" />
		<![endif]-->
		<!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style/css/ie7.css" />
		<![endif]-->
		
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<link href="<?php bloginfo('template_url'); ?>/favicon.ico" rel="shortcut icon"/>
	
		<?php wp_head(); ?>
		
		<!-- Facebook -->
		<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

	</head>
	<?php 	
		//get the file name and echo page ID as the file name
		$currentFile = $_SERVER["REQUEST_URI"];
    	$parts = Explode('/', $currentFile);
    	$currentFile = $parts[count($parts) - 1];
	?>
<body id="<?php echo $currentFile ?>" >
		<!-- begin header -->
		<div class="header">
			<div class="headerContainer">
				<a href="<?php bloginfo('url')?>"><img id="harrisLogo" alt="Harris" src="<?php bloginfo('template_url'); ?>/assets/harrisLogo.png" /></a>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
				<div class="translator">
					<p>Choose your language: </p>
					<ul class="language">
						<li><a href="http://www.harrisequip.com/"><img alt="english" class="language-link-image" id="language-english" src="<?php echo get_bloginfo('url') . '/wp-content/images/flags/us.gif'?>"/> English</a></li>
						<li><a href="http://es.harrisequip.com/"><img alt="spanish" class="language-link-image" id="language-spanish" src="<?php echo get_bloginfo('url') . '/wp-content/images/flags/es.gif'?>"/> Español</a></li>
					</ul>
				</div>
				<div id="mainNavigation" class="navigation">
					<ul class="nav">
						<?php wp_list_pages('title_li=&include=45,3,5,63,8,10,1847');  //display only top-level pages with depth=# ?>
					</ul>
					
				</div>
			</div>
		</div>
		
		<!-- end header -->
		<div class="container"><!-- Begin Container -->