<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'the_content', 'dtoc_floating_callback' );

function dtoc_floating_callback( $content ) {

    global $dtoc_dashboard;
    
    if ( empty( $dtoc_dashboard['modules']['floating'] ) ) {
        return $content;
    }

    if ( is_singular() && in_the_loop() && is_main_query() ) {

        $options = dtoc_get_options_by_device( 'floating' );        

        if ( ! empty( $options ) && dtoc_placement_condition_matched( $options ) ) {
            
            $matches     = dtoc_filter_heading( $content, $options );
                     
            if ( ! empty( $matches ) ) {

                $headings    = dtoc_get_headings( $matches );
                                
                if ( count( $headings ) ) {

                    if ( ! empty( $options['jump_links']) ) {

                        $anchors     = dtoc_get_headings_with_anchors( $matches );                        
                        $content     = dtoc_add_jumb_ids( $headings, $anchors, $content ); 
    
                    }   
    
                    $content     = $content.dtoc_floating_box( $matches, $options );

                }				
                
            }
        }                    
                
    }    

    return $content;    
}

function dtoc_floating_box( $matches, $options = [] ) {
    
    $dbc_style = dtoc_box_container_style( $options );
    $html = '<div class="dtoc-floating-box-container" style="'.$dbc_style.'">';
    
    if ( ! empty( $options['display_title'] ) ) {

        $heading_text = '';                        
        if ( isset( $options['header_text'] ) && $options['header_text'] === 'Table of Contents' ) {
            $heading_text = '<span class="dtoc-floating-title-str">'.esc_html__( 'Table of Contents', 'digital-table-of-contents' ).'</span>';
        }else{
            $heading_text = '<span class="dtoc-floating-title-str">'.esc_html( $options['header_text'] ).'</span>';
        }

        $t_style = dtoc_get_title_style( $options );        
        $html .= '<div class="dtoc-floating-toggle-label" style="'.$t_style.'">';
        $html .= '<span class="dtoc-floating-left-grp">';
        $html .= '<span class="dtoc-floating-drag-icon" aria-hidden="true"></span>';
        $html .= $heading_text;
        $html .= '</span>';
        $html .= dtoc_get_header_icon( $options );
        $html .= '</div>';        
    }
    $html .= dtoc_get_custom_style( $options );
    $html .= dtoc_get_toc_link_style( $options, 'incontent' );
    $html .= '<div class="dtoc-floating-box-body">';
    $html .= dtoc_get_plain_toc_html( $matches, $options );
    $html .= '</div>';
    
    $html .= '</div>';

    return $html;
}
 
 add_filter('dtoc_regex_filter_incontent','dtoc_regex_heading_include_floating',10,1);

 function dtoc_regex_heading_include_floating( $regex ) {

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