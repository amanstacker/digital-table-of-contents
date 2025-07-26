<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function dtoc_box_on_css( $matches , $options = [] ) {

    $html = '<div class="dtoc-box-container">';    

    if ( isset( $options['display_title'] ) ) {

        if ( isset( $options['toggle_body'] ) ) {

            if ( $options['toggle_initial'] == 'show' ) {
                $html .= '<input type="checkbox" id="dtoc-toggle-check" checked>'; 
            }else{
                $html .= '<input type="checkbox" id="dtoc-toggle-check">'; 
            }
            
        }

        $html .= '<label for="dtoc-toggle-check" class="dtoc-toggle-label">';
        $html .= '<span>'.esc_html( $options['header_text'] ).'</span>';
        $html .= dtoc_get_header_icon( $options );
        $html .= '</label>';    

        
        
    }
           
    $html .= '<div class="dtoc-box-on-css-body">';

    $html .= dtoc_get_plain_toc_html( $matches, $options );
    
    $html .= '</div>';
    
    $html .= '</div>';

    return $html;
}

function dtoc_box_hierarchy_heading_list($matches, $options = []){
			$html               = '';            
            $current_depth      = 100;    // headings can't be larger than h6 but 100 as a default to be sure
			$numbered_items     = [];
			$numbered_items_min = null;

			// find the minimum heading to establish our baseline
			foreach ( $matches as $i => $match ) {
				if ( $current_depth > $matches[ $i ][2] ) {
					$current_depth = (int) $matches[ $i ][2];
				}
			}

			$numbered_items[ $current_depth ] = 0;
			$numbered_items_min               = $current_depth;

			foreach ( $matches as $i => $match ) {

				$level = $matches[ $i ][2];
				$count = $i + 1;

				if ( $current_depth == (int) $matches[ $i ][2] ) {

					$html .= "<li class='dtoc-page-" . $matches[ $i ]['page'] . " dtoc-heading-level-" . $current_depth . "'>";
				}

				// start lists
				if ( $current_depth != (int) $matches[ $i ][2] ) {

					for ( $current_depth; $current_depth < (int) $matches[ $i ][2]; $current_depth++ ) {

						$numbered_items[ $current_depth + 1 ] = 0;
						$html .= "<ul class='dtoc-list-level-" . $level . "'><li class='dtoc-heading-level-" . $level . "'>";
					}
				}

				$title = isset( $matches[ $i ]['alternate'] ) ? $matches[ $i ]['alternate'] : $matches[ $i ][0];
				$title = strip_tags( $title );
				if(isset($options['jump_links'])){
					$html .= sprintf(
							 '<a class="dtoc-link dtoc-heading-' . $count . '" href="%1$s" title="%2$s">%3$s</a>',
								esc_attr( trailingslashit( get_permalink() )  . ($matches[ $i ]['page'] > 1 ? $matches[ $i ]['page'] : '') . '#' . $matches[ $i ]['id'] ),
								esc_attr( strip_tags( $title ) ),
								$title
					);
				}else{
					
					$html .= $title;
				
				}
				
				// end lists
				if ( $i != count( $matches ) - 1 ) {

					if ( $current_depth > (int) $matches[ $i + 1 ][2] ) {

						for ( $current_depth; $current_depth > (int) $matches[ $i + 1 ][2]; $current_depth-- ) {

							$html .= '</li></ul>';
							$numbered_items[ $current_depth ] = 0;
						}
					}

					if ( $current_depth == (int) @$matches[ $i + 1 ][2] ) {

						$html .= '</li>';
					}

				} else {

					// this is the last item, make sure we close off all tags
					for ( $current_depth; $current_depth >= $numbered_items_min; $current_depth-- ) {

						$html .= '</li>';

						if ( $current_depth != $numbered_items_min ) {
							$html .= '</ul>';
						}
					}
				}
			}
            return $html;
}
function dtoc_box_heading_list($matches, $options = []){
    $html = '';
    $dtoc_current_permalink = trailingslashit( get_permalink() );
    foreach ( $matches as $i => $match ) {

        $count = $i + 1;

        $title = isset( $matches[ $i ]['alternate'] ) ? $matches[ $i ]['alternate'] : $matches[ $i ][0];
        $title = strip_tags( $title );

        $html .= "<li>";
		
		if(isset($options['jump_links'])){
			$html .= sprintf(
					'<a class="dtoc-link dtoc-heading-' . $count . '" href="%1$s" title="%2$s">%3$s</a>',
					esc_attr( $dtoc_current_permalink  . ($matches[ $i ]['page'] > 1 ? $matches[ $i ]['page'] : '') . '#' . $matches[ $i ]['id'] ),
					esc_attr( strip_tags( $title ) ),
					$title
			);		
		}else{
			$html .= $title;
		}        
        $html .= '</li>';
    }

    return $html;
}
function dtoc_get_plain_toc_html($matches, $options){
    $html = '';
    $html .= '<ul>';    
    if(isset($options['hierarchy'])){        
        $html .= dtoc_box_hierarchy_heading_list($matches , $options);
    }else{
        $html .= dtoc_box_heading_list($matches, $options);
    }    
    $html .= '</ul>';
    return $html;
}
function dtoc_box_on_js($matches, $options = []){
    
    $c_style = '';
    if(isset($options['border_type'])){
        $c_style .= 'border:'.esc_attr($options['border_type']).';';
    }
    if(isset($options['border_color'])){
        $c_style .= 'border-color:'.esc_attr($options['border_color']).';';
    }
    if(isset($options['border_radius_top_left'])){
        $c_style .= 'border-top-left-radius:'.esc_attr($options['border_radius_top_left']).esc_attr($options['border_radius_unit']).';';
    }
    if(isset($options['border_radius_top_right'])){
        $c_style .= 'border-top-right-radius:'.esc_attr($options['border_radius_top_right']).esc_attr($options['border_radius_unit']).';';
    }
    if(isset($options['border_radius_bottom_left'])){
        $c_style .= 'border-bottom-left-radius:'.esc_attr($options['border_radius_bottom_left']).esc_attr($options['border_radius_unit']).';';
    }
    if(isset($options['border_radius_bottom_right'])){
        $c_style .= 'border-bottom-right-radius:'.esc_attr($options['border_radius_bottom_right']).esc_attr($options['border_radius_unit']).';';
    }
    
    if(isset($options['border_width_top'])){
        $c_style .= 'border-top-width:'.esc_attr($options['border_width_top']).esc_attr($options['border_width_unit']).';';
    }
    if(isset($options['border_width_right'])){
        $c_style .= 'border-right-width:'.esc_attr($options['border_width_right']).esc_attr($options['border_width_unit']).';';
    }
    if(isset($options['border_width_bottom'])){
        $c_style .= 'border-bottom-width:'.esc_attr($options['border_width_bottom']).esc_attr($options['border_width_unit']).';';
    }
    if(isset($options['border_width_left'])){
        $c_style .= 'border-left-width:'.esc_attr($options['border_width_left']).esc_attr($options['border_width_unit']).';';
    }
    $html = '<div class="dtoc-box-container" style="'.$c_style.'">';

    if(isset($options['display_title'])){
        $heading_text = $t_style = '';        
        if(isset($options['title_bg_color'])){
            $t_style .= 'background:'.esc_attr($options['title_bg_color']).';';
        }
        if(isset($options['title_color'])){
            $t_style .= 'color:'.esc_attr($options['title_color']).';';
        }
        
        if ( isset( $options['header_text'] ) && $options['header_text'] === 'Table Of Contents' ){
            $heading_text = esc_html__( 'Table Of Contents', 'digital-table-of-contents' );
        }else{
            $heading_text = esc_html( $options['header_text'] );
        }

        $html .= '<div class="dtoc-box-header-container" style="'.$t_style.'">';
        $html .= '<div class="dtoc-toggle-label">'.$heading_text.'';
        $html .= dtoc_get_header_icon( $options );
        $html .= '</div>';
        $html .= '</div>';
    }
    $b_style = '';
    if(isset($options['bg_color'])){
        $b_style .= 'background:'.esc_attr($options['bg_color']).';';
    }
    $html .= '<div class="dtoc-box-on-js-body" style="'.$b_style.'">';
    $html .= dtoc_get_plain_toc_html($matches, $options);
    $html .= '</div>';
    
    $html .= '</div>';

    return $html;
}

