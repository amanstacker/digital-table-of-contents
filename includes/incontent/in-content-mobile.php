<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'the_content', 'dtoc_in_content_mobile_callback' );

function dtoc_in_content_mobile_callback( $content ) {

    global $dtoc_dashboard;
    
    if ( empty( $dtoc_dashboard['modules']['incontent_mobile'] ) ) {
        return $content;
    }   

    if ( is_singular() && in_the_loop() && is_main_query() ) {

        $options = dtoc_get_options_by_device( 'incontent_mobile' );        

        if ( ! empty( $options ) && dtoc_placement_condition_matched( $options ) ) {
            
            $matches     = dtoc_filter_heading( $content, $options );
                     
            if ( ! empty( $matches ) ) {

                $headings    = dtoc_get_headings( $matches );
                                
                if ( count( $headings ) ) {

                    if ( ! empty( $options['jump_links']) ) {

                        $anchors     = dtoc_get_headings_with_anchors( $matches );                        
                        $content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
    
                    }   
                    
                    $content     = dtoc_position_inside_content( $content, $matches, $options );

                }				
                
            }
        }                    
                
    }    

    return $content;    
}