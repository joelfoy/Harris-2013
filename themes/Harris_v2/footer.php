
	<div <?php if (is_page('home')) { ?> class="footerHome" <?php } elseif (is_page('products')) { ?> class="footerHome"
	<?php } else { ?> class="footer" <?php } ?> >
		<ul class="footColumns">
			<!-- Left Footer Column -->
			<li class="leftCol_footer">
				<ul class="footNav"><?php wp_list_pages('title_li=&depth=1&exclude=45,1358');  // display only top-level pages with depth=# ?></ul>
				<p class="copyright">Harris &copy;
	    	<?php
	    	ini_set('date.timezone', 'America/New_York');
	    	$startYear = 2007;
	    	$thisYear = date('Y');
	    	if ($startYear == $thisYear) {
	    		echo $startYear;
	    		}
	    	else {
	    		echo "$startYear-$thisYear";
	    		} 
	    	?> Reproduction in whole or in part without express written permission of Harris is prohibited.</p>
			</li>
			<!-- Right Footer Column -->
			<li class="rightCol_footer">
				<div class="socialMedia">
					<ul>
						<li class="rssIcon"><a href="<?php bloginfo('rss2_url'); ?>" title="RSS">Harris RSS Feed</a></li>
						<li class="twitterIcon"><a href="http://twitter.com/HarrisEquip" title="Twitter">Harris thoughts on Twitter</a></li>
						<li class="facebookIcon"><a href="http://www.facebook.com/HarrisEquip" title="Facebook">Harris on Facebook</a></li>
						<li class="googleIcon"><a href="https://plus.google.com/112182459114194584606?prsrc=3" title="Google+">Harris on Google+</a></li>
						<li class="flickrIcon"><a href="http://www.flickr.com/photos/harrisequipment" title="Flickr">Harris photos on Flickr</a></li>
						<li class="youtubeIcon"><a href="http://www.youtube.com/HarrisEquipment" title="YouTube">Harris videos on YouTube</a></li>
					</ul>
				</div>
			</li>
		</ul>
	
	
	</div>

<?php wp_footer(); ?>

</div><!-- end Container -->

	<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/fancybox.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/harris.js"></script>
	<?php if (is_page_template('products.php')) { ?><script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/product-page-effects.js"></script><?php } ?>
	
	
	<?php
//if ( function_exists( 'yoast_analytics' ) ) { 
//yoast_analytics(); }
?>
<!-- Start of HubSpot Logging Code  -->
<script type="text/javascript" language="javascript">
var hs_portalid=55884; 
var hs_salog_version = "2.00";
var hs_ppa = "harrisequip.app5.hubspot.com"
document.write(unescape("%3Cscript src='" + document.location.protocol + "//" + hs_ppa + "/salog.js.aspx' type='text/javascript'%3E%3C/script%3E"));
</script>
<!-- End of HubSpot Logging Code --> 

<script>
//Tealium GA Promo Tracking, Copyright 2009, All Rights Reserved.
var promoTracking={
	o:pageTracker, //google tracking object
	p:'promo_id', //querystring manual tag param
	m:5, //max impression tracking number
	c:'promotion', //event category
	i:'impressions', //event impression action
	e:'clicks', //event click action
	INIT:function(a,b,c){for(a=0;a<document.links.length;a++){b=this.R(document.links[a].href,this.p);if(b.length&&this.m>0){this.T(this.c,this.i,b);
		this.E(document.links[a],'mousedown',this.V);this.m--}}},
	R:function(a,b,c,d,e){c=a.indexOf('?'+b+'='),e='';c=(c<0)?a.indexOf('&'+b+'='):c;if(c>0){d=a.indexOf('&',c+1);d=(d<0)?a.length:d;e=a.substring(c+b.length+2,d)}return e},
	E:function(a,b,c){if(a.addEventListener){a.addEventListener(b,c,false)}else if(a.attachEvent){a.attachEvent("on"+b,c)}},
	V:function(a){o=promoTracking;if((a.which&&a.which==1)||(a.button&&a.button==1)){var b=document.all?window.event.srcElement:this;for(var c=0;c<3;c++){if(d=b.tagName){
		if(d.toLowerCase()!='a'&&d.toLowerCase()!='area')b=b.parentElement}}c=o.R(b.href,o.p);if(c.length)o.T(o.c,o.e,c)}},
	T:function(a,b,c){this.o._trackEvent(a,b,c)}
};
setTimeout("promoTracking.INIT()",0);
</script>

</body>
	
</html>