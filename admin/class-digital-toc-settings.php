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
		'Digital Table Of Contents In-Content',
        'In-Content',
		'manage_options',
		'dtoc_incontent',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents In-Content',
        'In-Content Mobile',
		'manage_options',
		'dtoc_incontent_mobile',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents In-Content',
        'In-Content Tablet',
		'manage_options',
		'dtoc_incontent_tablet',
        [$this, 'dtoc_settings_page_render']				
	);	
    add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Sticky',
        'Sticky',
		'manage_options',
		'dtoc_sticky',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Sticky',
        'Sticky Mobile',
		'manage_options',
		'dtoc_sticky_mobile',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Sticky',
        'Sticky Tablet',
		'manage_options',
		'dtoc_sticky_tablet',
        [$this, 'dtoc_settings_page_render']				
	);
    add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Floating',
        'Floating',
		'manage_options',
		'dtoc_floating',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Floating',
        'Floating Mobile',
		'manage_options',
		'dtoc_floating_mobile',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Floating',
        'Floating Tablet',
		'manage_options',
		'dtoc_floating_tablet',
        [$this, 'dtoc_settings_page_render']
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Shortcode',
        'Shortcode',
		'manage_options',
		'dtoc_shortcode',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Shortcode',
        'Shortcode Mobile',
		'manage_options',
		'dtoc_shortcode_mobile',
        [$this, 'dtoc_settings_page_render']				
	);
	add_submenu_page(
		'dtoc',
		'Digital Table Of Contents Shortcode',
        'Shortcode Tablet',
		'manage_options',
		'dtoc_shortcode_tablet',
        [$this, 'dtoc_settings_page_render']
	);		

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
    $tab_array[]       = 'display';        
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
    <h1 class="wp-heading-inline"><?php echo esc_html__('Digital Table Of Contents', 'digital-table-of-contents'); ?> | <?php echo $this->_page_title; ?></h1>    
    <!-- setting form start here -->
    <div class="dtoc-main-wrapper">
    <div class="dtoc-form-options">
     
     <h2 class="nav-tab-wrapper dtoc-tabs">
                     <?php					
                         echo '<a href="' . esc_url(dtoc_admin_tab_link('general', $this->_setting_name)) . '" class="nav-tab ' . esc_attr( $tab == 'general' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-welcome-view-site"></span> ' . esc_html__('General','digital-table-of-contents') . '</a>';                                                
                         echo '<a href="' . esc_url(dtoc_admin_tab_link('display', $this->_setting_name)) . '" class="nav-tab ' . esc_attr( $tab == 'display' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-visibility"></span> ' . esc_html__('Display','digital-table-of-contents') . '</a>';		                                    
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
                 echo "<div class='dtoc-display' ".( $tab != 'display' ? 'style="display:none;"' : '').">";                
                     do_settings_sections( 'dtoc_display_setting_section' );	
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
                 echo 'Container';
                 echo "</div>";
                 echo "<div class='dtoc-panel'>";                 
                 do_settings_sections( 'dtoc_customization_container_section' );
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";                 
                 echo 'Title';
                 echo "</div>";
                 echo "<div class='dtoc-panel'>";                 
                 do_settings_sections( 'dtoc_customization_title_section' );
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";                 
                 echo 'Icon';
                 echo "</div>";
                 echo "<div class='dtoc-panel'>";                 
                 do_settings_sections( 'dtoc_customization_icon_section' );
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";                 
                 echo 'Border';
                 echo "</div>";
                 echo "<div class='dtoc-panel'>";                 
                 do_settings_sections( 'dtoc_customization_border_section' );
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";                 
                 echo 'Link';
                 echo "</div>";
                 echo "<div class='dtoc-panel'>";                 
                 do_settings_sections( 'dtoc_customization_link_section' );
                 echo "</div>";

                 echo "<div class='dtoc-accordion'>";                 
                 echo 'Custom CSS';
                 echo "</div>";
                 echo "<div class='dtoc-panel'>";                 
                 $this->dtoc_customization_custom_css_cb();                                    
                 echo "</div>";
                                                                                     
                     
                 echo "</div>";                 

                 if(in_array($this->_setting_name, $this->_shortcode_modules)){
                    //Shortcode Source
                 echo "<div class='dtoc-shortcode_source' ".( $tab != 'shortcode_source' ? 'style="display:none;"' : '').">";
                     do_settings_sections( 'dtoc_shortcode_source_setting_section' );
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
        echo dtoc_get_live_preview_by_type($this->_setting_name, $this->_setting_option);
     ?>
        
    </div>
    </div>    
    <!-- setting form ends here -->
    </div>
    <?php

}

public function dtoc_settings_initiate(){
	
    register_setting('dtoc_incontent_group', 'dtoc_incontent' );
	register_setting('dtoc_incontent_mobile_group', 'dtoc_incontent_mobile' );
    register_setting('dtoc_incontent_tablet_group', 'dtoc_incontent_tablet' );

    register_setting('dtoc_sticky_group', 'dtoc_sticky' );
	register_setting('dtoc_sticky_mobile_group', 'dtoc_sticky_mobile' );
    register_setting('dtoc_sticky_tablet_group', 'dtoc_sticky_tablet' );

    register_setting('dtoc_floating_group', 'dtoc_floating' );
	register_setting('dtoc_floating_mobile_group', 'dtoc_floating_mobile' );
    register_setting('dtoc_floating_tablet_group', 'dtoc_floating_tablet' );

    register_setting('dtoc_shortcode_group', 'dtoc_shortcode' );
	register_setting('dtoc_shortcode_mobile_group', 'dtoc_shortcode_mobile' );
    register_setting('dtoc_shortcode_tablet_group', 'dtoc_shortcode_tablet' );

    // general
    add_settings_section('dtoc_general_setting_section', __return_false(), '__return_false', 'dtoc_general_setting_section');                                
    add_settings_field(
        'dtoc_general_jump_links',
         esc_html__('Jump Links', 'digital-table-of-contents'),
        [$this, 'dtoc_general_jump_links_cb'],
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
         array( 'label_for' => 'jump_links')
    );
    add_settings_field(
        'dtoc_general_loading_type',
         esc_html__('Loading Type', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_loading_type_cb'],        		
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
        array( 'label_for' => 'loading_type', 'class' => 'dtoc_child_opt dtoc_jump_links')
    );
    add_settings_field(
        'dtoc_general_scroll_behavior',
         esc_html__('Scroll Behavior', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_scroll_behavior_cb'],        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
        array( 'label_for' => 'scroll_behavior', 'class' => 'dtoc_child_opt dtoc_jump_links')
    );
    add_settings_field(
        'dtoc_general_scroll_back_to_toc',
         esc_html__('Scroll Back TO TOC', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_scroll_back_to_toc_cb'],        		        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
         array( 'label_for' => 'scroll_back_to_toc', 'class' => 'dtoc_child_opt dtoc_jump_links')
    );
    add_settings_field(
        'dtoc_general_header_text',
         esc_html__('Header Text', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_header_text_cb'],        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
    );
    add_settings_field(
        'dtoc_general_header_icon',
         esc_html__('Header Icon', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_header_icon_cb'],        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
    );
    add_settings_field(
        'dtoc_general_alignment',
         esc_html__('Alignment', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_alignment_cb'],        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
    );
    add_settings_field(
        'dtoc_general_wrap_content',
         esc_html__('Wrap Content Around TOC', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_wrap_content_cb'],        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
         array( 'label_for' => 'wrap_content')
    );
    add_settings_field(
        'dtoc_general_hierarchy',
         esc_html__('Hierarchy', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_hierarchy_cb'],        		        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
        array( 'label_for' => 'hierarchy')
    );    
    add_settings_field(                
        'dtoc_general_exp_col_subheadings',
         esc_html__('Expand / Collapse', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_exp_col_subheadings_cb'],        		        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
        array( 'label_for' => 'exp_col_subheadings', 'class' => 'dtoc_child_opt dtoc_hierarchy')
    );
    add_settings_field(
        'dtoc_general_show_more',
         esc_html__('Show More', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_show_more_cb'],        		        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
         array( 'label_for' => 'show_more')
    );        
    add_settings_field(
        'dtoc_general_list_style_type',
         esc_html__('List Style Type', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_list_style_type_cb'],        		        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
    );    
    add_settings_field(
        'dtoc_general_combine_page_break',
         esc_html__('Combine Page Break', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_combine_page_break_cb'],        		        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
        array( 'label_for' => 'combine_page_break')
    );
    add_settings_field(
        'dtoc_general_headings_include',
         esc_html__('Select Heading Tags', 'digital-table-of-contents'),
		 [$this, 'dtoc_general_headings_include_cb'],        
        'dtoc_general_setting_section',
        'dtoc_general_setting_section',
    );
    
    // Customization

	// Customization
    // add_settings_section('dtoc_customization_setting_section', __return_false(), '__return_false', 'dtoc_customization_setting_section');
    // add_settings_field(
    //     'dtoc_customization_design_type',
    //      esc_html__('Design Type', 'digital-table-of-contents'),        
	// 	[$this, 'dtoc_customization_design_type_cb'],  
    //     'dtoc_customization_setting_section',
    //     'dtoc_customization_setting_section',
    // );
    add_settings_section('dtoc_customization_container_section', __return_false(), '__return_false', 'dtoc_customization_container_section');
    add_settings_section('dtoc_customization_title_section', __return_false(), '__return_false', 'dtoc_customization_title_section');
    add_settings_section('dtoc_customization_icon_section', __return_false(), '__return_false', 'dtoc_customization_icon_section');
    add_settings_section('dtoc_customization_border_section', __return_false(), '__return_false', 'dtoc_customization_border_section');
    add_settings_section('dtoc_customization_link_section', __return_false(), '__return_false', 'dtoc_customization_link_section');
    // add_settings_section('dtoc_customization_custom_css_section', __return_false(), '__return_false', 'dtoc_customization_custom_css_section');    

    add_settings_field(
        'dtoc_customization_title_bg_color',
         esc_html__('Background Color', 'digital-table-of-contents'),        		
		[$this, 'dtoc_customization_title_bg_color_cb'],  
        'dtoc_customization_title_section',
        'dtoc_customization_title_section',
    );
    add_settings_field(
        'dtoc_customization_title_fg_color',
         esc_html__('Foreground Color', 'digital-table-of-contents'),        		
		[$this, 'dtoc_customization_title_fg_color_cb'],  
        'dtoc_customization_title_section',
        'dtoc_customization_title_section',
    );
    add_settings_field(
        'dtoc_customization_title_font_size',
         esc_html__('Font Size', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_title_font_size_cb'],  
        'dtoc_customization_title_section',
        'dtoc_customization_title_section'
    );
    add_settings_field(
        'dtoc_customization_title_font_weight',
         esc_html__('Font Weight', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_title_font_weight_cb'],  
        'dtoc_customization_title_section',
        'dtoc_customization_title_section'
    );
    add_settings_field(
        'dtoc_customization_title_padding',
         esc_html__('Padding', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_title_padding_cb'],  
        'dtoc_customization_title_section',
        'dtoc_customization_title_section'
    );
    // Icon customization starts here
    add_settings_field(
        'dtoc_customization_icon_bg_color',
         esc_html__('Background Color', 'digital-table-of-contents'),        		
		[$this, 'dtoc_customization_icon_bg_color_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    add_settings_field(
        'dtoc_customization_icon_fg_color',
         esc_html__('Foreground Color', 'digital-table-of-contents'),        		
		[$this, 'dtoc_customization_icon_fg_color_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    add_settings_field(
        'dtoc_customization_icon_size_color',
         esc_html__('Size', 'digital-table-of-contents'),        		
		[$this, 'dtoc_customization_icon_size_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    add_settings_field(
        'dtoc_customization_icon_border_type',
         esc_html__('Border Type', 'digital-table-of-contents'),
		[$this, 'dtoc_customization_icon_border_type_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    add_settings_field(
        'dtoc_customization_icon_border_color',
         esc_html__('Border Color', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_icon_border_color_cb'],  		
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    add_settings_field(
        'dtoc_customization_icon_border_width',
         esc_html__('Border Width', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_icon_border_width_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );    
    add_settings_field(
        'dtoc_customization_icon_border_radius',
         esc_html__('Border Radius', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_icon_border_radius_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    add_settings_field(
        'dtoc_customization_icon_padding',
         esc_html__('Padding', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_icon_padding_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    add_settings_field(
        'dtoc_customization_icon_margin',
         esc_html__('Margin', 'digital-table-of-contents'),
		[$this, 'dtoc_customization_icon_margin_cb'],  
        'dtoc_customization_icon_section',
        'dtoc_customization_icon_section',
    );
    
    // Icon customization ends here        
    add_settings_field(
        'dtoc_customization_bg_color',
         esc_html__('Background Color', 'digital-table-of-contents'),        		
		[$this, 'dtoc_customization_bg_color_cb'],  
        'dtoc_customization_container_section',
        'dtoc_customization_container_section',
    );    
    add_settings_field(
        'dtoc_customization_link_color',
         esc_html__('Color', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_link_color_cb'],  
        'dtoc_customization_link_section',
        'dtoc_customization_link_section',
    );
    add_settings_field(
        'dtoc_customization_link_hover_color',
         esc_html__('Hover Color', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_link_hover_color_cb'],  	
        'dtoc_customization_link_section',
        'dtoc_customization_link_section',
    );
    add_settings_field(
        'dtoc_customization_link_visited_color',
         esc_html__('Visited Color', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_link_visited_color_cb'],  	
        'dtoc_customization_link_section',
        'dtoc_customization_link_section',
    );
    add_settings_field(
        'dtoc_customization_link_padding',
         esc_html__('Padding', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_link_padding_cb'],
        'dtoc_customization_link_section',
        'dtoc_customization_link_section',
    );
    add_settings_field(
        'dtoc_customization_link_margin',
         esc_html__('Margin', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_link_margin_cb'],
        'dtoc_customization_link_section',
        'dtoc_customization_link_section',
    );
    add_settings_field(
        'dtoc_customization_container_width',
         esc_html__('Width', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_container_width_cb'],  	
        'dtoc_customization_container_section',
        'dtoc_customization_container_section',
    );
    add_settings_field(
        'dtoc_customization_container_height',
         esc_html__('Height', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_container_height_cb'],  	
        'dtoc_customization_container_section',
        'dtoc_customization_container_section',
    );
    add_settings_field(
        'dtoc_customization_container_margin',
         esc_html__('Margin', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_container_margin_cb'],  	
        'dtoc_customization_container_section',
        'dtoc_customization_container_section',
    );
    add_settings_field(
        'dtoc_customization_container_padding',
         esc_html__('Padding', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_container_padding_cb'],  
        'dtoc_customization_container_section',
        'dtoc_customization_container_section',
    );
    add_settings_field(
        'dtoc_customization_border_type',
         esc_html__('Type', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_border_type_cb'],  
        'dtoc_customization_border_section',
        'dtoc_customization_border_section',
    );
    add_settings_field(
        'dtoc_customization_border_color',
         esc_html__('Color', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_border_color_cb'],  		
        'dtoc_customization_border_section',
        'dtoc_customization_border_section',
    );
    add_settings_field(
        'dtoc_customization_border_width',
         esc_html__('Width', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_border_width_cb'],  
        'dtoc_customization_border_section',
        'dtoc_customization_border_section',
    );    
    add_settings_field(
        'dtoc_customization_border_radius',
         esc_html__('Radius', 'digital-table-of-contents'),        
		[$this, 'dtoc_customization_border_radius_cb'],  
        'dtoc_customization_border_section',
        'dtoc_customization_border_section',
    );             
    //Shortcode Source    
    add_settings_section('dtoc_shortcode_source_setting_section', __return_false(), '__return_false', 'dtoc_shortcode_source_setting_section');
    add_settings_field(
        'dtoc_shortcode_source',
            '',
            [$this, 'dtoc_shortcode_source_cb'],        
        'dtoc_shortcode_source_setting_section',
        'dtoc_shortcode_source_setting_section'
    );              
    add_settings_section('dtoc_display_setting_section', __return_false(), '__return_false', 'dtoc_display_setting_section');                                
    
    add_settings_field(
            'dtoc_display_When',
             esc_html__('Display When', 'digital-table-of-contents'),
			 [$this, 'dtoc_display_when_cb'],        		            
            'dtoc_display_setting_section',
            'dtoc_display_setting_section'
    );    
    add_settings_field(
            'dtoc_display_position',
             esc_html__('Display Position', 'digital-table-of-contents'),
			 [$this, 'dtoc_display_position_cb'],            
            'dtoc_display_setting_section',
            'dtoc_display_setting_section'
    );
    add_settings_field(
            'dtoc_display_title',
             esc_html__('Display Title', 'digital-table-of-contents'),
			 [$this, 'dtoc_display_title_cb'],            
            'dtoc_display_setting_section',
            'dtoc_display_setting_section',
             array( 'label_for' => 'display_title')
    );
    add_settings_field(
        'dtoc_display_toggle_body',
         esc_html__('Toggle Body', 'digital-table-of-contents'),
		 [$this, 'dtoc_display_toggle_body_cb'],        		        
        'dtoc_display_setting_section',
        'dtoc_display_setting_section',
         array( 'label_for' => 'toggle_body', 'class' => 'dtoc_child_opt')
    );
    add_settings_field(
        'dtoc_display_toggle_initial',
         esc_html__('Toggle Initial', 'digital-table-of-contents'),
		 [$this, 'dtoc_display_toggle_initial_cb'],        
        'dtoc_display_setting_section',
        'dtoc_display_setting_section',
         array( 'label_for' => 'toggle_initial', 'class' => 'dtoc_child_opt')
    );    

}

public function dtoc_general_combine_page_break_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[combine_page_break]" id="combine_page_break" type="checkbox" value="1" <?php echo (isset($this->_setting_option['combine_page_break']) && $this->_setting_option['combine_page_break'] == 1 ? 'checked' : '' ) ?>>
        
    <?php
}

public function dtoc_general_hierarchy_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>  
        <input class="dtoc_parent_option" name="<?php echo $this->_setting_name; ?>[hierarchy]" id="hierarchy" type="checkbox" value="1" <?php echo (isset($this->_setting_option['hierarchy']) && $this->_setting_option['hierarchy'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_general_exp_col_subheadings_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[exp_col_subheadings]" id="exp_col_subheadings" type="checkbox" value="1" <?php echo (isset($this->_setting_option['exp_col_subheadings']) && $this->_setting_option['exp_col_subheadings'] == 1 ? 'checked' : '' ) ?>>
    <?php
}

public function dtoc_general_list_style_type_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    	                
    $counters = array(
				'decimal'   => __( 'Decimal numbers, start with 1. (default value)', 'digital-table-of-contents' ),
                'disc'      => __( 'A filled circle.', 'digital-table-of-contents' ),                
                'none'      => __( 'No item marker is shown.', 'digital-table-of-contents' ),                
                'circle'      => __( 'circle', 'digital-table-of-contents' ),
                'square'      => __( 'square', 'digital-table-of-contents' ),
                'cjk-decimal'      => __( 'Han decimal', 'digital-table-of-contents' ),
                'decimal-leading-zero'      => __( 'Decimal padded by initial zero', 'digital-table-of-contents' ),
                'lower-roman'      => __( 'Lowercase roman numerals.', 'digital-table-of-contents' ),
                'upper-roman'      => __( 'Uppercase roman numerals.', 'digital-table-of-contents' ),
                'lower-greek'      => __( 'Lowercase classical Greek.', 'digital-table-of-contents' ),
                'lower-alpha'      => __( 'Lowercase ASCII letters.', 'digital-table-of-contents' ),
                'upper-alpha'      => __( 'Uppercase ASCII letters.', 'digital-table-of-contents' ),
                'arabic-indic'      => __( 'Arabic-Indic numbers.', 'digital-table-of-contents' ),
                'armenian'      => __( 'Traditional Armenian numbering.', 'digital-table-of-contents' ),
                'bengali'      => __( 'Bengali numbering.', 'digital-table-of-contents' ),
                'cambodian'      => __( 'Cambodian/Khmer numbering.', 'digital-table-of-contents' ),
                'cjk-earthly-branch'      => __( 'Han "Earthly Branch" ordinals.', 'digital-table-of-contents' ),
                'cjk-heavenly-stem'      => __( 'Han "Heavenly Stem" ordinals.', 'digital-table-of-contents' ),
                'cjk-ideographic'      => __( 'Traditional Chinese informal numbering.', 'digital-table-of-contents' ),
                'devanagari'      => __( 'Devanagari numbering.', 'digital-table-of-contents' ),
                'ethiopic-numeric'      => __( 'Ethiopic numbering.', 'digital-table-of-contents' ),
                'georgian'      => __( 'Traditional Georgian numbering.', 'digital-table-of-contents' ),
                'gujarati'      => __( 'Gujarati numbering.', 'digital-table-of-contents' ),
                'gurmukhi'      => __( 'Gurmukhi numbering.', 'digital-table-of-contents' ),
                'hebrew'      => __( 'Traditional Hebrew numbering.', 'digital-table-of-contents' ),
                'hiragana'      => __( 'Dictionary-order hiragana lettering.', 'digital-table-of-contents' ),
                'hiragana-iroha'      => __( 'Iroha-order hiragana lettering.', 'digital-table-of-contents' ),
                'japanese-formal'      => __( 'Japanese formal numbering.', 'digital-table-of-contents' ),
                'japanese-informal'      => __( 'Japanese informal numbering.', 'digital-table-of-contents' ),
                'kannada'      => __( 'Kannada numbering.', 'digital-table-of-contents' ),
                'katakana'      => __( 'Dictionary-order katakana lettering.', 'digital-table-of-contents' ),
                'katakana-iroha'      => __( 'Iroha-order katakana lettering.', 'digital-table-of-contents' ),
                'korean-hangul-formal'      => __( 'Formal Korean Han numbering.', 'digital-table-of-contents' ),
                'korean-hanja-informal'      => __( 'Korean hanja numbering.', 'digital-table-of-contents' ),
                'lao'      => __( 'Laotian numbering.', 'digital-table-of-contents' ),
                'lower-armenian'      => __( 'Lowercase Armenian numbering.', 'digital-table-of-contents' ),
                'malayalam'      => __( 'Malayalam numbering.', 'digital-table-of-contents' ),
                'mongolian'      => __( 'Mongolian numbering.', 'digital-table-of-contents' ),
                'myanmar'      => __( 'Myanmar (Burmese) numbering.', 'digital-table-of-contents' ),
                'oriya'      => __( 'Oriya numbering.', 'digital-table-of-contents' ),
                'persian'      => __( 'Persian numbering.', 'digital-table-of-contents' ),
                'simp-chinese-formal'      => __( 'Chinese formal numbering.', 'digital-table-of-contents' ),
                'simp-chinese-informal'      => __( 'Chinese informal numbering.', 'digital-table-of-contents' ),
                'tamil'      => __( 'Tamil numbering.', 'digital-table-of-contents' ),
                'telugu'      => __( 'Telugu numbering.', 'digital-table-of-contents' ),
                'thai'      => __( 'Thai numbering.', 'digital-table-of-contents' ),
                'tibetan'      => __( 'Tibetan numbering.', 'digital-table-of-contents' ),
                'trad-chinese-formal'      => __( 'Traditional Chinese formal numbering.', 'digital-table-of-contents' ),
                'trad-chinese-informal'      => __( 'Traditional Chinese informal numbering.', 'digital-table-of-contents' ),
                'upper-armenian'      => __( 'Traditional uppercase Armenian numbering.', 'digital-table-of-contents' ),
                'urdu'      => __( 'Urdu numbering', 'digital-table-of-contents' )                
            );

    ?>
    
	<select name="<?php echo $this->_setting_name; ?>[list_style_type]" id="list_style_type">
        <?php  
            foreach ($counters as $key => $value) {
                if( isset($this->_setting_option['list_style_type']) && $key == $this->_setting_option['list_style_type']){
                    echo '<option value="'.esc_attr($key).'" selected>'.esc_html($value).'</option>';
                }else{
                    echo '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                }
                
            }
        ?>
                
    </select>
	
    <?php
}
public function dtoc_general_show_more_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[show_more]" id="show_more" type="checkbox" value="1" <?php echo (isset($this->_setting_option['show_more']) && $this->_setting_option['show_more'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_general_jump_links_cb($args){
    $this->dtoc_resolve_meta_settings_name(); 	    
    ?>  
        <input class="dtoc_parent_option" name="<?php echo $this->_setting_name; ?>[jump_links]" id="jump_links" type="checkbox" value="1" <?php echo (isset($this->_setting_option['jump_links']) && $this->_setting_option['jump_links'] == 1 ? 'checked' : '' ) ?>>
        
    <?php
}
public function dtoc_customization_border_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
        ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[border_color]" id="border_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['border_color'] ) ? esc_attr( $this->_setting_option['border_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_icon_border_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
    <input type="text" name="<?php echo $this->_setting_name; ?>[icon_border_color]" id="icon_border_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['icon_border_color'] ) ? esc_attr( $this->_setting_option['icon_border_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
<?php
}
public function dtoc_customization_link_color_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[link_color]" id="link_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['link_color'] ) ? esc_attr( $this->_setting_option['link_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_link_hover_color_cb(){
    $this->dtoc_resolve_meta_settings_name(); 	    
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[link_hover_color]" id="link_hover_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['link_hover_color'] ) ? esc_attr( $this->_setting_option['link_hover_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_link_visited_color_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[link_visited_color]" id="link_visited_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['link_visited_color'] ) ? esc_attr( $this->_setting_option['link_visited_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_title_fg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[title_fg_color]" id="title_fg_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['title_fg_color'] ) ? esc_attr( $this->_setting_option['title_fg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_title_bg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[title_bg_color]" id="title_bg_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['title_bg_color'] ) ? esc_attr( $this->_setting_option['title_bg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_bg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[bg_color]" id="bg_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['bg_color'] ) ? esc_attr( $this->_setting_option['bg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_icon_bg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[icon_bg_color]" id="icon_bg_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['icon_bg_color'] ) ? esc_attr( $this->_setting_option['icon_bg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_icon_fg_color_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
        <input type="text" name="<?php echo $this->_setting_name; ?>[icon_fg_color]" id="icon_fg_color" class="dtoc-colorpicker" data-alpha-enabled="true" value="<?php echo isset( $this->_setting_option['icon_fg_color'] ) ? esc_attr( $this->_setting_option['icon_fg_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
    <?php
}
public function dtoc_customization_design_type_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>    
	<select name="<?php echo $this->_setting_name; ?>[design_type]" id="design_type">
        <option value="grey" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'grey' ? 'selected' : '' ) ?>><?php echo esc_html__('Grey', 'digital-table-of-contents'); ?></option>
        <option value="light_blue" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'light_blue' ? 'selected' : '' ) ?>><?php echo esc_html__('Light Blue', 'digital-table-of-contents'); ?></option>
        <option value="white" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'white' ? 'selected' : '' ) ?>><?php echo esc_html__('White', 'digital-table-of-contents'); ?></option>
        <option value="black" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'black' ? 'selected' : '' ) ?>><?php echo esc_html__('Black', 'digital-table-of-contents'); ?></option>
        <option value="transparent" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'transparent' ? 'selected' : '' ) ?>><?php echo esc_html__('Transparent', 'digital-table-of-contents'); ?></option>
        <option value="custom" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'custom' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom', 'digital-table-of-contents'); ?></option>
    </select>
	
    <?php
}
public function dtoc_customization_custom_css_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>
  <div class="dtoc_custom_styles"><?php  echo isset($this->_setting_option['custom_css'])?$this->_setting_option['custom_css']:'';?></div>
  <textarea id="custom_css" name="<?php echo $this->_setting_name; ?>[custom_css]" style="display: none"></textarea>  
	<?php
}
public function dtoc_customization_icon_size_cb(){
    $this->dtoc_resolve_meta_settings_name();	
    ?>    	
    <ul style="display: flex;">
        <li>
        <input type="number" class="small-text" id="icon_width" name="<?php echo $this->_setting_name; ?>[icon_width]" value="<?php echo isset( $this->_setting_option['icon_width'] ) ? esc_attr( $this->_setting_option['icon_width']) : '25'; ?>">
        <br>
        <label><?php echo esc_html__('Width', 'digital-table-of-contents'); ?></label>
        </li>

        <li>
        <input type="number" class="small-text" id="icon_height" name="<?php echo $this->_setting_name; ?>[icon_height]" value="<?php echo isset( $this->_setting_option['icon_height'] ) ? esc_attr( $this->_setting_option['icon_height']) : '25'; ?>">
        <br>
        <label><?php echo esc_html__('Height', 'digital-table-of-contents'); ?></label>
        </li>
        
        <li>
        <select name="<?php echo $this->_setting_name; ?>[icon_size_unit]" id="icon_size_unit">
            <option value="px" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['icon_size_unit']) && $this->_setting_option['icon_size_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <label><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></label>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_border_radius_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   
    ?>    	
    <ul style="display: flex;">
        <li>
        <input type="number" class="small-text" id="border_radius_top_left" name="<?php echo $this->_setting_name; ?>[border_radius_top_left]" value="<?php echo isset( $this->_setting_option['border_radius_top_left'] ) ? esc_attr( $this->_setting_option['border_radius_top_left']) : '0'; ?>">
        <label><?php echo esc_html__('Top Left', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <input type="number" class="small-text" id="border_radius_top_right" name="<?php echo $this->_setting_name; ?>[border_radius_top_right]" value="<?php echo isset( $this->_setting_option['border_radius_top_right'] ) ? esc_attr( $this->_setting_option['border_radius_top_right']) : '0'; ?>">
        <label><?php echo esc_html__('Top Right', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <input type="number" class="small-text" id="border_radius_bottom_left" name="<?php echo $this->_setting_name; ?>[border_radius_bottom_left]" value="<?php echo isset( $this->_setting_option['border_radius_bottom_left'] ) ? esc_attr( $this->_setting_option['border_radius_bottom_left']) : '0'; ?>">
        <label><?php echo esc_html__('Bottom Left', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <input type="number" class="small-text" id="border_radius_bottom_right" name="<?php echo $this->_setting_name; ?>[border_radius_bottom_right]" value="<?php echo isset( $this->_setting_option['border_radius_bottom_right'] ) ? esc_attr( $this->_setting_option['border_radius_bottom_right']) : '0'; ?>">
        <label><?php echo esc_html__('Bottom Right', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <select name="<?php echo $this->_setting_name; ?>[border_radius_unit]" id="border_radius_unit">
            <option value="px" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['border_radius_unit']) && $this->_setting_option['border_radius_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <label><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></label>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_icon_border_radius_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   
    ?>    	
    <ul style="display: flex;">
        <li>
        <input type="number" class="small-text" id="icon_border_radius_top_left" name="<?php echo $this->_setting_name; ?>[icon_border_radius_top_left]" value="<?php echo isset( $this->_setting_option['icon_border_radius_top_left'] ) ? esc_attr( $this->_setting_option['icon_border_radius_top_left']) : '0'; ?>">
        <label><?php echo esc_html__('Top Left', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <input type="number" class="small-text" id="icon_border_radius_top_right" name="<?php echo $this->_setting_name; ?>[icon_border_radius_top_right]" value="<?php echo isset( $this->_setting_option['icon_border_radius_top_right'] ) ? esc_attr( $this->_setting_option['icon_border_radius_top_right']) : '0'; ?>">
        <label><?php echo esc_html__('Top Right', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <input type="number" class="small-text" id="icon_border_radius_bottom_left" name="<?php echo $this->_setting_name; ?>[icon_border_radius_bottom_left]" value="<?php echo isset( $this->_setting_option['icon_border_radius_bottom_left'] ) ? esc_attr( $this->_setting_option['icon_border_radius_bottom_left']) : '0'; ?>">
        <label><?php echo esc_html__('Bottom Left', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <input type="number" class="small-text" id="icon_border_radius_bottom_right" name="<?php echo $this->_setting_name; ?>[icon_border_radius_bottom_right]" value="<?php echo isset( $this->_setting_option['icon_border_radius_bottom_right'] ) ? esc_attr( $this->_setting_option['icon_border_radius_bottom_right']) : '0'; ?>">
        <label><?php echo esc_html__('Bottom Right', 'digital-table-of-contents'); ?></label>
        </li>
        <li>
        <select name="<?php echo $this->_setting_name; ?>[icon_border_radius_unit]" id="icon_border_radius_unit">
            <option value="px" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
            <option value="pt" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
            <option value="%" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
            <option value="em" <?php echo (isset($this->_setting_option['icon_border_radius_unit']) && $this->_setting_option['icon_border_radius_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <label><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></label>
        </li>
    </ul>    	    
    <?php
}
public function dtoc_customization_link_margin_cb(){
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'margin', 'link');
}
public function dtoc_customization_link_padding_cb(){
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'link');
}
public function dtoc_customization_icon_padding_cb(){    
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'icon');
}
public function dtoc_customization_title_padding_cb(){
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'title');
}
public function dtoc_customization_icon_margin_cb(){    
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'margin', 'icon');    
}
public function dtoc_customization_container_width_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
    <input type="number" class="small-text" id="container_height" name="<?php echo $this->_setting_name; ?>[container_width]" value="<?php echo isset( $this->_setting_option['container_width'] ) ? esc_attr( $this->_setting_option['container_width']) : '0'; ?>">
    <select name="<?php echo $this->_setting_name; ?>[container_width_unit]" id="container_width_unit">
        <option value="px" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
        <option value="pt" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
        <option value="%" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
        <option value="em" <?php echo (isset($this->_setting_option['container_width_unit']) && $this->_setting_option['container_width_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <label><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></label>
    <?php
}
public function dtoc_customization_title_font_size_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
    <input type="number" class="small-text" id="title_font_size" name="<?php echo $this->_setting_name; ?>[title_font_size]" value="<?php echo isset( $this->_setting_option['title_font_size'] ) ? esc_attr( $this->_setting_option['title_font_size']) : '0'; ?>">
    <select name="<?php echo $this->_setting_name; ?>[title_font_size_unit]" id="title_font_size_unit">
        <option value="px" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
        <option value="pt" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
        <option value="%" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
        <option value="em" <?php echo (isset($this->_setting_option['title_font_size_unit']) && $this->_setting_option['title_font_size_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <label><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></label>
    <?php
}
public function dtoc_customization_title_font_weight_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
    <input type="number" class="small-text" id="title_font_weight" name="<?php echo $this->_setting_name; ?>[title_font_weight]" value="<?php echo isset( $this->_setting_option['title_font_weight'] ) ? esc_attr( $this->_setting_option['title_font_weight']) : '0'; ?>">
    <select name="<?php echo $this->_setting_name; ?>[title_font_weight_unit]" id="title_font_weight_unit">
        <option value="px" <?php echo (isset($this->_setting_option['title_font_weight_unit']) && $this->_setting_option['title_font_weight_unit'] == 'px' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
        <option value="pt" <?php echo (isset($this->_setting_option['title_font_weight_unit']) && $this->_setting_option['title_font_weight_unit'] == 'pt' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
        <option value="%" <?php echo (isset($this->_setting_option['title_font_weight_unit']) && $this->_setting_option['title_font_weight_unit'] == '%' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
        <option value="em" <?php echo (isset($this->_setting_option['title_font_weight_unit']) && $this->_setting_option['title_font_weight_unit'] == 'em' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <label><?php echo esc_html__('Unit', 'digital-table-of-contents'); ?></label>
    <?php
}
public function dtoc_customization_container_height_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>
    <input type="number" class="small-text" id="ez-toc-settings[headings-padding-top]" name="ez-toc-settings[headings-padding-top]" value="0" placeholder="">
    <select name="<?php echo $this->_setting_name; ?>[design_type]" id="design_type">
        <option value="px" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'grey' ? 'selected' : '' ) ?>><?php echo esc_html__('px', 'digital-table-of-contents'); ?></option>
        <option value="pt" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'light_blue' ? 'selected' : '' ) ?>><?php echo esc_html__('pt', 'digital-table-of-contents'); ?></option>
        <option value="%" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'white' ? 'selected' : '' ) ?>><?php echo esc_html__('%', 'digital-table-of-contents'); ?></option>
        <option value="em" <?php echo (isset($this->_setting_option['design_type']) && $this->_setting_option['design_type'] == 'black' ? 'selected' : '' ) ?>><?php echo esc_html__('em', 'digital-table-of-contents'); ?></option>        
        </select>
        <label>Unit</label>
    <?php
    
}
public function dtoc_customization_container_margin_cb(){            
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'margin', 'container');        
}
public function dtoc_customization_container_padding_cb(){    
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'padding', 'container');
}
public function dtoc_customization_icon_border_width_cb(){
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'width', 'icon_border');
}
public function dtoc_customization_border_width_cb(){      
    dtoc_different_four_sides_html($this->_setting_name, $this->_setting_option, 'width', 'border');        
}
public function dtoc_customization_border_type_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?>    
	<select name="<?php echo $this->_setting_name; ?>[border_type]" id="border_type">
        <option value="default" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="none" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'none' ? 'selected' : '' ) ?>><?php echo esc_html__('None', 'digital-table-of-contents'); ?></option>
        <option value="solid" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'solid' ? 'selected' : '' ) ?>><?php echo esc_html__('Solid', 'digital-table-of-contents'); ?></option>
        <option value="double" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'double' ? 'selected' : '' ) ?>><?php echo esc_html__('Double', 'digital-table-of-contents'); ?></option>
        <option value="dotted" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'dotted' ? 'selected' : '' ) ?>><?php echo esc_html__('Dotted', 'digital-table-of-contents'); ?></option>
        <option value="dashed" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'dashed' ? 'selected' : '' ) ?>><?php echo esc_html__('Dashed', 'digital-table-of-contents'); ?></option>
        <option value="groove" <?php echo (isset($this->_setting_option['border_type']) && $this->_setting_option['border_type'] == 'groove' ? 'selected' : '' ) ?>><?php echo esc_html__('Groove', 'digital-table-of-contents'); ?></option>
    </select>
	
    <?php
}
public function dtoc_customization_icon_border_type_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>    
	<select name="<?php echo $this->_setting_name; ?>[icon_border_type]" id="icon_border_type">
        <option value="default" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'default' ? 'selected' : '' ) ?>><?php echo esc_html__('Default', 'digital-table-of-contents'); ?></option>
        <option value="none" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'none' ? 'selected' : '' ) ?>><?php echo esc_html__('None', 'digital-table-of-contents'); ?></option>
        <option value="solid" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'solid' ? 'selected' : '' ) ?>><?php echo esc_html__('Solid', 'digital-table-of-contents'); ?></option>
        <option value="double" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'double' ? 'selected' : '' ) ?>><?php echo esc_html__('Double', 'digital-table-of-contents'); ?></option>
        <option value="dotted" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'dotted' ? 'selected' : '' ) ?>><?php echo esc_html__('Dotted', 'digital-table-of-contents'); ?></option>
        <option value="dashed" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'dashed' ? 'selected' : '' ) ?>><?php echo esc_html__('Dashed', 'digital-table-of-contents'); ?></option>
        <option value="groove" <?php echo (isset($this->_setting_option['icon_border_type']) && $this->_setting_option['icon_border_type'] == 'groove' ? 'selected' : '' ) ?>><?php echo esc_html__('Groove', 'digital-table-of-contents'); ?></option>
    </select>
	
    <?php
}
public function dtoc_general_loading_type_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   	                
    ?>    
    
    <input type="radio" id="js_loading_type" name="<?php echo $this->_setting_name; ?>[loading_type]" value="js"<?php echo (isset($this->_setting_option['loading_type']) && $this->_setting_option['loading_type'] == 'js' ? 'checked' : '' ) ?>>
    <label for="js_loading_type"><?php echo esc_html__('JS', 'digital-table-of-contents'); ?></label>
    <input type="radio" id="css_loading_type" name="<?php echo $this->_setting_name; ?>[loading_type]" value="css" <?php echo (isset($this->_setting_option['loading_type']) && $this->_setting_option['loading_type'] == 'css' ? 'checked' : '' ) ?>>
    <label for="css_loading_type"><?php echo esc_html__('CSS', 'digital-table-of-contents'); ?></label>	
    
    <?php
}
public function dtoc_general_scroll_behavior_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   	                
    ?>    
    
    <input type="radio" id="auto_scroll_behavior" name="<?php echo $this->_setting_name; ?>[scroll_behavior]" value="auto"<?php echo (isset($this->_setting_option['scroll_behavior']) && $this->_setting_option['scroll_behavior'] == 'auto' ? 'checked' : '' ) ?>>
    <label for="auto_scroll_behavior"><?php echo esc_html__('Auto', 'digital-table-of-contents'); ?></label>
    <input type="radio" id="smooth_scroll_behavior" name="<?php echo $this->_setting_name; ?>[scroll_behavior]" value="smooth" <?php echo (isset($this->_setting_option['scroll_behavior']) && $this->_setting_option['scroll_behavior'] == 'smooth' ? 'checked' : '' ) ?>>
    <label for="smooth_scroll_behavior"><?php echo esc_html__('Smooth', 'digital-table-of-contents'); ?></label>	
    
    <?php
}
public function dtoc_general_alignment_cb(){
    $this->dtoc_resolve_meta_settings_name(); 		
    ?> 
    
    <input type="radio" id="left_alignment" name="<?php echo $this->_setting_name; ?>[alignment]" value="left"<?php echo (isset($this->_setting_option['alignment']) && $this->_setting_option['alignment'] == 'left' ? 'checked' : '' ) ?>>
    <label for="left_alignment"><?php echo esc_html__('Left', 'digital-table-of-contents'); ?></label>
    <input type="radio" id="center_alignment" name="<?php echo $this->_setting_name; ?>[alignment]" value="center"<?php echo (isset($this->_setting_option['alignment']) && $this->_setting_option['alignment'] == 'center' ? 'checked' : '' ) ?>>
    <label for="center_alignment"><?php echo esc_html__('Center', 'digital-table-of-contents'); ?></label>
    <input type="radio" id="right_alignment" name="<?php echo $this->_setting_name; ?>[alignment]" value="right"<?php echo (isset($this->_setting_option['alignment']) && $this->_setting_option['alignment'] == 'right' ? 'checked' : '' ) ?>>
    <label for="right_alignment"><?php echo esc_html__('Right', 'digital-table-of-contents'); ?></label>    
    
	
    <?php
}
public function dtoc_general_header_icon_cb(){
	$this->dtoc_resolve_meta_settings_name(); 	
    ?>    
	<select name="<?php echo $this->_setting_name; ?>[header_icon]" id="header_icon">
        <option value="none" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'none' ? 'selected' : '' ) ?>><?php echo esc_html__('None', 'digital-table-of-contents'); ?></option>        
        <option value="plain_list" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'plain_list' ? 'selected' : '' ) ?>><?php echo esc_html__('Plain List', 'digital-table-of-contents'); ?></option>
        <option value="updown_arrow" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'updown_arrow' ? 'selected' : '' ) ?>><?php echo esc_html__('Up Down Arrow', 'digital-table-of-contents'); ?></option>
        <option value="list_updown_arrow" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'list_updown_arrow' ? 'selected' : '' ) ?>><?php echo esc_html__('List Up Down Arrow', 'digital-table-of-contents'); ?></option>
        <option value="custom_text" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'custom_text' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom Text', 'digital-table-of-contents'); ?></option>
        <option value="custom_icon" <?php echo (isset($this->_setting_option['header_icon']) && $this->_setting_option['header_icon'] == 'custom_icon' ? 'selected' : '' ) ?>><?php echo esc_html__('Custom Icon', 'digital-table-of-contents'); ?></option>
    </select>	
    <button type="button" class="button pwaforwp-icon-upload" data-editor="content">
		<span class="dashicons dashicons-format-image" style="margin-top: 4px;"></span> <?php echo esc_html__('Choose Icon', 'digital-table-of-contents'); ?> 
	</button>
    <?php
}
public function dtoc_general_header_text_cb(){
	    $this->dtoc_resolve_meta_settings_name(); 	
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[header_text]" id="header_text" type="text" value="<?php echo (isset($this->_setting_option['header_text']) ? $this->_setting_option['header_text'] : 'Table Of Contents' ) ?>">
    <?php
}
public function dtoc_display_title_cb(){  
    $this->dtoc_resolve_meta_settings_name(); 	  	                        
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[display_title]" id="display_title" type="checkbox" value="1" <?php echo (isset($this->_setting_option['display_title']) && $this->_setting_option['display_title'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_general_scroll_back_to_toc_cb(){  
    $this->dtoc_resolve_meta_settings_name(); 	  	                        
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[scroll_back_to_top]" id="scroll_back_to_toc" type="checkbox" value="1" <?php echo (isset($this->_setting_option['scroll_back_to_top']) && $this->_setting_option['scroll_back_to_top'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_general_wrap_content_cb(){ 
    $this->dtoc_resolve_meta_settings_name(); 	   	                        
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[wrap_content]" id="wrap_content" type="checkbox" value="1" <?php echo (isset($this->_setting_option['wrap_content']) && $this->_setting_option['wrap_content'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_display_toggle_body_cb(){  
    $this->dtoc_resolve_meta_settings_name(); 	                        
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[toggle_body]" id="toggle_body" type="checkbox" value="1" <?php echo (isset($this->_setting_option['toggle_body']) && $this->_setting_option['toggle_body'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_customization_remove_css_js_cb(){ 
    $this->dtoc_resolve_meta_settings_name();   	                        
    ?>  
        <input name="<?php echo $this->_setting_name; ?>[remove_unused_css_js]" id="remove_unused_css_js" type="checkbox" value="1" <?php echo (isset($this->_setting_option['remove_unused_css_js']) && $this->_setting_option['remove_unused_css_js'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
public function dtoc_general_headings_include_cb(){
    $this->dtoc_resolve_meta_settings_name();
    ?>        
        <input name="<?php echo $this->_setting_name; ?>[headings_include][1]" id="headings_include_1" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][1]) && $this->_setting_option['headings_include'][1] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_1"><?php echo esc_html__('H1', 'digital-table-of-contents'); ?></label>
        <br>
        <input name="<?php echo $this->_setting_name; ?>[headings_include][2]" id="headings_include_2" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][2]) && $this->_setting_option['headings_include'][2] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_2"><?php echo esc_html__('H2', 'digital-table-of-contents'); ?></label>
        <br>
        <input name="<?php echo $this->_setting_name; ?>[headings_include][3]" id="headings_include_3" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][3]) && $this->_setting_option['headings_include'][3] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_3"><?php echo esc_html__('H3', 'digital-table-of-contents'); ?></label>
        <br>
        <input name="<?php echo $this->_setting_name; ?>[headings_include][4]" id="headings_include_4" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][4]) && $this->_setting_option['headings_include'][4] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_4"><?php echo esc_html__('H4', 'digital-table-of-contents'); ?></label>
        <br>
        <input name="<?php echo $this->_setting_name; ?>[headings_include][5]" id="headings_include_5" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][5]) && $this->_setting_option['headings_include'][5] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_5"><?php echo esc_html__('H5', 'digital-table-of-contents'); ?></label>
        <br>
        <input name="<?php echo $this->_setting_name; ?>[headings_include][6]" id="headings_include_6" type="checkbox" value="1" <?php echo (isset($this->_setting_option['headings_include'][6]) && $this->_setting_option['headings_include'][6] == 1 ? 'checked' : '' ) ?>>&nbsp;<label for="headings_include_6"><?php echo esc_html__('H6', 'digital-table-of-contents'); ?></label>

        <p class="description"><?php echo esc_html__('Select the headings to be added when the table of contents being created. Deselecting it will be excluded.', 'digital-table-of-contents'); ?></p>
                        
    <?php

}
public function dtoc_shortcode_source_cb(){

    echo '[digital_toc]';

}
public function dtoc_placement_setting_section_cb(){
            
    $result = dtoc_get_all_post_types();    

    if(!empty($result)){

        foreach ($result as $key => $value) {
            
            echo '<div>';
            echo '<div class="dtoc-accordion"><label class="dtoc-placement-checked" for=singular-'.esc_attr($key).'><input class="dtoc-placement-checked" id=singular-'.esc_attr($key).' type="checkbox" name="'.esc_attr($this->_setting_name).'[placement]['.esc_attr($key).'][is_enabled]" value="1" '.(isset($this->_setting_option["placement"][$key]["is_enabled"]) ? "checked": "").' />All ' . esc_html($value).'</label></div>';
            echo '<div class="dtoc-panel">';
            echo '<div class="dtoc-panel-body">';
                                
                $taxonomy_objects = get_object_taxonomies( $key, 'objects' );
                if(!empty($taxonomy_objects)){
                    $j = 1;
                    $terms_arr = [];
                    foreach ($taxonomy_objects as $tkey => $tvalue) {
                        $saved_term = false;
                        if(isset($this->_setting_option['placement'][$key]['taxonomy'][$tvalue->name]['ids'])){
                            $saved_term = true;
                            $terms = get_terms( array(
                                'taxonomy'   => sanitize_text_field($tvalue->name),
                                'hide_empty' => false,
                                'include'    =>  $this->_setting_option['placement'][$key]['taxonomy'][$tvalue->name]['ids']
                            ) );
                        }else{
                            $terms = get_terms( array(
                                'taxonomy'   => sanitize_text_field($tvalue->name),
                                'hide_empty' => false,
                                'number'     => 1                            
                            ) );    
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
                            echo '<h5>Belong to '.esc_html($tvalue->label).'</h5>';
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
                echo '<h5>Skip '.esc_html($value).'</h5>';  
                echo '</div>';
                echo '<div class="dtoc-acc-cont-s">';
                echo '<select multiple class="dtoc-placement-select2" data-ajax--url="'.admin_url( 'admin-ajax.php' ).'?skip_type='.esc_attr($key).'" name="'.esc_attr($this->_setting_name).'[placement]['.esc_attr($key).'][skip][]">';
                if(isset($this->_setting_option['placement'][$key]['skip'])){
                    $result = get_posts( array(
                        'post_type'       => $key,            
                        'post__in'        => $this->_setting_option['placement'][$key]['skip']                        
                    ) );    
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
public function dtoc_display_when_cb(){   
    $this->dtoc_resolve_meta_settings_name(); 	                
    ?>
        <input type="number" min="1" max="1000" id="display_when" name="<?php echo $this->_setting_name; ?>[display_when]" value="<?php echo (isset($this->_setting_option['display_when']) ? esc_attr($this->_setting_option['display_when']) : 1 ) ?>" />
        <p><?php echo esc_html__('Headings is greater or equal to above number.', 'digital-table-of-contents'); ?></p>		
    <?php
}
public function dtoc_display_position_cb(){ 
    $this->dtoc_resolve_meta_settings_name();     
    ?>    
	<select name="<?php echo $this->_setting_name; ?>[display_position]" id="display_position">
        <option value="before_first_heading" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'before_first_heading' ? 'selected' : '' ) ?>><?php echo esc_html__('Before First Heading', 'digital-table-of-contents'); ?></option>
        <option value="after_first_heading" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'after_first_heading' ? 'selected' : '' ) ?>><?php echo esc_html__('After First Heading', 'digital-table-of-contents'); ?></option>
        <option value="top_of_the_content" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'top_of_the_content' ? 'selected' : '' ) ?>><?php echo esc_html__('Top Of The Content', 'digital-table-of-contents'); ?></option>
        <option value="bottom_of_the_content" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'bottom_of_the_content' ? 'selected' : '' ) ?>><?php echo esc_html__('Bottom Of The Content', 'digital-table-of-contents'); ?></option>
        <option value="middle_of_the_content" <?php echo (isset($this->_setting_option['display_position']) && $this->_setting_option['display_position'] == 'middle_of_the_content' ? 'selected' : '' ) ?>><?php echo esc_html__('Middle Of The Content', 'digital-table-of-contents'); ?></option>
    </select>	
    <?php
}
public function dtoc_display_toggle_initial_cb(){
    $this->dtoc_resolve_meta_settings_name();	
    ?>    
	<select name="<?php echo $this->_setting_name; ?>[toggle_initial]" id="toggle_initial">
        <option value="show" <?php echo (isset($this->_setting_option['toggle_initial']) && $this->_setting_option['toggle_initial'] == 'show' ? 'selected' : '' ) ?>><?php echo esc_html__('Show', 'digital-table-of-contents'); ?></option>
        <option value="hide" <?php echo (isset($this->_setting_option['toggle_initial']) && $this->_setting_option['toggle_initial'] == 'hide' ? 'selected' : '' ) ?>><?php echo esc_html__('Hide', 'digital-table-of-contents'); ?></option>        
    </select>	
    <?php
}

public function dtoc_resolve_meta_settings_name(){
	$dtoc_meta_type = get_transient('dtoc_meta_type');
	if($dtoc_meta_type){
		$this->_setting_name = $dtoc_meta_type;
	}
}

}
if (class_exists('Digital_TOC_Settings')) {
	new Digital_TOC_Settings();
};