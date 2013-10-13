<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="alert">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>

	<?php previous_comments_link("Older") ?>  <?php next_comments_link() ?>

	<ol class="commentlist">
	<?php wp_list_comments(); ?>
	</ol>

	<?php previous_comments_link() ?>  <?php next_comments_link() ?>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div class="response">

	<div id="respond">
	
		<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>
	
		<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
	
		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>
	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	
			<?php if ( is_user_logged_in() ) : ?>
	
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
	
			<?php else : ?>
	
			
			<label for="author">Name<?php if ($req) echo "<span class='required'>*</span>"; ?></label>
			<input class="commentInput" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			
			<label for="email">Email<?php if ($req) echo "<span class='required'>*</span>"; ?> <small>(will not be published)</small></label>
			<input class="commentInput" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			
			<label for="url">Website</label>
			<input class="commentInput" type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
	
			<?php endif; ?>
	
			<!--<p><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></p>-->
	
			<textarea name="comment" class="commentInput" id="comment" cols="100%" rows="10" tabindex="4"></textarea>
	
			<input class="commentButton" name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
			<label id="commenterror" class="error" for="submit">Please enter a comment</label>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
	
		</form>
	
		<?php endif; // If registration required and not logged in ?>
	
	</div>
	
	<div id="response-emailSignup">
		<h3>Like what you are reading?</h3>
		<p>Take a second and sign up for Harris Blog in your Inbox. Be the first to know Harris information from the source.</p>
		<div class="feedBurner">
			<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=harrisequip/OxIO', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<h4>Get the Blog in your inbox</h4>
				<label for="email" class="">Enter your email address:</label>
				<input id="comment-subscribe-button" class="" type="submit" value="Subscribe" />
				<input class="formInput" type="text" name="email" id="email"/>
				<input type="hidden" value="harrisequip/OxIO" name="uri"/>
				<input type="hidden" name="loc" value="en_US"/>
				<label for="email" class="error feedBurnerError" id="subscribeError">Email Required</label>
				<p><small>Delivered by <a href="http://feedburner.google.com" target="_blank">FeedBurner</a></small></p>
			</form>
		</div>
	</div>
	
</div>
<?php endif; // if you delete this the sky will fall on your head ?>