=== WP Easy Post Types ===
Contributors:  chertz
Plugin website: http://www.wpeasyposttypes.com
Tags: custom post types, cms, custom fields, custom categories
Requires at least: 3.0.0
Tested up to: 3.2.1
Stable tag: 1.2.1
Last updated time: 2011-8-3

Create custom WordPress post types on the fly with an easy to use interface. Then manage custom fields and categories for your post types.

== Description ==

This plugin lets you take advantage of the Wordpress 3.0 custom post type feature, and create your own post type. The plugin allows you to add a set of fields attached to your new post type, so that in the edit and add new windows a new box will show with the fields defined. Each field added will be saved in the Wordpress Database as a custom field, so that you can take advantage of the standard Wordpress query rules to list your content on the page template.

[Plugin URI]: (http://www.wpeasyposttypes.com)

== Installation ==

1. After downloading the plugin, unzip the plugin 
1. Upload `easyposttypes` to the `/wp-content/plugins/` directory  or go through the Wordpress plugin Upload dialog
1. Activate the plugin

== Frequently Asked Questions ==

= Where can I learn more about Easy Post Types? =

To learn more, please visit http://www.wpeasyposttypes.com

= I get a 404 page when trying to view a post of my custom post type =

This can be caused by having a page with the same slug as your custom post type key. The Page does not need to be published (it can event be in the trash) for this issue to exists.

You will either need to permanently delete the Page or create the a new post type with a different key.

This is an issue with WordPress rewrite. We are looking into how to workaround the issue.


== Screenshots ==

1. screenshot-1.jpg is the add post type dialog.

2. screenshot-2.jpg is the add field dialog.

3. screenshot-3.jpg are the import/export features.

== Changelog ==

= 1.0B =
  * The initial release

= 1.0.1B =

1. The permalinks are automatically updated now resolving the issue of having to manually update them from the options page to get URLs to work for new post types
1. A custom admin icon instead of the standard gear icon
1. An improved UX workflow for adding new post type

= 1.2.0 =

1. Added more styling for better UI on the administration interface
1. Added more classes for custom components
1. Added the ability to create a custom taxonomy and associate that with the normal Posts and Pages.
1. Fixed a few issues with the Javascript on front end side
1. Fixed URLs and local paths known issues
1. Improved the browse images functionality
1. Fixed permalink issues for archive pages

= 1.2.1 =

1. Last updated time on WP Site
