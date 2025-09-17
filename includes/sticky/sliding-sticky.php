<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'the_content', 'dtoc_sliding_sticky_callback' );

function dtoc_sliding_sticky_callback( $content ) {

    global $dtoc_dashboard;
    
    if ( empty( $dtoc_dashboard['modules']['sliding_sticky'] ) ) {
        return $content;
    }

    if ( is_singular() && in_the_loop() && is_main_query() ) {
        
        $options = dtoc_get_options_by_device( 'sliding_sticky' );        

        if ( ! empty( $options ) && dtoc_placement_condition_matched( $options ) ) {
            
            $matches     = dtoc_filter_heading( $content, $options );
       
            if ( ! empty( $matches ) ) {

                $headings    = dtoc_get_headings( $matches );
                                
                if ( count( $headings ) ) {

                    if ( ! empty( $options['jump_links']) ) {

                        $anchors     = dtoc_get_headings_with_anchors( $matches );                        
                        $content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
    
                    }   
    
                    if ( ! empty( $options['rendering_style'] ) && $options['rendering_style'] == 'css' ) {
            
                        $content     = $content.dtoc_sliding_sticky_box_on_css( $matches, $options );

                    }else{
                        
                        $content     = $content.dtoc_sliding_sticky_box_on_js( $matches,$options );
                    }

                }				
                
            }
        }                    
                
    }    

    return $content;    
}

function dtoc_sliding_sticky_box_on_css( $matches , $options = [] ) {

    $dbc_style = dtoc_box_container_style( $options );

    // Handle toggle initial state
    $initial_state = ! empty( $options['toggle_initial'] ) ? $options['toggle_initial'] : 'hide';
    $checked_attr  = ( $initial_state === 'show' ) ? ' checked="checked"' : '';

    // Add checkbox with conditional checked
    $html  = '<input type="checkbox" id="dtoc-sliding-sticky-toggle"'. $checked_attr .'>' . "\n";

    $html .= '<div class="dtoc-sliding-sticky-container dtoc-'. esc_attr( $options['display_position'] ) .'" style="'.$dbc_style.'">' . "\n";
    
    $t_style = dtoc_get_toggle_btn_style( $options );
    $html .= '<label for="dtoc-sliding-sticky-toggle" class="dtoc-sliding-sticky-toggle-btn" style="'.$t_style.'">'. esc_html( $options['toggle_btn_text'] ) .'</label>' . "\n";    
    
    // Scrollable inner wrapper
    $html .= '<div class="dtoc-sliding-sticky-inner">' . "\n";

    if ( ! empty( $options['display_title'] ) ) {
        $t_style = dtoc_get_title_style( $options );        
        $html .= '<span class="dtoc-sliding-sticky-title-str" style="'.$t_style.'">'. esc_html( $options['header_text'] ) .'</span>' . "\n";                
    }

    $html .= dtoc_get_custom_style( $options );
    $html .= dtoc_get_toc_link_style( $options, 'sliding_sticky' );       

    $html .= '<div class="dtoc-sliding-sticky-box-body dtoc-sliding-sticky-box-on-css-body">' . "\n";
    $html .= dtoc_get_plain_toc_html( $matches, $options );    
    $html .= '</div>' . "\n"; // close body

    $html .= '</div>' . "\n"; // close inner
    $html .= '</div>' . "\n"; // close container

    return $html;
}


function dtoc_sliding_sticky_box_on_js( $matches, $options = [] ) {

	$dbc_style = dtoc_box_container_style( $options );

	// Initial state (show/hide)
	$initial_state = ! empty( $options['toggle_initial'] ) ? $options['toggle_initial'] : 'hide';
	$initial_class = ( $initial_state === 'show' ) ? ' dtoc-open' : ' dtoc-closed';

	// Detect if left or right positioned
	$is_left = strpos( $options['display_position'], 'left' ) !== false;

	// Safe offset to avoid flicker (about 300px, adjust if needed)
	if ( $initial_state === 'show' ) {
		$dbc_style .= $is_left ? 'left:0;' : 'right:0;';
	} else {
		$dbc_style .= $is_left ? 'left:-300px;visibility:hidden;' : 'right:-300px;visibility:hidden;';
	}

	$html  = '<div class="dtoc-sliding-sticky-container dtoc-' . esc_attr( $options['display_position'] ) . $initial_class . '" style="' . esc_attr( $dbc_style ) . '">' . "\n";

	// Toggle button
	$t_style = dtoc_get_toggle_btn_style( $options );
	$html .= '<button type="button" class="dtoc-sliding-sticky-toggle-btn" style="' . esc_attr( $t_style ) . '">' . esc_html( $options['toggle_btn_text'] ) . '</button>' . "\n";

	// Scrollable inner wrapper
	$html .= '<div class="dtoc-sliding-sticky-inner">' . "\n";

	if ( ! empty( $options['display_title'] ) ) {
		$t_style = dtoc_get_title_style( $options );
		$html   .= '<span class="dtoc-sliding-sticky-title-str" style="' . esc_attr( $t_style ) . '">' . esc_html( $options['header_text'] ) . '</span>' . "\n";
	}

	$html .= dtoc_get_custom_style( $options );
	$html .= dtoc_get_toc_link_style( $options, 'sliding_sticky' );

	$html .= '<div class="dtoc-sliding-sticky-box-body dtoc-sliding-sticky-box-on-js-body">' . "\n";
	$html .= dtoc_get_plain_toc_html( $matches, $options );
	$html .= '</div>' . "\n"; // close body

	$html .= '</div>' . "\n"; // close inner
	$html .= '</div>' . "\n"; // close container

	return $html;
}