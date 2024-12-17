<?php
/*
Plugin Name: Digital Table Of Contents
Description: A plugin to automatically add table of contents on posts and pages or via shortcode.
Version: 1.0.0
Text Domain: digital-table-of-contents
Domain Path: /languages
Author: Aman Kumar Sharma
Author URI: https://profiles.wordpress.org/amanstacker/
License: GPLv2 or later
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DTOC_VERSION', '1.0.0' );
define( 'DTOC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include required files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-dtoc-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-dtoc-render.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-dtoc-assets.php';

class DigitalTableOfContents {

    public function __construct() {
        // Initialize plugin
        new DTOC_Settings();
        new DTOC_Render();
        new DTOC_Assets();
    }
}

new DigitalTableOfContents();