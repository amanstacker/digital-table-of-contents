<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

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

function dtoc_dummy_content($options){
	$content = '';	
	$content .= '<h1>Heading 1</h1>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<h1>Heading 2</h1>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industr\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<h1>Heading 3</h1>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<h1>Heading 4</h1>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>
	<h1>Heading 5</h1>
	<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;</p>';

	$content .=(isset($options['custom_css']) && !empty($options['custom_css']))? '<style id="dtoc_custom_css">'.esc_attr($options['custom_css']).'</style>':'';
	$matches     = dtoc_filter_heading($content,$options); 
	if(!empty($matches)){
		$headings    = dtoc_get_headings($matches); 				
		if(isset($options['jump_links']) && $options['jump_links'] == true){
			$anchors     = dtoc_get_headings_with_anchors($matches);
			$content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
		}             
		$content     = dtoc_position_inside_content($content, $matches, $options);
		
		
	}

	return $content;
}
function dtoc_preview_html_by_device_type($device, $options){
	$html = '';
	switch ($device) {
		case 'laptop':
			$html .= '<div class="dtoc-preview-container">'; 
			$html .= '<h2 class="dtoc-preview-heading">LIVE PREVIEW</h2>'; 
			$html .= '<div class="dtoc-preview-container">';
			$html .= '<div class="dtoc-pre-laptop">';
			$html .= '<div class="dtoc-pre-laptop-content">';
			$html .= dtoc_dummy_content($options);
			$html .= '</div>'; 
			$html .= '</div>'; 
			$html .= '</div>';
			$html .= '</div>';
			break;
		case 'mobile':
			$html .= '<div class="dtoc-preview-container">'; 
			$html .= '<h2 class="dtoc-preview-heading">LIVE PREVIEW</h2>'; 
			$html .= '<div class="dtoc-preview-container">';
			$html .= '<div class="dtoc-pre-mobile">';
			$html .= '<div class="dtoc-pre-mobile-content">';
			$html .= dtoc_dummy_content($options);
			$html .= '</div>'; 
			$html .= '</div>'; 
			$html .= '</div>';
			$html .= '</div>';
			break;
		case 'tablet':
			$html .= '<div class="dtoc-preview-container">'; 
			$html .= '<h2 class="dtoc-preview-heading">LIVE PREVIEW</h2>'; 
			$html .= '<div class="dtoc-preview-container">';
			$html .= '<div class="dtoc-pre-tablet">';
			$html .= '<div class="dtoc-pre-tablet-content">';
			$html .= dtoc_dummy_content($options);
			$html .= '</div>'; 
			$html .= '</div>'; 
			$html .= '</div>';
			$html .= '</div>';
			break;
		
		default:		
			break;
	}

	return $html;
}
function dtoc_get_live_preview_by_type($type, $options){
	$preview = '';
	switch ($type) {
		case 'dtoc_incontent':				
			$preview = dtoc_preview_html_by_device_type('laptop', $options);
			break;
		case 'dtoc_incontent_mobile':				
			$preview = dtoc_preview_html_by_device_type('mobile', $options);			
			break;
		case 'dtoc_incontent_tablet':	
			$preview = dtoc_preview_html_by_device_type('tablet', $options);
			break;
		case 'dtoc_sticky':				
			$preview = dtoc_preview_html_by_device_type('laptop', $options);
			break;
		case 'dtoc_sticky_mobile':		
			$preview = dtoc_preview_html_by_device_type('mobile', $options);
			break;
		case 'dtoc_sticky_tablet':		
			$preview = dtoc_preview_html_by_device_type('tablet', $options);
			break;
		case 'dtoc_floating':			
			$preview = dtoc_preview_html_by_device_type('laptop', $options);
			break;
		case 'dtoc_floating_mobile':	
			$preview = dtoc_preview_html_by_device_type('mobile', $options);
			break;
		case 'dtoc_floating_tablet':	
			$preview = dtoc_preview_html_by_device_type('tablet', $options);
			break;
		case 'dtoc_shortcode':			
			$preview = dtoc_preview_html_by_device_type('laptop', $options);
			break;
		case 'dtoc_shortcode_mobile':				
			$preview = dtoc_preview_html_by_device_type('mobile', $options);
			break;
		case 'dtoc_shortcode_tablet':	
			$preview = dtoc_preview_html_by_device_type('tablet', $options);
			break;
		default:
			# code...
			break;
	}

	return $preview;

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
			<input data-group="<?php echo $section_type.'_'.$css_type; ?>" type="number" class="small-text" id="<?php echo $section_type.'_'.$css_type.'_'.$key; ?>" name="<?php echo $setting_name.'['.$section_type,'_'.$css_type.'_'.$key.']'; ?>" value="<?php echo isset( $setting_options[$section_type.'_'.$css_type.'_'.$key] ) ? esc_attr( $setting_options[$section_type.'_'.$css_type.'_'.$key]) : '0'; ?>">
			<span data-group="<?php echo $section_type.'_'.$css_type; ?>"><?php echo esc_html__($value, 'digital-table-of-contents'); ?></span>
        </li>
		<?php
	}
	?>    	            
        <li>
		<select data-group="<?php echo $section_type.'_'.$css_type; ?>" id="<?php echo $section_type.'_'.$css_type.'_unit'; ?>" name="<?php echo $setting_name.'['.$section_type.'_'.$css_type.'_unit'; ?>]">
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
	?>
    <label for="<?php echo esc_attr( $id ); ?>" class="dtoc-tooltip-wrapper">
        <span class="dashicons dashicons-editor-help"></span>
        <span class="dtoc-tooltip-text"><?php echo esc_html( $text ); ?></span>
    </label>
    <?php
}