<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function dtoc_sticky_box_on_css( $matches , $options = [] ) {

    $dbc_style = dtoc_box_container_style( $options );

    $html  = '<input type="checkbox" id="dtoc-sticky-toggle">' . "\n";

    $html .= '<div class="dtoc-sticky-container dtoc-'. esc_attr( $options['display_position'] ) .'" style="'.$dbc_style.'">' . "\n";

    if ( ! empty( $options['toggle_body'] ) ) {
        $t_style = dtoc_get_toggle_btn_style( $options );
        $html .= '<label for="dtoc-sticky-toggle" class="dtoc-sticky-toggle-btn" style="'.$t_style.'">'. esc_html( $options['toggle_btn_text'] ) .'</label>' . "\n";    
    }

    // Scrollable inner wrapper
    $html .= '<div class="dtoc-sticky-inner">' . "\n";

    if ( ! empty( $options['display_title'] ) ) {
        $t_style = dtoc_get_title_style( $options );        
        $html .= '<span class="dtoc-sticky-title-str" style="'.$t_style.'">'. esc_html( $options['header_text'] ) .'</span>' . "\n";                
    }

    $html .= dtoc_get_custom_style( $options );
    $html .= dtoc_get_toc_link_style( $options, 'sticky' );       

    $html .= '<div class="dtoc-sticky-box-body dtoc-sticky-box-on-css-body">' . "\n";
    $html .= dtoc_get_plain_toc_html( $matches, $options );    
    $html .= '</div>' . "\n"; // close body

    $html .= '</div>' . "\n"; // close inner
    $html .= '</div>' . "\n"; // close container

    return $html;
}


function dtoc_sticky_box_on_js( $matches, $options = [] ) {
    
    $dbc_style = dtoc_box_container_style( $options );    
    $html = '<div class="dtoc-sticky-container dtoc-'. esc_attr( $options['display_position'] ) .'" style="'.$dbc_style.'">' . "\n";

    if ( ! empty( $options['toggle_body'] ) ) {

        $html .= '<span class="dtoc-sticky-toggle-btn">'.esc_html( $options['toggle_btn_text'] ).'</span>' . "\n";    
            
    }
    
    if ( ! empty( $options['display_title'] ) ) {

        $html .= '<span class="dtoc-sticky-title-str">'.esc_html( $options['header_text'] ).'</span>';                
            
    }
    
    $html .= dtoc_get_custom_style( $options );
    $html .= dtoc_get_toc_link_style( $options, 'incontent' );       
    $html .= '<div class="dtoc-sticky-box-body dtoc-sticky-box-on-css-body">';
    $html .= dtoc_get_plain_toc_html( $matches, $options );    
    $html .= '</div>';
    $html .= '</div>';

    return $html;
    
}

function dtoc_box_on_css( $matches , $options = [] ) {

    $dbc_style = dtoc_box_container_style( $options );
    $html = '<div class="dtoc-box-container" style="'.$dbc_style.'">';    

    if ( ! empty( $options['display_title'] ) ) {

        if ( isset( $options['toggle_body'] ) ) {

            if ( $options['toggle_initial'] == 'show' ) {
                $html .= '<input type="checkbox" id="dtoc-toggle-check" checked>'; 
            }else{
                $html .= '<input type="checkbox" id="dtoc-toggle-check">'; 
            }
            
        }
        $t_style = dtoc_get_title_style( $options );
        $html .= '<label for="dtoc-toggle-check" class="dtoc-toggle-label" style="'.$t_style.'">';
        $html .= '<span class="dtoc-title-str">'.esc_html( $options['header_text'] ).'</span>';
        $html .= dtoc_get_header_icon( $options );
        $html .= '</label>';    
            
    }
    $html .= dtoc_get_custom_style( $options );
    $html .= dtoc_get_toc_link_style( $options, 'incontent' );       
    $html .= '<div class="dtoc-box-body dtoc-box-on-css-body">';

    $html .= dtoc_get_plain_toc_html( $matches, $options );
    
    $html .= '</div>';
    
    $html .= '</div>';

    return $html;
}

