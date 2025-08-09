<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'dtoc_init_shortcode' );
add_filter( 'strip_shortcodes_tagnames', 'dtoc_strip_shortcode_tag', 10, 2 );

function dtoc_init_shortcode() {
	add_shortcode( 'digital_toc', 'dtoc_shortcode_callback' );    
}


function dtoc_shortcode_callback( $attr , $tag_content, $tag ) {
            
    global $dtoc_shortcode;    
    $options = [];
    if ( ! is_array( $attr ) ) {
        $attr = [];
    }

    $options = array_merge( $dtoc_shortcode, $attr );
        
    $post_id = isset( $options['post_id'] ) ? $options['post_id'] : get_the_ID();

    $content = get_post_field( 'post_content', $post_id );        
    
    $content = strip_shortcodes( $content );    

    $matches     = dtoc_filter_heading( $content, $options );    

    $dtocbox = '';
    
    if ( ! empty( $matches ) && $options['rendering_style'] == 'css' ) {
        $dtocbox     = dtoc_box_on_css( $matches, $options );
    }else{
        $dtocbox     = dtoc_box_on_js( $matches, $options );
    }    
    
    return $dtocbox;
}

function dtoc_strip_shortcode_tag( $tags_to_remove, $content ) {
    
    $tags_to_remove = array(
        'digital_toc'        
    );
    
    return apply_filters( 'dtoc_tags_to_be_removed_filter', $tags_to_remove );
}

add_filter( 'the_content', 'dtoc_in_content_add_jumb_callback' );

function dtoc_in_content_add_jumb_callback( $content ) {
    
    if ( is_singular() && in_the_loop() && is_main_query() ) {
        
        if ( strpos( $content, '[digital_toc' ) === false ) {
            return $content;
        }

        global $dtoc_shortcode;
        $options = $dtoc_shortcode;

        if ( ! empty( $options ) ) {
            
            $matches     = dtoc_filter_heading( $content, $options );
                     
            if ( ! empty( $matches ) ) {

                $headings    = dtoc_get_headings( $matches );
                                
                if ( count( $headings ) ) {

                    if ( ! empty( $options['jump_links'] ) ) {

                        $anchors     = dtoc_get_headings_with_anchors( $matches );                        
                        $content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
    
                    }                           

                }				
                
            }
        }                    
                
    }    

    return $content;    
}