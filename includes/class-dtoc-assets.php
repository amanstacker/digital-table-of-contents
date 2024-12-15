<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DTOC_Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    public function enqueue_assets() {
        wp_enqueue_style( 'digital-toc-style', DTOC_PLUGIN_URL.'assets/css/style.css' ,[], DTOC_VERSION ,'all');
        wp_enqueue_script( 'digital-toc-script', DTOC_PLUGIN_URL.'assets/js/script.js', [ 'jquery' ], DTOC_VERSION , true );
    }
}
