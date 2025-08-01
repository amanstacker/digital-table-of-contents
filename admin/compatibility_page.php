<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
//add_action( 'admin_menu', 'dtoc_add_compatibility_menu_links');
function dtoc_add_compatibility_menu_links(){
    add_submenu_page(
		'dtoc',
		'Digital Table of Contents Compatibility',
        'Compatibility',
		'manage_options',
		'dtoc_compatibility',
        'dtoc_compatibility_page_render'
	);
}


function dtoc_compatibility_page_render(){

    // Authentication
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
    // Handing save settings
	if ( isset( $_GET['settings-updated'] ) ) {
		settings_errors();               
	}

    $tab = dtoc_admin_get_tab('plugins', [ 'plugins','themes' ]);
    ?>
    <div class="wrap dtoc-main-container">
    <h1 class="wp-heading-inline"><?php echo esc_html__('Digital Table of Contents | Compatibility', 'digital-table-of-contents'); ?></h1>    
    <!-- setting form start here -->
    <div class="dtoc-main-wrapper">
    <div class="dtoc-form-options">
    <h2 class="nav-tab-wrapper dtoc-tabs">
					<?php					
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('plugins', 'dtoc_compatibility')) . '" class="nav-tab ' . esc_attr( $tab == 'plugins' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-welcome-view-site"></span> ' . esc_html__('Plugins','digital-table-of-contents') . '</a>';
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('themes', 'dtoc_compatibility')) . '" class="nav-tab ' . esc_attr( $tab == 'themes' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-admin-generic"></span> ' . esc_html__('Themes','digital-table-of-contents') . '</a>';
					?>
				</h2>
    <form action="options.php" method="post" enctype="multipart/form-data" class="dtoc-settings-form">
			<div class="dtoc-settings-form-wrap">
			<?php
                settings_fields( 'dtoc_compatibility_options_group' );	
                //General tab
                echo "<div class='dtoc-plugins' ".( $tab != 'plugins' ? 'style="display:none;"' : '').">";                
                    do_settings_sections( 'dtoc_compatibility_plugins_setting_section' );	
                echo "</div>";
                //Display tab
                echo "<div class='dtoc-themes' ".( $tab != 'themes' ? 'style="display:none;"' : '').">";                
                    do_settings_sections( 'dtoc_compatibility_themes_setting_section' );	
                echo "</div>";                 
			?>
		</div>

			<div class="button-wrapper">                                                                
                <?php submit_button( esc_html__('Save Settings', 'digital-table-of-contents') ); ?>                                
			</div>              
		</form>
    </div>
    <div class="dtoc-preview-wrapper">
        <!-- Upgrad to Premium starts here -->        
        <h2 class="dtoc-preview-heading">Upgrad to Premium</h2>
        <!-- Upgrade to premium ends here -->
    </div>    
    </div>
    <!-- setting form ends here -->
    </div>
    <?php

}

//add_action('admin_init', 'dtoc_compatibility_tablet_settings_initiate');

function dtoc_compatibility_tablet_settings_initiate(){

    register_setting( 'dtoc_compatibility_options_group', 'dtoc_compatibility' );
    // general
    add_settings_section('dtoc_compatibility_plugins_setting_section', __return_false(), '__return_false', 'dtoc_compatibility_plugins_setting_section');
        
    add_settings_field(
        'dtoc_compatibility_plugins_elementor',
         esc_html__('Elementor', 'digital-table-of-contents'),
        'dtoc_compatibility_plugins_elementor_cb',		
        'dtoc_compatibility_plugins_setting_section',
        'dtoc_compatibility_plugins_setting_section',
        [ 'label_for' => 'elementor' ]
    );    

    add_settings_section('dtoc_compatibility_themes_setting_section', __return_false(), '__return_false', 'dtoc_compatibility_themes_setting_section');
        
    add_settings_field(
        'dtoc_compatibility_themes_divi',
         esc_html__('Divi', 'digital-table-of-contents'),
        'dtoc_compatibility_themes_divi_cb',		
        'dtoc_compatibility_themes_setting_section',
        'dtoc_compatibility_themes_setting_section',
        [ 'label_for' => 'divi' ]
    );                        

}
function dtoc_compatibility_plugins_elementor_cb(){
    global $dtoc_compatibility;	                        
    ?>  
        <input name="dtoc_compatibility[plugins][elementor]" id="elementor" type="checkbox" value="1" <?php echo (isset($dtoc_compatibility['plugins']['elementor']) && $dtoc_compatibility['plugins']['elementor'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
function dtoc_compatibility_themes_divi_cb(){
    global $dtoc_compatibility;
    ?>  
        <input name="dtoc_compatibility[themes][divi]" id="divi" type="checkbox" value="1" <?php echo (isset($dtoc_compatibility['themes']['divi']) && $dtoc_compatibility['themes']['divi'] == 1 ? 'checked' : '' ) ?>>
    <?php
}
