<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', 'dtoc_options_init' );

function dtoc_options_init(){
    
	global $dtoc_dashboard, $dtoc_incontent, $dtoc_incontent_mobile, $dtoc_incontent_tablet, $dtoc_sliding_sticky, $dtoc_sliding_sticky_mobile, $dtoc_sliding_sticky_tablet, $dtoc_floating, $dtoc_floating_mobile, $dtoc_floating_tablet, $dtoc_shortcode, $dtoc_shortcode_mobile, $dtoc_shortcode_tablet, $dtoc_compatibility;

        $dtoc_dashboard          = get_option( 'dtoc_dashboard', dtoc_default_dashboard_options() );

        $dtoc_incontent          = get_option( 'dtoc_incontent', dtoc_default_incontent_options() );
        $dtoc_incontent_mobile   = get_option( 'dtoc_incontent_mobile', dtoc_default_incontent_mobile_options() );
        $dtoc_incontent_tablet   = get_option( 'dtoc_incontent_tablet', dtoc_default_incontent_tablet_options() );

        $dtoc_shortcode          = get_option( 'dtoc_shortcode', dtoc_default_shortcode_options() );
        $dtoc_shortcode_mobile   = get_option( 'dtoc_shortcode_mobile', dtoc_default_shortcode_mobile_options() );
        $dtoc_shortcode_tablet   = get_option( 'dtoc_shortcode_tablet', dtoc_default_shortcode_tablet_options() );

        $dtoc_sliding_sticky             = get_option( 'dtoc_sliding_sticky', dtoc_default_sticky_options() );
        $dtoc_sliding_sticky_mobile      = get_option( 'dtoc_sliding_sticky_mobile', dtoc_default_sticky_mobile_options() );
        $dtoc_sliding_sticky_tablet      = get_option( 'dtoc_sliding_sticky_tablet', dtoc_default_sticky_tablet_options() );

        $dtoc_floating           = get_option( 'dtoc_floating', dtoc_default_floating_options() );
        $dtoc_floating_mobile    = get_option( 'dtoc_floating_mobile', dtoc_default_floating_mobile_options() );
        $dtoc_floating_tablet    = get_option( 'dtoc_floating_tablet', dtoc_default_floating_tablet_options() );

        $dtoc_compatibility      = get_option( 'dtoc_compatibility', dtoc_default_compatibility_options() );
        
}
function dtoc_default_floating_options(){
       
		$default = dtoc_option_types('all',['floating'],'default');
        $default = apply_filters("dtoc_default_floating_options_filter", $default);
        return $default;    
}
function dtoc_default_floating_mobile_options(){
        $default = dtoc_option_types('all',['floating_mobile'],'default');
        $default = apply_filters("dtoc_default_floating_mobile_options_filter", $default);
        return $default;    
}
function dtoc_default_floating_tablet_options(){
        $default = dtoc_option_types('all',['floating_tablet'],'default');
        $default = apply_filters("dtoc_default_floating_tablet_options_filter", $default);
        return $default;    
}
function dtoc_default_sticky_options() {
	$default = [
		"rendering_style" => "js",
		"display_title" => 1,
		"header_text" => "Table of Contents",
		"toggle_initial" => "hide",
		"toggle_btn_text" => "Index",
		"jump_links" => 1,
		"scroll_behavior" => "smooth",
		"display_when" => 2,
		"display_position" => "left-top",
		"paragraph_number" => 1,
		"list_style_type" => "decimal",
		"headings_include" => [
			"1" => 1,
			"2" => 1,
			"3" => 1,
			"4" => 1,
			"5" => 1,
			"6" => 1,
		],
		"accessibility" => 1,
		"exclude_headings" => "",
		"placement" => [
			"post" => [
				"is_enabled" => 1,
			],
		],
		"bg_color" => "#f9f9f9",
		"container_width_mode" => "default",
		"container_width" => 0,
		"container_width_unit" => "px",
		"container_height_mode" => "default",
		"design_type" => "px",
		"container_margin_mode" => "default",
		"container_margin_top" => 0,
		"container_margin_right" => 0,
		"container_margin_bottom" => 0,
		"container_margin_left" => 0,
		"container_margin_unit" => "px",
		"container_padding_mode" => "default",
		"container_padding_top" => 0,
		"container_padding_right" => 0,
		"container_padding_bottom" => 0,
		"container_padding_left" => 0,
		"container_padding_unit" => "px",
		"border_type" => "solid",
		"border_color" => "#dddddd",
		"border_width_mode" => "custom",
		"border_width_top" => 1,
		"border_width_right" => 1,
		"border_width_bottom" => 1,
		"border_width_left" => 1,
		"border_width_unit" => "px",
		"border_radius_mode" => "default",
		"border_radius_top_left" => 0,
		"border_radius_top_right" => 0,
		"border_radius_bottom_left" => 0,
		"border_radius_bottom_right" => 0,
		"border_radius_unit" => "px",
		"title_bg_color" => "#f9f9f9",
		"title_fg_color" => "#222222",
		"title_font_size_mode" => "default",
		"title_font_size" => 0,
		"title_font_size_unit" => "px",
		"title_font_weight_mode" => "default",
		"title_font_weight" => 0,
		"title_padding_mode" => "default",
		"title_padding_top" => 0,
		"title_padding_right" => 0,
		"title_padding_bottom" => 0,
		"title_padding_left" => 0,
		"title_padding_unit" => "px",
		"toggle_btn_bg_color" => "#d3d3d3",
		"toggle_btn_fg_color" => "#000000",
		"toggle_btn_size_mode" => "default",
		"toggle_btn_width" => 25,
		"toggle_btn_height" => 25,
		"toggle_btn_size_unit" => "px",
		"toggle_btn_border_type" => "default",
		"toggle_btn_border_color" => "#d3d3d3",
		"toggle_btn_border_width_mode" => "default",
		"toggle_btn_border_width_top" => 0,
		"toggle_btn_border_width_right" => 0,
		"toggle_btn_border_width_bottom" => 0,
		"toggle_btn_border_width_left" => 0,
		"toggle_btn_border_width_unit" => "px",
		"toggle_btn_border_radius_mode" => "default",
		"toggle_btn_border_radius_top_left" => 0,
		"toggle_btn_border_radius_top_right" => 0,
		"toggle_btn_border_radius_bottom_left" => 0,
		"toggle_btn_border_radius_bottom_right" => 0,
		"toggle_btn_border_radius_unit" => "px",
		"toggle_btn_padding_mode" => "default",
		"toggle_btn_padding_top" => 0,
		"toggle_btn_padding_right" => 0,
		"toggle_btn_padding_bottom" => 0,
		"toggle_btn_padding_left" => 0,
		"toggle_btn_padding_unit" => "px",
		"link_color" => "#1a73e8",
		"link_hover_color" => "#0c47a1",
		"link_visited_color" => "#465568",
		"link_padding_mode" => "default",
		"link_padding_top" => 0,
		"link_padding_right" => 0,
		"link_padding_bottom" => 0,
		"link_padding_left" => 0,
		"link_padding_unit" => "px",
		"link_margin_mode" => "default",
		"link_margin_top" => 0,
		"link_margin_right" => 0,
		"link_margin_bottom" => 0,
		"link_margin_left" => 0,
		"link_margin_unit" => "px",
		"custom_css" => "",
	];
	
	$default = apply_filters("dtoc_default_sticky_options_filter", $default );
	return $default;
}
function dtoc_default_sticky_mobile_options(){
        $default = [				
		"header_text" => "Table of Contents",
		"toggle_initial" => "hide",		
		"jump_links" => 1,
		"scroll_behavior" => "smooth",
		"display_when" => 2,
		"display_position" => "bottom-sheet",		
		"list_style_type" => "decimal",
		"headings_include" => [
			"1" => 1,
			"2" => 1,
			"3" => 1,
			"4" => 1,
			"5" => 1,
			"6" => 1,
		],
		"accessibility" => 1,
		"exclude_headings" => "",
		"placement" => [
			"post" => [
				"is_enabled" => 1,
			],
		],
		"bg_color" => "#f9f9f9",
		"container_width_mode" => "default",
		"container_width" => 0,
		"container_width_unit" => "px",
		"container_height_mode" => "default",
		"design_type" => "px",
		"container_margin_mode" => "default",
		"container_margin_top" => 0,
		"container_margin_right" => 0,
		"container_margin_bottom" => 0,
		"container_margin_left" => 0,
		"container_margin_unit" => "px",
		"container_padding_mode" => "default",
		"container_padding_top" => 0,
		"container_padding_right" => 0,
		"container_padding_bottom" => 0,
		"container_padding_left" => 0,
		"container_padding_unit" => "px",
		"border_type" => "solid",
		"border_color" => "#dddddd",
		"border_width_mode" => "custom",
		"border_width_top" => 1,
		"border_width_right" => 1,
		"border_width_bottom" => 1,
		"border_width_left" => 1,
		"border_width_unit" => "px",
		"border_radius_mode" => "default",
		"border_radius_top_left" => 0,
		"border_radius_top_right" => 0,
		"border_radius_bottom_left" => 0,
		"border_radius_bottom_right" => 0,
		"border_radius_unit" => "px",
		"title_bg_color" => "#f9f9f9",
		"title_fg_color" => "#222222",
		"title_font_size_mode" => "default",
		"title_font_size" => 0,
		"title_font_size_unit" => "px",
		"title_font_weight_mode" => "default",
		"title_font_weight" => 0,
		"title_padding_mode" => "default",
		"title_padding_top" => 0,
		"title_padding_right" => 0,
		"title_padding_bottom" => 0,
		"title_padding_left" => 0,
		"title_padding_unit" => "px",
		"toggle_btn_bg_color" => "#d3d3d3",
		"toggle_btn_fg_color" => "#000000",
		"toggle_btn_size_mode" => "default",
		"toggle_btn_width" => 25,
		"toggle_btn_height" => 25,
		"toggle_btn_size_unit" => "px",
		"toggle_btn_border_type" => "default",
		"toggle_btn_border_color" => "#d3d3d3",
		"toggle_btn_border_width_mode" => "default",
		"toggle_btn_border_width_top" => 0,
		"toggle_btn_border_width_right" => 0,
		"toggle_btn_border_width_bottom" => 0,
		"toggle_btn_border_width_left" => 0,
		"toggle_btn_border_width_unit" => "px",
		"toggle_btn_border_radius_mode" => "default",
		"toggle_btn_border_radius_top_left" => 0,
		"toggle_btn_border_radius_top_right" => 0,
		"toggle_btn_border_radius_bottom_left" => 0,
		"toggle_btn_border_radius_bottom_right" => 0,
		"toggle_btn_border_radius_unit" => "px",
		"toggle_btn_padding_mode" => "default",
		"toggle_btn_padding_top" => 0,
		"toggle_btn_padding_right" => 0,
		"toggle_btn_padding_bottom" => 0,
		"toggle_btn_padding_left" => 0,
		"toggle_btn_padding_unit" => "px",
		"link_color" => "#1a73e8",
		"link_hover_color" => "#0c47a1",
		"link_visited_color" => "#465568",
		"link_padding_mode" => "default",
		"link_padding_top" => 0,
		"link_padding_right" => 0,
		"link_padding_bottom" => 0,
		"link_padding_left" => 0,
		"link_padding_unit" => "px",
		"link_margin_mode" => "default",
		"link_margin_top" => 0,
		"link_margin_right" => 0,
		"link_margin_bottom" => 0,
		"link_margin_left" => 0,
		"link_margin_unit" => "px",
		"custom_css" => "",
	];
	
	$default = apply_filters("dtoc_default_sticky_mobile_options_filter", $default );
	return $default;
}
function dtoc_default_sticky_tablet_options(){
        $default = dtoc_option_types('all',['sticky_tablet'],'default');
        $default = apply_filters("dtoc_default_sticky_tablet_options_filter", $default);
        return $default;    
}
function dtoc_default_incontent_options(){

        $default = [
            "rendering_style" => "js",
            "display_title" => 1,
            "header_text" => "Table of Contents",
            "toggle_body" => 1,
            "toggle_initial" => "show",
            "header_icon" => "list_icon",
            "custom_icon_url" => "",
            "show_text" => "show",
            "hide_text" => "hide",
            "jump_links" => 1,
            "scroll_behavior" => "smooth",
            "alignment" => "left",
            "display_when" => 2,
            "display_position" => "top_of_the_content",
            "paragraph_number" => 1,
            "list_style_type" => "decimal",
            "headings_include" => [
                "1" => 1,
                "2" => 1,
                "3" => 1,
                "4" => 1,
                "5" => 1,
                "6" => 1,
            ],
            "hierarchy"          => 0,
            "combine_page_break" => 0,
            "accessibility"     => 1,
            "preserve_line_breaks" => 0,
            "exclude_headings"  => '',
            "placement" => [
                "post" => [
                    "is_enabled" => 1,
                    "taxonomy" => [
                        "post_tag" => [
                            "ope" => "OR",
                        ],
                    ],
                ],
            ],
            "bg_color" => "#f9f9f9",
            "container_width_mode" => "default",
            "container_width" => 0,
            "container_width_unit" => "px",
            "container_height_mode" => "default",
            "design_type" => "px",
            "container_margin_mode" => "default",
            "container_margin_top" => 0,
            "container_margin_right" => 0,
            "container_margin_bottom" => 0,
            "container_margin_left" => 0,
            "container_margin_unit" => "px",
            "container_padding_mode" => "default",
            "container_padding_top" => 0,
            "container_padding_right" => 0,
            "container_padding_bottom" => 0,
            "container_padding_left" => 0,
            "container_padding_unit" => "px",
            "border_type" => "solid",
            "border_color" => "#dddddd",
            "border_width_mode" => "custom",
            "border_width_top" => 1,
            "border_width_right" => 1,
            "border_width_bottom" => 1,
            "border_width_left" => 1,
            "border_width_unit" => "px",
            "border_radius_mode" => "default",
            "border_radius_top_left" => 0,
            "border_radius_top_right" => 0,
            "border_radius_bottom_left" => 0,
            "border_radius_bottom_right" => 0,
            "border_radius_unit" => "px",
            "title_bg_color" => "#eeeeee",
            "title_fg_color" => "#222222",
            "title_font_size_mode" => "default",
            "title_font_size" => 0,
            "title_font_size_unit" => "px",
            "title_font_weight_mode" => "default",
            "title_font_weight" => 0,
            "title_padding_mode" => "default",
            "title_padding_top" => 0,
            "title_padding_right" => 0,
            "title_padding_bottom" => 0,
            "title_padding_left" => 0,
            "title_padding_unit" => "px",
            "icon_bg_color" => "#e0e0e0",
            "icon_fg_color" => "#333333",
            "icon_size_mode" => "default",
            "icon_width" => 25,
            "icon_height" => 25,
            "icon_size_unit" => "px",
            "icon_border_type" => "default",
            "icon_border_color" => "#D5E0EB",
            "icon_border_width_mode" => "default",
            "icon_border_width_top" => 0,
            "icon_border_width_right" => 0,
            "icon_border_width_bottom" => 0,
            "icon_border_width_left" => 0,
            "icon_border_width_unit" => "px",
            "icon_border_radius_mode" => "default",
            "icon_border_radius_top_left" => 0,
            "icon_border_radius_top_right" => 0,
            "icon_border_radius_bottom_left" => 0,
            "icon_border_radius_bottom_right" => 0,
            "icon_border_radius_unit" => "px",
            "icon_padding_mode" => "default",
            "icon_padding_top" => 0,
            "icon_padding_right" => 0,
            "icon_padding_bottom" => 0,
            "icon_padding_left" => 0,
            "icon_padding_unit" => "px",
            "icon_margin_mode" => "default",
            "icon_margin_top" => 0,
            "icon_margin_right" => 0,
            "icon_margin_bottom" => 0,
            "icon_margin_left" => 0,
            "icon_margin_unit" => "px",
            "link_color" => "#1a73e8",
            "link_hover_color" => "#0c47a1",
            "link_visited_color" => "#5f6368",
            "link_padding_mode" => "default",
            "link_padding_top" => 0,
            "link_padding_right" => 0,
            "link_padding_bottom" => 0,
            "link_padding_left" => 0,
            "link_padding_unit" => "px",
            "link_margin_mode" => "default",
            "link_margin_top" => 0,
            "link_margin_right" => 0,
            "link_margin_bottom" => 0,
            "link_margin_left" => 0,
            "link_margin_unit" => "px",
            "custom_css" => "",
        ];
		
        $default = apply_filters("dtoc_default_incontent_options_filter", $default);
        return $default;    
}
function dtoc_default_incontent_mobile_options(){
        $default = dtoc_option_types('all',['incontent_mobile'],'default');
        $default = apply_filters("dtoc_default_incontent_mobile_options_filter", $default);
        return $default;    
}
function dtoc_default_incontent_tablet_options(){
        $default = dtoc_option_types('all',['incontent_tablet'],'default');
        $default = apply_filters("dtoc_default_incontent_tablet_options_filter", $default);
        return $default;    
}
function dtoc_default_compatibility_options() {

        $default = [
             'plugins' => [
                'elementor' => true               
             ],
             'themes' => [
                'divi' => false             
             ]  
        ];

        $default = apply_filters("dtoc_default_compatibility_options_filter", $default);
        return $default;                        
}
function dtoc_default_dashboard_options() {

        $default = [
             'delete_plugin_data'           => false,   
             'modules' => [
                'incontent'                 => true,
                'incontent_mobile'          => false,
                'incontent_tablet'          => false,
                'sliding_sticky'            => false,
                'sliding_sticky_mobile'     => false,                
                'sticky_tablet'             => false,
                'floating'                  => false,
                'floating_mobile'           => false,
                'floating_tablet'           => false,
                'shortcode'                 => false,
                'shortcode_mobile'          => false,
                'shortcode_tablet'          => false,                      
             ]  
        ];

        $default = apply_filters("dtoc_default_dashboard_options_filter", $default);
        return $default;                        
}

