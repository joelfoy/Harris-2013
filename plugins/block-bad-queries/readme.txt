=== Plugin Name ===

Contributors: Jeff Starr
Plugin Name: Block Bad Queries (BBQ)
Plugin URI: http://perishablepress.com/press/2009/12/22/protect-wordpress-against-malicious-url-requests/
Tags: security, protect, firewall, php, eval, malicious, url, request, block
Author URI: http://perishablepress.com/
Author: Perishable Press
Donate link: http://digwp.com/book/
Requires at least: 2.3
Tested up to: 2.9
Stable tag: 1.0
Version: 1.0

== Description ==

Description: Protect WordPress Against Malicious URL Requests 

Many WordPress sites gets attacked with extremely malicious code, fortunately Jeff Starr wrote a simple script that checks for excessively long request strings (i.e., greater than 255 characters), as well as the presence of either eval( or base64 in the request URI.

== Installation ==

To protect your site using this lightweight script, simply unzip the zip file, it only has one folder with three files inside it.  Now, upload that folder and it's contents to your WP plugin directory. 

Then to activate it, log into your WordPress Admin area and go to the installed plugins page, look for "Block Bad Queries" and click on Activate. That's it! 

Once active, this plugin will silently and effectively close any connections for these sorts of injection-type attacks.

== Upgrade Notice ==

To upgrade BBQ, remove old version and replace with new version. Nothing else needs done.

== Screenshots ==

No screenshots available - code only.

== Changelog ==

2009/12/30 - Additional request strings added
2009/12/30 - Added check for admin users

== Frequently Asked Questions ==

Q: Do I need to do anything else for BBQ to work?
A: Nope, just install and relax knowing that BBQ is protecting your site from bad URL requests.

== Donations ==

To support this and other plugins, consider buying a copy of my book, [Digging into WordPress](http://digwp.com/).