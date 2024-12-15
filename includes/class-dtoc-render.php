<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DTOC_Render {

    public function __construct() {
        add_action( 'the_content', [ $this, 'auto_insert_toc' ] );
        add_shortcode( 'digital_toc', [ $this, 'render_toc_shortcode' ] );
    }

    public function auto_insert_toc( $content ) {
        $options = get_option( 'digital_toc_options', [] );
        $post_types = $options['post_types'] ?? [];
	    $headings  = $options['headings'] ?? [ 'h2' ];

        if ( !empty($post_types) && is_singular( $post_types ) ) {
			
		$toc = $this->generate_toc( $content, $options );
			
		if (preg_match_all('/<(' . implode('|', $headings) . ')>(.*?)<\/\1>/', $content, $matches, PREG_OFFSET_CAPTURE)) {
				foreach ($matches[0] as $index => $match) {
					$headingTag = $matches[1][$index][0];
					$headingText = $matches[2][$index][0];
					$id = 'toc-item-' . $index;	
					 $content = str_replace($match[0], '<' . $headingTag . '><span class="digital-toc-span" id="'.esc_attr($id).'"></span>' . $headingText . '</' . $headingTag . '>', $content);
				}
		}

	
            return $toc . $content;
        }

        return $content;
    }

    public function render_toc_shortcode( $atts ) {
        $atts = shortcode_atts(
            [
                'headings'  => [ 'h2' ],
                'hierarchy' => false,
                'toggle'    => false,
                'title'     => 'Table of Contents',
            ],
            $atts
        );

        return $this->generate_toc( get_the_content(), $atts );
    }

private function generate_toc( $content, $options ) {
    $headings  = $options['headings'] ?? [ 'h2' ];
    $hierarchy = $options['hierarchy'] ?? false;
    $toggle    = $options['toggle'] ?? false;
    $title     = $options['title'] ?? 'Table of Contents';

    $toc = '<div class="digital-toc"><div class="digital-toc-header">';
    $toc .= '<h2>' . esc_html( $title ) . '</h2>';

    if ( $toggle ) {
        $toc .= '<button class="toggle-toc">' . __( 'Show TOC', 'dtoc' ) . '</button></div>';
    }

    $toc .= '<ul class="toc-list' . ( $toggle ? ' hidden' : '' ) . '">';

    if ( preg_match_all( '/<(' . implode( '|', $headings ) . ')>(.*?)<\\/\\1>/', $content, $matches, PREG_OFFSET_CAPTURE ) ) {
        $hierarchy_data = $this->build_hierarchy( $matches, $hierarchy );

        foreach ( $hierarchy_data as $item ) {
            $toc .= '<li><a href="#' . esc_attr( $item['id'] ) . '">' . esc_html( $item['text'] ) . '</a></li>';
        }
    }

    $toc .= '</ul></div>';

    return $toc;
}


    private function build_hierarchy( $matches, $hierarchy ) {
        $items = [];
        foreach ( $matches[0] as $index => $match ) {
            $id = 'toc-item-' . $index;
            $items[] = [
                'id'   => $id,
                'text' => strip_tags( $matches[2][ $index ][0] ),
            ];
        }

        return $items;
    }
}
