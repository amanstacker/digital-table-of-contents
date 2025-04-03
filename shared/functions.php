<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', 'dtoc_options_init' );

function dtoc_options_init(){
    
	global $dtoc_dashboard, $dtoc_incontent, $dtoc_incontent_mobile, $dtoc_incontent_tablet, $dtoc_sticky, $dtoc_sticky_mobile, $dtoc_sticky_tablet, $dtoc_floating, $dtoc_floating_mobile, $dtoc_floating_tablet, $dtoc_shortcode, $dtoc_shortcode_mobile, $dtoc_shortcode_tablet, $dtoc_compatibility;

        $dtoc_dashboard          = get_option( 'dtoc_dashboard', dtoc_default_dashboard_options() );

        $dtoc_incontent          = get_option( 'dtoc_incontent', dtoc_default_incontent_options() );
        $dtoc_incontent_mobile   = get_option( 'dtoc_incontent_mobile', dtoc_default_incontent_mobile_options() );
        $dtoc_incontent_tablet   = get_option( 'dtoc_incontent_tablet', dtoc_default_incontent_tablet_options() );

        $dtoc_shortcode          = get_option( 'dtoc_shortcode', dtoc_default_shortcode_options() );
        $dtoc_shortcode_mobile   = get_option( 'dtoc_shortcode_mobile', dtoc_default_shortcode_mobile_options() );
        $dtoc_shortcode_tablet   = get_option( 'dtoc_shortcode_tablet', dtoc_default_shortcode_tablet_options() );

        $dtoc_sticky             = get_option( 'dtoc_sticky', dtoc_default_sticky_options() );
        $dtoc_sticky_mobile      = get_option( 'dtoc_sticky_mobile', dtoc_default_sticky_mobile_options() );
        $dtoc_sticky_tablet      = get_option( 'dtoc_sticky_tablet', dtoc_default_sticky_tablet_options() );

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
function dtoc_default_sticky_options(){
		$default = dtoc_option_types('all',['sticky'],'default');
        $default = apply_filters("dtoc_default_sticky_options_filter", $default);
        return $default;    
}
function dtoc_default_sticky_mobile_options(){
        $default = dtoc_option_types('all',['sticky_mobile'],'default');
        $default = apply_filters("dtoc_default_sticky_mobile_options_filter", $default);
        return $default;    
}
function dtoc_default_sticky_tablet_options(){
        $default = dtoc_option_types('all',['sticky_tablet'],'default');
        $default = apply_filters("dtoc_default_sticky_tablet_options_filter", $default);
        return $default;    
}
function dtoc_default_incontent_options(){
		$default = dtoc_option_types('all',['incontent'],'default');
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
             'delete_plugin_data'  => false,   
             'modules' => [
                'incontent_mobile' => false,
                'incontent_tablet' => false,
                'sticky'           => false,
                'sticky_mobile'    => false,
                'sticky_tablet'    => false,
                'floating'         => false,
                'floating_mobile'  => false,
                'floating_tablet'  => false,
                'shortcode'        => false,
                'shortcode_mobile' => false,
                'shortcode_tablet' => false,
                'compatibility'    => false       
             ]  
        ];

        $default = apply_filters("dtoc_default_dashboard_options_filter", $default);
        return $default;                        
}

function dtoc_default_shortcode_options(){
        $default = dtoc_option_types('all',['shortcode'],'default');
        $default = apply_filters("dtoc_default_shortcode_options_filter", $default);
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
    $my_allowed['input'] = array(
            'class'        => array(),
            'id'           => array(),
            'name'         => array(),
            'value'        => array(),
            'type'         => array(),
            'style'        => array(),
            'placeholder'  => array(),
            'maxlength'    => array(),
            'checked'      => array(),
            'readonly'     => array(),
            'disabled'     => array(),
            'width'        => array()            
    );     
    $my_allowed['number'] = array(
            'class'        => array(),
            'id'           => array(),
            'name'         => array(),
            'value'        => array(),
            'type'         => array(),
            'style'        => array(),                    
            'width'        => array()            
    );     
     $my_allowed['textarea'] = array(
            'class' => array(),
            'id'    => array(),
            'name'  => array(),
            'value' => array(),
            'type'  => array(),
            'style' => array(),
            'rows'  => array()
    );                  
    $my_allowed['select'] = array(
            'class'    => array(),
            'id'       => array(),
            'name'     => array(),
            'value'    => array(),
            'type'     => array(),
            'required' => array()
    );    
    $my_allowed['option'] = array(
            'selected' => array(),
            'value'    => array()
    );                       
    $my_allowed['style'] = array(
            'types'    => array()
    );
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Loading Type',
        'name' => 'loading_type',
        'type' => 'radio',
        'values' => [
            [
                'id' => 'js_loading_type',
                'label' => 'JS',
                'value' => 'js'
            ],
            [
                'id' => 'css_loading_type',
                'label' => 'CSS',
                'value' => 'css'
            ]
        ],
		'value' => 'js',
		'default' =>'js',
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Scroll Back TO TOC',
        'name' => 'scroll_back_to_top',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Header Text',
        'name' => 'header_text',
        'type' => 'text',
        'value' => '',
		'placeholder'=>'Table Of Contents',
		'default' =>'Table Of Contents',
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Wrap Content Around TOC',
        'name' => 'wrap_content',
        'type' => 'checkbox',
        'value' => '1',
		'default' =>'',
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Hierarchy',
        'name' => 'hierarchy',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Expand / Collapse',
        'name' => 'exp_col_subheadings',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Show More',
        'name' => 'show_more',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'General',
        'label' => 'Combine Page Break',
        'name' => 'combine_page_break',
        'type' => 'checkbox',
        'value' => '1',
		'default'=> false,
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'Display',
        'label' => 'Display Title',
        'name' => 'display_title',
        'type' => 'checkbox',
        'value' => '1',
        'checked' => false,
		'default'=> false,
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
    ],
    [
        'tab' => 'Display',
        'label' => 'Toggle Body',
        'name' => 'toggle_body',
        'type' => 'checkbox',
        'value' => '1',
        'checked' => false,
		'default'=> false,
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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
		'settings_for' => ['incontent','sticky','floating','shortcode','incontent_mobile','sticky_mobile','floating_mobile','shortcode_mobile','incontent_tablet','sticky_tablet','floating_tablet','shortcode_tablet']
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