function dtoc_box_hierarchy_heading_list($matches,   $options = []){
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
				if ( ! empty( $options['jump_links'] ) ) {
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

function dtoc_box_heading_list( $matches, $options = [] ) {
    
    $html = '';
    $dtoc_current_permalink = trailingslashit( get_permalink() );

    foreach ( $matches as $i => $match ) {
        $count = $i + 1;

        $title = isset( $match['alternate'] ) ? $match['alternate'] : $match[0];
        
        if ( ! empty( $options['preserve_line_breaks'] ) ) {
            $title = strip_tags( $title, '<br>' );
        }else{
            $title = strip_tags( $title );
        }
                
        $html .= '<li>';

        if ( ! empty( $options['jump_links'] ) ) {
            $link = esc_attr( $dtoc_current_permalink . ( $match['page'] > 1 ? $match['page'] : '' ) . '#' . $match['id'] );

            $accessibility_attrs = '';
            if ( ! empty( $options['accessibility'] ) ) {
                $accessibility_attrs .= ' aria-label="' . esc_attr( 'Jump to ' . $title ) . '"';
            }

            $html .= sprintf(
                '<a class="dtoc-link dtoc-heading-%1$d" href="%2$s"%3$s>%4$s</a>',
                $count,
                $link,
                $accessibility_attrs,
                $title
            );
        } else {
            $html .= $title;
        }

        $html .= '</li>';
    }

    return $html;
}

function dtoc_get_plain_toc_html($matches, $options){
    $html = '';
    $html .= '<ul>';    
    if ( ! empty( $options['hierarchy'] ) ) {
        $html .= dtoc_box_hierarchy_heading_list($matches , $options);
    }else{
        $html .= dtoc_box_heading_list($matches, $options);
    }    
    $html .= '</ul>';
    return $html;
}

function dtoc_box_on_js( $matches, $options = [] ) {
    
    $dbc_style = dtoc_box_container_style( $options );
    $html = '<div class="dtoc-box-container" style="'.$dbc_style.'">';
    
    if ( ! empty( $options['display_title'] ) ) {

        $heading_text = '';                        
        if ( isset( $options['header_text'] ) && $options['header_text'] === 'Table of Contents' ) {
            $heading_text = '<span class="dtoc-title-str">'.esc_html__( 'Table of Contents', 'digital-table-of-contents' ).'</span>';
        }else{
            $heading_text = '<span class="dtoc-title-str">'.esc_html( $options['header_text'] ).'</span>';
        }

        $t_style = dtoc_get_title_style( $options );        
        $html .= '<div class="dtoc-toggle-label" style="'.$t_style.'">'.$heading_text.'';
        $html .= dtoc_get_header_icon( $options );
        $html .= '</div>';        
    }
    $html .= dtoc_get_custom_style( $options );
    $html .= dtoc_get_toc_link_style( $options, 'incontent' );
    $html .= '<div class="dtoc-box-body dtoc-box-on-js-body">';
    $html .= dtoc_get_plain_toc_html( $matches, $options );
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
                [
                    $matches[ $i ][1],
                    '</h' . $matches[ $i ][2] . '>'
                ],
                [
                    '><span class="dtoc-section" id="' . esc_attr($anchor) . '"></span>',
                    '<span class="dtoc-section-end"></span></h' . esc_attr($matches[ $i ][2]) . '>'
                ],
                $matches[ $i ][0]
            );
        }
    
    return $headings;
}

function dtoc_get_headings( $matches ) {

    $headings = [];
                
        foreach ( $matches as $i => $match ) {

            $headings[] = str_replace(
                [
                    $matches[ $i ][1],        
                    '</h' . $matches[ $i ][2] . '>'
                ],
                [
                    '>',
                    '</h' . $matches[ $i ][2] . '>'
                ],
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

                if ( ! empty( $options['exclude_headings'] ) ) {
                    $matches = dtoc_filter_exclude_heading_matches( $matches, $options['exclude_headings'] );
                }                

                $matches = dtoc_heading_ids( $matches );
                $matches = dtoc_next_page( $matches, $page );                

            } else {

                return [];
            }

        }
        
        return array_values( $matches ); 

}