function dtoc_default_shortcode_options() {

        $default = [
            "rendering_style" => "js",
            "display_title" => 1,
            "header_text" => "Table of Contents",
            "toggle_body" => 1,
            "toggle_initial" => "show",
            "header_icon" => "list_icon",
            "custom_icon_url" => "",
            "show_text" => "show",
            "hide_text" => "hide",
            "jump_links" => 1,
            "scroll_behavior" => "smooth",
            "alignment" => "left",
            "display_when" => 2,
            "display_position" => "top_of_the_content",
            "paragraph_number" => 1,
            "list_style_type" => "decimal",
            "headings_include" => [
                "1" => 1,
                "2" => 1,
                "3" => 1,
                "4" => 1,
                "5" => 1,
                "6" => 1,
            ],
            "hierarchy"          => 0,
            "combine_page_break" => 0,
            "accessibility"     => 1, 
            "preserve_line_breaks" => 0,           
            "exclude_headings" => '',
            "bg_color" => "#f9f9f9",
            "container_width_mode" => "default",
            "container_width" => 0,
            "container_width_unit" => "px",
            "container_height_mode" => "default",
            "design_type" => "px",
            "container_margin_mode" => "default",
            "container_margin_top" => 0,
            "container_margin_right" => 0,
            "container_margin_bottom" => 0,
            "container_margin_left" => 0,
            "container_margin_unit" => "px",
            "container_padding_mode" => "default",
            "container_padding_top" => 0,
            "container_padding_right" => 0,
            "container_padding_bottom" => 0,
            "container_padding_left" => 0,
            "container_padding_unit" => "px",
            "border_type" => "solid",
            "border_color" => "#dddddd",
            "border_width_mode" => "custom",
            "border_width_top" => 1,
            "border_width_right" => 1,
            "border_width_bottom" => 1,
            "border_width_left" => 1,
            "border_width_unit" => "px",
            "border_radius_mode" => "default",
            "border_radius_top_left" => 0,
            "border_radius_top_right" => 0,
            "border_radius_bottom_left" => 0,
            "border_radius_bottom_right" => 0,
            "border_radius_unit" => "px",
            "title_bg_color" => "#eeeeee",
            "title_fg_color" => "#222222",
            "title_font_size_mode" => "default",
            "title_font_size" => 0,
            "title_font_size_unit" => "px",
            "title_font_weight_mode" => "default",
            "title_font_weight" => 0,
            "title_padding_mode" => "default",
            "title_padding_top" => 0,
            "title_padding_right" => 0,
            "title_padding_bottom" => 0,
            "title_padding_left" => 0,
            "title_padding_unit" => "px",
            "icon_bg_color" => "#e0e0e0",
            "icon_fg_color" => "#333333",
            "icon_size_mode" => "default",
            "icon_width" => 25,
            "icon_height" => 25,
            "icon_size_unit" => "px",
            "icon_border_type" => "default",
            "icon_border_color" => "#D5E0EB",
            "icon_border_width_mode" => "default",
            "icon_border_width_top" => 0,
            "icon_border_width_right" => 0,
            "icon_border_width_bottom" => 0,
            "icon_border_width_left" => 0,
            "icon_border_width_unit" => "px",
            "icon_border_radius_mode" => "default",
            "icon_border_radius_top_left" => 0,
            "icon_border_radius_top_right" => 0,
            "icon_border_radius_bottom_left" => 0,
            "icon_border_radius_bottom_right" => 0,
            "icon_border_radius_unit" => "px",
            "icon_padding_mode" => "default",
            "icon_padding_top" => 0,
            "icon_padding_right" => 0,
            "icon_padding_bottom" => 0,
            "icon_padding_left" => 0,
            "icon_padding_unit" => "px",
            "icon_margin_mode" => "default",
            "icon_margin_top" => 0,
            "icon_margin_right" => 0,
            "icon_margin_bottom" => 0,
            "icon_margin_left" => 0,
            "icon_margin_unit" => "px",
            "link_color" => "#1a73e8",
            "link_hover_color" => "#0c47a1",
            "link_visited_color" => "#5f6368",
            "link_padding_mode" => "default",
            "link_padding_top" => 0,
            "link_padding_right" => 0,
            "link_padding_bottom" => 0,
            "link_padding_left" => 0,
            "link_padding_unit" => "px",
            "link_margin_mode" => "default",
            "link_margin_top" => 0,
            "link_margin_right" => 0,
            "link_margin_bottom" => 0,
            "link_margin_left" => 0,
            "link_margin_unit" => "px",
            "custom_css" => "",
        ];

        $default = apply_filters( "dtoc_default_shortcode_options_filter", $default );
        return $default;    

}

