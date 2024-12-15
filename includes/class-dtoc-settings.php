<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DTOC_Settings {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'create_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function register_settings() {
        register_setting( 'digital_toc_settings', 'digital_toc_options' );
    }

    public function create_settings_page() {
        add_options_page(
            __( 'Digital Table of Contents Settings', 'digital-table-of-contents' ),
            __( 'Digital TOC', 'digital-table-of-contents' ),
            'manage_options',
            'digital_toc_settings',
            [ $this, 'render_settings_page' ]
        );
    }

    public function render_settings_page() {
        $options = get_option( 'digital_toc_options', [
            'post_types' => [ 'post' ],
            'headings'   => [ 'h2' ],
            'hierarchy'  => false,
            'toggle'     => false,
            'title'      => 'Table of Contents',
        ] );

        include plugin_dir_path( __FILE__ ) . '../templates/settings-page.php';
    }
}
