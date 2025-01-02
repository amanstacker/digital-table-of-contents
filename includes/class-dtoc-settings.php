<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DTOC_Settings {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'dtoc_create_settings_page' ] );
        add_action( 'admin_init', [ $this, 'dtoc_register_settings' ] );
    }

    public function dtoc_register_settings() {
        register_setting(
            'digital_toc_settings', 
            'dtoc_toc_options', 
            [
                'type'              => 'array',
                'sanitize_callback' => [ $this, 'dtoc_sanitize_options' ],
            ]
        );
    }

    public function dtoc_sanitize_options( $options ) {
        if ( ! is_array( $options ) ) {
            return [];
        }

        // Default options
        $defaults = [
            'post_types' => [ 'post' ],
            'headings'   => [ 'h2' ],
            'hierarchy'  => false,
            'toggle'     => false,
            'title'      => 'Table of Contents',
        ];

        // Merge with defaults to ensure all fields exist
        $options = wp_parse_args( $options, $defaults );

        // Sanitize each field
        $sanitized = [];
        $sanitized['post_types'] = array_map( 'sanitize_text_field', (array) $options['post_types'] );
        $sanitized['headings']   = array_map( 'sanitize_text_field', (array) $options['headings'] );
        $sanitized['hierarchy']  = filter_var( $options['hierarchy'], FILTER_VALIDATE_BOOLEAN );
        $sanitized['toggle']     = filter_var( $options['toggle'], FILTER_VALIDATE_BOOLEAN );
        $sanitized['title']      = sanitize_text_field( $options['title'] );

        return $sanitized;
    }

    public function dtoc_create_settings_page() {
        add_options_page(
            __( 'Digital Table of Contents Settings', 'digital-table-of-contents' ),
            __( 'Digital TOC', 'digital-table-of-contents' ),
            'manage_options',
            'digital_toc_settings',
            [ $this, 'dtoc_render_settings_page' ]
        );
    }

    public function dtoc_render_settings_page() {
        $options = get_option( 'dtoc_toc_options', [
            'post_types' => [ 'post' ],
            'headings'   => [ 'h2' ],
            'hierarchy'  => false,
            'toggle'     => false,
            'title'      => 'Table of Contents',
        ] );

        include plugin_dir_path( __FILE__ ) . '../templates/settings-page.php';
    }
}
