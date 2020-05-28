=== PHP Everywhere ===
Contributors: alexander_fuchs 
Donate link:http://www.alexander-fuchs.net/donate/
Tags: code,html,php,post,page,widget,insert PHP,custom code,insert PHP page,insert PHP post,run PHP,use PHP,execphp
Requires at least: 5.0
Tested up to: 5.3
Requires PHP: 5.3
Stable tag: trunk
License: GPL2
License URI: http://www.gnu.de/documents/gpl-2.0.de.html

This plugin enables PHP code everywhere in your WordPress instalation.

Using this plugin you can use PHP in widgets, pages and posts. Supports Gutenberg.

== Description ==

<p style="margin: 0px 0px 22px; padding: 0px; clear: left; font-size: 13px; color: #444444; font-family: sans-serif; line-height: 22px;">
  This plugin enables PHP code everywhere in your WordPress instalation.
</p>

<p style="margin: 0px 0px 22px; padding: 0px; clear: left; font-size: 13px; color: #444444; font-family: sans-serif; line-height: 22px;">
  Using this plugin you can use PHP in:
</p>

<p style="margin: 0px 0px 22px; padding: 0px; clear: left; font-size: 13px; color: #444444; font-family: sans-serif; line-height: 22px;">
  <ul>
    <li>
      Widgets
    </li>
    <li>
      Pages
    </li>
    <li>
      Posts
    </li>
  </ul>
</p>
<p style="margin: 0px 0px 22px; padding: 0px; clear: left; font-size: 13px; color: #444444; font-family: sans-serif; line-height: 22px;">
  The plugin also supports different user restrictions and multiple PHP instances.
</p>
<p style="margin: 0px 0px 22px; padding: 0px; clear: left; font-size: 13px; color: #444444; font-family: sans-serif; line-height: 22px;">
  So feel free to just insert PHP in every part of your WordPress site.</p>
<p style="margin: 0px 0px 22px; padding: 0px; clear: left; font-size: 13px; color: #444444; font-family: sans-serif; line-height: 22px;">
  Examples of use:
<ul>
    <li>
      Create custom contact forms and process any kind of data or upload.
    </li>
    <li>
      Generate user optimized content.
    </li>
    <li>
      Customize every little detail of your WordPress installation.
    </li>
  </ul>
</p>

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page. There is a usage guide on the plugins options page.
== Frequently Asked Questions ==

**Q: How do I use this plugin?**

A: You can find a usage guide on the options page

**Q: Does this plugin support multiple PHP instances?**

A: Yes, but you need to check for a position parameter using an if statements in your PHP snippet. The Gutenberg Block also supports multiple instances.

**Q: Does this plugin support the Gutenberg editor?**

A: Yes. The plugin provides a Gutenberg Block.

== Screenshots ==

1. This is the plugins Gutenberg Block.
2. This is the plugins post and pages option. Paste your PHP or HTML into this option and place the shortcode where you want the plugin to appear.
3. This is the plugins multiple PHP instance functionality
4. The plugin looks like this while using the classic editor

== Changelog ==

= 2.0.1 - December 04, 2019 =

* Info: Clarified WordPress 5.3 compatibility and adjusted settings page

= 2.0.0 - June 15, 2019 =

* New: Added Gutenberg Block
* New: Added option to disable Options box.
* New: Added option to disable Gutenberg Block.

= 1.4.5 - March 14, 2019 =

* Info: Clarified Gutenberg and WordPress 5.1 compatibility

= 1.4.3/4 - October 17, 2018 =

* Fix: Fixed deprecated warning on PHP 7.2
* Fix: Fixed error introduced in 1.4.3

= 1.4.2 - May 13, 2018 =

* New: Added italien translation

= 1.4.1 - December 01, 2017 =

* Fix: Added Wordpress.org translation support

= 1.4 - November 26, 2017 =

* New: Added Wordpress.org translation support
* Fix: Fixed security flaw where authenticated users were able to make themself administrators and execute php. Thanks [@dandr3ss](https://twitter.com/dandr3ss)

= 1.3 - November 08, 2017 =

* Fix: Fixed deprecation notice on PHP 7.1

= 1.2.5 =

*	minor bugfix for translations
*	lowered the plugins memmory footprint

= 1.2.4 =

*	added a portuguese translation

= 1.2.3 =

*	bug fix for WP 4.3.1, thanks thea2zbrand

= 1.2 =

*	added a german translation
*	added a serbian translation

= 1.1.2 =

*   fixed some minor bugs when creating a menu

= 1.1 =

*   added multiple PHP instances

= 1.0 =

*   release

== Other Notes ==
**Design**

Icon & Wallpaper Design : [GiGATEAM Ltd.](https://gigateam.net/)

**Translation**

English and German : [Alexander Fuchs](https://www.alexander-fuchs.net)
Portuguese : [Luis Reis](http://inforarte.com/)
Serbian : [Borisa Djuraskovic](http://www.webhostinghub.com)
Italian : Andrea Rosenthal Manetti