function dtoc_default_shortcode_mobile_options(){
        $default = dtoc_option_types('all',['shortcode_mobile'],'default');
        $default = apply_filters("dtoc_default_shortcode_mobile_options_filter", $default);
        return $default;    
}
function dtoc_default_shortcode_tablet_options(){
        $default = dtoc_option_types('all',['shortcode_tablet'],'default');
        $default = apply_filters("dtoc_default_shortcode_tablet_options_filter", $default);
        return $default;    
}
function dtoc_allowed_html_tags() {
    
    $my_allowed = wp_kses_allowed_html( 'post' );    
    $my_allowed['input'] = [
            'class'        => [],
            'id'           => [],
            'name'         => [],
            'value'        => [],
            'type'         => [],
            'style'        => [],
            'placeholder'  => [],
            'maxlength'    => [],
            'checked'      => [],
            'readonly'     => [],
            'disabled'     => [],
            'width'        => []            
    ];     
    $my_allowed['number'] = [
            'class'        => [],
            'id'           => [],
            'name'         => [],
            'value'        => [],
            'type'         => [],
            'style'        => [],                    
            'width'        => []            
    ];     
     $my_allowed['textarea'] = [
            'class' => [],
            'id'    => [],
            'name'  => [],
            'value' => [],
            'type'  => [],
            'style' => [],
            'rows'  => []
     ];                  
    $my_allowed['select'] = [
            'class'    => [],
            'id'       => [],
            'name'     => [],
            'value'    => [],
            'type'     => [],
            'required' => []
    ];    
    $my_allowed['option'] = [
            'selected' => [],
            'value'    => []
    ];                       
    $my_allowed['style'] = [
            'types'    => []
    ];

    return $my_allowed;
    
}

