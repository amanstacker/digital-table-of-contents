<?php
/**
 * Uninstall script for Digital TOC Plugin.
 *
 * Fired when the plugin is deleted from WordPress.
 *
 * @package DigitalTOC
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Delete plugin options (site-level + network-level).
 */
function dtoc_delete_plugin_data() {
    
    $dtoc_dashboard          = get_option( 'dtoc_dashboard' , false );	

	if ( empty( $dtoc_dashboard['delete_plugin_data'] ) ) {
		// User did not enable data removal → exit without deleting.
		return;
	}

	// List of site-level options.
	$site_options = [
		'dtoc_dashboard',
		'dtoc_incontent',
		'dtoc_incontent_mobile',
		'dtoc_shortcode',
        'dtoc_sliding_sticky',
        'dtoc_sliding_sticky_mobile',
        'dtoc_floating',
        'dtoc_compatibility',
	];	

	if ( ! is_multisite() ) {
		// Single site cleanup.
		foreach ( $site_options as $option ) {
			delete_option( $option );
		}
	} else {
		// Multisite: loop through all sites.
		$sites = get_sites( [ 'fields' => 'ids' ] );

		foreach ( $sites as $site_id ) {
			switch_to_blog( $site_id );

			foreach ( $site_options as $option ) {
				delete_option( $option );
			}

			restore_current_blog();
		}		
	}
}

dtoc_delete_plugin_data();