function dtoc_add_jumb_ids( $headings, $anchors, $content ) {

	if ( is_array( $headings ) && is_array( $anchors ) && $content ) {		
        $content = str_replace($headings, $anchors, $content);		
	}
	return $content;
}

function dtoc_get_headings_with_anchors( $matches ) {

    $headings = [];        
                    
        foreach ( $matches as $i => $match ) {

            $anchor     = $matches[ $i ]['id'];            
            $headings[] = str_replace(
                array(
                    $matches[ $i ][1],
                    '</h' . $matches[ $i ][2] . '>'
                ),
                array(
                    '><span class="dtoc-section" id="' . esc_attr($anchor) . '"></span>',
                    '<span class="dtoc-section-end"></span></h' . esc_attr($matches[ $i ][2]) . '>'
                ),
                $matches[ $i ][0]
            );
        }
    
    return $headings;
}

function dtoc_get_headings( $matches ) {

    $headings = [];
                
        foreach ( $matches as $i => $match ) {

            $headings[] = str_replace(
                array(
                    $matches[ $i ][1],        
                    '</h' . $matches[ $i ][2] . '>'
                ),
                array(
                    '>',
                    '</h' . $matches[ $i ][2] . '>'
                ),
                $matches[ $i ][0]
            );
        }    
    return $headings;
}

