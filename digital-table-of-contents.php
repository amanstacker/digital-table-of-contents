<?php
/**
 * Plugin Name: Digital Table of Contents
 * Description: A plugin to automatically insert a table of contents into posts or pages and provide a shortcode for manual insertion.
 * Version: 1.0.0
 * Author: amanstacker
 * License: GPL2
 * Text Domain: digital-table-of-contents
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
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