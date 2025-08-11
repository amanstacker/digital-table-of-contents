<?php
/*
Plugin Name: Digital Table of Contents
Description: Show automated table of contents generated from the post content.
Version: 1.0.2
Text Domain: digital-table-of-contents
Domain Path: /languages
Author: amanstacker
Author URI: https://profiles.wordpress.org/amanstacker/
License: GPLv2 or later
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define('DTOC_VERSION', '1.0.2');
define('DTOC_DIR_NAME', plugin_basename( dirname( __FILE__ ) ) );
define('DTOC_BASE_NAME', plugin_basename( __FILE__ ) );
define('DTOC_PATH', dirname( __FILE__ ) );
define('DTOC_URL', plugin_dir_url( __FILE__ ) );

//shared
require_once( DTOC_PATH . '/shared/functions.php' );

//admin
require_once( DTOC_PATH . '/feedback/feedback.php' );
require_once( DTOC_PATH . '/admin/misc.php' );
require_once( DTOC_PATH . '/admin/generic_functions.php' );
require_once( DTOC_PATH . '/admin/class-digital-toc-settings.php' );
require_once( DTOC_PATH . '/admin/dashboard_page.php' );
require_once( DTOC_PATH . '/admin/compatibility_page.php' );

require_once( DTOC_PATH . '/admin/class-digital-toc-posts-metaboxes.php' );
require_once( DTOC_PATH . '/admin/class-digital-toc-taxonomies-metaboxes.php' );


//includes
require_once( DTOC_PATH . '/includes/misc.php' );
require_once( DTOC_PATH . '/includes/generic_functions.php' );
require_once( DTOC_PATH . '/includes/incontent/in_content.php' );
require_once( DTOC_PATH . '/includes/sticky/sticky.php' );
require_once( DTOC_PATH . '/includes/floating/floating.php' );
require_once( DTOC_PATH . '/includes/shortcode/shortcode.php' );