function dtoc_generate_Heading_id( $heading ) {
    
    $response_id = false;

    if ( $heading ) {
                
        $response_id = html_entity_decode( $heading, ENT_QUOTES, get_option( 'blog_charset' ) );        
        $response_id = preg_replace( '`<br[/\s]*>`i', '', $response_id );        
        $response_id = trim( wp_strip_all_tags( $response_id ) );                
        $response_id = remove_accents( $response_id );        
        $response_id = str_replace( array( "\r", "\n", "\n\r", "\r\n" ), ' ', $response_id );        
        $response_id = htmlentities2( $response_id );
        $response_id = str_replace( array( '&shy;', '&amp;', '&nbsp;'), ' ', $response_id );        
        $response_id = preg_replace( '/[\x00-\x1F\x7F]*/u', '', $response_id );                
        $response_id = str_replace(array( '*', '\'', '(', ')', ';', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', '%', '{', '}', '|', '\\', '^', '~', '[', ']', '`', '$', '.', '+', '!', '*', '\'', '(', ')', ',', 'â€˜', 'â€™', 'â€œ', 'â€' ),'', $response_id );                
        $response_id = str_replace( array( ':', '-', '-', 'â€“', 'â€”' ), '-', $response_id );        
                        
        $response_id = preg_replace( '/\s+/', '_', $response_id );        
        $response_id = preg_replace( '/-+/', '-', $response_id );        
        $response_id = preg_replace( '/_+/', '_', $response_id );        
        $response_id = rtrim( $response_id, '-_' );        

        $response_id = preg_replace_callback(
            "{[^0-9a-z_.!~*'();,/?:@&=+$#-]}i",
            function( $m ) {
                return sprintf( '%%%02X', ord( $m[0] ) );
            },
            $response_id
        );
        
    }    
    
    return $response_id;
}

function dtoc_heading_ids( $matches ) {
        
    foreach ( $matches as $i => $match ) {

        $matches[ $i ]['id'] = dtoc_generate_Heading_id( $matches[ $i ][0] );
    }    
    return $matches;
}


function dtoc_remove_empty_headings( $matches ) {
    $new_matches = [];        
    foreach ( $matches as $i => $match ) {

        if ( trim( strip_tags( $matches[ $i ][0] ) ) != false ) {

            $new_matches[ $i ] = $matches[ $i ];
        }
    }        
    return $new_matches;
}

function dtoc_next_page( $matches, $page ){
	
    foreach ( $matches as $i => $match ) {
        $matches[ $i ][ 'page' ] = $page;
    }
    
    return $matches;
}

function dtoc_filter_headings_by_content( $content, $page, $type, $options ) { 

    $matches = [];
    $regex = apply_filters( "dtoc_regex_filter_{$type}", '/(<h([1-6]{1})[^>]*>)(.*)<\/h\2>/msuU' );

    if ( preg_match_all( $regex, $content, $matches, PREG_SET_ORDER ) ) {
                
            if ( ! empty( $options['headings_include'] ) && count( $options['headings_include'] ) != 6 ) {
                
                $new_matches = [];
                $heading_inc = array_keys( $options['headings_include'] );

                foreach ( $matches as $i => $match ) {

                    if ( in_array( $matches[ $i ][2], $heading_inc ) ) {

                        $new_matches[ $i ] = $matches[ $i ];
                    }
                }

	    		$matches = $new_matches;

            }

            $minimum = 1;
            
            if ( isset( $options['display_when'] ) ) {
                $minimum = $options['display_when'];
            }
                                         
            if ( count( $matches ) >= $minimum ) {
                
                $matches = dtoc_heading_ids( $matches );
                $matches = dtoc_next_page( $matches, $page );                

            } else {

                return [];
            }

        }
        
        return array_values( $matches ); 

}

function dtoc_filter_heading( $content, $options = [] ) {

    global $post,$page;
    
    $response = [];
	$type = isset($options['type']) ? $options['type'] : 'incontent';
    if( is_object($post) && strpos( $post->post_content, '<!--nextpage-->' ) !== false){

        $splited_content = preg_split( '/<!--nextpage-->/msuU', $post->post_content );
        if ( is_array( $splited_content ) ) {

            $post_page = 1;
			foreach ( $splited_content as $sp_content ) {
				$result = [];
				 if(isset($options['combine_page_break'])){
					$result = dtoc_filter_headings_by_content( $sp_content, $post_page, $type, $options );
					 if($result){
						$response = array_merge($response, $result);
					 }
					 
				 }else{
					 if($page == $post_page){
						$result = dtoc_filter_headings_by_content( $sp_content, $post_page, $type, $options );
						 if($result){
							$response = array_merge($response, $result);
						 }
					}  
				 }
                
				$post_page++;
			}

		}

    }else{
        $response = dtoc_filter_headings_by_content( $content, 1, $type, $options );				
    }
    
    return $response;
}
function dtoc_get_header_icon( $options ) {

    if ( $options['header_icon'] == 'none') {
        return '';
    }

    $icon_html = '';

    $c_style = '';
    if(isset($options['icon_border_type'])){
        $c_style .= 'border:'.esc_attr($options['icon_border_type']).';';
    }
    if(isset($options['icon_border_color'])){
        $c_style .= 'border-color:'.esc_attr($options['icon_border_color']).';';
    }
    if(isset($options['icon_border_radius_top_left'])){
        $c_style .= 'border-top-left-radius:'.esc_attr($options['icon_border_radius_top_left']).esc_attr($options['icon_border_radius_unit']).';';
    }
    if(isset($options['icon_border_radius_top_right'])){
        $c_style .= 'border-top-right-radius:'.esc_attr($options['icon_border_radius_top_right']).esc_attr($options['icon_border_radius_unit']).';';
    }
    if(isset($options['icon_border_radius_bottom_left'])){
        $c_style .= 'border-bottom-left-radius:'.esc_attr($options['icon_border_radius_bottom_left']).esc_attr($options['icon_border_radius_unit']).';';
    }
    if(isset($options['icon_border_radius_bottom_right'])){
        $c_style .= 'border-bottom-right-radius:'.esc_attr($options['icon_border_radius_bottom_right']).esc_attr($options['icon_border_radius_unit']).';';
    }
    
    if(isset($options['icon_border_width_top'])){
        $c_style .= 'border-top-width:'.esc_attr($options['icon_border_width_top']).esc_attr($options['icon_border_width_unit']).';';
    }
    if(isset($options['icon_border_width_right'])){
        $c_style .= 'border-right-width:'.esc_attr($options['icon_border_width_right']).esc_attr($options['icon_border_width_unit']).';';
    }
    if(isset($options['icon_border_width_bottom'])){
        $c_style .= 'border-bottom-width:'.esc_attr($options['icon_border_width_bottom']).esc_attr($options['icon_border_width_unit']).';';
    }
    if(isset($options['icon_border_width_left'])){
        $c_style .= 'border-left-width:'.esc_attr($options['icon_border_width_left']).esc_attr($options['icon_border_width_unit']).';';
    }

    if(isset($options['icon_margin_top'])){
        $c_style .= 'margin-top:'.esc_attr($options['icon_margin_top']).esc_attr($options['icon_margin_unit']).';';
    }
    if(isset($options['icon_margin_right'])){
        $c_style .= 'margin-right:'.esc_attr($options['icon_margin_right']).esc_attr($options['icon_margin_unit']).';';
    }
    if(isset($options['icon_margin_bottom'])){
        $c_style .= 'margin-bottom:'.esc_attr($options['icon_margin_bottom']).esc_attr($options['icon_margin_unit']).';';
    }
    if(isset($options['icon_margin_left'])){
        $c_style .= 'margin-left:'.esc_attr($options['icon_margin_left']).esc_attr($options['icon_margin_unit']).';';
    }

    if(isset($options['icon_margin_top'])){
        $c_style .= 'margin-top:'.esc_attr($options['icon_margin_top']).esc_attr($options['icon_margin_unit']).';';
    }
    if(isset($options['icon_margin_right'])){
        $c_style .= 'margin-right:'.esc_attr($options['icon_margin_right']).esc_attr($options['icon_margin_unit']).';';
    }
    if(isset($options['icon_margin_bottom'])){
        $c_style .= 'margin-bottom:'.esc_attr($options['icon_margin_bottom']).esc_attr($options['icon_margin_unit']).';';
    }
    if(isset($options['icon_margin_left'])){
        $c_style .= 'margin-left:'.esc_attr($options['icon_margin_left']).esc_attr($options['icon_margin_unit']).';';
    }

    if(isset($options['icon_padding_top'])){
        $c_style .= 'padding-top:'.esc_attr($options['icon_padding_top']).esc_attr($options['icon_padding_unit']).';';
    }
    if(isset($options['icon_padding_right'])){
        $c_style .= 'padding-right:'.esc_attr($options['icon_padding_right']).esc_attr($options['icon_padding_unit']).';';
    }
    if(isset($options['icon_padding_bottom'])){
        $c_style .= 'padding-bottom:'.esc_attr($options['icon_padding_bottom']).esc_attr($options['icon_padding_unit']).';';
    }
    if(isset($options['icon_padding_left'])){
        $c_style .= 'padding-left:'.esc_attr($options['icon_padding_left']).esc_attr($options['icon_padding_unit']).';';
    }
    
    if(empty($options['header_icon'])){
        $options['header_icon'] ="";
    }
    switch ($options['header_icon']) {
        case 'list_icon':
            
            $icon_html = '<span class="dtoc_icon_toggle"><svg style="'.$c_style.'" height="'.esc_attr($options['icon_height']).'" width="'.esc_attr($options['icon_height']).'" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" fill="none">
  
  <rect x="1" y="1" width="46" height="46" rx="4" stroke="#aaa" fill="'.esc_attr($options['icon_bg_color']).'"/>

  <!-- List bullets and lines -->
  <circle cx="10" cy="14" r="1.5" fill="'.esc_attr($options['icon_fg_color']).'"/>
  <rect x="14" y="13" width="14" height="2" rx="1" fill="'.esc_attr($options['icon_fg_color']).'"/>

  <circle cx="10" cy="24" r="1.5" fill="'.esc_attr($options['icon_fg_color']).'"/>
  <rect x="14" y="23" width="14" height="2" rx="1" fill="'.esc_attr($options['icon_fg_color']).'"/>

  <circle cx="10" cy="34" r="1.5" fill="'.esc_attr($options['icon_fg_color']).'"/>
  <rect x="14" y="33" width="14" height="2" rx="1" fill="'.esc_attr($options['icon_fg_color']).'"/>

  <!-- Arrows -->
  <path d="M36 18L32 22H40L36 18Z" fill="'.esc_attr($options['icon_fg_color']).'"/>
  <path d="M36 30L40 26H32L36 30Z" fill="'.esc_attr($options['icon_fg_color']).'"/>
</svg></span>
';
            break;        
        case 'plus_minus':
            $icon_html = '<span class="dtoc_icon_toggle">
            <span class="dtoc_icon_brackets">[</span>
            <span class="dtoc-show-text dtoc-plus">+</span>
            <span class="dtoc-hide-text dtoc-minus">-</span>
            <span class="dtoc_icon_brackets">]</span>
            </span>';        
            break;        
        case 'show_hide':
            $icon_html = '<span class="dtoc_icon_toggle">
            <span class="dtoc_icon_brackets">[</span>
            <span class="dtoc-show-text">'.esc_html( $options['show_text'] ).'</span>
            <span class="dtoc-hide-text">'.esc_html( $options['hide_text'] ).'</span>
            <span class="dtoc_icon_brackets">]</span>
            </span>';        
            break;        
        case 'custom_icon':
            $icon_html = '<span style="'.$c_style.'" class="dtoc_icon_toggle"><img src="'.esc_url( $options['custom_icon_url'] ).'" /></span>';        
            break;
        
        default:
            # code...
            break;
    }
    
    return $icon_html;
}