/**
 * Filter heading matches based on exclusion patterns.
 *
 * @param array  $matches          The heading matches from regex (containing tag, level, and text).
 * @param string $exclude_patterns Pipe-separated exclusion string. Supports wildcards (*).
 *
 * @return array Filtered matches.
 */

function dtoc_filter_exclude_heading_matches( $matches, $exclude_patterns ) {

	if ( empty( $exclude_patterns ) || ! is_array( $matches ) ) {
		return $matches;
	}

	$patterns = array_map( 'trim', explode( '|', $exclude_patterns ) );
	$regex_patterns = array();

	foreach ( $patterns as $pattern ) {
		if ( $pattern === '' ) {
			continue;
		}
		$escaped = preg_quote( $pattern, '/' );
		$regex = str_replace( '\*', '.*', $escaped ); // Convert * to .*
		$regex_patterns[] = '/^' . $regex . '$/i';    // Full string match, case-insensitive
	}

	$filtered = array();

	foreach ( $matches as $match ) {
		// Normalize heading text
		$heading_text = wp_strip_all_tags( $match[3] );
		$heading_text = preg_replace( '/\s+/', ' ', $heading_text ); // Replace newlines/tabs/multiple spaces with single space
		$heading_text = trim( $heading_text );

		$exclude = false;
		foreach ( $regex_patterns as $regex ) {
			if ( preg_match( $regex, $heading_text ) ) {
				$exclude = true;
				break;
			}
		}

		if ( ! $exclude ) {
			$filtered[] = $match;
		}
	}

	return array_values( $filtered ); // Reindex
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
    
    if ( empty( $options['header_icon'] ) || $options['header_icon'] === 'none' ) {
        return '';
    }

    $icon_html = '';
    $c_style = '';

    // Accessibility setup
    $add_accessibility = !empty( $options['accessibility'] ) && $options['accessibility'] == 1;
    $aria_label = 'Toggle Table of Contents';

    // Border type
    if ( !empty($options['icon_border_type']) && $options['icon_border_type'] !== 'default' ) {
        $c_style .= 'border-style:' . esc_attr( $options['icon_border_type'] ) . ';';
    }

    // Border color
    if ( !empty($options['icon_border_color']) ) {
        $c_style .= 'border-color:' . esc_attr( $options['icon_border_color'] ) . ';';
    }

    // Border width
    if ( !empty($options['icon_border_width_mode']) && $options['icon_border_width_mode'] === 'custom' ) {
        $sides = ['top', 'right', 'bottom', 'left'];
        foreach ( $sides as $side ) {
            $key = "icon_border_width_$side";
            if ( isset($options[$key]) ) {
                $c_style .= "border-{$side}-width:" . esc_attr($options[$key]) . esc_attr($options['icon_border_width_unit']) . ';';
            }
        }
    }

    // Border radius
    if ( !empty($options['icon_border_radius_mode']) && $options['icon_border_radius_mode'] === 'custom' ) {
        $corners = [
            'top_left' => 'top-left',
            'top_right' => 'top-right',
            'bottom_left' => 'bottom-left',
            'bottom_right' => 'bottom-right'
        ];
        foreach ( $corners as $key => $css ) {
            $field = "icon_border_radius_$key";
            if ( isset($options[$field]) ) {
                $c_style .= "border-{$css}-radius:" . esc_attr($options[$field]) . esc_attr($options['icon_border_radius_unit']) . ';';
            }
        }
    }

    // Margin
    if ( !empty($options['icon_margin_mode']) && $options['icon_margin_mode'] === 'custom' ) {
        $sides = ['top', 'right', 'bottom', 'left'];
        foreach ( $sides as $side ) {
            $key = "icon_margin_$side";
            if ( isset($options[$key]) ) {
                $c_style .= "margin-{$side}:" . esc_attr($options[$key]) . esc_attr($options['icon_margin_unit']) . ';';
            }
        }
    }

    // Padding
    if ( !empty($options['icon_padding_mode']) && $options['icon_padding_mode'] === 'custom' ) {
        $sides = ['top', 'right', 'bottom', 'left'];
        foreach ( $sides as $side ) {
            $key = "icon_padding_$side";
            if ( isset($options[$key]) ) {
                $c_style .= "padding-{$side}:" . esc_attr($options[$key]) . esc_attr($options['icon_padding_unit']) . ';';
            }
        }
    }

    // Size
    $icon_width = '';
    $icon_height = '';
    if ( !empty($options['icon_size_mode']) && $options['icon_size_mode'] === 'custom' ) {
        $icon_width  = isset($options['icon_width']) ? esc_attr($options['icon_width']) . esc_attr($options['icon_size_unit']) : '';
        $icon_height = isset($options['icon_height']) ? esc_attr($options['icon_height']) . esc_attr($options['icon_size_unit']) : '';
        $c_style .= $icon_width ? "width:$icon_width;" : '';
        $c_style .= $icon_height ? "height:$icon_height;" : '';
    }

    $bg_color = !empty($options['icon_bg_color']) ? esc_attr($options['icon_bg_color']) : 'transparent';
    $fg_color = !empty($options['icon_fg_color']) ? esc_attr($options['icon_fg_color']) : '#000';

    // ICON HTML OUTPUT
    switch ( $options['header_icon'] ) {
        
        case 'list_icon':
            $icon_width  = '35px';
            $icon_height = '35px';

            if ( isset($options['icon_size_mode']) && $options['icon_size_mode'] === 'custom' ) {
                $unit = isset($options['icon_size_unit']) ? esc_attr($options['icon_size_unit']) : 'px';
                if ( !empty($options['icon_width']) ) {
                    $icon_width = esc_attr($options['icon_width']) . $unit;
                }
                if ( !empty($options['icon_height']) ) {
                    $icon_height = esc_attr($options['icon_height']) . $unit;
                }
            }

            $icon_html = '<span class="dtoc_icon_toggle"' .
                ( $add_accessibility ? ' role="button" aria-label="' . $aria_label . '"' : '' ) .
                '><svg style="' . $c_style . '" width="' . $icon_width . '" height="' . $icon_height . '" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true">
                <rect x="1" y="1" width="46" height="46" rx="4" stroke="#aaa" fill="' . $bg_color . '"/>
                <circle cx="10" cy="14" r="1.5" fill="' . $fg_color . '"/>
                <rect x="14" y="13" width="14" height="2" rx="1" fill="' . $fg_color . '"/>
                <circle cx="10" cy="24" r="1.5" fill="' . $fg_color . '"/>
                <rect x="14" y="23" width="14" height="2" rx="1" fill="' . $fg_color . '"/>
                <circle cx="10" cy="34" r="1.5" fill="' . $fg_color . '"/>
                <rect x="14" y="33" width="14" height="2" rx="1" fill="' . $fg_color . '"/>
                <path d="M36 18L32 22H40L36 18Z" fill="' . $fg_color . '"/>
                <path d="M36 30L40 26H32L36 30Z" fill="' . $fg_color . '"/>
            </svg></span>';
            break;

        case 'plus_minus':
            $icon_html = '<span class="dtoc_icon_toggle" style="' . $c_style . '"' .
                ( $add_accessibility ? ' role="button" aria-label="' . $aria_label . '"' : '' ) . '>
                <span class="dtoc_icon_brackets">[</span>
                <span class="dtoc-show-text dtoc-plus">+</span>
                <span class="dtoc-hide-text dtoc-minus">-</span>
                <span class="dtoc_icon_brackets">]</span>
            </span>';
            break;

        case 'show_hide':
            $icon_html = '<span class="dtoc_icon_toggle" style="' . $c_style . '"' .
                ( $add_accessibility ? ' role="button" aria-label="' . $aria_label . '"' : '' ) . '>
                <span class="dtoc_icon_brackets">[</span>
                <span class="dtoc-show-text">' . esc_html( $options['show_text'] ) . '</span>
                <span class="dtoc-hide-text">' . esc_html( $options['hide_text'] ) . '</span>
                <span class="dtoc_icon_brackets">]</span>
            </span>';
            break;

        case 'custom_icon':
            $icon_html = '<span class="dtoc_icon_toggle" style="' . $c_style . '"' .
                ( $add_accessibility ? ' role="button" aria-label="' . $aria_label . '"' : '' ) . '>
                <img src="' . esc_url( $options['custom_icon_url'] ) . '" alt="' . ( $add_accessibility ? $aria_label : 'Icon' ) . '" />
            </span>';
            break;
    }

    return $icon_html;
}



