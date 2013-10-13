<?php
/*
	Template Name: Unsubscribe Request
*/
?>

<?php //GET HEADER  
	get_header(); ?>

<h1 class="pageTitle">Unsubscribe</h1>

<div class="pageContent clearfix">

	<?php //This is the page main Content ?> 
	<div class="content">
		<div class="removal-form-area">
			<div class="newsletter_removal">
			<?php 
			$emailComplete = $_GET["signupComplete"];
				//nothing happened yet
				if (!$unsubscribeComplete) { ?>
				<h6>Harris Emails</h6>
				<p class="removeMessage">Decided to leave?</p>
				<form name="emailRemove" id="emailRemove" action="<?php echo bloginfo('template_url')?>/includes/unsubscribe-process.php" method="post">
				<label for="email" id="email_label">Email</label>
				<input name="email" id="email" class="formInput" size="18" type="text">
				<input class="button" id="emailSubmit" name="emailSubmit" type="submit" value="Sign up!">
				</form>
				<?php } ?>
				
				<?php 
				//email not valid
				if ($unsubscribeComplete == no) { ?>
				<h6>Harris Emails</h6>
				<p class='signupError signupMessage'>Please enter a valid email.</p>
				<form name="emailRemove" id="emailRemove" action="<?php echo bloginfo('template_url')?>/includes/unsubscribe-process.php" method="post">
				<label for="email" id="email_label">Email</label>
				<input name="email" id="email" class="formInput" size="18" type="text">
				<input class="button" id="emailSubmit" name="emailSubmit" type="submit" value="Sign up!">
				</form>
				<?php } ?>
				
				<?php 
				//email sent
				if ($unsubscribeComplete == yes) { ?>
				<div id="removeMessage">
				<h6 class='signup_complete'>You have been removed</h6>
				<p class='removalMessage'>We are sorry you no longer wish to receive the Harris Emails. You will receive an email confirming your address removal.</p>
				<p class='thankYou'>Thank You</p>
				</div>
				<?php } ?>
				
			</div>	
		</div>
		
		<div class="product-reminder"> 
			<h2>Harris Products</h2>
			<p class="leaving-text">Harris has the worlds most comprehensive line of recycling equipment. You may be leaving our e-newsletter, but don't forget about our quality products.</p>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&include=23,25,27,29,31,33,91,93,96,1132");
					if ($children) { ?>
							  <ul id="removal-prodList" class="removal-prodList">
							  	<?php echo $children; ?>
							  </ul>
							  <?php } ?>
			<?php endwhile; endif; ?>
			
		</div>
	
	</div>
	<?php //The end to the main page Content ?>
	
	
</div>

<?php get_footer(); ?>