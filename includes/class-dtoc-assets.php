<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DTOC_Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'dtoc_enqueue_assets' ] );
    }

    public function dtoc_enqueue_assets() {
        wp_enqueue_style( 'dtoc-list-style', DTOC_PLUGIN_URL.'assets/css/style.css' ,[], DTOC_VERSION ,'all');
        wp_enqueue_script( 'dtoc-list-script', DTOC_PLUGIN_URL.'assets/js/script.js', [ 'jquery' ], DTOC_VERSION , true );
    }
}