function dtoc_box_container_style( $options = [] ) {
	$style = '';

	// Background color
	if ( ! empty( $options['bg_color'] ) ) {
		$style .= 'background-color:' . esc_attr( $options['bg_color'] ) . ';';
	}

	// Width
	if ( ! empty( $options['container_width_mode'] ) ) {
		switch ( $options['container_width_mode'] ) {
			case 'auto':
				$style .= 'width:auto;';
				break;
			case 'full':
				$style .= 'width:100%;';
				break;
			case 'fit-content':
				$style .= 'width:fit-content;';
				break;
			case 'custom':
				if ( ! empty( $options['container_width'] ) && ! empty( $options['container_width_unit'] ) ) {
					$style .= 'width:' . esc_attr( $options['container_width'] ) . esc_attr( $options['container_width_unit'] ) . ';';
				}
				break;
		}
	}

	// Height
	if ( ! empty( $options['container_height_mode'] ) ) {
		switch ( $options['container_height_mode'] ) {
			case 'auto':
				$style .= 'height:auto;';
				break;
			case 'full':
				$style .= 'height:100%;';
				break;
			case 'fit-content':
				$style .= 'height:fit-content;';
				break;
			case 'custom':
				if ( ! empty( $options['container_height'] ) && ! empty( $options['container_height_unit'] ) ) {
					$style .= 'height:' . esc_attr( $options['container_height'] ) . esc_attr( $options['container_height_unit'] ) . ';';
				}
				break;
		}
	}

	// Margin
	if ( ! empty( $options['container_margin_mode'] ) ) {
		if ( 'auto' === $options['container_margin_mode'] ) {
			$style .= 'margin:auto;';
		} elseif ( 'custom' === $options['container_margin_mode'] ) {
			$unit = esc_attr( $options['container_margin_unit'] );
			$style .= 'margin-top:' . esc_attr( $options['container_margin_top'] ) . $unit . ';';
			$style .= 'margin-right:' . esc_attr( $options['container_margin_right'] ) . $unit . ';';
			$style .= 'margin-bottom:' . esc_attr( $options['container_margin_bottom'] ) . $unit . ';';
			$style .= 'margin-left:' . esc_attr( $options['container_margin_left'] ) . $unit . ';';
		}
	}

	// Padding
	if ( ! empty( $options['container_padding_mode'] ) ) {
		if ( 'auto' === $options['container_padding_mode'] ) {
			$style .= 'padding:auto;';
		} elseif ( 'custom' === $options['container_padding_mode'] ) {
			$unit = esc_attr( $options['container_padding_unit'] );
			$style .= 'padding-top:' . esc_attr( $options['container_padding_top'] ) . $unit . ';';
			$style .= 'padding-right:' . esc_attr( $options['container_padding_right'] ) . $unit . ';';
			$style .= 'padding-bottom:' . esc_attr( $options['container_padding_bottom'] ) . $unit . ';';
			$style .= 'padding-left:' . esc_attr( $options['container_padding_left'] ) . $unit . ';';
		}
	}

	// Border type (style)
	if ( ! empty( $options['border_type'] ) && 'default' !== $options['border_type'] ) {
		$style .= 'border-style:' . esc_attr( $options['border_type'] ) . ';';
	}

	// Border color
	if ( ! empty( $options['border_color'] ) ) {
		$style .= 'border-color:' . esc_attr( $options['border_color'] ) . ';';
	}

	// Border width (custom mode only)
	if ( ! empty( $options['border_width_mode'] ) && 'custom' === $options['border_width_mode'] && ! empty( $options['border_width_unit'] ) ) {
		$unit = esc_attr( $options['border_width_unit'] );
		$style .= 'border-top-width:' . esc_attr( $options['border_width_top'] ) . $unit . ';';
		$style .= 'border-right-width:' . esc_attr( $options['border_width_right'] ) . $unit . ';';
		$style .= 'border-bottom-width:' . esc_attr( $options['border_width_bottom'] ) . $unit . ';';
		$style .= 'border-left-width:' . esc_attr( $options['border_width_left'] ) . $unit . ';';
	}

	// Border radius (custom mode only)
	if ( ! empty( $options['border_radius_mode'] ) && 'custom' === $options['border_radius_mode'] && ! empty( $options['border_radius_unit'] ) ) {
		$unit = esc_attr( $options['border_radius_unit'] );
		$style .= 'border-top-left-radius:' . esc_attr( $options['border_radius_top_left'] ) . $unit . ';';
		$style .= 'border-top-right-radius:' . esc_attr( $options['border_radius_top_right'] ) . $unit . ';';
		$style .= 'border-bottom-right-radius:' . esc_attr( $options['border_radius_bottom_right'] ) . $unit . ';';
		$style .= 'border-bottom-left-radius:' . esc_attr( $options['border_radius_bottom_left'] ) . $unit . ';';
	}

	return $style;
}


