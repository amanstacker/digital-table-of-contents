<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'dtoc_add_dashboard_menu_links' );

function dtoc_add_dashboard_menu_links() {

    add_menu_page(
		__( 'Digital Table of Contents', 'digital-table-of-contents' ),
		'Digital TOC',
		'manage_options',
		'dtoc',
		'dtoc_dashboard_page_render',
		'dashicons-index-card',
		70
	);
    add_submenu_page(
		'dtoc',
		'Dashboard',
        'Dashboard',
		'manage_options',
		'dtoc',
        'dtoc_dashboard_page_render',				
	);    
}


function dtoc_dashboard_page_render(){

    // Authentication
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
    // Handing save settings
	if ( isset( $_GET['settings-updated'] ) ) {
		settings_errors();               
	}

    $tab = dtoc_admin_get_tab( 'modules', array( 'modules','tools', 'compatibility', 'support' ) );
    ?>
    <div class="wrap dtoc-main-container">
    <h1 class="wp-heading-inline"><?php echo esc_html__('Digital Table of Contents', 'digital-table-of-contents'); ?></h1>    
    <!-- setting form start here -->
    <div class="dtoc-dashboard-wrapper">
     
    <h2 class="nav-tab-wrapper dtoc-tabs">
					<?php					                        
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('modules', 'dtoc')) . '" class="nav-tab ' . esc_attr( $tab == 'modules' ? 'nav-tab-active' : '') . '"> ' . esc_html__('Modules','digital-table-of-contents') . '</a>';                                                
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('tools', 'dtoc')) . '" class="nav-tab ' . esc_attr( $tab == 'tools' ? 'nav-tab-active' : '') . '"> ' . esc_html__('Tools','digital-table-of-contents') . '</a>';
                        // echo '<a href="' . esc_url(dtoc_admin_tab_link('compatibility', 'dtoc')) . '" class="nav-tab ' . esc_attr( $tab == 'compatibility' ? 'nav-tab-active' : '') . '"> ' . esc_html__('Compatibility','digital-table-of-contents') . '</a>';
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('support', 'dtoc')) . '" class="nav-tab ' . esc_attr( $tab == 'support' ? 'nav-tab-active' : '') . '"> ' . esc_html__('Support Center','digital-table-of-contents') . '</a>';                                                                        
					?>
				</h2>
    <form action="options.php" method="post" enctype="multipart/form-data" class="dtoc-settings-form">
			<div class="dtoc-settings-form-wrap">
			<?php
                settings_fields( 'dtoc_dashboard_options_group' );	                
                //Digital tab
                echo "<div class='dtoc-modules' ".( $tab != 'modules' ? 'style="display:none;"' : '').">"; 
                    dtoc_dashboard_modules();                                                  
                echo "</div>";                 
                //Tools tab
                echo "<div class='dtoc-tools' ".( $tab != 'tools' ? 'style="display:none;"' : '').">";
                    do_settings_sections( 'dtoc_dashboard_tools_setting_section_hook' );	
                echo "</div>";
                //Compatibility tab
                // echo "<div class='dtoc-compatibility' ".( $tab != 'compatibility' ? 'style="display:none;"' : '').">";
                //     do_settings_sections( 'dtoc_dashboard_compatibility_setting_section_hook' );	
                // echo "</div>";
                //Support tab
                echo "<div class='dtoc-support' ".( $tab != 'support' ? 'style="display:none;"' : '').">";                
                    dtoc_dashboard_support();   
                echo "</div>";                
			?>
		</div>

			<div class="button-wrapper">                                                                
                <?php submit_button( esc_html__('Save Settings', 'digital-table-of-contents') ); ?>                                
			</div>  
            
		</form>
    </div>
    <!-- setting form ends here -->
    </div>
    <?php

}

