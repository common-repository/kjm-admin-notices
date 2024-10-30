=== KJM Admin Notices ===
Contributors: webmarka
Donate link: https://www.kajoom.ca/
Tags: admin notice, admin notices, notices, frontend notices, dashboard, messages, dismissible, management tool, email notifications, email, maintenance, administration
Requires at least: 3.0.1
Tested up to: 5.4
Stable tag: 2.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Notify your WordPress users effortlessly! Create, manage and display nice custom dismissible notices to admin users and public visitors.

== Description ==

Notify your WordPress users effortlessly! Create, manage and display nice custom dismissible notices to admin users and public visitors.

KJM Admin Notices helps you communicate with your website users and visitors by providing a complete way of managing and displaying nice notices on your website and inside the WP admin panel.

= Features: =

* Create, manage and display to admin users and visitors nice custom dismissible notices.
* Display notices on the frontend to public visitors.
* Each notice can be styled based on the 4 (+1) built-in WordPress notices : info (blue), success (green), warning (yellow), error (red) + default (gray).
* Custom notices background and text color.
* Choose to which roles you want to display / send notice.
* Notices are dismissible by the user, on a per user basis.
* Assign tags, category, author, publish date to your notice.
* Shortcodes : 3 handy shortocdes available as placeholders into the title or the body message : `[kjm_website_domain]`, `[kjm_display_name]` and `[kjm_admin_login]`.
* Email notifications : Send notices by email to your users. Send copy to the admin.
* Scheduled Notices publication : plan your announcements in advance and publish them later.
* You can even enable WordPress comments on your notices to turn this into a collaborative system!
* Save general system information along with notice : WordPress version, active plugins and versions, theme and version, child-theme and version.

== Installation ==

1. Upload `kjm-admin-notices` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to 'Settings -> KJM Admin Notices' to review the available global options.
1. Start creating your notices by going to 'Manage KJM Admin Notices' and have fun!

== Frequently Asked Questions ==

= Admin Notices don't get sent by email? =

First, make sure the 'Send Email' option is on. Same thing on your notice edit screen, make sure the 'Send Email' option is checked. Also make sure you checked relevant roles in ' Show Notice to Roles'. Since version 1.0.8, notices are sent on the first time the notice is published. You will see a big gray button in the 'Sent' column which shows to how many people the notice has been sent.

= How to use shortcodes? =

There are currently 3 different shortcodes available in KJM Admin Notices.

1. `[kjm_website_domain]` will be replaced with the base website domain name. Eg. 'domain.com'. Can be used in title and content.
1. `[kjm_display_name]` will be replaced with the user Display Name. Eg. 'John Doe'. Can be used in title and content.
1. `[kjm_admin_login]` will be replaced with the login URL to your website. Eg. 'http://domain.com/wp-login.php'. Can be used in content only.

= Are there some future improvements planned? =

* Provide date and time for automatic notice expiration.
* Add readmore management with JS in notices display. Eg : "Show More" toggle.
* Add an AJAX notes system on notices (different plugin?).

== Screenshots ==

1. Frontend Notices with custom colors.
2. Admin Notices backend display.
3. Settings page. 
4. Edit Notice page. 
5. Post type list page. 


== Changelog ==

= 2.0.1 =

New version 2.0.1 : Bugfixes, small improvements and new option to Hide Dismiss Button.

**Better session management**

* Bugfix: prevent session to interfere with REST API and loopback requests. Thanks to @knutsp for his tips!
* Enhancement : close session on login and logout.

**Better handling of some metaboxes**

* Bugfix: Better handling of "Show Notices to Roles" checkboxes display;
* Bugfix: Prevent custom fields values to be overrided on update when checkboxes
 are disabled. Thanks to @koullis for reporting the problem;
 
**New feature : Hide Dismiss Button**

* Added option to hide the Dismiss Button. Note : If both Dismiss Link and
 Dismiss Button are hidden, then the Notice will not be dismissable by the user.
* Better Edit Link positionning to prevent overlap when the Notice is small.

**Others fixes**

* Fixed PHP Warning:  _() expects exactly 1 parameter, 2 given in
 includes/class-kjm-admin-notices-shared.php on line 320.
* Updated languages strings.

= 2.0.0 =

New version 2.0.0 : Front-end publishing and many new features!

**New features and improvements**

* Ability to post notices on the public site
* Selection of custom colors for notices background and text
* Track views statistics
* New status for archiving a notice
* Alternative update system for beta releases

**Languages**

* Support for rigth-to-left (RTL) languages
* Addition of 3 languages: Arabic and two Indian languages

**Interoperability**

* Compatibility list with supported plugins
* Implementation of multiple WordPress hook filters

