
jQuery(document).ready(function() {

	/**
	 * Handles toggoling of menus
	 */
	jQuery('.toggle-buttton').bind('click', function() {
		var content = jQuery(this).parent().next();
		var button = jQuery(this);
		if(content.is(':visible')){
			content.animate({
				opacity: 0,
				height: 'toggle'
				}, 500, 'swing');
			button.html("+");	
		}else{
			content.animate({
				opacity: 1,
				height: 'toggle'
				}, 500, 'swing');
			button.html("-");							  
		}
	});
	
	
});

/**
 * Extended analytics plugin
 */
	
// Define global variables
var pageTracker;
			
jQuery.jAnalytics = function(account_id, options)
{
		
			// Default settings
			var defaults = {
				enableAnchorTrack: 	false,				// index.html#track/campaign/newsletter-july/mylink
				enableDownloadTrack: false,
				enableEmailTrack: false,
				enableOutboundTrack : false,
				trackFiles:			["zip", "pdf"] 		// could also be error, succes
			}
				
			// Merge user and default settings
			settings 		= jQuery.extend({}, defaults, options);
		
			// Call init
			init();
			
			/**
			 * bindTracking
			 * This function is called when the ga script is loaded
			 * 
			 * @return void
			 */
			function bindTracking(){
				
				// Get page tracker
				pageTracker = _gat._getTracker(account_id);

				// Start tracking pages
				pageTracker._trackPageview();
				
				// Create regex for file downloads to track
				var filetypes = new RegExp('\.(' + settings.trackFiles.join("|") + ')$', 'i');
				
				// Loop through links
				jQuery('a').each(function(){

					var href = jQuery(this).attr('href');

					// Track downloads
					if (href.match(filetypes) && settings.enableDownloadTrack){
						jQuery(this).click(function() {
		  					var extension = (/[.]/.exec(href)) ? /[^.]+$/.exec(href) : undefined;
		  					result = trackEvent('Download', 'click - ' + extension, getLinkLabel(jQuery(this)));
						});
					}
					
					// Track mailto's
					else if (href.match(/^mailto\:/i) && settings.enableEmailTrack){
						jQuery(this).click(function() {
							result = trackEvent('Mailto', 'click', getLinkLabel(jQuery(this)));
						});
					}

					// Track outgoing links
					else if ((href.match(/^https?\:/i)) && (!href.match(document.domain)) && settings.enableOutboundTrack){
						jQuery(this).click(function() {
							result = trackEvent('External', 'click', getLinkLabel(jQuery(this)));
						});
					}
					
				});
				
				if(settings.enableAnchorTrack){
					result = document.location.hash.match(/\#track\/(.*)/i);
					if(result){
						var parts = result[1].split("/");
						var category = parts[0];
						var action = parts[1];
						var label = parts[2] == undefined || parts[2] == "" ? stripDomain(document.location.href) : parts[2] + ' (' + stripDomain(document.location.href) + ')';
						result = trackEvent(category, action, label);
					}
				}
				
			}
			
			/**
			 * Track event
			 * 
			 * @todo Change this code (copy :s)
			 * @param string category
			 * @param string action
			 * @param string label
			 * @param int value
			 * @return bool
			 */
			function trackEvent(category, action, label, value){
				 if(typeof pageTracker == 'undefined') {
					 return false;
				 } else {
					 return pageTracker._trackEvent(category, action, label, value);
				 }

			}
			
			/**
			 * Track page view
			 * 
			 * @todo Change this code (copy :s)
			 * @param string uri
			 * @return bool
			 */
			function trackPageview(url){
				if(typeof pageTracker == 'undefined') {
					 return false;
				 } else {
					 return pageTracker._trackPageview(uri);
				 }
			}
			
			/**
			 * Create label for a link
			 * 
			 * @param HTMLElement link
			 * @return string
			 */
			function getLinkLabel(link){
				var href = jQuery(link).attr('href').replace(/^mailto\:/i, '');
				href = stripDomain(href);
				return jQuery(link).attr('title') == '' ? href : href + ' (' + jQuery(link).attr('title') + ')';
			}
			
			/**
			 * Get domainname from a url
			 * 
			 * @param string uri
			 * @return string
			 */
			function getDomain(uri, strip_www){
				domain = uri.match(/:\/\/(.[^/]+)/)[1];
				if(strip_www) domain = domain.replace("www.", "");                                     
				return domain;                                    
			}
			
			/**
			 * Strips the current domain from an internal link
			 * 
			 * @param string uri
			 * @return string
			 */
			function stripDomain(uri){
				if(uri.indexOf( "http://www." + document.domain ) > -1 || uri.indexOf( "http://" + document.domain ) > -1 ){
					uri = uri.replace("http://www." + document.domain, "").replace("http://" + document.domain, "");
				}else{
					uri = uri.replace(/^https?\:\/\/(www.)?/i, '');
				}
				uri = uri.replace(/#track(.*)/i, '');
				return uri;
			}
			
			/**
			 * Load GA tracker script from google
			 * 
			 * @return void
			 */
			function init(){

				// Get protocal (http or https)
				var url = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				
				// Compose analytics ga script url
				url += 'google-analytics.com/ga.js';
				
				try{
					jQuery.getScript(url, function(){
						bindTracking();
					});
				}catch(error){
					
				}
				
			}

}