function dtoc_get_toggle_btn_style( $options ) {
	$style = '';

	// Background color.
	if ( ! empty( $options['toggle_btn_bg_color'] ) ) {
		$style .= 'background:' . esc_attr( $options['toggle_btn_bg_color'] ) . ';';
	}

	// Foreground color.
	if ( ! empty( $options['toggle_btn_fg_color'] ) ) {
		$style .= 'color:' . esc_attr( $options['toggle_btn_fg_color'] ) . ';';
	}

	// Size (only if mode is custom).
	if ( isset( $options['toggle_btn_size_mode'] ) && $options['toggle_btn_size_mode'] === 'custom' ) {
		$width  = isset( $options['toggle_btn_width'] ) ? (int) $options['toggle_btn_width'] : 0;
		$height = isset( $options['toggle_btn_height'] ) ? (int) $options['toggle_btn_height'] : 0;
		$unit   = ! empty( $options['toggle_btn_size_unit'] ) ? esc_attr( $options['toggle_btn_size_unit'] ) : 'px';

		if ( $width > 0 ) {
			$style .= 'width:' . $width . $unit . ';';
		}
		if ( $height > 0 ) {
			$style .= 'height:' . $height . $unit . ';';
		}
	}

	// Border type.
	if ( ! empty( $options['toggle_btn_border_type'] ) && $options['toggle_btn_border_type'] !== 'default' ) {
		$style .= 'border-style:' . esc_attr( $options['toggle_btn_border_type'] ) . ';';
	}

	// Border color.
	if ( ! empty( $options['toggle_btn_border_color'] ) ) {
		$style .= 'border-color:' . esc_attr( $options['toggle_btn_border_color'] ) . ';';
	}

	// Border width (only if custom).
	if ( isset( $options['toggle_btn_border_width_mode'] ) && $options['toggle_btn_border_width_mode'] === 'custom' ) {
		$top    = isset( $options['toggle_btn_border_width_top'] ) ? (int) $options['toggle_btn_border_width_top'] : 0;
		$right  = isset( $options['toggle_btn_border_width_right'] ) ? (int) $options['toggle_btn_border_width_right'] : 0;
		$bottom = isset( $options['toggle_btn_border_width_bottom'] ) ? (int) $options['toggle_btn_border_width_bottom'] : 0;
		$left   = isset( $options['toggle_btn_border_width_left'] ) ? (int) $options['toggle_btn_border_width_left'] : 0;

		if ( $top > 0 || $right > 0 || $bottom > 0 || $left > 0 ) {
			$unit = ! empty( $options['toggle_btn_border_width_unit'] ) ? esc_attr( $options['toggle_btn_border_width_unit'] ) : 'px';
			$style .= 'border-width:' . $top . $unit . ' ' . $right . $unit . ' ' . $bottom . $unit . ' ' . $left . $unit . ';';
		}
	}

	// Border radius (only if custom).
	if ( isset( $options['toggle_btn_border_radius_mode'] ) && $options['toggle_btn_border_radius_mode'] === 'custom' ) {
		$tl = isset( $options['toggle_btn_border_radius_top_left'] ) ? (int) $options['toggle_btn_border_radius_top_left'] : 0;
		$tr = isset( $options['toggle_btn_border_radius_top_right'] ) ? (int) $options['toggle_btn_border_radius_top_right'] : 0;
		$bl = isset( $options['toggle_btn_border_radius_bottom_left'] ) ? (int) $options['toggle_btn_border_radius_bottom_left'] : 0;
		$br = isset( $options['toggle_btn_border_radius_bottom_right'] ) ? (int) $options['toggle_btn_border_radius_bottom_right'] : 0;

		if ( $tl > 0 || $tr > 0 || $bl > 0 || $br > 0 ) {
			$unit = ! empty( $options['toggle_btn_border_radius_unit'] ) ? esc_attr( $options['toggle_btn_border_radius_unit'] ) : 'px';
			$style .= 'border-radius:' . $tl . $unit . ' ' . $tr . $unit . ' ' . $br . $unit . ' ' . $bl . $unit . ';';
		}
	}

	// Padding (only if custom).
	if ( isset( $options['toggle_btn_padding_mode'] ) && $options['toggle_btn_padding_mode'] === 'custom' ) {
		$top    = isset( $options['toggle_btn_padding_top'] ) ? (int) $options['toggle_btn_padding_top'] : 0;
		$right  = isset( $options['toggle_btn_padding_right'] ) ? (int) $options['toggle_btn_padding_right'] : 0;
		$bottom = isset( $options['toggle_btn_padding_bottom'] ) ? (int) $options['toggle_btn_padding_bottom'] : 0;
		$left   = isset( $options['toggle_btn_padding_left'] ) ? (int) $options['toggle_btn_padding_left'] : 0;

		if ( $top > 0 || $right > 0 || $bottom > 0 || $left > 0 ) {
			$unit = ! empty( $options['toggle_btn_padding_unit'] ) ? esc_attr( $options['toggle_btn_padding_unit'] ) : 'px';
			$style .= 'padding:' . $top . $unit . ' ' . $right . $unit . ' ' . $bottom . $unit . ' ' . $left . $unit . ';';
		}
	}

	return $style;
}