[See this blog article for more details](https://www.kajoom.ca/en/blog/kjm-admin-notices-plugin-version-2-0-brings-frontend-publication/)


= 1.1.12 =

[Beta Release] New version 1.1.12 : Bug fixes on the new Beta version.

* Fixed PHP Warning: NOTICE: UNDEFINED INDEX: KJMNOTICE IN 
  CLASS-KJM-ADMIN-NOTICES-PUBLIC.PHP ON LINE 236
* Set variable $kjm_cookie only if $_COOKIE['kjmnotice'] is set.
* Fixed JS Error TypeError: $(...).wpColorPicker is not a functionCode
  The 'wp-color-picker' library needs to be loaded before the script so I added
  it as a dependency.
* Fixed PHP Warning: Declaration of Kjm_Admin_Notices_Admin should be compatible
  with Kjm_Plugin_Admin_Base_1_0 by adding parameter $hook to method
  enqueue_scripts($hook)
  
Specials thanks to Francisco for his work on this version!

= 1.1.11 =

[Beta Release] Beta version with many new features.

* Frontend notice publication.
* Custom color selection for notices.
* Added options to exclude superadmin and/or notice author from views stats.
* Added settings sections with supported plugins compatibility list;
* Added compatibility code for plugin Archive Post Statuss;
* Updated plugin-update-checker to the latest version.
* Change in the class name used for plugin-update-checker.
* Added Arabic and two India langs;
* Added RTL support;
* And many more! Full changelog will be added to the stable version.

= 1.0.10 =

Verified compatibility with WP 5.0.

* Tested plugin with WordPress 5.0 intallation;
* Fixed wrong action name preventing a link to the settings page to display on the plugins list page;
* Changed a constant name.

= 1.0.9 =

Two bugs fixes, one styling issue and one bug on checkboxes introduced in version 1.0.7.

* Improved custom fields save and update handling.
* Fixed post meta new value was not taken in account when un-checked checkboxes.
* Fixed some plugin styles that was not properly isolated.

= 1.0.8 =

Bug fixes for notice email sending and notice admin display.

* Fixed Notice duplicate ID causing display error in some cases.
* Fixed Send Email behavior, emails are now sent on the first save.
* Fixed Send Email on planned publication.

*** Thanks to @koullis for pointing us the issues! ***

= 1.0.7 =

New EN and FR translations, bug fixes for auto-publish WP feature and email metabox display.

* Fixed planned Notices was not displaying on auto-publish.
* Fixed email metabox should not appear if send email plugin option is off.
* Added English (US and CA) translations.
* Added French (CA) translations.
* Updated French translations.

*** Thanks to @koullis for pointing us the planned publication issue! ***

= 1.0.6 =

Improvements and bug fixes. Verified compatibility with WP 4.9

* Added ability to define users roles or capability who are allowed to send notices.
* Added a "Debug" metabox for debugging purposes.
* Implement local-settings file loading.
* Fixed Global Param "Child Theme" value.

= 1.0.5 =

Many small changes, improvements and bug fixes and verified compatibility with WP 4.7

* Compatibility check test with WP 4.7.
* Updated languages files. Replaced "Modify Notice" by "Edit Notice" in translation strings.
* Only call save_metaboxes() method on kjm_notice CTP. Thanks to "Cesar" for reporting this bug :)
* Prevent a PHP Strict Standards message to display.

= 1.0.4 =

* Corrected typos in README.txt file.
* Moved away extra code not intended for this plugin in an external file.
* Versionned admin base class to prevent conflits between plugins.
* Removed unused files and deactivated some unused code.

= 1.0.3 =

* Added an alternate updater to update from custom servers instead of WP.
* Removed local settings data.

= 1.0.2 =

Added possibility to customize display of notices, hardened security, and a lot of new features.

* Only display notices to those in the targeted roles.
* Allow hiding title, metas and dismiss link.
* Updated languages strings. Added language strings to .pot file. Added FR traduction.
* Only send notice to selected user roles.
* Added option to allow Comments system on Notices CPT.
* Added metabox to display global application params : WP version, active plugins, themes.
* Added checkbox on CPT to allow sending a copy to admin email.
* Added "Manage KJM Admin Notices" in the plugin options page.
* Force Notice CPT to be in Private mode (for comments to be private too).
* Added metaboxes and function to manage roles to send / display notices.
* Enhancement of the get_items() admin base method.
* Added filter "kjm_plugin_admin_base_get_items" to allow external modification.
* Cleaning in class-kjm-plugin-admin-base.php
* Do not display "Manage KJM Admin Notices" if CPT isn't activated.
* Js for "show to all / none" toggling in admin edit CPT screen.
* Corrected bugs in send_email_notice() function.
* Reinitialize variables $to, $subject and $body to prevent reuse of data.
* Added role "none" to exclude from emailing notices.
* Added nonces to securize requests. Done on options page and AJAX calls.
* Added an upgrade version automatic detection and process.

= 1.0.1 =

* Fix : Dont send email notice to some users roles (subscriber, contributor, customer).

= 1.0.0 =

* Initial release of kjm-admin-notices. 
* Refactorized to WordPress Plugin Boilerplate 3.0.

== Upgrade Notice ==

= 2.0.0 =

Visit the settings page to activate new features: Frontend Publication, Alternate Updates.

= 1.0.4 =

Defined a way to manage extra functionnality.

= 1.0.3 =

Enabled updates with an alternate updater taking updates from custom servers instead of WP as an option.

= 1.0.2 =

New plugin version 1.0.2. Added possibility to customize display of notices, hardened security, and a lot of new features.

