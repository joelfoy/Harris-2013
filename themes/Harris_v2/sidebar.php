<div class="blogSidebar">
	<div class="feedBurner">
		<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=harrisequip/OxIO', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
			<h4>Get the Blog in your inbox</h4>
			<label for="email" class="">Enter your email address:</label>
			<input class="button" type="submit" value="Subscribe" />
			<input class="formInput" type="text" name="email" id="email"/>
			<input type="hidden" value="harrisequip/OxIO" name="uri"/>
			<input type="hidden" name="loc" value="en_US"/>
			
			<label for="email" class="error feedBurnerError" id="subscribeError">Email Required</label>
			<p><small>Delivered by <a href="http://feedburner.google.com" target="_blank">FeedBurner</a></small></p>
		</form>
	</div>
	<ul id="social-share">
		<li id="share-twitter"><a href="http://twitter.com/home?status=Now Reading <?php the_permalink(); ?>">Send to Twitter</a></li>
		<li id="share-facebook"><a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>">Share on Facebook</a></li>
		<li id="share-feed"><a href="feed://www.harrisequip.com/feed">Subscribe to our RSS feed</a></li>
		<li id="like-button"><fb:like send="true" layout="button_count" width="300" show_faces="false" font="verdana"></fb:like></li>
	</ul>
	<div class="blogItems">
	
<?php
//Dynamic Blog Sidebar
 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar1') ) : ?><?php endif; ?>
	</div>		
	

</div>
		