function dtoc_get_title_style( $options ) {
	$style = '';

	// Background color
	if ( ! empty( $options['title_bg_color'] ) ) {
		$style .= 'background:' . esc_attr( $options['title_bg_color'] ) . ';';
	}

	// Foreground color
	if ( ! empty( $options['title_fg_color'] ) ) {
		$style .= 'color:' . esc_attr( $options['title_fg_color'] ) . ';';
	}

	// Font size
	if (
		isset( $options['title_font_size_mode'] ) &&
		$options['title_font_size_mode'] === 'custom' &&
		! empty( $options['title_font_size'] ) &&
		is_numeric( $options['title_font_size'] ) &&
		$options['title_font_size'] > 0 &&
		! empty( $options['title_font_size_unit'] )
	) {
		$style .= 'font-size:' . esc_attr( $options['title_font_size'] ) . esc_attr( $options['title_font_size_unit'] ) . ';';
	}

	// Font weight
	if (
		isset( $options['title_font_weight_mode'] ) &&
		$options['title_font_weight_mode'] === 'custom' &&
		! empty( $options['title_font_weight'] ) &&
		is_numeric( $options['title_font_weight'] ) &&
		$options['title_font_weight'] > 0
	) {
		$style .= 'font-weight:' . esc_attr( $options['title_font_weight'] ) . ';';
	}

	// Padding (only if mode is custom and any value is > 0)
	if (
		isset( $options['title_padding_mode'] ) &&
		$options['title_padding_mode'] === 'custom'
	) {
		$top    = isset( $options['title_padding_top'] ) ? (int) $options['title_padding_top'] : 0;
		$right  = isset( $options['title_padding_right'] ) ? (int) $options['title_padding_right'] : 0;
		$bottom = isset( $options['title_padding_bottom'] ) ? (int) $options['title_padding_bottom'] : 0;
		$left   = isset( $options['title_padding_left'] ) ? (int) $options['title_padding_left'] : 0;

		if ( $top > 0 || $right > 0 || $bottom > 0 || $left > 0 ) {
			$unit = ! empty( $options['title_padding_unit'] ) ? esc_attr( $options['title_padding_unit'] ) : 'px';
			$style .= 'padding:' . $top . $unit . ' ' . $right . $unit . ' ' . $bottom . $unit . ' ' . $left . $unit . ';';
		}
	}

	return $style;
}