function dtoc_option_types ( $tab = 'all' , $settings = [] , $type ="default" ) {
	
	$options_types = [
    [
        'tab' => 'General',
        'label' => 'Jump Links',
        'name' => 'jump_links',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> '1',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Rendering Style',
        'name' => 'rendering_style',
        'type' => 'radio',
        'values' => [
            [
                'id' => 'js_rendering_style',
                'label' => 'JS-based',
                'value' => 'js'
            ],
            [
                'id' => 'css_rendering_style',
                'label' => 'CSS-based',
                'value' => 'css'
            ]
        ],
		'value' => 'js',
		'default' =>'js',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Scroll Behavior',
        'name' => 'scroll_behavior',
        'type' => 'radio',
        'values' => [
            [
                'id' => 'auto_scroll_behavior',
                'label' => 'Auto',
                'value' => 'auto'
            ],
            [
                'id' => 'smooth_scroll_behavior',
                'label' => 'Smooth',
                'value' => 'smooth'
            ]
        ],
		'value' => 'smooth',
		'default' =>'smooth',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Scroll Back TO TOC',
        'name' => 'scroll_back_to_top',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Header Text',
        'name' => 'header_text',
        'type' => 'text',
        'value' => '',
		'placeholder'=>'Table of Contents',
		'default' =>'Table of Contents',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Header Icon',
        'name' => 'header_icon',
        'type' => 'select',
        'options' => [
            '' => 'None',
            'plain_list' => 'Plain List',
            'updown_arrow' => 'Up Down Arrow',
            'list_updown_arrow' => 'List Up Down Arrow',
            'custom_text' => 'Custom Text',
            'custom_icon' => 'Custom Icon'
        ],
		'selected'=> '',
		'value' => 'list_updown_arrow',
		'default' =>'list_updown_arrow',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Alignment',
        'name' => 'alignment',
        'type' => 'radio',
        'values' => [
            [
                'id' => 'left_alignment',
                'label' => 'Left',
                'value' => 'left'
            ],
            [
                'id' => 'center_alignment',
                'label' => 'Center',
                'value' => 'center'
            ],
            [
                'id' => 'right_alignment',
                'label' => 'Right',
                'value' => 'right'
            ]
        ],
		'value' => 'left',
		'default' =>'left',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Wrap Content Around TOC',
        'name' => 'wrap_content',
        'type' => 'checkbox',
        'value' => '1',
		'default' =>'',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Hierarchy',
        'name' => 'hierarchy',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Expand / Collapse',
        'name' => 'exp_col_subheadings',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Show More',
        'name' => 'show_more',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'List Style Type',
        'name' => 'list_style_type',
        'type' => 'select',
        'options' => [
            'decimal' => 'Decimal numbers, start with 1.',
            'disc' => 'A filled circle.',
            '' => 'No item marker is shown.',
            'circle' => 'Circle',
            'square' => 'Square',
            
        ],
		'selected' => '',
		'value' => 'decimal',
		'default' =>'decimal',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Combine Page Break',
        'name' => 'combine_page_break',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Select Heading Tags',
        'name' => 'headings_include',
        'type' => 'checkbox_group',
        'options' => [
            '1' => 'H1',
            '2' => 'H2',
            '3' => 'H3',
            '4' => 'H4',
            '5' => 'H5',
            '6' => 'H6'
        ],
		'selected' => [],
		'value' => ['1'=> true,'2'=> true,'3'=> true,'4'=> true,'5'=> true,'6'=> true],
		'default' =>['1'=> true,'2'=> true,'3'=> true,'4'=> true,'5'=> true,'6'=> true],
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
	    [
        'tab' => 'Display',
        'label' => 'Display When',
        'name' => 'display_when',
        'type' => 'number',
        'min' => 1,
        'max' => 1000,
        'value' => '2',
        'description' => 'Headings is greater or equal to above number.',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'Display',
        'label' => 'Display Position',
        'name' => 'display_position',
        'type' => 'select',
        'options' => [
		     '' => 'Select',
            'before_first_heading' => 'Before First Heading',
            'after_first_heading' => 'After First Heading',
            'top_of_the_content' => 'Top Of The Content',
            'bottom_of_the_content' => 'Bottom Of The Content',
            'after_paragraph_number' => 'Middle Of The Content'
        ],
        'selected' => '',
		'value' => 'top_of_the_content',
		'default'=> 'top_of_the_content',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'Display',
        'label' => 'Display Title',
        'name' => 'display_title',
        'type' => 'checkbox',
        'value' => '1',
        'checked' => false,
		'default'=> false,
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'Display',
        'label' => 'Toggle Body',
        'name' => 'toggle_body',
        'type' => 'checkbox',
        'value' => '1',
        'checked' => false,
		'default'=> false,
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'Display',
        'label' => 'Toggle Initial',
        'name' => 'toggle_initial',
        'type' => 'select',
        'options' => [
			'' =>'',
            'show' => 'Show',
            'hide' => 'Hide'
        ],
		'value' => 'show',
        'selected' => 'show',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ]
	
	,
	 [
        'tab' => 'Display',
        'label' => 'Toggle Initial',
        'name' => 'position',
        'type' => 'select',
        'options' => [
            'show' => 'Show',
            'hide' => 'Hide'
        ],
		'value' => 'show',
        'selected' => 'show',
		'settings_for' => ['incontent','sliding_sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ]

	
];

$return_array = [];

foreach( $options_types as $option ){
	
	if(( $option['tab'] ==  $tab || $tab == "all" )   && ( empty($settings) || array_intersect($settings, $option['settings_for']))){
		if( $type == 'default'){
			if(isset($option['name']) && isset($option['default'])){
				$return_array [$option['name']] = $option['default'];
			}
				
		}else{
			$return_array[] = $option;
		}
	}
	
}

return $return_array;
}