function dtoc_dashboard_modules(){

	global $dtoc_dashboard;

    $modules = [
        [            
            'title' => 'In-Content',
            'desc'  => 'This is default module. Displays a dynamic Table of Contents directly within your post content, helping readers navigate long articles with ease. Automatically generated based on headings',
            'name'  => 'incontent',
            'url'   => admin_url( 'admin.php?page=dtoc_incontent'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],
        [
            'title' => 'Shortcode',
            'desc'  => 'TOC shortcode generates a structured list of headings for a specific post or page, allowing you to place it at a desired position within the content.',
            'name'  => 'shortcode',
            'url'   => admin_url( 'admin.php?page=dtoc_shortcode'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],        
        [
            'title' => 'Sticky',
            'desc'  => 'A Sticky TOC is a fixed navigation element that stays within a defined container, typically in the sidebar or at the top, while scrolling.',
            'name'  => 'sticky',
            'url'   => admin_url( 'admin.php?page=dtoc_sticky'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],
        [
            'title' => 'Floating',
            'desc'  => 'A Floating TOC is a movable, draggable, or collapsible navigation element that isn\'t fixed, allowing repositioning and enhanced interaction',
            'name'  => 'floating',
            'url'   => admin_url( 'admin.php?page=dtoc_floating'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],        
        [            
            'title' => 'In-Content Mobile',
            'desc'  => 'Enable for advanced, separate customization of the In-Content TOC in mobile. If disabled, the TOC will display by default based on the In-Content module.',
            'name'  => 'incontent_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_incontent_mobile'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],
        [
            'title' => 'In-Content Tablet',
            'desc'  => 'Enable for advanced, separate customization of the In-Content TOC in tablet. If disabled, the TOC will display by default based on the In-Content module.',
            'name'  => 'incontent_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_incontent_tablet'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],        
        [            
            'title' => 'Sticky Mobile',
            'desc'  => 'Enable for advanced, separate customization of the Sticky TOC in mobile. If disabled, the TOC will display by default based on the Sticky module.',
            'name'  => 'sticky_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_sticky_mobile'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],
        [
            'title' => 'Sticky Tablet',
            'desc'  => 'Enable for advanced, separate customization of the Sticky TOC in tablet. If disabled, the TOC will display by default based on the Sticky module.',
            'name'  => 'sticky_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_sticky_tablet'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],        
        [
            'title' => 'Floating Mobile',
            'desc'  => 'Enable for advanced, separate customization of the Floating TOC in mobile. If disabled, the TOC will display by default based on the floating module.',
            'name'  => 'floating_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_floating_mobile'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],
        [           
            'title' => 'Floating Tablet',
            'desc'  => 'Enable for advanced, separate customization of the Floating TOC in tablet. If disabled, the TOC will display by default based on the floating module.',
            'name'  => 'floating_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_floating_tablet'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],        
        [
            'title' => 'Shortcode Mobile',
            'desc'  => 'Enable for advanced, separate customization of the Shortcode in mobile. If disabled, the TOC will display by default based on the Shortcode module.',
            'name'  => 'shortcode_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_shortcode_mobile'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ],
        [
            'title' => 'Shortcode Tablet',
            'desc'  => 'Enable for advanced, separate customization of the Shortcode in tablet. If disabled, the TOC will display by default based on the Shortcode module.',
            'name'  => 'shortcode_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_shortcode_tablet'),
            'learn' => 'https://digitaltableofcontents/documentation'
        ]                
    ];
    ?> 
        <div class="dtoc-grid-container"> 
    <?php

    foreach ( $modules as $value ) {
        ?>
            <div class="dtoc-grid-item">    
            <div class="dtoc-grid-header">                
                <h3><?php esc_html_e($value['title'], 'digital-table-of-contents'); ?></h3>
                <p><?php esc_html_e($value['desc'], 'digital-table-of-contents'); ?> 
                <!-- <a href="<?php echo esc_url( $value['learn'] );  ?>">Learn More</a> -->
            </p>
            </div>
            <hr>
            <div class="dtoc-grid-footer">
            <div class="dtoc-switch-block">
            <div class="dtoc-loader"></div>
            <label class="dtoc-switch">
                <input type="checkbox" class="dtoc-grid-checkbox" name="<?php echo esc_attr($value['name']) ?>" <?php if($dtoc_dashboard['modules'][$value['name']] == true){ echo 'checked';}?> >
                <span class="dtoc-slider"></span>
            </label>
            </div>
            <a class="button dtoc-grid-settings" <?php if($dtoc_dashboard['modules'][$value['name']] == true){ echo 'style="display:block"';}?> href="<?php echo esc_url($value['url']); ?>"><?php esc_html_e('Settings', 'digital-table-of-contents'); ?></a>
            </div>
        </div>
        <?php      
    }    
    ?>
    </div>
    <?php
}

add_action('admin_init', 'dtoc_dashboard_settings_initiate');

function dtoc_dashboard_settings_initiate(){
    // need sanitization of registered option
    register_setting( 'dtoc_dashboard_options_group', 'dtoc_dashboard_options', 'dtoc_sanitize_register_setting' );
                                
    add_settings_section( 'dtoc_dashboard_tools_import_export_section', esc_html__( 'Import / Export', 'digital-table-of-contents' ), '__return_false', 'dtoc_dashboard_tools_setting_section_hook' );
        add_settings_field(
            'dtoc_dashboard_export',
            esc_html__('Export Settings', 'digital-table-of-contents'),
            'dtoc_dashboard_export_cb',		
            'dtoc_dashboard_tools_setting_section_hook',
            'dtoc_dashboard_tools_import_export_section',
        );
	    add_settings_field(
        'dtoc_dashboard_import',
         esc_html__('Import Settings', 'digital-table-of-contents'),
        'dtoc_dashboard_import_cb',		
        'dtoc_dashboard_tools_setting_section_hook',
        'dtoc_dashboard_tools_import_export_section',
    );

    add_settings_section( 'dtoc_dashboard_tools_delete_reset_section', esc_html__( 'Delete Plugin Data & Reset', 'digital-table-of-contents' ), '__return_false', 'dtoc_dashboard_tools_setting_section_hook' );
        add_settings_field(
            'dtoc_dashboard_export',
            esc_html__('Delete Data', 'digital-table-of-contents'),
            'dtoc_dashboard_delete_cb',		
            'dtoc_dashboard_tools_setting_section_hook',
            'dtoc_dashboard_tools_delete_reset_section',
        );
	    add_settings_field(
        'dtoc_dashboard_import',
         esc_html__('Reset Data', 'digital-table-of-contents'),
        'dtoc_dashboard_reset_cb',		
        'dtoc_dashboard_tools_setting_section_hook',
        'dtoc_dashboard_tools_delete_reset_section',
        );
    

}
function dtoc_dashboard_export_cb(){
    global $dtoc_dashboard;	
    ?>  
         <div class="wrap">			
            <button type="button" name="export" class="button button-primary" id="dtoc-export-button"><?php echo esc_html__('Export Options', 'digital-table-of-contents'); ?></button>
			<div id="dtoc-export-loader" style="display: none;"><?php echo esc_html__('Loading...', 'digital-table-of-contents'); ?></div>   
            <?php 
                // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'header_icon'); 
            ?>
		</div>
    <?php    
}
function dtoc_dashboard_reset_cb(){    
    ?>  
    <div class="wrap">                        
        <input type="text" id="dtoc-reset-input" placeholder="Type 'reset' here">
        <button type="button" id="dtoc-reset-button" class="button button-secondary" disabled>
            <?php echo esc_html__('Reset Options', 'digital-table-of-contents'); ?>
        </button>
        <?php 
	        // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'dtoc-reset-input'); 
        ?>
        <p><?php echo esc_html__('Type "reset" in the box above to enable the reset button.', 'digital-table-of-contents'); ?></p>
        <div id="dtoc-reset-message"></div>
    </div>
    <?php
}
function dtoc_dashboard_delete_cb(){    
    global $dtoc_dashboard;	
    ?>              
        <input type="checkbox" id="delete_plugin_data" name="dtoc_dashboard[delete_plugin_data]" value="1" <?php checked(1, $dtoc_dashboard['delete_plugin_data']); ?> />                        
    <?php
    // dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'delete_plugin_data'); 
}


function dtoc_dashboard_import_cb() {
    ?>
    <div class="wrap">
    
        <div style="display: flex; align-items: center; gap: 10px; max-width: 600px;">
            <input type="file" name="import_file" id="dtoc-import-file" accept=".json" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            
            <button type="button" id="dtoc-import-button" class="button button-primary">
                <?php esc_html_e('Import Options', 'digital-table-of-contents'); ?>
            </button>
            <?php 
            	// dtoc_tooltip(__('tex1t', 'digital-table-of-contents'), 'dtoc-import-file'); 
            ?>
        </div>

        <div id="dtoc-import-loader" style="display: none; margin-top: 10px;">            
            <p style="margin-top: 5px; color: #555;"><?php esc_html_e('Uploading...', 'digital-table-of-contents'); ?></p>
        </div>
            
        <div id="dtoc-import-message" style="margin-top: 15px; font-weight: bold;"></div>

    </div>
    <?php
}

function dtoc_dashboard_support() {
    global $dtoc_dashboard; 
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php
            //  esc_html_e('Support Center: Get Help, Resources & Pro Features', 'digital-table-of-contents');
            esc_html_e('Support Center: Get Help, Resources', 'digital-table-of-contents');
              ?>
        </h1>
        <p class="description"><?php 
            // esc_html_e('Need assistance? Submit a support request, explore helpful resources, or upgrade to Pro for premium features.', 'digital-table-of-contents');
            esc_html_e('Need assistance? Submit a support request, explore helpful resources.', 'digital-table-of-contents');
         ?></p>

        <div class="metabox-holder">
            <div class="meta-box-sortables">
                <div class="dtoc-support-container">
                    
                    <!-- Left Side: Support Form -->
                    <div class="dtoc-support-form postbox">
                        <h2 class="hndle"><span><?php esc_html_e('Submit a Support Request', 'digital-table-of-contents'); ?></span></h2>
                        <div class="inside">
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="dtoc_support_name"><?php esc_html_e('Name', 'digital-table-of-contents'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" id="dtoc_support_name" class="regular-text" placeholder="<?php esc_attr_e('Enter your name', 'digital-table-of-contents'); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="dtoc_support_email"><?php esc_html_e('Email', 'digital-table-of-contents'); ?></label>
                                    </th>
                                    <td>
                                        <input type="email" id="dtoc_support_email" class="regular-text" placeholder="<?php esc_attr_e('Enter your email', 'digital-table-of-contents'); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="dtoc_support_message"><?php esc_html_e('Message', 'digital-table-of-contents'); ?></label>
                                    </th>
                                    <td>
                                        <textarea id="dtoc_support_message" class="large-text code" rows="5" placeholder="<?php esc_attr_e('Describe your issue', 'digital-table-of-contents'); ?>"></textarea>
                                    </td>
                                </tr>
                            </table>

                            <p class="submit">
                                <button id="dtoc_support_submit" class="button button-primary"><?php esc_html_e('Submit Support Request', 'digital-table-of-contents'); ?></button>
                            </p>

                            <div id="dtoc_support_response"></div>
                        </div>
                    </div>

                    <!-- Middle Column: Support Links -->
                    <div class="dtoc-support-resources postbox">
                        <h2 class="hndle"><span><?php esc_html_e('Coming Soon', 'digital-table-of-contents'); ?></span></h2>
                        <!-- <h2 class="hndle"><span><?php esc_html_e('Help & Resources', 'digital-table-of-contents'); ?></span></h2>
                        <div class="inside">
                            <ul>
                                <li><a href="#" target="_blank"><?php esc_html_e('Documentation', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('FAQs', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('Community Forum', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('Feature Requests', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('Contact Support', 'digital-table-of-contents'); ?></a></li>
                            </ul>
                        </div> -->
                    </div>
                    
                    <!-- Right Column: Upgrade to Pro -->
                    <div class="dtoc-upgrade-to-pro postbox">
                        <h2 class="hndle"><span><?php esc_html_e('Coming Soon', 'digital-table-of-contents'); ?></span></h2>
                        <!-- <h2 class="hndle"><span><?php esc_html_e('Upgrade to Pro: Unlock Premium Features', 'digital-table-of-contents'); ?></span></h2>
                        <div class="inside">
                            <p><?php esc_html_e('Get access to exclusive premium features and priority support.', 'digital-table-of-contents'); ?></p>
                            <ul>
                                <li><?php esc_html_e('Advanced customization options', 'digital-table-of-contents'); ?></li>
                                <li><?php esc_html_e('Premium support', 'digital-table-of-contents'); ?></li>
                                <li><?php esc_html_e('Extra integrations', 'digital-table-of-contents'); ?></li>
                            </ul>
                            <p>
                                <a href="#" class="button button-primary"><?php esc_html_e('Upgrade Now', 'digital-table-of-contents'); ?></a>
                            </p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <?php
}
