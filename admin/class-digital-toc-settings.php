<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Digital_TOC_Settings{

private $_page_title        = '';
private $_setting_name      = '';	
private $_setting_option    = [];	
private $_shortcode_modules = ['dtoc_shortcode', 'dtoc_shortcode_mobile', 'dtoc_shortcode_tablet'];
private $_meta_setting_name = '';


public function __construct(){
	add_action('admin_menu', [$this, 'dtoc_add_menu_links'],11);
	add_action('admin_init', [$this, 'dtoc_settings_initiate']);
}

public function dtoc_add_menu_links(){
	
    add_submenu_page(
		'dtoc',
		'Digital Table of Contents In-Content',
        'In-Content',
		'manage_options',
		'dtoc_incontent',
        [$this, 'dtoc_settings_page_render']				
	);
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents In-Content',
    //     'In-Content Mobile',
	// 	'manage_options',
	// 	'dtoc_incontent_mobile',
    //     [$this, 'dtoc_settings_page_render']				
	// );
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents In-Content',
    //     'In-Content Tablet',
	// 	'manage_options',
	// 	'dtoc_incontent_tablet',
    //     [$this, 'dtoc_settings_page_render']				
	// );	
    
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents Sticky',
    //     'Sticky Mobile',
	// 	'manage_options',
	// 	'dtoc_sticky_mobile',
    //     [$this, 'dtoc_settings_page_render']				
	// );
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents Sticky',
    //     'Sticky Tablet',
	// 	'manage_options',
	// 	'dtoc_sticky_tablet',
    //     [$this, 'dtoc_settings_page_render']				
	// );
    // add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents Floating',
    //     'Floating',
	// 	'manage_options',
	// 	'dtoc_floating',
    //     [$this, 'dtoc_settings_page_render']				
	// );
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents Floating',
    //     'Floating Mobile',
	// 	'manage_options',
	// 	'dtoc_floating_mobile',
    //     [$this, 'dtoc_settings_page_render']				
	// );
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents Floating',
    //     'Floating Tablet',
	// 	'manage_options',
	// 	'dtoc_floating_tablet',
    //     [$this, 'dtoc_settings_page_render']
	// );
	add_submenu_page(
		'dtoc',
		'Digital Table of Contents Shortcode',
        'Shortcode',
		'manage_options',
		'dtoc_shortcode',
        [$this, 'dtoc_settings_page_render']				
	);
    add_submenu_page(
		'dtoc',
		'Digital Table of Contents Sticky',
        'Sticky',
		'manage_options',
		'dtoc_sticky',
        [$this, 'dtoc_settings_page_render']				
	);
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents Shortcode',
    //     'Shortcode Mobile',
	// 	'manage_options',
	// 	'dtoc_shortcode_mobile',
    //     [$this, 'dtoc_settings_page_render']				
	// );
	// add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table of Contents Shortcode',
    //     'Shortcode Tablet',
	// 	'manage_options',
	// 	'dtoc_shortcode_tablet',
    //     [$this, 'dtoc_settings_page_render']
	// );		

}

private function dtoc_initialize_class_properties(){

if(function_exists('get_current_screen')){
		
		$screen_id = get_current_screen()->id;
		$this->_setting_name = str_replace('digital-toc_page_','',$screen_id);
		global $dtoc_incontent, $dtoc_incontent_mobile,$dtoc_incontent_tablet, $dtoc_sticky, $dtoc_sticky_mobile, $dtoc_sticky_tablet, $dtoc_floating, $dtoc_floating_mobile, $dtoc_floating_tablet, $dtoc_shortcode, $dtoc_shortcode_mobile, $dtoc_shortcode_tablet;
		
		switch ($this->_setting_name) {
			case 'dtoc_incontent':				
				$this->_page_title     = 'In-Content';
				$this->_setting_option = $dtoc_incontent;
				break;
			case 'dtoc_incontent_mobile':	
				$this->_page_title     = 'In-Content Mobile';			
				$this->_setting_option = $dtoc_incontent_mobile;
				break;
			case 'dtoc_incontent_tablet':	
				$this->_page_title     = 'In-Content Tablet';			
				$this->_setting_option = $dtoc_incontent_tablet;
				break;
			case 'dtoc_sticky':				
				$this->_page_title     = 'Sticky';
				$this->_setting_option = $dtoc_sticky;
				break;
			case 'dtoc_sticky_mobile':		
				$this->_page_title     = 'Sticky Mobile';		
				$this->_setting_option = $dtoc_sticky_mobile;
				break;
			case 'dtoc_sticky_tablet':		
				$this->_page_title     = 'Sticky Tablet';		
				$this->_setting_option = $dtoc_sticky_tablet;
				break;
			case 'dtoc_floating':			
				$this->_page_title     = 'Floating';	
				$this->_setting_option = $dtoc_floating;
				break;
			case 'dtoc_floating_mobile':	
				$this->_page_title     = 'Floating Mobile';			
				$this->_setting_option = $dtoc_floating_mobile;
				break;
			case 'dtoc_floating_tablet':	
				$this->_page_title     = 'Floating Tablet';			
				$this->_setting_option = $dtoc_floating_tablet;
				break;
			case 'dtoc_shortcode':			
				$this->_page_title     = 'Shortcode';	
				$this->_setting_option = $dtoc_shortcode;
				break;
			case 'dtoc_shortcode_mobile':				
				$this->_page_title     = 'Shortcode Mobile';
				$this->_setting_option = $dtoc_shortcode_mobile;
				break;
			case 'dtoc_shortcode_tablet':	
				$this->_page_title     = 'Shortcode Tablet';			
				$this->_setting_option = $dtoc_shortcode_tablet;
				break;
			default:
				# code...
				break;
		}

	}
}
public function dtoc_settings_page_render(){	
    // Authentication
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
    // Handing save settings
	if ( isset( $_GET['settings-updated'] ) ) {
		settings_errors();               
	}
	$this->dtoc_initialize_class_properties();
    
    $tab_array         = [];
    $tab_array[]       = 'general';
    $tab_array[]       = 'advanced';        
    if(!in_array($this->_setting_name, $this->_shortcode_modules)){
        $tab_array[]       = 'placement';    
    }    
    $tab_array[] = 'customization';
    if(in_array($this->_setting_name, $this->_shortcode_modules)){
        $tab_array[]       = 'shortcode_source';    
    }
    $tab = dtoc_admin_get_tab('general', $tab_array);
    ?>
    <div class="wrap dtoc-main-container">
    <h1 class="wp-heading-inline"><?php echo esc_html__('Digital Table of Contents', 'digital-table-of-contents'); ?> | <?php echo $this->_page_title; ?></h1>    
    <!-- setting form start here -->
    <div class="dtoc-main-wrapper">
    <div class="dtoc-form-options">
     
     <h2 class="nav-tab-wrapper dtoc-tabs">
                     <?php					
                         echo '<a href="' . esc_url(dtoc_admin_tab_link('general', $this->_setting_name)) . '" class="nav-tab ' . esc_attr( $tab == 'general' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-welcome-view-site"></span> ' . esc_html__('General','digital-table-of-contents') . '</a>';                                                
                         echo '<a href="' . esc_url(dtoc_admin_tab_link('advanced', $this->_setting_name)) . '" class="nav-tab ' . esc_attr( $tab == 'advanced' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-admin-tools"></span> ' . esc_html__('Advanced','digital-table-of-contents') . '</a>';		                                    
                         if(!in_array($this->_setting_name, $this->_shortcode_modules)){
                            echo '<a href="' . esc_url(dtoc_admin_tab_link('placement', $this->_setting_name)) . '" class="nav-tab ' . esc_attr( $tab == 'placement' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-location"></span> ' . esc_html__('Placement','digital-table-of-contents') . '</a>';		                                    
                         }                         
                         echo '<a href="' . esc_url(dtoc_admin_tab_link('customization', $this->_setting_name)) . '" class="nav-tab ' . esc_attr( $tab == 'customization' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-admin-customizer"></span> ' . esc_html__('Customization','digital-table-of-contents') . '</a>';                                                
                         if(in_array($this->_setting_name, $this->_shortcode_modules)){
                            echo '<a href="' . esc_url(dtoc_admin_tab_link('shortcode_source', $this->_setting_name)) . '" class="nav-tab ' . esc_attr( $tab == 'shortcode_source' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-shortcode"></span> ' . esc_html__('Shortcode Source','digital-table-of-contents') . '</a>';
                         }
                     ?>
                 </h2>
     <form action="options.php" method="post" enctype="multipart/form-data" class="dtoc-settings-form">
             <div class="dtoc-settings-form-wrap">
             <?php
                 settings_fields( $this->_setting_name.'_group' );	
                 //General tab
                 echo "<div class='dtoc-general' ".( $tab != 'general' ? 'style="display:none;"' : '').">";                
                     do_settings_sections( 'dtoc_general_setting_section' );	
                 echo "</div>";
                 //Display tab
                 echo "<div class='dtoc-advanced' ".( $tab != 'advanced' ? 'style="display:none;"' : '').">";                
                     do_settings_sections( 'dtoc_advanced_setting_section' );	
                 echo "</div>"; 
                 if(!in_array($this->_setting_name, $this->_shortcode_modules)){
                    //Placement
                 echo "<div class='dtoc-placement' ".( $tab != 'placement' ? 'style="display:none;"' : '').">";
                    $this->dtoc_placement_setting_section_cb();                    
                 echo "</div>"; 
                 }                 
                 //Digital tab
                 echo "<div class='dtoc-customization' ".( $tab != 'customization' ? 'style="display:none;"' : '').">";                

                 echo "<div class='dtoc-accordion'>";
                 echo "<div class='dtoc-accordion-header'>";                 
                 echo '<span>'. esc_html__( 'Container', 'digital-table-of-contents' ). '</span>';
                 echo "</div>";
                 echo "<div class='dtoc-accordion-panel'>";                 
                 do_settings_sections( 'dtoc_customization_container_section' );
                 echo "</div>";
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";
                 echo "<div class='dtoc-accordion-header'>";                                  
                 echo '<span>'. esc_html__( 'Border', 'digital-table-of-contents' ). '</span>';
                 echo "</div>";
                 echo "<div class='dtoc-accordion-panel'>";                 
                 do_settings_sections( 'dtoc_customization_border_section' );
                 echo "</div>";
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";
                 echo "<div class='dtoc-accordion-header'>";                 
                 echo '<span>'. esc_html__( 'Title', 'digital-table-of-contents' ). '</span>';
                 echo "</div>";
                 echo "<div class='dtoc-accordion-panel'>";                 
                 do_settings_sections( 'dtoc_customization_title_section' );
                 echo "</div>";
                 echo "</div>";

                 if ( $this->_setting_name == 'dtoc_sticky' ) {

                    echo "<div class='dtoc-accordion'>";
                    echo "<div class='dtoc-accordion-header'>";                 
                    echo '<span>'. esc_html__( 'Toggle Button', 'digital-table-of-contents' ). '</span>';
                    echo "</div>";
                    echo "<div class='dtoc-accordion-panel'>";                 
                    do_settings_sections( 'dtoc_customization_toggle_btn_section' );
                    echo "</div>";
                    echo "</div>";

                 }else{

                    echo "<div class='dtoc-accordion'>";
                    echo "<div class='dtoc-accordion-header'>";                 
                    echo '<span>'. esc_html__( 'Icon', 'digital-table-of-contents' ). '</span>';
                    echo "</div>";
                    echo "<div class='dtoc-accordion-panel'>";                 
                    do_settings_sections( 'dtoc_customization_icon_section' );
                    echo "</div>";
                    echo "</div>";

                 }
                 
                 
                 echo "<div class='dtoc-accordion'>";
                 echo "<div class='dtoc-accordion-header'>";                 
                 echo '<span>'. esc_html__( 'Link', 'digital-table-of-contents' ). '</span>';
                 echo "</div>";
                 echo "<div class='dtoc-accordion-panel'>";                 
                 do_settings_sections( 'dtoc_customization_link_section' );
                 echo "</div>";
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";
                 echo "<div class='dtoc-accordion-header'>";                                  
                 echo '<span>'. esc_html__( 'Custom CSS', 'digital-table-of-contents' ). '</span>';
                 echo "</div>";
                 echo "<div class='dtoc-accordion-panel'>";                 
                 $this->dtoc_customization_custom_css_cb();                                    
                 echo "</div>";
                 echo "</div>";                                                                                     
                     
                 echo "</div>";                 

                 if ( in_array( $this->_setting_name, $this->_shortcode_modules ) ) {
                    //Shortcode Source
                 echo "<div class='dtoc-shortcode_source' ".( $tab != 'shortcode_source' ? 'style="display:none;"' : '').">";                     
                     $this->dtoc_shortcode_source(); 
                 echo "</div>"; 

                 }
             ?>
         </div>
 
             <div class="button-wrapper">                                                                
                 <?php submit_button( esc_html__('Save Settings', 'digital-table-of-contents') ); ?>
             </div>  
             
         </form>
     </div>
    <div class="dtoc-preview-wrapper">

    <?php
        echo '<div class="wrap">';
    // your settings UI
    require_once( DTOC_PATH . '/admin/live-preview-soon.php' );
    
    echo '</div>';
       // echo dtoc_get_live_preview_by_type($this->_setting_name, $this->_setting_option);
     ?>
        
    </div>
    </div>    
    <!-- setting form ends here -->
    </div>
    <?php

}

public function dtoc_settings_initiate(){

    $page = 'dtoc_incontent';

    if ( isset( $_GET['page'] ) ) {
		$page = sanitize_key( wp_unslash( $_GET['page'] ) );
	}    
	
    /**
	 * ---------------------------------
	 * Register Setting Groups
	 * ---------------------------------
	 */

    $settings_groups = [
		'dtoc_incontent_group'         => 'dtoc_incontent',
		'dtoc_incontent_mobile_group'  => 'dtoc_incontent_mobile',
		'dtoc_incontent_tablet_group'  => 'dtoc_incontent_tablet',

		'dtoc_sticky_group'            => 'dtoc_sticky',
		'dtoc_sticky_mobile_group'     => 'dtoc_sticky_mobile',
		'dtoc_sticky_tablet_group'     => 'dtoc_sticky_tablet',

		'dtoc_floating_group'          => 'dtoc_floating',
		'dtoc_floating_mobile_group'   => 'dtoc_floating_mobile',
		'dtoc_floating_tablet_group'   => 'dtoc_floating_tablet',

		'dtoc_shortcode_group'         => 'dtoc_shortcode',
		'dtoc_shortcode_mobile_group'  => 'dtoc_shortcode_mobile',
		'dtoc_shortcode_tablet_group'  => 'dtoc_shortcode_tablet',
	];

	foreach ( $settings_groups as $group => $option ) {
		register_setting( $group, $option, 'dtoc_sanitize_register_setting' );
	}

    /**
	 * ---------------------------------
	 * Settings Sections
	 * ---------------------------------
	 */
	$sections = [
		'dtoc_general_setting_section',
		'dtoc_customization_container_section',
		'dtoc_customization_title_section',
		'dtoc_customization_icon_section',
        'dtoc_customization_toggle_btn_section',
		'dtoc_customization_border_section',
		'dtoc_customization_link_section',
		'dtoc_advanced_setting_section',
	];

	foreach ( $sections as $section ) {
		add_settings_section( $section, __return_false(), '__return_false', $section );
	} 
    
    /**
	 * ---------------------------------
	 * Settings Fields (generic config)
	 * Each field can define "pages" => ['dtoc_incontent', 'dtoc_sticky', ...]
	 * If "pages" not set, it will show everywhere.
	 * ---------------------------------
	 */

    $fields = [
		'dtoc_general_rendering_style' => [
			'title'    => __( 'Rendering Style', 'digital-table-of-contents' ),
			'callback' => 'dtoc_general_rendering_style_cb',
			'section'  => 'dtoc_general_setting_section',
			'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		],
		'dtoc_display_title' => [
			'title'    => __( 'Title', 'digital-table-of-contents' ),
			'callback' => 'dtoc_display_title_cb',
			'section'  => 'dtoc_general_setting_section',
			'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
			'args'     => [ 'label_for' => 'display_title' ],
		],
		'dtoc_general_header_text' => [
			'title'    => __( 'Text', 'digital-table-of-contents' ),
			'callback' => 'dtoc_general_header_text_cb',
			'section'  => 'dtoc_general_setting_section',
			'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
			'args'     => [ 'class' => 'dtoc_child_opt dtoc_display_title' ],
		],	
        'dtoc_display_toggle_body' => [
		'title'    => __( 'Toggle', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_toggle_body_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
		'args'     => [
			'class'     => 'dtoc_child_opt dtoc_display_title',
			'label_for' => 'toggle_body',
		],
	],
	'dtoc_display_toggle_initial' => [
		'title'    => __( 'Initial Body View', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_toggle_initial_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
		'args'     => [
			'class' => 'dtoc_child_opt dtoc_2_label_child_opt dtoc_display_title',
		],
	],    
	'dtoc_display_toggle_initial' => [
		'title'    => __( 'Initial Body View', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_toggle_initial_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_sticky' ],
		'args'     => [
			'class' => 'dtoc_toggle_body',
		],
	], 
    'dtoc_general_toggle_btn_text' => [
			'title'    => __( 'Toggle Button Text', 'digital-table-of-contents' ),
			'callback' => 'dtoc_general_toggle_btn_text_cb',
			'section'  => 'dtoc_general_setting_section',
			'pages'    => [ 'dtoc_sticky' ],
			'args'     => [ 'class' => 'dtoc_toggle_body' ],
	],	   
	'dtoc_general_header_icon' => [
		'title'    => __( 'Icon', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_header_icon_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
		'args'     => [
			'class' => 'dtoc_child_opt dtoc_2_label_child_opt dtoc_display_title',
		],
	],
	'dtoc_general_show_text' => [
		'title'    => __( 'Show Text', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_show_text_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
		'args'     => [
			'class' => 'dtoc_child_opt dtoc_2_label_child_opt dtoc_3_label_child_opt dtoc_display_title',
		],
	],
	'dtoc_general_hide_text' => [
		'title'    => __( 'Hide Text', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_hide_text_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
		'args'     => [
			'class' => 'dtoc_child_opt dtoc_2_label_child_opt dtoc_3_label_child_opt dtoc_display_title',
		],
	],	
    'dtoc_general_jump_links' => [
		'title'    => __( 'Jump Links', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_jump_links_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [
			'label_for' => 'jump_links',
		],
	],
	'dtoc_general_scroll_behavior' => [
		'title'    => __( 'Scroll Behavior', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_scroll_behavior_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [
			'class' => 'dtoc_child_opt dtoc_jump_links',
		],
	],
	'dtoc_general_scroll_back_to_toc' => [
		'title'    => __( 'Scroll Back to TOC', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_scroll_back_to_toc_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
		'args'     => [
			'label_for' => 'scroll_back_to_toc',
			'class'     => 'dtoc_child_opt dtoc_jump_links',
		],
	],
	'dtoc_general_alignment' => [
		'title'    => __( 'Alignment', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_alignment_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
	],
	'dtoc_general_wrap_content' => [
		'title'    => __( 'Wrap Content Around', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_wrap_content_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
		'args'     => [
			'label_for' => 'wrap_content',
		],
	],
    'dtoc_display_When' => [
		'title'    => __( 'Display When', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_when_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_position' => [
		'title'    => __( 'Position', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_position_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
	],
    'dtoc_position' => [
		'title'    => __( 'Position', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_sticky_position_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_sticky'],
	],
	'dtoc_paragraph_number' => [
		'title'    => __( 'Paragraph Number', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_paragraph_number_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [
			'label_for' => 'paragraph_number',
			'class'     => 'dtoc_child_opt dtoc_paragraph_number',
		],
	],
	'dtoc_general_list_style_type' => [
		'title'    => __( 'List Style Type', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_list_style_type_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_general_headings_include' => [
		'title'    => __( 'Select Heading Tags', 'digital-table-of-contents' ),
		'callback' => 'dtoc_general_headings_include_cb',
		'section'  => 'dtoc_general_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
    'dtoc_customization_title_bg_color' => [
		'title'    => __( 'Background Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_title_bg_color_cb',
		'section'  => 'dtoc_customization_title_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_title_fg_color' => [
		'title'    => __( 'Foreground Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_title_fg_color_cb',
		'section'  => 'dtoc_customization_title_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_title_font_size' => [
		'title'    => __( 'Font Size', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_title_font_size_cb',
		'section'  => 'dtoc_customization_title_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_title_font_weight' => [
		'title'    => __( 'Font Weight', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_title_font_weight_cb',
		'section'  => 'dtoc_customization_title_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_title_padding' => [
		'title'    => __( 'Padding', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_title_padding_cb',
		'section'  => 'dtoc_customization_title_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
    'dtoc_customization_toggle_btn_bg_color' => [
		'title'    => __( 'Background Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_bg_color_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky'],
	],
	'dtoc_customization_toggle_btn_fg_color' => [
		'title'    => __( 'Foreground Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_fg_color_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky' ],
	],
	'dtoc_customization_toggle_btn_size_color' => [
		'title'    => __( 'Size', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_size_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky' ],
	],
	'dtoc_customization_toggle_btn_border_type' => [
		'title'    => __( 'Border Type', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_border_type_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky'],
	],
	'dtoc_customization_toggle_btn_border_color' => [
		'title'    => __( 'Border Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_border_color_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky' ],
	],
	'dtoc_customization_toggle_btn_border_width' => [
		'title'    => __( 'Border Width', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_border_width_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky' ],
	],
	'dtoc_customization_toggle_btn_border_radius' => [
		'title'    => __( 'Border Radius', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_border_radius_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky' ],
	],
	'dtoc_customization_toggle_btn_padding' => [
		'title'    => __( 'Padding', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_toggle_btn_padding_cb',
		'section'  => 'dtoc_customization_toggle_btn_section',
		'pages'    => [ 'dtoc_sticky' ],
	],	
    'dtoc_customization_icon_bg_color' => [
		'title'    => __( 'Background Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_bg_color_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_fg_color' => [
		'title'    => __( 'Foreground Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_fg_color_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_size_color' => [
		'title'    => __( 'Size', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_size_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_border_type' => [
		'title'    => __( 'Border Type', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_border_type_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_border_color' => [
		'title'    => __( 'Border Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_border_color_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_border_width' => [
		'title'    => __( 'Border Width', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_border_width_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_border_radius' => [
		'title'    => __( 'Border Radius', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_border_radius_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_padding' => [
		'title'    => __( 'Padding', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_padding_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_icon_margin' => [
		'title'    => __( 'Margin', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_icon_margin_cb',
		'section'  => 'dtoc_customization_icon_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
    
	'dtoc_customization_bg_color' => [
		'title'    => __( 'Background Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_bg_color_cb',
		'section'  => 'dtoc_customization_container_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_link_color' => [
		'title'    => __( 'Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_link_color_cb',
		'section'  => 'dtoc_customization_link_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_link_hover_color' => [
		'title'    => __( 'Hover Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_link_hover_color_cb',
		'section'  => 'dtoc_customization_link_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_link_visited_color' => [
		'title'    => __( 'Visited Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_link_visited_color_cb',
		'section'  => 'dtoc_customization_link_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_link_padding' => [
		'title'    => __( 'Padding', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_link_padding_cb',
		'section'  => 'dtoc_customization_link_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_link_margin' => [
		'title'    => __( 'Margin', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_link_margin_cb',
		'section'  => 'dtoc_customization_link_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_container_width' => [
		'title'    => __( 'Width', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_container_width_cb',
		'section'  => 'dtoc_customization_container_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_container_height' => [
		'title'    => __( 'Height', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_container_height_cb',
		'section'  => 'dtoc_customization_container_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_container_margin' => [
		'title'    => __( 'Margin', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_container_margin_cb',
		'section'  => 'dtoc_customization_container_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_container_padding' => [
		'title'    => __( 'Padding', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_container_padding_cb',
		'section'  => 'dtoc_customization_container_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_border_type' => [
		'title'    => __( 'Type', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_border_type_cb',
		'section'  => 'dtoc_customization_border_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_border_color' => [
		'title'    => __( 'Color', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_border_color_cb',
		'section'  => 'dtoc_customization_border_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_border_width' => [
		'title'    => __( 'Width', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_border_width_cb',
		'section'  => 'dtoc_customization_border_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_customization_border_radius' => [
		'title'    => __( 'Radius', 'digital-table-of-contents' ),
		'callback' => 'dtoc_customization_border_radius_cb',
		'section'  => 'dtoc_customization_border_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
	],
	'dtoc_display_hierarchy' => [
		'title'    => __( 'Hierarchy', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_hierarchy_cb',
		'section'  => 'dtoc_advanced_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [ 'label_for' => 'hierarchy' ],
	],
	'dtoc_display_exp_col_subheadings' => [
		'title'    => __( 'Expand / Collapse', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_exp_col_subheadings_cb',
		'section'  => 'dtoc_advanced_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [ 'label_for' => 'exp_col_subheadings', 'class' => 'dtoc_child_opt dtoc_hierarchy' ],
	],
	'dtoc_display_show_more' => [
		'title'    => __( 'Show More', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_show_more_cb',
		'section'  => 'dtoc_advanced_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [ 'label_for' => 'show_more' ],
	],
	'dtoc_display_combine_page_break' => [
		'title'    => __( 'Combine Page Break', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_combine_page_break_cb',
		'section'  => 'dtoc_advanced_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [ 'label_for' => 'combine_page_break' ],
	],
	'dtoc_display_accessibility' => [
		'title'    => __( 'Accessibility', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_accessibility_cb',
		'section'  => 'dtoc_advanced_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [ 'label_for' => 'accessibility' ],
	],
	'dtoc_display_preserve_line_breaks' => [
		'title'    => __( 'Preserve Line Breaks', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_preserve_line_breaks_cb',
		'section'  => 'dtoc_advanced_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [ 'label_for' => 'preserve_line_breaks' ],
	],
	'dtoc_display_exclude_headings' => [
		'title'    => __( 'Exclude Headings', 'digital-table-of-contents' ),
		'callback' => 'dtoc_display_exclude_headings_cb',
		'section'  => 'dtoc_advanced_setting_section',
		'pages'    => [ 'dtoc_incontent', 'dtoc_sticky', 'dtoc_shortcode' ],
		'args'     => [ 'label_for' => 'exclude_headings' ],
	],
	];
    
    // Dynamically register fields for this page
	foreach ( $fields as $id => $field ) {
		$pages = ! empty( $field['pages'] ) ? $field['pages'] : [ $page ]; // if no pages set, assume all
		if ( in_array( $page, $pages, true ) ) {
			add_settings_field(
				$id,
				esc_html( $field['title'] ),
				[ $this, $field['callback'] ],
				$field['section'],
				$field['section'],
				! empty( $field['args'] ) ? $field['args'] : []
			);
		}
	}
                       
}

public function dtoc_display_exclude_headings_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>  
        <textarea cols="45" rows="3" class="smpg-input" name="<?php echo $this->_setting_name; ?>[exclude_headings]" id="exclude_headings"><?php echo (isset($this->_setting_option['exclude_headings']) ? $this->_setting_option['exclude_headings'] : '' ) ?></textarea>        
        <p>Separate multiple headings with a pipe |. Use an asterisk * as a wildcard to match other text.</p>
        <strong>Example:</strong>
        <p>Fruit* : Ignore headings starting with "Fruit".</p>
        <p>*Fruit Diet* Ignore headings with "Fruit Diet" somewhere in the heading.</p>
        <p>Apple Tree|Oranges|Yellow Bananas Ignore headings that are exactly "Apple Tree", "Oranges" or "Yellow Bananas".</p>
    <?php
}
public function dtoc_display_preserve_line_breaks_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[preserve_line_breaks]" id="preserve_line_breaks" type="checkbox" value="1" <?php echo (isset($this->_setting_option['preserve_line_breaks']) && $this->_setting_option['preserve_line_breaks'] == 1 ? 'checked' : '' ) ?>>
        
    <?php
}
public function dtoc_display_accessibility_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[accessibility]" id="accessibility" type="checkbox" value="1" <?php echo (isset($this->_setting_option['accessibility']) && $this->_setting_option['accessibility'] == 1 ? 'checked' : '' ) ?>>
        
    <?php
}

public function dtoc_display_combine_page_break_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[combine_page_break]" id="combine_page_break" type="checkbox" value="1" <?php echo (isset($this->_setting_option['combine_page_break']) && $this->_setting_option['combine_page_break'] == 1 ? 'checked' : '' ) ?>>
        
    <?php
}

public function dtoc_display_hierarchy_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>  
        <input class="dtoc_parent_option smpg-input" name="<?php echo $this->_setting_name; ?>[hierarchy]" id="hierarchy" type="checkbox" value="1" <?php echo (isset($this->_setting_option['hierarchy']) && $this->_setting_option['hierarchy'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_display_exp_col_subheadings_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[exp_col_subheadings]" id="exp_col_subheadings" type="checkbox" value="1" <?php echo (isset($this->_setting_option['exp_col_subheadings']) && $this->_setting_option['exp_col_subheadings'] == 1 ? 'checked' : '' ) ?>>
    <?php
}

public function dtoc_general_list_style_type_cb() {
    $this->dtoc_resolve_meta_settings_name();

    $current_value = isset($this->_setting_option['list_style_type']) ? $this->_setting_option['list_style_type'] : '';

    $groups = [
        'Common Styles' => [
            'decimal' => __( 'Decimal (1, 2, 3)', 'digital-table-of-contents' ),
            'decimal-leading-zero' => __( 'Decimal with Leading Zero (01, 02)', 'digital-table-of-contents' ),
            'disc' => __( 'Disc (●)', 'digital-table-of-contents' ),
            'circle' => __( 'Circle (○)', 'digital-table-of-contents' ),
            'square' => __( 'Square (■)', 'digital-table-of-contents' ),
            'none' => __( 'No Marker', 'digital-table-of-contents' ),
        ],
        'Alphabetic' => [
            'lower-alpha' => __( 'Lowercase Alphabet (a, b, c)', 'digital-table-of-contents' ),
            'upper-alpha' => __( 'Uppercase Alphabet (A, B, C)', 'digital-table-of-contents' ),
        ],
        'Roman Numerals' => [
            'lower-roman' => __( 'Lowercase Roman (i, ii, iii)', 'digital-table-of-contents' ),
            'upper-roman' => __( 'Uppercase Roman (I, II, III)', 'digital-table-of-contents' ),
        ],
        'Language-Specific Styles' => [
            'arabic-indic' => __( 'Arabic-Indic', 'digital-table-of-contents' ),
            'devanagari' => __( 'Devanagari', 'digital-table-of-contents' ),
            'bengali' => __( 'Bengali', 'digital-table-of-contents' ),
            'gujarati' => __( 'Gujarati', 'digital-table-of-contents' ),
            'gurmukhi' => __( 'Gurmukhi', 'digital-table-of-contents' ),
            'kannada' => __( 'Kannada', 'digital-table-of-contents' ),
            'malayalam' => __( 'Malayalam', 'digital-table-of-contents' ),
            'oriya' => __( 'Oriya', 'digital-table-of-contents' ),
            'tamil' => __( 'Tamil', 'digital-table-of-contents' ),
            'telugu' => __( 'Telugu', 'digital-table-of-contents' ),
            'urdu' => __( 'Urdu', 'digital-table-of-contents' ),
            'thai' => __( 'Thai', 'digital-table-of-contents' ),
            'lao' => __( 'Lao', 'digital-table-of-contents' ),
            'myanmar' => __( 'Myanmar', 'digital-table-of-contents' ),
            'tibetan' => __( 'Tibetan', 'digital-table-of-contents' ),
            'persian' => __( 'Persian', 'digital-table-of-contents' ),
            'cambodian' => __( 'Cambodian/Khmer', 'digital-table-of-contents' ),
        ],
        'CJK & East Asian Styles' => [
            'cjk-decimal' => __( 'CJK Decimal', 'digital-table-of-contents' ),
            'cjk-earthly-branch' => __( 'CJK Earthly Branch', 'digital-table-of-contents' ),
            'cjk-heavenly-stem' => __( 'CJK Heavenly Stem', 'digital-table-of-contents' ),
            'japanese-formal' => __( 'Japanese Formal', 'digital-table-of-contents' ),
            'japanese-informal' => __( 'Japanese Informal', 'digital-table-of-contents' ),
            'korean-hangul-formal' => __( 'Korean Hangul (Formal)', 'digital-table-of-contents' ),
            'korean-hanja-informal' => __( 'Korean Hanja (Informal)', 'digital-table-of-contents' ),
            'simp-chinese-formal' => __( 'Simplified Chinese (Formal)', 'digital-table-of-contents' ),
            'simp-chinese-informal' => __( 'Simplified Chinese (Informal)', 'digital-table-of-contents' ),
            'trad-chinese-formal' => __( 'Traditional Chinese (Formal)', 'digital-table-of-contents' ),
            'trad-chinese-informal' => __( 'Traditional Chinese (Informal)', 'digital-table-of-contents' ),
            'cjk-ideographic' => __( 'CJK Ideographic (Informal)', 'digital-table-of-contents' ),
        ],
        'Other Styles' => [
            'armenian' => __( 'Armenian', 'digital-table-of-contents' ),
            'upper-armenian' => __( 'Upper Armenian', 'digital-table-of-contents' ),
            'lower-armenian' => __( 'Lower Armenian', 'digital-table-of-contents' ),
            'georgian' => __( 'Georgian', 'digital-table-of-contents' ),
            'ethiopic-numeric' => __( 'Ethiopic', 'digital-table-of-contents' ),
            'mongolian' => __( 'Mongolian', 'digital-table-of-contents' ),
            'hebrew' => __( 'Hebrew', 'digital-table-of-contents' ),
            'hiragana' => __( 'Hiragana (Dictionary Order)', 'digital-table-of-contents' ),
            'hiragana-iroha' => __( 'Hiragana (Iroha Order)', 'digital-table-of-contents' ),
            'katakana' => __( 'Katakana (Dictionary Order)', 'digital-table-of-contents' ),
            'katakana-iroha' => __( 'Katakana (Iroha Order)', 'digital-table-of-contents' ),
        ],
    ];
    ?>

    <select class="smpg-input" name="<?php echo esc_attr($this->_setting_name); ?>[list_style_type]" id="list_style_type">
        <?php foreach ( $groups as $group_label => $options ) : ?>
            <optgroup label="<?php echo esc_attr( $group_label ); ?>">
                <?php foreach ( $options as $key => $label ) : ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current_value, $key ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </optgroup>
        <?php endforeach; ?>
    </select>

    <p class="description"><?php esc_html_e( 'Some list styles may not work in all browsers.', 'digital-table-of-contents' ); ?></p>

    <?php
}

public function dtoc_display_show_more_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[show_more]" id="show_more" type="checkbox" value="1" <?php echo (isset($this->_setting_option['show_more']) && $this->_setting_option['show_more'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_general_jump_links_cb($args){
    $this->dtoc_resolve_meta_settings_name(); 	    
    ?>  
        <input class="smpg-input dtoc_parent_option" name="<?php echo $this->_setting_name; ?>[jump_links]" id="jump_links" type="checkbox" value="1" <?php echo (isset($this->_setting_option['jump_links']) && $this->_setting_option['jump_links'] == 1 ? 'checked' : '' ) ?>>
        
    <?php
}
public function dtoc_customization_border_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
        ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[border_color]" id="border_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['border_color'] ) ? esc_attr( $this->_setting_option['border_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_icon_border_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
    <input type="text" name="<?php echo $this->_setting_name; ?>[icon_border_color]" id="icon_border_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['icon_border_color'] ) ? esc_attr( $this->_setting_option['icon_border_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
<?php
}
public function dtoc_customization_toggle_btn_border_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
    <input type="text" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_color]" id="toggle_btn_border_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['toggle_btn_border_color'] ) ? esc_attr( $this->_setting_option['toggle_btn_border_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
<?php
}
public function dtoc_customization_link_color_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[link_color]" id="link_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['link_color'] ) ? esc_attr( $this->_setting_option['link_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_link_hover_color_cb(){
    $this->dtoc_resolve_meta_settings_name(); 	    
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[link_hover_color]" id="link_hover_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['link_hover_color'] ) ? esc_attr( $this->_setting_option['link_hover_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_link_visited_color_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[link_visited_color]" id="link_visited_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['link_visited_color'] ) ? esc_attr( $this->_setting_option['link_visited_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_title_fg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[title_fg_color]" id="title_fg_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['title_fg_color'] ) ? esc_attr( $this->_setting_option['title_fg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_title_bg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[title_bg_color]" id="title_bg_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['title_bg_color'] ) ? esc_attr( $this->_setting_option['title_bg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_bg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[bg_color]" id="bg_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['bg_color'] ) ? esc_attr( $this->_setting_option['bg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_toggle_btn_bg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[toggle_btn_bg_color]" id="toggle_btn_bg_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['toggle_btn_bg_color'] ) ? esc_attr( $this->_setting_option['toggle_btn_bg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_toggle_btn_fg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[toggle_btn_fg_color]" id="toggle_btn_fg_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['toggle_btn_fg_color'] ) ? esc_attr( $this->_setting_option['toggle_btn_fg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_icon_bg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[icon_bg_color]" id="icon_bg_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['icon_bg_color'] ) ? esc_attr( $this->_setting_option['icon_bg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_icon_fg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[icon_fg_color]" id="icon_fg_color" class="smpg-input dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['icon_fg_color'] ) ? esc_attr( $this->_setting_option['icon_fg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}

public function dtoc_shortcode_source(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>
    <textarea id="dtoc_shortcode_source_textarea" rows="5" cols="60" readonly>[digital_toc]</textarea>
    <span id="dtoc_copy_inline" style="display:none; color:#46b450; margin-left:8px; font-weight:600;">
        <?php esc_html_e( 'Copied!', 'digital-toc' ); ?>
    </span>

	<?php
}
public function dtoc_customization_custom_css_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>
    <div class="dtoc_custom_styles"><?php  echo isset($this->_setting_option['custom_css']) ? $this->_setting_option['custom_css']: ''; ?></div>
    <textarea id="custom_css" name="<?php echo $this->_setting_name; ?>[custom_css]" style="display: none"></textarea>  
	<?php
}
public function dtoc_customization_icon_size_cb(){
    $this->dtoc_resolve_meta_settings_name();	
    ?>    	
    <select data-group="icon_size" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[icon_size_mode]" id="icon_size_mode">
        <option value="default" <?php echo (isset($this->_setting_option['icon_size_mode']) && $this->_setting_option['icon_size_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['icon_size_mode']) && $this->_setting_option['icon_size_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['icon_size_mode']) && $this->_setting_option['icon_size_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <ul style="display: flex;">
        <li>
        <input data-group="icon_size" type="number" class="smpg-input small-text" id="icon_width" name="<?php echo $this->_setting_name; ?>[icon_width]" value="<?php echo isset( $this->_setting_option['icon_width'] ) ? esc_attr( $this->_setting_option['icon_width']) : '25'; ?>">
        <br>
        <span data-group="icon_size"><?php echo esc_html__('Width', 'digital-table-of-contents'); ?></span>
        </li>

        <li>
        <input data-group="icon_size" type="number" class="smpg-input small-text" id="icon_height" name="<?php echo $this->_setting_name; ?>[icon_height]" value="<?php echo isset( $this->_setting_option['icon_height'] ) ? esc_attr( $this->_setting_option['icon_height']) : '25'; ?>">
        <br>
        <span data-group="icon_size"><?php echo esc_html__('Height', 'digital-table-of-contents'); ?></span>
        </li>
        
        <li>
        <select data-group="icon_size" class="smpg-input" name="<?php echo $this->_setting_name; ?>[icon_size_unit]" id="icon_size_unit">
            <option value="px" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <span data-group="icon_size"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_toggle_btn_size_cb(){
    $this->dtoc_resolve_meta_settings_name();	
    ?>    	
    <select data-group="toggle_btn_size" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[toggle_btn_size_mode]" id="toggle_btn_size_mode">
        <option value="default" <?php echo (isset($this->_setting_option['toggle_btn_size_mode']) && $this->_setting_option['toggle_btn_size_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['toggle_btn_size_mode']) && $this->_setting_option['toggle_btn_size_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['toggle_btn_size_mode']) && $this->_setting_option['toggle_btn_size_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <ul style="display: flex;">
        <li>
        <input data-group="toggle_btn_size" type="number" class="smpg-input small-text" id="toggle_btn_width" name="<?php echo $this->_setting_name; ?>[toggle_btn_width]" value="<?php echo isset( $this->_setting_option['toggle_btn_width'] ) ? esc_attr( $this->_setting_option['toggle_btn_width']) : '25'; ?>">
        <br>
        <span data-group="toggle_btn_size"><?php echo esc_html__('Width', 'digital-table-of-contents'); ?></span>
        </li>

        <li>
        <input data-group="toggle_btn_size" type="number" class="smpg-input small-text" id="toggle_btn_height" name="<?php echo $this->_setting_name; ?>[toggle_btn_height]" value="<?php echo isset( $this->_setting_option['toggle_btn_height'] ) ? esc_attr( $this->_setting_option['toggle_btn_height']) : '25'; ?>">
        <br>
        <span data-group="toggle_btn_size"><?php echo esc_html__('Height', 'digital-table-of-contents'); ?></span>
        </li>
        
        <li>
        <select data-group="toggle_btn_size" class="smpg-input" name="<?php echo $this->_setting_name; ?>[toggle_btn_size_unit]" id="toggle_btn_size_unit">
            <option value="px" <?php echo (isset($this->_setting_option['toggle_btn_size_unit']) && $this->_setting_option['toggle_btn_size_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['toggle_btn_size_unit']) && $this->_setting_option['toggle_btn_size_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['toggle_btn_size_unit']) && $this->_setting_option['toggle_btn_size_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['toggle_btn_size_unit']) && $this->_setting_option['toggle_btn_size_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <span data-group="toggle_btn_size"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_border_radius_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   
    ?>    	
    
    <select data-group="border_radius" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[border_radius_mode]" id="border_radius_mode">
        <option value="default" <?php echo (isset($this->_setting_option['border_radius_mode']) && $this->_setting_option['border_radius_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
        <option value="custom" <?php echo (isset($this->_setting_option['border_radius_mode']) && $this->_setting_option['border_radius_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    
    <ul style="display: flex;">
        <li>
        <input data-group="border_radius" type="number" class="smpg-input small-text" id="border_radius_top_left" name="<?php echo $this->_setting_name; ?>[border_radius_top_left]" value="<?php echo isset( $this->_setting_option['border_radius_top_left'] ) ? esc_attr( $this->_setting_option['border_radius_top_left']) : '0'; ?>">
        <span data-group="border_radius"><?php echo esc_html__('Top Left', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="border_radius" type="number" class="smpg-input small-text" id="border_radius_top_right" name="<?php echo $this->_setting_name; ?>[border_radius_top_right]" value="<?php echo isset( $this->_setting_option['border_radius_top_right'] ) ? esc_attr( $this->_setting_option['border_radius_top_right']) : '0'; ?>">
        <span data-group="border_radius"><?php echo esc_html__('Top Right', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="border_radius" type="number" class="smpg-input small-text" id="border_radius_bottom_left" name="<?php echo $this->_setting_name; ?>[border_radius_bottom_left]" value="<?php echo isset( $this->_setting_option['border_radius_bottom_left'] ) ? esc_attr( $this->_setting_option['border_radius_bottom_left']) : '0'; ?>">
        <span data-group="border_radius"><?php echo esc_html__('Bottom Left', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="border_radius" type="number" class="smpg-input small-text" id="border_radius_bottom_right" name="<?php echo $this->_setting_name; ?>[border_radius_bottom_right]" value="<?php echo isset( $this->_setting_option['border_radius_bottom_right'] ) ? esc_attr( $this->_setting_option['border_radius_bottom_right']) : '0'; ?>">
        <span data-group="border_radius"><?php echo esc_html__('Bottom Right', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <select data-group="border_radius" class="smpg-input" name="<?php echo $this->_setting_name; ?>[border_radius_unit]" id="border_radius_unit">
            <option value="px" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <span data-group="border_radius"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_icon_border_radius_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   
    ?>    	
    <select data-group="icon_border_radius" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[icon_border_radius_mode]" id="icon_border_radius_mode">
        <option value="default" <?php echo (isset($this->_setting_option['icon_border_radius_mode']) && $this->_setting_option['icon_border_radius_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
        <option value="custom" <?php echo (isset($this->_setting_option['icon_border_radius_mode']) && $this->_setting_option['icon_border_radius_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <ul style="display: flex;">
        <li>
        <input data-group="icon_border_radius" type="number" class="smpg-input small-text" id="icon_border_radius_top_left" name="<?php echo $this->_setting_name; ?>[icon_border_radius_top_left]" value="<?php echo isset( $this->_setting_option['icon_border_radius_top_left'] ) ? esc_attr( $this->_setting_option['icon_border_radius_top_left']) : '0'; ?>">
        <span data-group="icon_border_radius"><?php echo esc_html__('Top Left', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="icon_border_radius" type="number" class="smpg-input small-text" id="icon_border_radius_top_right" name="<?php echo $this->_setting_name; ?>[icon_border_radius_top_right]" value="<?php echo isset( $this->_setting_option['icon_border_radius_top_right'] ) ? esc_attr( $this->_setting_option['icon_border_radius_top_right']) : '0'; ?>">
        <span data-group="icon_border_radius"><?php echo esc_html__('Top Right', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="icon_border_radius" type="number" class="smpg-input small-text" id="icon_border_radius_bottom_left" name="<?php echo $this->_setting_name; ?>[icon_border_radius_bottom_left]" value="<?php echo isset( $this->_setting_option['icon_border_radius_bottom_left'] ) ? esc_attr( $this->_setting_option['icon_border_radius_bottom_left']) : '0'; ?>">
        <span data-group="icon_border_radius"><?php echo esc_html__('Bottom Left', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="icon_border_radius" type="number" class="smpg-input small-text" id="icon_border_radius_bottom_right" name="<?php echo $this->_setting_name; ?>[icon_border_radius_bottom_right]" value="<?php echo isset( $this->_setting_option['icon_border_radius_bottom_right'] ) ? esc_attr( $this->_setting_option['icon_border_radius_bottom_right']) : '0'; ?>">
        <span data-group="icon_border_radius"><?php echo esc_html__('Bottom Right', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <select data-group="icon_border_radius" class="smpg-input" name="<?php echo $this->_setting_name; ?>[icon_border_radius_unit]" id="icon_border_radius_unit">
            <option value="px" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <span data-group="icon_border_radius"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_toggle_btn_border_radius_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   
    ?>    	
    <select data-group="toggle_btn_border_radius" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_radius_mode]" id="toggle_btn_border_radius_mode">
        <option value="default" <?php echo (isset($this->_setting_option['toggle_btn_border_radius_mode']) && $this->_setting_option['toggle_btn_border_radius_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
        <option value="custom" <?php echo (isset($this->_setting_option['toggle_btn_border_radius_mode']) && $this->_setting_option['toggle_btn_border_radius_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <ul style="display: flex;">
        <li>
        <input data-group="toggle_btn_border_radius" type="number" class="smpg-input small-text" id="toggle_btn_border_radius_top_left" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_radius_top_left]" value="<?php echo isset( $this->_setting_option['toggle_btn_border_radius_top_left'] ) ? esc_attr( $this->_setting_option['toggle_btn_border_radius_top_left']) : '0'; ?>">
        <span data-group="toggle_btn_border_radius"><?php echo esc_html__('Top Left', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="toggle_btn_border_radius" type="number" class="smpg-input small-text" id="toggle_btn_border_radius_top_right" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_radius_top_right]" value="<?php echo isset( $this->_setting_option['toggle_btn_border_radius_top_right'] ) ? esc_attr( $this->_setting_option['toggle_btn_border_radius_top_right']) : '0'; ?>">
        <span data-group="toggle_btn_border_radius"><?php echo esc_html__('Top Right', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="toggle_btn_border_radius" type="number" class="smpg-input small-text" id="toggle_btn_border_radius_bottom_left" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_radius_bottom_left]" value="<?php echo isset( $this->_setting_option['toggle_btn_border_radius_bottom_left'] ) ? esc_attr( $this->_setting_option['toggle_btn_border_radius_bottom_left']) : '0'; ?>">
        <span data-group="toggle_btn_border_radius"><?php echo esc_html__('Bottom Left', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <input data-group="toggle_btn_border_radius" type="number" class="smpg-input small-text" id="toggle_btn_border_radius_bottom_right" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_radius_bottom_right]" value="<?php echo isset( $this->_setting_option['toggle_btn_border_radius_bottom_right'] ) ? esc_attr( $this->_setting_option['toggle_btn_border_radius_bottom_right']) : '0'; ?>">
        <span data-group="toggle_btn_border_radius"><?php echo esc_html__('Bottom Right', 'digital-table-of-contents'); ?></span>
        </li>
        <li>
        <select data-group="toggle_btn_border_radius" class="smpg-input" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_radius_unit]" id="toggle_btn_border_radius_unit">
            <option value="px" <?php echo (isset($this->_setting_option['toggle_btn_border_radius_unit']) && $this->_setting_option['toggle_btn_border_radius_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['toggle_btn_border_radius_unit']) && $this->_setting_option['toggle_btn_border_radius_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['toggle_btn_border_radius_unit']) && $this->_setting_option['toggle_btn_border_radius_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['toggle_btn_border_radius_unit']) && $this->_setting_option['toggle_btn_border_radius_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <span data-group="toggle_btn_border_radius"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_link_margin_cb(){
    ?>
    <select data-group="link_margin" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[link_margin_mode]" id="link_margin_mode">
        <option value="default" <?php echo (isset($this->_setting_option['link_margin_mode']) && $this->_setting_option['link_margin_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['link_margin_mode']) && $this->_setting_option['link_margin_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['link_margin_mode']) && $this->_setting_option['link_margin_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'margin', 'link');
}
public function dtoc_customization_link_padding_cb(){
    ?>
    <select data-group="link_padding" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[link_padding_mode]" id="link_padding_mode">
        <option value="default" <?php echo (isset($this->_setting_option['link_padding_mode']) && $this->_setting_option['link_padding_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['link_padding_mode']) && $this->_setting_option['link_padding_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['link_padding_mode']) && $this->_setting_option['link_padding_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'link');
}
public function dtoc_customization_icon_padding_cb(){    
    ?>
    <select data-group="icon_padding" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[icon_padding_mode]" id="icon_padding_mode">
        <option value="default" <?php echo (isset($this->_setting_option['icon_padding_mode']) && $this->_setting_option['icon_padding_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['icon_padding_mode']) && $this->_setting_option['icon_padding_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['icon_padding_mode']) && $this->_setting_option['icon_padding_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'icon');
}
public function dtoc_customization_toggle_btn_padding_cb(){    
    ?>
    <select data-group="toggle_btn_padding" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[toggle_btn_padding_mode]" id="toggle_btn_padding_mode">
        <option value="default" <?php echo (isset($this->_setting_option['toggle_btn_padding_mode']) && $this->_setting_option['toggle_btn_padding_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['toggle_btn_padding_mode']) && $this->_setting_option['toggle_btn_padding_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['toggle_btn_padding_mode']) && $this->_setting_option['toggle_btn_padding_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'toggle_btn');
}
public function dtoc_customization_title_padding_cb(){
    ?>
    <select data-group="title_padding" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[title_padding_mode]" id="title_padding_mode">
        <option value="default" <?php echo (isset($this->_setting_option['title_padding_mode']) && $this->_setting_option['title_padding_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['title_padding_mode']) && $this->_setting_option['title_padding_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['title_padding_mode']) && $this->_setting_option['title_padding_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'title');
}
public function dtoc_customization_icon_margin_cb(){    
    ?>
    <select data-group="icon_margin" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[icon_margin_mode]" id="icon_margin_mode">
        <option value="default" <?php echo (isset($this->_setting_option['icon_margin_mode']) && $this->_setting_option['icon_margin_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['icon_margin_mode']) && $this->_setting_option['icon_margin_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['icon_margin_mode']) && $this->_setting_option['icon_margin_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'margin', 'icon');    
}
public function dtoc_customization_container_width_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
    
      <select data-group="container_width" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[container_width_mode]" id="container_width_mode">
            <option value="default" <?php echo (isset($this->_setting_option['container_width_mode']) && $this->_setting_option['container_width_mode'] == 'default' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Default', 'digital-table-of-contents'); ?>
            </option>
            <option value="auto" <?php echo (isset($this->_setting_option['container_width_mode']) && $this->_setting_option['container_width_mode'] == 'auto' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Auto', 'digital-table-of-contents'); ?>
            </option>
            <option value="full" <?php echo (isset($this->_setting_option['container_width_mode']) && $this->_setting_option['container_width_mode'] == 'full' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Full width (100%)', 'digital-table-of-contents'); ?>
            </option>
            <option value="fit-content" <?php echo (isset($this->_setting_option['container_width_mode']) && $this->_setting_option['container_width_mode'] == 'fit-content' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Fit to Content', 'digital-table-of-contents'); ?>
            </option>
            <option value="custom" <?php echo (isset($this->_setting_option['container_width_mode']) && $this->_setting_option['container_width_mode'] == 'custom' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Custom', 'digital-table-of-contents'); ?>
            </option>
    </select>
    <input data-group="container_width" type="number" class="smpg-input small-text" id="container_width" name="<?php echo $this->_setting_name; ?>[container_width]" value="<?php echo isset( $this->_setting_option['container_width'] ) ? esc_attr( $this->_setting_option['container_width']) : '0'; ?>">
    <select class="smpg-input"data-group="container_width" name="<?php echo $this->_setting_name; ?>[container_width_unit]" id="container_width_unit">
        <option value="px" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
        <option value="pt" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
        <option value="%" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
        <option value="em" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
    </select>
        <span data-group="container_width" ><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
    <?php
}
public function dtoc_customization_title_font_size_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
    <select data-group="title_font_size" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[title_font_size_mode]" id="title_font_size_mode">
        <option value="default" <?php echo (isset($this->_setting_option['title_font_size_mode']) && $this->_setting_option['title_font_size_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
        <option value="custom" <?php echo (isset($this->_setting_option['title_font_size_mode']) && $this->_setting_option['title_font_size_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <input data-group="title_font_size" type="number" class="smpg-input small-text" id="title_font_size" name="<?php echo $this->_setting_name; ?>[title_font_size]" value="<?php echo isset( $this->_setting_option['title_font_size'] ) ? esc_attr( $this->_setting_option['title_font_size']) : '0'; ?>">
    <select data-group="title_font_size" name="<?php echo $this->_setting_name; ?>[title_font_size_unit]" id="title_font_size_unit">
        <option value="px" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
        <option value="pt" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
        <option value="%" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
        <option value="em" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
    <span data-group="title_font_size"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
    <?php
}
public function dtoc_customization_title_font_weight_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
        <select data-group="title_font_weight" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[title_font_weight_mode]" id="title_font_weight_mode">
            <option value="default" <?php echo (isset($this->_setting_option['title_font_weight_mode']) && $this->_setting_option['title_font_weight_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
            <option value="custom" <?php echo (isset($this->_setting_option['title_font_weight_mode']) && $this->_setting_option['title_font_weight_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
        </select>
        <input data-group="title_font_weight" type="number" class="smpg-input small-text" id="title_font_weight" name="<?php echo $this->_setting_name; ?>[title_font_weight]" value="<?php echo isset( $this->_setting_option['title_font_weight'] ) ? esc_attr( $this->_setting_option['title_font_weight']) : '0'; ?>">    
    <?php
}
public function dtoc_customization_container_height_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
        <select data-group="container_height" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[container_height_mode]" id="container_height_mode">
            <option value="default" <?php echo (isset($this->_setting_option['container_height_mode']) && $this->_setting_option['container_height_mode'] == 'default' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Default', 'digital-table-of-contents'); ?>
            </option>
            <option value="auto" <?php echo (isset($this->_setting_option['container_height_mode']) && $this->_setting_option['container_height_mode'] == 'auto' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Auto', 'digital-table-of-contents'); ?>
            </option>
            <option value="full" <?php echo (isset($this->_setting_option['container_height_mode']) && $this->_setting_option['container_height_mode'] == 'full' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Full Height (100%)', 'digital-table-of-contents'); ?>
            </option>
            <option value="fit-content" <?php echo (isset($this->_setting_option['container_height_mode']) && $this->_setting_option['container_height_mode'] == 'fit-content' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Fit to Content', 'digital-table-of-contents'); ?>
            </option>
            <option value="custom" <?php echo (isset($this->_setting_option['container_height_mode']) && $this->_setting_option['container_height_mode'] == 'custom' ? 'selected' : '' ); ?>>
                <?php echo esc_html__('Custom', 'digital-table-of-contents'); ?>
            </option>
        </select>

    <input data-group="container_height" type="number" class="smpg-input small-text" id="ez-toc-settings[headings-padding-top]" name="ez-toc-settings[headings-padding-top]" value="0" placeholder="">
    <select data-group="container_height" class="smpg-input" name="<?php echo $this->_setting_name; ?>[design_type]" id="design_type">
        <option value="px" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'grey' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
        <option value="pt" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'light_blue' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
        <option value="%" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'white' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
        <option value="em" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'black' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <span data-group="container_height"><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></span>
    <?php
    
}
public function dtoc_customization_container_margin_cb(){          
    ?>
    <select data-group="container_margin" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[container_margin_mode]" id="container_margin_mode">
        <option value="default" <?php echo (isset($this->_setting_option['container_margin_mode']) && $this->_setting_option['container_margin_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['container_margin_mode']) && $this->_setting_option['container_margin_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['container_margin_mode']) && $this->_setting_option['container_margin_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php  
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'margin', 'container');        
}
public function dtoc_customization_container_padding_cb(){    
    ?>
    <select data-group="container_padding" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[container_padding_mode]" id="container_padding_mode">
        <option value="default" <?php echo (isset($this->_setting_option['container_padding_mode']) && $this->_setting_option['container_padding_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="auto" <?php echo (isset($this->_setting_option['container_padding_mode']) && $this->_setting_option['container_padding_mode'] == 'auto' ? 'selected' : '' ) ?>><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['container_padding_mode']) && $this->_setting_option['container_padding_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'container');
}
public function dtoc_customization_icon_border_width_cb(){    
    ?>
    <select data-group="icon_border_width" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[icon_border_width_mode]" id="icon_border_width_mode">
        <option value="default" <?php echo (isset($this->_setting_option['icon_border_width_mode']) && $this->_setting_option['icon_border_width_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
        <option value="custom" <?php echo (isset($this->_setting_option['icon_border_width_mode']) && $this->_setting_option['icon_border_width_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'width', 'icon_border');
}
public function dtoc_customization_toggle_btn_border_width_cb(){    
    ?>
    <select data-group="toggle_btn_border_width" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_width_mode]" id="toggle_btn_border_width_mode">
        <option value="default" <?php echo (isset($this->_setting_option['toggle_btn_border_width_mode']) && $this->_setting_option['toggle_btn_border_width_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
        <option value="custom" <?php echo (isset($this->_setting_option['toggle_btn_border_width_mode']) && $this->_setting_option['toggle_btn_border_width_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'width', 'toggle_btn_border');
}
public function dtoc_customization_border_width_cb(){    
    ?>
    <select data-group="border_width" class="smpg-input smpg-mode-select" name="<?php echo $this->_setting_name; ?>[border_width_mode]" id="border_width_mode">
        <option value="default" <?php echo (isset($this->_setting_option['border_width_mode']) && $this->_setting_option['border_width_mode'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>        
        <option value="custom" <?php echo (isset($this->_setting_option['border_width_mode']) && $this->_setting_option['border_width_mode'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>        
    </select>
    <?php  
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'width', 'border');        
}
public function dtoc_customization_border_type_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>    
	<select class="smpg-input" name="<?php echo $this->_setting_name; ?>[border_type]" id="border_type">
        <option value="default" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="none" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'none' ? 'selected' : '' ) ?>><?php echo esc_html__('None', 'digital-table-of-contents'); ?></option>
        <option value="solid" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'solid' ? 'selected' : '' ) ?>><?php echo esc_html__('Solid', 'digital-table-of-contents'); ?></option>
        <option value="double" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'double' ? 'selected' : '' ) ?>><?php echo esc_html__('Double', 'digital-table-of-contents'); ?></option>
        <option value="dotted" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'dotted' ? 'selected' : '' ) ?>><?php echo esc_html__('Dotted', 'digital-table-of-contents'); ?></option>
        <option value="dashed" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'dashed' ? 'selected' : '' ) ?>><?php echo esc_html__('Dashed', 'digital-table-of-contents'); ?></option>
        <option value="groove" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'groove' ? 'selected' : '' ) ?>><?php echo esc_html__('Groove', 'digital-table-of-contents'); ?></option>
    </select>
	
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'border_type'); 
}
public function dtoc_customization_icon_border_type_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>    
	<select class="smpg-input" name="<?php echo $this->_setting_name; ?>[icon_border_type]" id="icon_border_type">
        <option value="default" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="none" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'none' ? 'selected' : '' ) ?>><?php echo esc_html__('None', 'digital-table-of-contents'); ?></option>
        <option value="solid" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'solid' ? 'selected' : '' ) ?>><?php echo esc_html__('Solid', 'digital-table-of-contents'); ?></option>
        <option value="double" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'double' ? 'selected' : '' ) ?>><?php echo esc_html__('Double', 'digital-table-of-contents'); ?></option>
        <option value="dotted" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'dotted' ? 'selected' : '' ) ?>><?php echo esc_html__('Dotted', 'digital-table-of-contents'); ?></option>
        <option value="dashed" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'dashed' ? 'selected' : '' ) ?>><?php echo esc_html__('Dashed', 'digital-table-of-contents'); ?></option>
        <option value="groove" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'groove' ? 'selected' : '' ) ?>><?php echo esc_html__('Groove', 'digital-table-of-contents'); ?></option>
    </select>	
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'icon_border_type'); 
}
public function dtoc_customization_toggle_btn_border_type_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>    
	<select class="smpg-input" name="<?php echo $this->_setting_name; ?>[toggle_btn_border_type]" id="toggle_btn_border_type">
        <option value="default" <?php echo (isset($this->_setting_option['toggle_btn_border_type']) && $this->_setting_option['toggle_btn_border_type'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="none" <?php echo (isset($this->_setting_option['toggle_btn_border_type']) && $this->_setting_option['toggle_btn_border_type'] == 'none' ? 'selected' : '' ) ?>><?php echo esc_html__('None', 'digital-table-of-contents'); ?></option>
        <option value="solid" <?php echo (isset($this->_setting_option['toggle_btn_border_type']) && $this->_setting_option['toggle_btn_border_type'] == 'solid' ? 'selected' : '' ) ?>><?php echo esc_html__('Solid', 'digital-table-of-contents'); ?></option>
        <option value="double" <?php echo (isset($this->_setting_option['toggle_btn_border_type']) && $this->_setting_option['toggle_btn_border_type'] == 'double' ? 'selected' : '' ) ?>><?php echo esc_html__('Double', 'digital-table-of-contents'); ?></option>
        <option value="dotted" <?php echo (isset($this->_setting_option['toggle_btn_border_type']) && $this->_setting_option['toggle_btn_border_type'] == 'dotted' ? 'selected' : '' ) ?>><?php echo esc_html__('Dotted', 'digital-table-of-contents'); ?></option>
        <option value="dashed" <?php echo (isset($this->_setting_option['toggle_btn_border_type']) && $this->_setting_option['toggle_btn_border_type'] == 'dashed' ? 'selected' : '' ) ?>><?php echo esc_html__('Dashed', 'digital-table-of-contents'); ?></option>
        <option value="groove" <?php echo (isset($this->_setting_option['toggle_btn_border_type']) && $this->_setting_option['toggle_btn_border_type'] == 'groove' ? 'selected' : '' ) ?>><?php echo esc_html__('Groove', 'digital-table-of-contents'); ?></option>
    </select>	
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'toggle_btn_border_type'); 
}
public function dtoc_general_rendering_style_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   	                
    ?>        
        <input class="smpg-input" data-id="rendering_style" type="radio" id="js_rendering_style" name="<?php echo esc_attr( $this->_setting_name ); ?>[rendering_style]" value="js" 
            <?php checked( isset( $this->_setting_option['rendering_style'] ) && $this->_setting_option['rendering_style'] === 'js' ); ?>>
        <label for="js_rendering_style" style="margin-right: 15px;"><?php esc_html_e( 'JS-based', 'digital-table-of-contents' ); ?></label>

        <input data-id="rendering_style" class="smpg-input" type="radio" id="css_rendering_style" name="<?php echo esc_attr( $this->_setting_name ); ?>[rendering_style]" value="css" 
            <?php checked( isset( $this->_setting_option['rendering_style'] ) && $this->_setting_option['rendering_style'] === 'css' ); ?>>
        <label for="css_rendering_style"><?php esc_html_e( 'CSS-based', 'digital-table-of-contents' ); ?></label>        
    <?php
}
public function dtoc_general_scroll_behavior_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   	                
    ?>            
    <input class="smpg-input" data-id="scroll_behavior" type="radio" id="auto_scroll_behavior" name="<?php echo esc_attr( $this->_setting_name ); ?>[scroll_behavior]" value="auto" 
        <?php checked( isset( $this->_setting_option['scroll_behavior'] ) && $this->_setting_option['scroll_behavior'] === 'auto' ); ?>>
    <label for="auto_scroll_behavior" style="margin-right: 15px;"><?php esc_html_e( 'Auto', 'digital-table-of-contents' ); ?></label>

    <input class="smpg-input" data-id="scroll_behavior" type="radio" id="smooth_scroll_behavior" name="<?php echo esc_attr( $this->_setting_name ); ?>[scroll_behavior]" value="smooth" 
        <?php checked( isset( $this->_setting_option['scroll_behavior'] ) && $this->_setting_option['scroll_behavior'] === 'smooth' ); ?>>
    <label for="smooth_scroll_behavior"><?php esc_html_e( 'Smooth', 'digital-table-of-contents' ); ?></label>        

    <?php
}
public function dtoc_general_alignment_cb() {
	$this->dtoc_resolve_meta_settings_name();
	?>

	<input class="smpg-input" data-id="alignment" type="radio" id="left_alignment" name="<?php echo esc_attr( $this->_setting_name ); ?>[alignment]" value="left" <?php checked( isset( $this->_setting_option['alignment'] ) && $this->_setting_option['alignment'] === 'left' ); ?>>
	<label for="left_alignment" style="margin-right: 15px;"><?php esc_html_e( 'Left', 'digital-table-of-contents' ); ?></label>

	<input class="smpg-input" data-id="alignment" type="radio" id="center_alignment" name="<?php echo esc_attr( $this->_setting_name ); ?>[alignment]" value="center" <?php checked( isset( $this->_setting_option['alignment'] ) && $this->_setting_option['alignment'] === 'center' ); ?>>
	<label for="center_alignment" style="margin-right: 15px;"><?php esc_html_e( 'Center', 'digital-table-of-contents' ); ?></label>

	<input class="smpg-input" data-id="alignment" type="radio" id="right_alignment" name="<?php echo esc_attr( $this->_setting_name ); ?>[alignment]" value="right" <?php checked( isset( $this->_setting_option['alignment'] ) && $this->_setting_option['alignment'] === 'right' ); ?> >
	<label for="right_alignment"><?php esc_html_e( 'Right', 'digital-table-of-contents' ); ?></label>

	<?php
}

public function dtoc_general_header_icon_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>    
		    
    <div style="display: flex;">
    <select class="smpg-input" name="<?php echo esc_attr($this->_setting_name); ?>[header_icon]" id="header_icon">
        <option value="none" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'none' ? 'selected' : '' ) ?>><?php echo esc_html__('None', 'digital-table-of-contents'); ?></option>        
        <option value="list_icon" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'list_icon' ? 'selected' : '' ) ?>><?php echo esc_html__('List Icon ☰', 'digital-table-of-contents'); ?></option>        
        <option value="show_hide" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'show_hide' ? 'selected' : '' ) ?>><?php echo esc_html__('Show / Hide ', 'digital-table-of-contents'); ?></option>
        <option value="plus_minus" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'plus_minus' ? 'selected' : '' ) ?>><?php echo esc_html__('Plus + / Minus -', 'digital-table-of-contents'); ?></option>        
        <option value="custom_icon" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'custom_icon' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom Icon', 'digital-table-of-contents'); ?></option>
    </select>
    <div id="custom-icon-wrapper" style="display: flex;">
        <button style="margin-left: 5px;" type="button" class="button dtoc-icon-upload" data-editor="content">
            <span class="dashicons dashicons-format-image" style="margin-top: 4px;"></span> 
            <?php echo esc_html__('Choose Icon', 'digital-table-of-contents'); ?>
        </button>
        <img id="custom-icon-preview" src="" alt="Icon Preview" style="max-height: 40px; margin-left: 10px; display: none;" />
        <input type="hidden" name="<?php echo esc_attr($this->_setting_name); ?>[custom_icon_url]" id="custom_icon_url" value="<?php echo esc_attr($this->_setting_option['custom_icon_url'] ?? ''); ?>">
    </div>    
    <?php 
        // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'header_icon'); 
    ?>
</div>

    
    <?php
}
public function dtoc_general_show_text_cb() {
    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
    <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[show_text]" id="show_text" type="text" value="<?php echo (isset($this->_setting_option['show_text']) ? $this->_setting_option['show_text'] : 'show' ) ?>">
    <?php
    // dtoc_tooltip(__('text', 'digital-table-of-contents'), 'show_text');
}
public function dtoc_general_hide_text_cb() {
    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
    <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[hide_text]" id="hide_text" type="text" value="<?php echo (isset($this->_setting_option['hide_text']) ? $this->_setting_option['hide_text'] : 'hide' ) ?>">
    <?php
    // dtoc_tooltip(__('text', 'digital-table-of-contents'), 'hide_text');
}
public function dtoc_general_header_text_cb() {
    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
    <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[header_text]" id="header_text" type="text" value="<?php echo (isset($this->_setting_option['header_text']) ? $this->_setting_option['header_text'] : 'Table of Contents' ) ?>">
    <?php
    // dtoc_tooltip(__('text', 'digital-table-of-contents'), 'header_text');
}

public function dtoc_general_toggle_btn_text_cb() {
    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
    <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[toggle_btn_text]" id="toggle_btn_text" type="text" value="<?php echo (isset($this->_setting_option['toggle_btn_text']) ? $this->_setting_option['toggle_btn_text'] : 'Index' ) ?>">
    <?php
    // dtoc_tooltip(__('text', 'digital-table-of-contents'), 'header_text');
}

public function dtoc_display_title_cb(){  
    $this->dtoc_resolve_meta_settings_name(); 	  	                        
    ?>  
        <input class="smpg-input dtoc_parent_option" name="<?php echo $this->_setting_name; ?>[display_title]" id="display_title" type="checkbox" value="1" <?php echo (isset($this->_setting_option['display_title']) && $this->_setting_option['display_title'] == 1 ? 'checked' : '' ) ?>>
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'display_title'); 
}
public function dtoc_general_scroll_back_to_toc_cb(){  
    $this->dtoc_resolve_meta_settings_name(); 	  	                        
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[scroll_back_to_top]" id="scroll_back_to_toc" type="checkbox" value="1" <?php echo (isset($this->_setting_option['scroll_back_to_top']) && $this->_setting_option['scroll_back_to_top'] == 1 ? 'checked' : '' ) ?>>
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'scroll_back_to_top'); 
}
public function dtoc_general_wrap_content_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   	                        
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[wrap_content]" id="wrap_content" type="checkbox" value="1" <?php echo (isset($this->_setting_option['wrap_content']) && $this->_setting_option['wrap_content'] == 1 ? 'checked' : '' ) ?>>
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'wrap_content'); 
}
public function dtoc_display_toggle_body_cb(){  
    $this->dtoc_resolve_meta_settings_name(); 	                        
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[toggle_body]" id="toggle_body" type="checkbox" value="1" <?php echo (isset($this->_setting_option['toggle_body']) && $this->_setting_option['toggle_body'] == 1 ? 'checked' : '' ) ?>>        
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'toggle_body'); 
}
public function dtoc_customization_remove_css_js_cb(){ 
    $this->dtoc_resolve_meta_settings_name();   	                        
    ?>  
        <input class="smpg-input" name="<?php echo $this->_setting_name; ?>[remove_unused_css_js]" id="remove_unused_css_js" type="checkbox" value="1" <?php echo (isset($this->_setting_option['remove_unused_css_js']) && $this->_setting_option['remove_unused_css_js'] == 1 ? 'checked' : '' ) ?>>
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'remove_unused_css_js'); 
}
public function dtoc_general_headings_include_cb(){
    $this->dtoc_resolve_meta_settings_name();
    ?>        
        <input class="smpg-input" data-id="headings_include" data-number="1" name="<?php echo $this->_setting_name; ?>[headings_include][1]" id="headings_include_1" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][1]) && $this->_setting_option['headings_include'][1] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_1"><?php echo esc_html__('H1', 'digital-table-of-contents'); ?></label>
        <br>
        <input class="smpg-input" data-id="headings_include" data-number="2" name="<?php echo $this->_setting_name; ?>[headings_include][2]" id="headings_include_2" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][2]) && $this->_setting_option['headings_include'][2] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_2"><?php echo esc_html__('H2', 'digital-table-of-contents'); ?></label>
        <br>
        <input class="smpg-input" data-id="headings_include" data-number="3" name="<?php echo $this->_setting_name; ?>[headings_include][3]" id="headings_include_3" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][3]) && $this->_setting_option['headings_include'][3] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_3"><?php echo esc_html__('H3', 'digital-table-of-contents'); ?></label>
        <br>
        <input class="smpg-input" data-id="headings_include" data-number="4" name="<?php echo $this->_setting_name; ?>[headings_include][4]" id="headings_include_4" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][4]) && $this->_setting_option['headings_include'][4] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_4"><?php echo esc_html__('H4', 'digital-table-of-contents'); ?></label>
        <br>
        <input class="smpg-input" data-id="headings_include" data-number="5" name="<?php echo $this->_setting_name; ?>[headings_include][5]" id="headings_include_5" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][5]) && $this->_setting_option['headings_include'][5] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_5"><?php echo esc_html__('H5', 'digital-table-of-contents'); ?></label>
        <br>
        <input class="smpg-input" data-id="headings_include" data-number="6" name="<?php echo $this->_setting_name; ?>[headings_include][6]" id="headings_include_6" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][6]) && $this->_setting_option['headings_include'][6] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_6"><?php echo esc_html__('H6', 'digital-table-of-contents'); ?></label>

        <p class="description"><?php echo esc_html__('Select the headings to be added when the table of contents being created. Deselecting it will be excluded.', 'digital-table-of-contents'); ?></p>
                        
    <?php

}

public function dtoc_placement_setting_section_cb(){
            
    $result = dtoc_get_all_post_types();    

    if(!empty($result)){

        foreach ($result as $key => $value) {
            
            echo '<div class="dtoc-accordion">';
            echo '<div class="dtoc-accordion-header"><label class="dtoc-placement-checked" for=singular-'.esc_attr($key).'><input class="dtoc-placement-checked" id=singular-'.esc_attr($key).' type="checkbox" name="'.esc_attr($this->_setting_name).'[placement]['.esc_attr($key).'][is_enabled]" value="1" '.(isset($this->_setting_option["placement"][$key]["is_enabled"]) ? "checked": "").' />All ' . esc_html($value).'</label></div>';
            echo '<div class="dtoc-accordion-panel">';
            echo '<div class="dtoc-accordion-panel-body">';
                                
                $taxonomy_objects = get_object_taxonomies( $key, 'objects' );
                if(!empty($taxonomy_objects)){
                    $j = 1;
                    $terms_arr = [];
                    foreach ($taxonomy_objects as $tkey => $tvalue) {
                        $saved_term = false;
                        if(isset($this->_setting_option['placement'][$key]['taxonomy'][$tvalue->name]['ids'])){
                            $saved_term = true;
                            $terms = get_terms( [
                                'taxonomy'   => sanitize_text_field($tvalue->name),
                                'hide_empty' => false,
                                'include'    =>  $this->_setting_option['placement'][$key]['taxonomy'][$tvalue->name]['ids']
                            ] );
                        }else{
                            $terms = get_terms( [
                                'taxonomy'   => sanitize_text_field($tvalue->name),
                                'hide_empty' => false,
                                'number'     => 1                            
                            ] );    
                        }    
                                                                          
                        if ( !is_wp_error( $terms ) && !empty($terms) ) {
                            $terms_arr[] = $terms;
                            if($j !== 1 ){
                                $opeval = 'OR';
                                if(isset($this->_setting_option['placement'][$key]['taxonomy'][$tvalue->name]['ope'])){
                                    $opeval = $this->_setting_option['placement'][$key]['taxonomy'][$tvalue->name]['ope'];
                                }                                
                                echo '<div class="dtoc-or-and">';
                                echo '<input type="hidden" name="'.esc_attr($this->_setting_name).'[placement]['.esc_attr($key).'][taxonomy]['.esc_attr($tvalue->name).'][ope]" value="'.esc_attr($opeval).'">';
                                echo '<a href="#" class="button dtoc-placement-ope">'.esc_html($opeval).'</a>';
                                echo '</div>';  
                            }
                            
                            echo '<div class="dtoc-acc-cont-body">';
                            echo '<div class="dtoc-acc-cont-h">';
                            echo '<h4>Belong to '.esc_html($tvalue->label).'</h4>';
                            echo '</div>';
                            echo '<div class="dtoc-acc-cont-s">';
                            echo '<select multiple class="dtoc-placement-select2" data-ajax--url="'.admin_url( 'admin-ajax.php' ).'?type='.esc_attr($tvalue->name).'" name="'.esc_attr($this->_setting_name).'[placement]['.esc_attr($key).'][taxonomy]['.esc_attr($tvalue->name).'][ids][]">';
                                if($saved_term){
                                    foreach ($terms as $term) {
                                        echo '<option value="'.esc_attr($term->term_id).'" selected="selected">'.esc_html($term->name).'</option>';
                                    }
                                }                            
                            echo '</select>';
                            echo '</div>';
                            echo '</div>';                            

                            $j++;                                                            
                        }
                        
                    }                 
                    if(!empty($terms_arr)){
                        echo '<div class="dtoc-hr"></div>';        
                    }   
                    
                }
                                                
                echo '<div class="dtoc-acc-cont-body">';
                echo '<div class="dtoc-acc-cont-h">';
                echo '<h4>Skip '.esc_html($value).'</h4>';  
                echo '</div>';
                echo '<div class="dtoc-acc-cont-s">';
                echo '<select multiple class="dtoc-placement-select2" data-ajax--url="'.admin_url( 'admin-ajax.php' ).'?skip_type='.esc_attr($key).'" name="'.esc_attr($this->_setting_name).'[placement]['.esc_attr($key).'][skip][]">';
                if(isset($this->_setting_option['placement'][$key]['skip'])){
                    $result = get_posts( [
                        'post_type'       => $key,            
                        'post__in'        => $this->_setting_option['placement'][$key]['skip']                        
                    ] );    
                    if (! is_wp_error( $result ) && ! empty( $result ) ) {
                        foreach ($result as $value) {
                            echo '<option value="'.esc_attr($value->ID).'" selected="selected">'.esc_html($value->post_title).'</option>';
                        }        
                    }	    
                }
                echo '</select>';
                echo '</div>';
                echo '</div>';
                                
            echo '</div>';

            echo '</div>';
            echo '</div>';
            

        }

    }
        
    ?>                	
    <?php
}
public function dtoc_general_when_cb(){   
    $this->dtoc_resolve_meta_settings_name(); 	                
    ?>
        <input class="smpg-input" type="number" min="1" max="200" id="display_when" name="<?php echo $this->_setting_name; ?>[display_when]" value="<?php echo (isset($this->_setting_option['display_when']) ? esc_attr($this->_setting_option['display_when']) : 1 ) ?>" />
        <p><?php echo esc_html__('Headings is greater or equal to above number.', 'digital-table-of-contents'); ?></p>		
    <?php
}
public function dtoc_general_position_cb(){ 
    $this->dtoc_resolve_meta_settings_name();     
    ?>    
	<select class="smpg-input" name="<?php echo $this->_setting_name; ?>[display_position]" id="display_position">
        <option value="before_first_heading" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'before_first_heading' ? 'selected' : '' ) ?>><?php echo esc_html__('Before First Heading', 'digital-table-of-contents'); ?></option>
        <option value="after_first_heading" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'after_first_heading' ? 'selected' : '' ) ?>><?php echo esc_html__('After First Heading', 'digital-table-of-contents'); ?></option>
        <option value="top_of_the_content" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'top_of_the_content' ? 'selected' : '' ) ?>><?php echo esc_html__('Top Of The Content', 'digital-table-of-contents'); ?></option>
        <option value="bottom_of_the_content" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'bottom_of_the_content' ? 'selected' : '' ) ?>><?php echo esc_html__('Bottom Of The Content', 'digital-table-of-contents'); ?></option>
        <option value="after_paragraph_number" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'after_paragraph_number' ? 'selected' : '' ) ?>><?php echo esc_html__('After Paragraph Number', 'digital-table-of-contents'); ?></option>
    </select>	
    <?php
}
public function dtoc_general_sticky_position_cb() {
	$this->dtoc_resolve_meta_settings_name();
	?>
	<select class="smpg-input" name="<?php echo esc_attr( $this->_setting_name ); ?>[display_position]" id="display_position">
		<option value="left-top" <?php echo ( isset( $this->_setting_option['display_position'] ) && $this->_setting_option['display_position'] === 'left-top' ? 'selected' : '' ); ?>>
			<?php echo esc_html__( 'Left Top', 'digital-table-of-contents' ); ?>
		</option>
		<option value="left-middle" <?php echo ( isset( $this->_setting_option['display_position'] ) && $this->_setting_option['display_position'] === 'left-middle' ? 'selected' : '' ); ?>>
			<?php echo esc_html__( 'Left Middle', 'digital-table-of-contents' ); ?>
		</option>
		<option value="left-bottom" <?php echo ( isset( $this->_setting_option['display_position'] ) && $this->_setting_option['display_position'] === 'left-bottom' ? 'selected' : '' ); ?>>
			<?php echo esc_html__( 'Left Bottom', 'digital-table-of-contents' ); ?>
		</option>
		<option value="right-top" <?php echo ( isset( $this->_setting_option['display_position'] ) && $this->_setting_option['display_position'] === 'right-top' ? 'selected' : '' ); ?>>
			<?php echo esc_html__( 'Right Top', 'digital-table-of-contents' ); ?>
		</option>
		<option value="right-middle" <?php echo ( isset( $this->_setting_option['display_position'] ) && $this->_setting_option['display_position'] === 'right-middle' ? 'selected' : '' ); ?>>
			<?php echo esc_html__( 'Right Middle', 'digital-table-of-contents' ); ?>
		</option>
		<option value="right-bottom" <?php echo ( isset( $this->_setting_option['display_position'] ) && $this->_setting_option['display_position'] === 'right-bottom' ? 'selected' : '' ); ?>>
			<?php echo esc_html__( 'Right Bottom', 'digital-table-of-contents' ); ?>
		</option>
	</select>
	<?php
}

public function dtoc_general_paragraph_number_cb(){ 
    $this->dtoc_resolve_meta_settings_name();     
    ?>    
        <input class="smpg-input" type="number" min="1" max="200" id="paragraph_number" name="<?php echo $this->_setting_name; ?>[paragraph_number]" value="<?php echo (isset($this->_setting_option['paragraph_number']) ? esc_attr($this->_setting_option['paragraph_number']) : 1 ) ?>" />	
    <?php
}
public function dtoc_display_toggle_initial_cb() {
	$this->dtoc_resolve_meta_settings_name();
	?>
	<input class="smpg-input" data-id="toggle_initial" type="radio" id="toggle_initial_show" name="<?php echo esc_attr( $this->_setting_name ); ?>[toggle_initial]" value="show" 
		<?php checked( isset( $this->_setting_option['toggle_initial'] ) && $this->_setting_option['toggle_initial'] === 'show' ); ?>>
	<label for="toggle_initial_show" style="margin-right: 15px;"><?php esc_html_e( 'Show', 'digital-table-of-contents' ); ?></label>

	<input class="smpg-input" data-id="toggle_initial" type="radio" id="toggle_initial_hide" name="<?php echo esc_attr( $this->_setting_name ); ?>[toggle_initial]" value="hide" 
		<?php checked( isset( $this->_setting_option['toggle_initial'] ) && $this->_setting_option['toggle_initial'] === 'hide' ); ?>>
	<label for="toggle_initial_hide"><?php esc_html_e( 'Hide', 'digital-table-of-contents' ); ?></label>
	<?php
}



public function dtoc_resolve_meta_settings_name() {

	$dtoc_meta_type = get_transient( 'dtoc_meta_type' );

	if ( $dtoc_meta_type ) {
		$this->_setting_name = $dtoc_meta_type;
	}
}

}
if ( class_exists( 'Digital_TOC_Settings' ) ) {
	new Digital_TOC_Settings();
};