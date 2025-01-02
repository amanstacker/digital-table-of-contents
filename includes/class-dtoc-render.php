<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DTOC_Render {

    public function __construct() {
        add_action( 'the_content', [ $this, 'dtoc_auto_insert_toc' ] );
        add_shortcode( 'dtoc_list', [ $this, 'dtoc_render_toc_shortcode' ] );
    }

    public function dtoc_auto_insert_toc( $content ) {
        $options = get_option( 'dtoc_toc_options', [] );
        $post_types = $options['post_types'] ? $options['post_types'] : [];
	    $headings  = $options['headings'] ? $options['headings'] : [ 'h2' ];

        if ( !empty($post_types) && is_singular( $post_types ) ) {
			
		$toc = $this->dtoc_generate_toc( $content, $options );
		
	if (preg_match_all('/<(' . implode('|', $headings) . ')\b[^>]*>(.*?)<\/\1>/', $content, $matches, PREG_OFFSET_CAPTURE)) {
        
    foreach ($matches[0] as $index => $match) {
        
        $headingTag = $matches[1][$index][0];
        $headingText = $matches[2][$index][0];
        $id = 'toc-item-' . esc_attr($index);
        // Replace the original heading with the modified one
        $content = str_replace(
            $match[0],
            '<' . $headingTag . '><span class="dtoc-list-span" id="' . esc_attr($id) . '"></span>' . esc_html($headingText) . '</' . $headingTag . '>',
            $content
        );
        
    }
}


	
            return $toc . $content;
        }

        return $content;
    }

    public function dtoc_render_toc_shortcode( $atts ) {
        $atts = shortcode_atts(
            [
                'headings'  => [ 'h2' ],
                'hierarchy' => false,
                'toggle'    => false,
                'title'     => 'Table of Contents',
            ],
            $atts
        );

        return $this->dtoc_generate_toc( get_the_content(), $atts );
    }

private function dtoc_generate_toc( $content, $options ) {
    $headings  = $options['headings'] ? $options['headings'] : [ 'h2' ];
    $hierarchy = $options['hierarchy'] ? $options['hierarchy'] : false;
    $toggle    = $options['toggle'] ? $options['toggle'] : false;
    $title     = $options['title'] ? $options['title'] : 'Table of Contents';

    $toc = '<div class="dtoc-list"><div class="dtoc-list-header">';
    $toc .= '<h2>' . esc_html( $title ) . '</h2>';

    if ( $toggle ) {
        $toc .= '<button class="toggle-toc">' . esc_html__( 'Show TOC', 'digital-table-of-contents' ) . '</button></div>';
    }

    $toc .= '<ul class="toc-list' . ( $toggle ? ' hidden' : '' ) . '">';

    if (preg_match_all('/<(' . implode('|', $headings) . ')\b[^>]*>(.*?)<\/\1>/', $content, $matches, PREG_OFFSET_CAPTURE)) {
        $hierarchy_data = $this->dtoc_build_hierarchy( $matches, $hierarchy );

        foreach ( $hierarchy_data as $item ) {
            $toc .= '<li><a href="#' . esc_attr( $item['id'] ) . '">' . esc_html( $item['text'] ) . '</a></li>';
        }
    }

    $toc .= '</ul></div>';

    return $toc;
}


    private function dtoc_build_hierarchy( $matches, $hierarchy ) {
        $items = [];
        foreach ( $matches[0] as $index => $match ) {
            $id = 'toc-item-' . $index;
            $items[] = [
                'id'   => $id,
                'text' => wp_strip_all_tags( $matches[2][ $index ][0] ),
            ];
        }

        return $items;
    }
}
