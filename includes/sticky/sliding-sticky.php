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