function dtoc_get_toc_link_style( $options, $type ) {

    $css = ".dtoc-box-body .dtoc-link {";

    if($type == 'sticky'){
        $css = ".dtoc-sticky-box-body .dtoc-link {";
    }    

    // Link color
    if ( ! empty( $options['link_color'] ) ) {
        $css .= "color: " . esc_attr( $options['link_color'] ) . ";";
    }

    // Padding
    if ( isset( $options['link_padding_mode'] ) ) {
        if ( $options['link_padding_mode'] === 'auto' ) {
            $css .= "padding: auto;";
        } elseif ( $options['link_padding_mode'] === 'custom' ) {
            $unit = isset( $options['link_padding_unit'] ) ? $options['link_padding_unit'] : 'px';
            $top = isset( $options['link_padding_top'] ) ? (int) $options['link_padding_top'] . $unit : '0' . $unit;
            $right = isset( $options['link_padding_right'] ) ? (int) $options['link_padding_right'] . $unit : '0' . $unit;
            $bottom = isset( $options['link_padding_bottom'] ) ? (int) $options['link_padding_bottom'] . $unit : '0' . $unit;
            $left = isset( $options['link_padding_left'] ) ? (int) $options['link_padding_left'] . $unit : '0' . $unit;
            $css .= "padding: {$top} {$right} {$bottom} {$left};";
        }
    }

    // Margin
    if ( isset( $options['link_margin_mode'] ) ) {
        if ( $options['link_margin_mode'] === 'auto' ) {
            $css .= "margin: auto;";
        } elseif ( $options['link_margin_mode'] === 'custom' ) {
            $unit = isset( $options['link_margin_unit'] ) ? $options['link_margin_unit'] : 'px';
            $top = isset( $options['link_margin_top'] ) ? (int) $options['link_margin_top'] . $unit : '0' . $unit;
            $right = isset( $options['link_margin_right'] ) ? (int) $options['link_margin_right'] . $unit : '0' . $unit;
            $bottom = isset( $options['link_margin_bottom'] ) ? (int) $options['link_margin_bottom'] . $unit : '0' . $unit;
            $left = isset( $options['link_margin_left'] ) ? (int) $options['link_margin_left'] . $unit : '0' . $unit;
            $css .= "margin: {$top} {$right} {$bottom} {$left};";
        }
    }

    $css .= "}";

    // Hover color
    if ( ! empty( $options['link_hover_color'] ) ) {
        
        if ( $type == 'sticky' ) {
            $css .= "dtoc-sticky-box-body .dtoc-link:hover {";            
        }else{
            $css .= ".dtoc-box-body .dtoc-link:hover {";
        }

        $css .= "color: " . esc_attr( $options['link_hover_color'] ) . ";";
        $css .= "}";
    }

    // Visited color
    if ( ! empty( $options['link_visited_color'] ) ) {
        
        if ( $type == 'sticky' ) {
            $css .= ".dtoc-sticky-box-body .dtoc-link:visited {";            
        }else{
            $css .= ".dtoc-box-body .dtoc-link:visited {";
        }

        $css .= "color: " . esc_attr( $options['link_visited_color'] ) . ";";
        $css .= "}";
        
    }

    return '<style id="dtoc-link-css">' . $css . '</style>';
}

function dtoc_get_custom_style( $options ) {

    if ( empty( $options['custom_css'] ) ) {
        return '';
    }

    // Sanitize output: allow only safe characters in CSS
    $css = trim( wp_strip_all_tags( $options['custom_css'] ) );

    // Don’t output if it's empty after cleaning
    if ( $css === '' ) {
        return '';
    }

    return '<style id="dtoc-custom-css">' . $css . '</style>';
}
