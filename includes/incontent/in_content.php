<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'the_content', 'dtoc_in_content_callback' );

function dtoc_in_content_callback( $content ) {

    if ( is_singular() && in_the_loop() && is_main_query() ) {

        $options = dtoc_get_options_by_device( 'incontent' );        

        if ( ! empty( $options ) && dtoc_placement_condition_matched( $options ) ) {

            $matches     = dtoc_filter_heading( $content, $options );            
                     
            if ( ! empty( $matches ) ) {

                $headings    = dtoc_get_headings( $matches );
                                
                if ( count( $headings ) ) {

                    if ( isset( $options['jump_links']) && $options['jump_links'] == true ) {

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

function dtoc_position_inside_content( $content, $matches, $options ) {
        
        if ( ! empty( $options['loading_type'] ) && $options['loading_type'] == 'css' ) {
            
            $dtocbox     = dtoc_box_on_css($matches,$options);
        }else{
            
            $dtocbox     = dtoc_box_on_js($matches,$options);
        }
        
        $display_position = 'top_of_the_content';

        if ( ! empty( $options['display_position'] ) ) {
            $display_position = $options['display_position'];
        }

        switch ( $display_position ) {

            case 'before_first_heading':                
                $content = preg_replace('/(<h[1-6][^>]*>.*?<\/h[1-6]>)/i', $dtocbox . '$1', $content, 1);                
                break;
            case 'after_first_heading':
                $content = preg_replace('/(<h[1-6][^>]*>.*?<\/h[1-6]>)/i', '$1' . $dtocbox, $content, 1);
                break;
            case 'top_of_the_content':
                $content = $dtocbox.$content;
                break;
            case 'bottom_of_the_content':
                $content = $content.$dtocbox;
                break;            
            case 'after_paragraph_number':
                $after_paragraph = 1;
                if ( ! empty( $options['paragraph_number'] ) ) {
                    $after_paragraph = $options['paragraph_number']; 
                }
                
                $closing_p        = '</p>';
                
                if ( strpos( $content, $closing_p ) !== false ) {
                    $paragraphs = explode( $closing_p, $content );
            
                    foreach ( $paragraphs as $index => $paragraph ) {
                        if ( trim( $paragraph ) ) {
                            $paragraphs[$index] .= $closing_p;
                        }
                        if ( $after_paragraph == $index + 1 ) {
                            $paragraphs[$index] .= $dtocbox;
                            break; // Insert once and exit loop
                        }
                    }
            
                    $content = implode( '', $paragraphs );
                }
            
                break;
                            
            default:
                $content = $dtocbox.$content;
                break;
        }
        
    return $content;

}

 
 add_filter('dtoc_regex_filter_incontent','dtoc_regex_heading_include',10,1);

 function dtoc_regex_heading_include( $regex ) {

	global $dtoc_dashboard, $dtoc_incontent, $dtoc_incontent_mobile, $dtoc_incontent_tablet;
    $options     = $dtoc_incontent;
	$device_type = dtoc_get_device_type();
	
	 switch ($device_type) {
		 
                case 'mobile':
				$options = $dtoc_incontent_mobile;
				break;
				
				case 'tablet':
				$options = $dtoc_incontent_tablet;
				break;
				
				default:
				break;
				
	 }
	if(!empty($options['headings_include']))
	{
		$allowed_heading = array_keys($options['headings_include']);
		$allowed_heading = is_array($allowed_heading)?implode(',',$allowed_heading):null;
		
		if($allowed_heading){
			
			return '/(<h(['.esc_attr($allowed_heading).']{1})[^>]*>)(.*)<\/h\2>/msuU';
		}
	}
	return $regex;
 }
 
 add_action('wp_footer','dtoc_scroll_backto_toc');
 function dtoc_scroll_backto_toc(){
	global $dtoc_incontent;
	if(isset($dtoc_incontent['scroll_back_to_top']) && isset($dtoc_incontent['loading_type'])){
		
		if($dtoc_incontent['loading_type'] == 'js'){
			echo ' <a href="" class="dtoc-btn dtoc-backtotoc" title="Go to Table of contents">'.esc_html__('TOC','digital-table-of-contents').'</a>';
			
		}else{
			echo ' <button class="dtoc-btn dtoc-backtotoc" title="Go to Table of contents">'.esc_html__('TOC','digital-table-of-contents').'</button>';
		}
		
		
	}
	 
 }