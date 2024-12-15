=== Digital Table of Contents ===
Contributors: amanstacker
Tags: toc, table of contents, WordPress
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
A plugin to automatically add a table of contents to posts and pages or via shortcode.

== Usage ==

1. **Auto-Inserting TOC:**
   - The TOC will automatically appear on selected post types (e.g., posts or pages) based on the settings configured in the admin panel.

2. **Using the Shortcode:**
   - You can manually insert a Table of Contents using the `[digital_toc]` shortcode. 
   - The shortcode supports the following arguments:
   
     **Arguments:**
     - `headings`: Specify which heading levels to include in the TOC (e.g., `headings="h2,h3,h4"`).
     - `toggle`: Enable the toggle feature (`toggle="true"` or `toggle="false"`).
     - `hierarchy`: Enable or disable nested hierarchy (`hierarchy="true"` or `hierarchy="false"`).
     - `title`: Customize the title of the TOC (e.g., `title="Custom TOC Title"`).

   **Example:**
	[digital_toc headings="h2,h3" toggle="true" hierarchy="true" title="My Custom TOC"]
	This will render a TOC that includes H2 and H3 headings, with toggle and hierarchy enabled, and a custom title "My Custom TOC."

== Installation ==
1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the settings in 'Settings > Digital TOC'.

== Changelog ==
= 1.0.0 =
* Initial release.
