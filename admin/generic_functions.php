<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function dtoc_sanitize_register_setting( $input = [] ) {

	$output = [];

	foreach ( $input as $key => $value ) {
		if ( is_array( $value ) ) {
			// Recursively sanitize arrays
			$output[ sanitize_key( $key ) ] = dtoc_sanitize_register_setting( $value );
		} else {
			// Determine sanitization type
			if ( is_numeric( $value ) ) {
				$output[ sanitize_key( $key ) ] = ( strpos( $value, '.' ) !== false ) ? floatval( $value ) : intval( $value );
			} elseif ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
				$output[ sanitize_key( $key ) ] = esc_url_raw( $value );
			} elseif ( strpos( $value, '#' ) === 0 && preg_match( '/^#[a-f0-9]{3,6}$/i', $value ) ) {
				// Hex colors
				$output[ sanitize_key( $key ) ] = sanitize_hex_color( $value );
			} else {
				// Default sanitization
				$sanitized = sanitize_text_field( $value );

				/**
				 * Per-field sanitization filter.
				 *
				 * @param string $sanitized The sanitized value.
				 * @param string $key       The field key.
				 * @param string $value     The original value.
				 */
				$sanitized = apply_filters( 'dtoc_sanitize_field_value', $sanitized, $key, $value );

				$output[ sanitize_key( $key ) ] = $sanitized;
			}
		}
	}

	// Global filter for full sanitized array.
	$output = apply_filters( 'dtoc_sanitize_register_setting', $output, $input );

	// Second-stage filter — restore HTML comments or other patterns.
	$output = apply_filters( 'dtoc_restore_html_comments', $output, $input );

	return $output;
}

function dtoc_admin_tab_link($tab = '', $page = 'dtoc', $args = []){
    	
	if ( ! is_multisite() ) {
		$link = admin_url( 'admin.php?page=' . $page );
	}
	else {
		$link = admin_url( 'admin.php?page=' . $page );
	}

	if ( $tab ) {
		$link .= '&tab=' . $tab;
	}

	if ( !empty($args) ) {
		foreach ( $args as $arg => $value ) {
			$link .= '&' . $arg . '=' . urlencode( $value );
		}
	}

	return esc_url($link);
}
function dtoc_admin_get_tab( $default = '', $available = [] ) {

	$tab = isset( $_GET['tab'] ) ? sanitize_text_field($_GET['tab']) : $default;
        
	if ( ! in_array( $tab, $available ) ) {
		$tab = $default;
	}

	return $tab;
}

function dtoc_get_all_post_types(){

    $response    = [];
    $post_types = get_post_types( array( 'public' => true ), 'object' );    	
	if(!empty($post_types) && is_array($post_types)){
		foreach ( $post_types as $post_type ) {
			if(is_object($post_type)){
				$response[$post_type->name] = $post_type->label;
			}			
		}
		unset($response['attachment']);
	}
		
    return $response;
    
}
function dtoc_get_all_taxonomies(){

	$response   = [];

    $args = [       
        'public'      => true,
        'show_ui'     => true,
	];

    $taxonomies = get_taxonomies( $args, 'object' );    
	if(!empty($taxonomies) && is_array($taxonomies)){
		foreach ( $taxonomies as $taxonomy ) {
			if(is_object($taxonomy)){
				$response[$taxonomy->name] = $taxonomy->label;
			}			
		}	
	}
    
    return $response;
    
}

function dtoc_different_four_sides_html($setting_name, $setting_options, $css_type, $section_type){
	
	$four_side = [
		'top' 	 => 'Top',
		'right'  => 'Right',
		'bottom' => 'Bottom',
		'left'   => 'Left'
	];
	$units = [
		'px' 	 => 'px',
		'pt'     => 'pt',
		'%'      => '%',
		'em'     => 'em'
	];

	?><ul style="display: flex;"><?php

	foreach ($four_side as $key => $value) {
		?>
		<li>
			<input data-group="<?php echo $section_type.'_'.$css_type; ?>" type="number" class="small-text smpg-input" id="<?php echo $section_type.'_'.$css_type.'_'.$key; ?>" name="<?php echo $setting_name.'['.$section_type,'_'.$css_type.'_'.$key.']'; ?>" value="<?php echo isset( $setting_options[$section_type.'_'.$css_type.'_'.$key] ) ? esc_attr( $setting_options[$section_type.'_'.$css_type.'_'.$key]) : '0'; ?>">
			<span data-group="<?php echo $section_type.'_'.$css_type; ?>"><?php echo esc_html__($value, 'digital-table-of-contents'); ?></span>
        </li>
		<?php
	}
	?>    	            
        <li>
		<select data-group="<?php echo $section_type.'_'.$css_type; ?>" id="<?php echo $section_type.'_'.$css_type.'_unit'; ?>" class="small-text smpg-input" name="<?php echo $setting_name.'['.$section_type.'_'.$css_type.'_unit'; ?>]">
			<?php
				foreach ($units as $key => $value) {					
					?><option value="<?php echo $key; ?>" <?php echo (isset($setting_options[$section_type.'_'.$css_type.'_unit']) && $setting_options[$section_type.'_'.$css_type.'_unit'] == $key ? 'selected' : '' ) ?>><?php echo esc_html__($value, 'digital-table-of-contents'); ?></option><?php					
				}
			 ?>                                
        </select>
        <span data-group="<?php echo $section_type.'_'.$css_type; ?>"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
        </li>
    </ul>    	    
    <?php
}

function dtoc_tooltip( $text, $id ) {
	
    return '<span class="dtoc-tooltip-wrapper">
        <span class="dashicons dashicons-editor-help"></span>
        <span class="dtoc-tooltip-text">'.esc_html( $text ).'</span>
    </span>';
    
}