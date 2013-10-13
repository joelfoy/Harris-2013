=== ICanLocalize Translator ===
Contributors: ICanLocalize
Tags: i18n, translation, localization, language, multilingual, SitePress
Requires at least: 2.5.1
Tested up to: 2.7
Stable tag: 1.3.1

Allows running multilingual WordPress sites with zero management. Automatically creates and updates translation when you edit.

== Description ==

"ICanLocalize Translator" allows running multi-lingual WordPress websites (See the [5 minute demo](http://media.icanlocalize.com/wp_translation_demos/icanlocalize-translator.htm)).
It helps maintain contents in different languages and automatically links between them.

* Blog in your native language. Translations will be created automatically.
* Use different domains, `www.myblog.com`, `es.myblog.com`, `de.myblog.com` or directories within the same domain.
* Updates are handled automatically. When the original contents update, translations follow.

WordPress supports contents in a single language. To make multi-lingual WordPress sites insensitive to upgrades and to other plugins,
ICanLocalize Translator doesn't change any table structure and doesn't alter permlinks. Instead, each language will run in its own WordPress instance.

= Is this machine translation? =

Unlike free machine translators, this plugin will send posts and pages to be translated by real people.
You can select from our pool of professional translators or assign the work to your favorite translator.

This plugin works together with [ICanLocalize Comment Translator Plugin](http://wordpress.org/extend/plugins/icanlocalize-comment-translator/).
It needs to be installed in the original-language blog. The Comment Translator plugin will be installed in the translated-language blog(s).

= Running a multi-lingual site =
Even though visitors read and comment in their languages, and You will do all your tasks (including comment moderation and replies) in your own language.

Comment moderation in your language is handled by [ICanLocalize Comment Translator Plugin](http://wordpress.org/extend/plugins/icanlocalize-comment-translator/) which needs to be install on each of the translated blogs.

The plugin provides a function that you can include in your theme which automatically links between contents in different languages.

= What gets translated =
The plugin will automatically send all texts to be translated, including:

* Posts
* Pages
* Tags
* Categories (names and descriptions)

= Where can I see some examples? =

[Our own blog](http://blog-en.icanlocalize.com) is being translated by our system from English to French.
You're invited to [contact us](http://www.icanlocalize.com/web_dialogs/new?language_id=1&store=4) for other examples.

= SitePress =
This plugin is part of [SitePress](http://sitepress.org) - a collection of plugins that turn WordPress into a fully featured multilingual content management system.

== Installation ==

ICanLocalize Translator follows the standard plugin install:

   1. Unzip the "ICanLocalize Translator" archive and copy the folder to /wp-content/plugins/.
   2. Activate the plugin.
   3. Use the Settings > ICanLocalize Translator admin page to enter your website ID and accesskey and select default translation options.

== Frequently Asked Questions ==

= Where do I get my website ID and accesskey to start using the plugin? =

You will need to visit [ICanLocalize](http://www.icanlocalize.com) and sign up for an account (it's free). Then, create a new "CMS translation" project.
This plugin must already be installed on your blog in order for our system to connect to it and validate the installation.

Then, your website's ID and accesskey are generated. Enter to the plugin admin screen and you're ready to start.

= Is this free translation? =

No. We pay professional human translators for their work, so we must charge for it too.
The payment for the translation will be negotiated directly between you and the translator (using our system).

= How good are these translation? =
All the translators in our system are professional translators, writing in their native language.
You can also select to use your own translator, if you're already working with one.
We guarantee that all translations done by our own translators are excellent.

= How do I localize my theme? =
This plugin will not handle your theme localization - but we can certainly help with this too. You'll need to follow these steps:

* Wrap all texts in the theme in gettext calls (this is what WP is doing for itself too).
* Create a PO or POT file that includes all texts to be translated. You're welcome to our free online [.PO extractor from PHP](http://www.icanlocalize.com/tools/php_scanner) which will read the ZIP file containing your theme and produce a single .PO file.
* Send the PO file to translation. Again, [our translators](http://www.icanlocalize.com) can do this job for you.
* Save the MO files you get from the translator in the theme folder.

= Will this plugin change my database or break things up? =
Absolutely not. It doesn't change the default WordPress tables. Instead, this plugin will create new contents in different blogs, where the translations will be kept.
All linking information between the contents in different languages is simply stored as custom fields.

= How can I add links between the original blog and the translated blogs? =
Follow these instructions for [adding language selectors](http://sitepress.org/wordpress-translation/automatic-links-between-original-and-translations/).
You can add a drop down language selector in header.php or a list of available languages at the beginning or end of each post/page.

== Version History ==

* Version 0.4
	* First public release
* Version 0.5
	* Improved support for page hierarchy
* Version 0.6
	* Works with WordPress MU
* Version 1.0
	* Users can cancel translation jobs
* Version 1.3
	* Includes drop down language switcher that can be added to header.php.
* Version 1.3.1
	* Dropdown language selector now support IE6
