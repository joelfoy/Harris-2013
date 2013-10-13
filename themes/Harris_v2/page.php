<?php get_header(); ?>
<!-- page -->
 		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<?php
			//this is for all the "pages" that are not the home page
			 

			if (!is_page('home')) { ?> 
			<div class="post" id="post-<?php the_ID(); ?>">
			<h1 class="pageTitle"><?php the_title(); ?></h1> 
				
				
				<?php
					  if($post->post_parent)
					  $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&exclude=151");
					  else
					  $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&exclude=151");
					  if ($children) { ?>
					  <ul class="childPages">
					  	<?php echo $children; ?>
					  </ul>
					  
				<?php } ?>
					  
			<?php 
			//This collects and displays main image on page. 
			$page_mainImage = get_post_meta($post->ID, 'page_mainImage', TRUE); 
			$page_shortDescription = get_post_meta($post->ID, 'page_shortDescription', TRUE); ?>
			<?php if($page_mainImage) { ?> 
				<?php $temp_mainImage = explode("|", $page_mainImage); ?> 
				<img class="mainImage" src="<?php echo bloginfo('url').'/wp-content/images/page_mainImages'.$temp_mainImage[0]; ?>" alt="<?php echo $temp_mainImage[1]; ?> - <?php echo $page_shortDescription; ?>" /> <?php } ?>
			
			<div class="pageContent clearfix">
				
				<?php //FOR SAFETY PAGE - Safety Sidebar
					if (is_page('safety')) { get_sidebar('safety'); } ?>
				
				<?php	// Content for all PAGES not PRODUCT pages 
					the_content(); ?>
				
				
				<?php //get contact sidebar
					if (is_page('contact')) { get_sidebar('contactForm'); } 
					elseif (is_page('latam-sales')) { get_sidebar('contactForm'); }
					elseif (is_page('asia-sales')) { get_sidebar('contactForm'); }
					elseif (is_page('north-american-sales')) { get_sidebar('contactForm'); }
					elseif (is_page('europe-africa-sales')) { get_sidebar('contactForm'); }
					elseif (is_page('australia-sales')) { get_sidebar('contactForm'); }
				?>
					
				<?php if (is_page('unsubscribe')) { get_sidebar('removeEmail'); } ?>
				
				<?php //SITEMAP PAGE
					if (is_page('sitemap')) {  ?>
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
								<h5>Ecotecnica Line</h5>
								<ul>
									<?php wp_list_pages('title_li=&child_of=1132'); ?>
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
					<?php } ?>
					
					<?php //SOCIAL PAGE
						if (is_page('social')) { get_sidebar('two'); } ?> 
					
					 	
					
			</div>
			
			<?php
			//Home page
			}  else { ?> 
			<div class="frontPageAd">
				<div class="mainAd-text">
					<ul>
						<li>Flat Slab Foundation requirement for less costly foundations</li>
						<li>True Clamshell Charge Box, both sides move for superior trapping and compression of material</li>
						<li>Higher Charge Box Compression Forces for faster compression of material, denser logs</li>
						<li>Aggressive Shear Knife Cutting Angle for more efficient shearing of scrap</li>
						<li>High Efficiency Hydraulics for higher flow rates and faster cycle times which results in production speed over competitive units</li>
						<li>Ability to Shear, Bale or Log materials</li>
						<li>Sold, Serviced and Warranted by Harris</li>
					</ul>
				</div>
				<div class="mainAd-cta"><a onClick="_gaq.push(['_trackEvent', 'CTA', 'AdClick', 'MainAd_HarrisBLS'])" href="<?php bloginfo('url'); ?>/products/balers-loggers-shears/harrisbls/">More Info</a></div>
			</div>
			<ul class="frontIntro clearfix">
				<li class="mission"><?php the_content(); ?></li>
				<li>
					<div class="newsletter_signup">
					<?php 
					$emailComplete = $_GET["signupComplete"];
						//nothing happened yet
						if (!$emailComplete) { ?>
						<h6>Harris e-Newsletter</h6>
						<p class="signupMessage">Keep up with the latest Harris News.</p>
						<form name="emailSignup" id="emailSignup" action="<?php echo bloginfo('template_url')?>/includes/signup_process.php" method="post">
						<label for="email" id="email_label">Email</label>
						<input name="email" id="email" class="formInput" size="18" type="text"/>
						<input class="button" id="emailSubmit" name="emailSubmit" type="submit" value="Sign up!"/>
						</form>
						<?php } ?>
						
						<?php 
						//email not valid
						if ($emailComplete == no) { ?>
						<h6>Harris e-Newsletter</h6>
						<p class='signupError signupMessage'>Please enter a valid email.</p>
						<form name="emailSignup" id="emailSignup" action="<?php echo bloginfo('template_url')?>/includes/signup_process.php" method="post">
						<label for="email" id="email_label">Email</label>
						<input name="email" id="email" class="formInput" size="18" type="text"/>
						<input class="button" id="emailSubmit" name="emailSubmit" type="submit" value="Sign up!"/>
						</form>
						<?php } ?>
						
						<?php 
						//email sent
						if ($emailComplete == yes) { ?>
						<div id="signupMessage">
						<h6 class='signup_complete'>Sign Up Complete!</h6>
						<p class='signupMessage'>You have been signed up for the Harris e-News email.</p>
						<p class='thankYou'>Thank You!</p>
						</div>
						<?php } ?>
						
					</div>
				</li>
			</ul>
			<?php 
			//get functions for ad rotation
			include_once('includes/home-ads.inc.php');			
			?>
			<div class="mainPage_previews">
				<ul>
					<li class="mainPage_preview">
					<a class="preview-link" href="<?php echo bloginfo('url').$ferrAdLink; ?>"><img class="small_preview" alt="<?php echo $ferrAltText; ?>" src="<?php echo bloginfo('url')?><?php echo $selectedFerrousAd; ?>" /></a></li>
					<li class="mainPage_preview">
					<a class="preview-link" href="<?php echo bloginfo('url').$nonFerrAdLink; ?>"><img class="small_preview" alt="<?php echo $nonFerrAltText; ?>" src="<?php echo bloginfo('url') ?><?php echo $selectedNonFerrousAd; ?>"  /></a></li> 
					<li class="latest mainPage_preview">
						<div class="latestNews"><h3>Recent News</h3>
						<?php
						$harrisPosts = new WP_Query();
						$harrisPosts->query('showposts=1');
						
						while ($harrisPosts->have_posts()) : $harrisPosts->the_post(); ?>
							<h4 id="front-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>  
						   	<p><?php the_content_limit(100, 'more'); ?></p>
						<?php endwhile;?>
						</div>
					</li>
				</ul>
			</div>
			
			<?php } ?> 
			
		
		<?php endwhile; endif; ?>
		
		

<?php get_footer(); ?>