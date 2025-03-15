<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'the_content', 'dtoc_floating_content_callback');

function dtoc_floating_content_callback($content){
    
    if ( is_singular() && in_the_loop() && is_main_query() ) {

        global $dtoc_floating, $dtoc_dashboard;
            
        if(isset($dtoc_dashboard['modules']['floating']) && $dtoc_dashboard['modules']['floating'] == 1 && dtoc_placement_condition_matched($dtoc_floating)){
            $matches     = dtoc_filter_heading($content,$dtoc_floating);
                     
            if(!empty($matches)){
                $html        = '';   
                $headings    = dtoc_get_headings($matches); 				
				if(isset($dtoc_floating['jump_links']) && $dtoc_floating['jump_links'] == true){                    
					$anchors     = dtoc_get_headings_with_anchors($matches);
					$content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
				}
                $html .= '<div class="dtoc-floating-container">';
                $html .= '<div class="dtoc-floating-body">';
                $html .= dtoc_get_plain_toc_html($matches , $dtoc_floating);
                $html .= '</div>';
                $html .= '</div>';

                $content = $content.$html;   
            }            
        }                    
                
    }    

    return $content;    
}