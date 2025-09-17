<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'the_content', 'dtoc_sliding_sticky_mobile_callback' );

function dtoc_sliding_sticky_mobile_callback( $content ) {
    
    global $dtoc_dashboard;
    
    if ( empty( $dtoc_dashboard['modules']['sliding_sticky_mobile'] ) ) {
        return $content;
    }

    if ( is_singular() && in_the_loop() && is_main_query() ) {
        
        $options = dtoc_get_options_by_device( 'sliding_sticky_mobile' );

        if ( ! empty( $options ) && dtoc_placement_condition_matched( $options ) ) {
            
            $matches     = dtoc_filter_heading( $content, $options );
       
            if ( ! empty( $matches ) ) {

                $headings    = dtoc_get_headings( $matches );
                                
                if ( count( $headings ) ) {

                    if ( ! empty( $options['jump_links']) ) {
                        
                        $anchors     = dtoc_get_headings_with_anchors( $matches );                        
                        $content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
    
                    }   
    
                    $content     = $content.dtoc_sliding_sticky_mobile_box( $matches,$options );

                }				
                
            }
        }                    
                
    }    

    return $content;    
}

function dtoc_sliding_sticky_mobile_box( $matches, $options = [] ) {
			
    $dbc_style = dtoc_box_container_style( $options );
    $html  = '<div class="dtoc-sliding-sticky-mobile-container dtoc-'.esc_attr( $options['display_position'] ).'" style="' . esc_attr( $dbc_style ) . '">';    
    
	$t_style = dtoc_get_title_style( $options );
	$html   .= '<div class="dtoc-sliding-sticky-mobile-header" style="' . esc_attr( $t_style ) . '">' . esc_html( $options['header_text'] ) . '</div>' . "\n";
	    
    $html .= dtoc_get_custom_style( $options );
	$html .= dtoc_get_toc_link_style( $options, 'sliding_sticky_mobile' );
    $html .= '<div class="dtoc-sliding-sticky-mobile-box-body">' . "\n";
	$html .= dtoc_get_plain_toc_html( $matches, $options );
	$html .= '</div>' . "\n"; // close body
    $html .= '</div>';

    return $html;

}