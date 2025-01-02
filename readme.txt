=== Digital Table Of Contents ===
Contributors: amanstacker
Tags: toc, table of contents, navigation, menu, heading
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin to automatically add table of contents on posts and pages or via shortcode.

== Description ==

A plugin to automatically add table of contents on posts and pages or via shortcode.

== Usage ==

1. **Auto-Inserting TOC:**

   - The TOC will automatically appear on selected post types (e.g., posts or pages) based on the settings configured in the admin panel.

2. **Using the Shortcode:**

   - You can manually insert a Table of Contents using the `[dtoc_list]` shortcode. 
   - The shortcode supports the following arguments:
   
     **Arguments:**
     - `headings`: Specify which heading levels to include in the TOC (e.g., `headings="h2,h3,h4"`).
     - `toggle`: Enable the toggle feature (`toggle="true"` or `toggle="false"`).
     - `hierarchy`: Enable or disable nested hierarchy (`hierarchy="true"` or `hierarchy="false"`).
     - `title`: Customize the title of the TOC (e.g., `title="Custom TOC Title"`).

   **Example:**
   
	[dtoc_list headings="h2,h3" toggle="true" hierarchy="true" title="My Custom TOC"]
	This will render a TOC that includes H2 and H3 headings, with toggle and hierarchy enabled, and a custom title "My Custom TOC."

== Report Bug or Contribute fix ==

Encounter an issue with Digital Table Of Contents? or wanted to contribute. Kindly visit Digital Table Of Contents repository on [GitHub](https://github.com/amanstacker/digital-table-of-contents). Please be aware that GitHub is not a support forum, but rather a streamlined platform for effectively addressing and solving problems.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the settings in 'Settings > Digital TOC'.


== Changelog ==

= 1.0.0 =

* Initial release.