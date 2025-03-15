<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'the_content', 'dtoc_sticky_content_callback');

function dtoc_sticky_content_callback($content){
    
    if ( is_singular() && in_the_loop() && is_main_query() ) {

        global $dtoc_dashboard;
		
		$dtoc_sticky = dtoc_get_options_by_device('sticky');
            
        if(isset($dtoc_dashboard['modules']['sticky']) && $dtoc_dashboard['modules']['sticky'] == 1 && dtoc_placement_condition_matched($dtoc_sticky)){
            $matches     = dtoc_filter_heading($content,$dtoc_sticky);
                error_log(print_r($matches,true));
            if(!empty($matches)){
                $html        = '';   
                $headings    = dtoc_get_headings($matches); 
				error_log(print_r($headings,true));				
				if(isset($dtoc_sticky['jump_links']) && $dtoc_sticky['jump_links'] == true){                    
					$anchors     = dtoc_get_headings_with_anchors($matches);
					$content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
				}
                $style = 'position:fixed;top:0;margin:auto;';
                if(isset($dtoc_sticky['position']) && ($dtoc_sticky['position'] == 'right_top' || $dtoc_sticky['position'] == 'right_middle' || $dtoc_sticky['position'] == 'right_bottom')){
                    $style .= 'right:0;';
                }else{
                    $style .= 'left:0;';
                }
                if(isset($dtoc_sticky['bg_color'])){
                    $style .= 'background:'.esc_attr($dtoc_sticky['bg_color']).';';
                }
                if(isset($dtoc_sticky['border_color'])){
                    $style .= 'border-right:1px solid '.esc_attr($dtoc_sticky['border_color']).';';
                }                
                       
                $html .= '<div class="dtoc-sticky-container" style="'.$style.'">';
                $html .= '<div class="dtoc-sticky-body">';
                $html .= dtoc_get_plain_toc_html($matches , $dtoc_sticky);
                $html .= '</div>';
                $html .= '</div>';

                $content = $content.$html;   
            }            
        }                    
                
    }    

    return $content;    
}

add_filter('dtoc_regex_filter_sticky','dtoc_regex_heading_include_sticky',10,1);
 function dtoc_regex_heading_include_sticky($regex){
	global $dtoc_dashboard, $dtoc_sticky, $dtoc_sticky_mobile, $dtoc_sticky_tablet;
    $options     = $dtoc_sticky;
	$device_type = dtoc_get_device_type();
	
	 switch ($device_type) {
		 
                case 'mobile':
				$options = $dtoc_sticky_mobile;
				break;
				
				case 'tablet':
				$options = $dtoc_sticky_tablet;
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