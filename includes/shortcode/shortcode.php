<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'dtoc_init_shortcode' );
add_filter( 'strip_shortcodes_tagnames', 'dtoc_strip_shortcode_tag', 10, 2 );

function dtoc_init_shortcode() {
	add_shortcode('advanced-toc', 'dtoc_shortcode_callback');    
}


function dtoc_shortcode_callback($atts, $tag_content, $tag){
    global $dtoc_advanced_options;
    $dtoc_advanced_options['rendering_style'] = 'js';    
    $post_id = isset($atts['post_id']) ? $atts['post_id'] : get_the_ID();

    $content = get_post_field('post_content', $post_id);    
    
    $content = strip_shortcodes($content);    
    if(function_exists('do_blocks')){
        $content = do_blocks($content);
    }

    $matches     = dtoc_filter_heading($content);    

    $dtocbox = '';
    
    if(!empty($matches) && !empty($dtoc_advanced_options['rendering_style']) && $dtoc_advanced_options['rendering_style'] == 'css'){
        $dtocbox     = dtoc_box_on_css($matches,$dtoc_advanced_options);
    }else{
        $dtocbox     = dtoc_box_on_js($matches,$dtoc_advanced_options);
    }    
    
    return $dtocbox;
}

function dtoc_strip_shortcode_tag($tags_to_remove, $content){
    $tags_to_remove = array(
        'advanced-toc'        
    );
    return apply_filters( 'dtoc_tags_to_be_removed_filter', $tags_to_remove);
}