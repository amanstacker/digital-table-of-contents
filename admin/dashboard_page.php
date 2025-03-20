<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'dtoc_add_dashboard_menu_links');
function dtoc_add_dashboard_menu_links(){
    add_menu_page(
		__( 'Digital Table Of Contents', 'digital-table-of-contents' ),
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
    // add_submenu_page(
	// 	'dtoc',
	// 	'Digital Table Of Contents Help & Support',
    //     'Help & Support',
	// 	'manage_options',
	// 	'dtoc_support',
    //     'dtoc_compatibility_page_render'
	// );
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

    $tab = dtoc_admin_get_tab('modules', array('modules','tools', 'support'));
    ?>
    <div class="wrap dtoc-main-container">
    <h1 class="wp-heading-inline"><?php echo esc_html__('Digital Table Of Contents', 'digital-table-of-contents'); ?></h1>    
    <!-- setting form start here -->
    <div class="dtoc-dashboard-wrapper">
     
    <h2 class="nav-tab-wrapper dtoc-tabs">
					<?php					                        
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('modules', 'dtoc')) . '" class="nav-tab ' . esc_attr( $tab == 'modules' ? 'nav-tab-active' : '') . '"> ' . esc_html__('Modules','digital-table-of-contents') . '</a>';                                                
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('tools', 'dtoc')) . '" class="nav-tab ' . esc_attr( $tab == 'tools' ? 'nav-tab-active' : '') . '"> ' . esc_html__('Tools','digital-table-of-contents') . '</a>';
                        echo '<a href="' . esc_url(dtoc_admin_tab_link('support', 'dtoc')) . '" class="nav-tab ' . esc_attr( $tab == 'support' ? 'nav-tab-active' : '') . '"> ' . esc_html__('Support','digital-table-of-contents') . '</a>';                                                                        
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
                    do_settings_sections( 'dtoc_dashboard_tools_setting_section' );	
                echo "</div>";
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

    $modules = array(
        array(            
            'title' => 'Sticky',
            'desc'  => 'A Sticky TOC is a fixed navigation element that stays within a defined container, typically in the sidebar or at the top, while scrolling.',
            'name'  => 'sticky',
            'url'   => admin_url( 'admin.php?page=dtoc_sticky')
        ),
        array(            
            'title' => 'Floating',
            'desc'  => 'A Floating TOC is a movable, draggable, or collapsible navigation element that isn\'t fixed, allowing repositioning and enhanced interaction',
            'name'  => 'floating',
            'url'   => admin_url( 'admin.php?page=dtoc_floating')
        ),
        array(            
            'title' => 'Shortcode',
            'desc'  => 'TOC shortcode generates a structured list of headings for a specific post or page, allowing you to place it at a desired position within the content.',
            'name'  => 'shortcode',
            'url'   => admin_url( 'admin.php?page=dtoc_shortcode')
        ),
        array(            
            'title' => 'Compatibility',
            'desc'  => 'For Table of Contents plugin works smoothly with third-party plugins, maintaining functionality and formatting across different tools and environments.',
            'name'  => 'compatibility',
            'url'   => admin_url( 'admin.php?page=dtoc_compatibility')
        ),
        array(            
            'title' => 'In-Content Mobile',
            'desc'  => 'Enable for advanced, separate customization of the In-Content TOC in mobile. If disabled, the TOC will display by default based on the In-Content module.',
            'name'  => 'incontent_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_incontent_mobile')
        ),
        array(            
            'title' => 'In-Content Tablet',
            'desc'  => 'Enable for advanced, separate customization of the In-Content TOC in tablet. If disabled, the TOC will display by default based on the In-Content module.',
            'name'  => 'incontent_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_incontent_tablet')
        ),        
        array(            
            'title' => 'Sticky Mobile',
            'desc'  => 'Enable for advanced, separate customization of the Sticky TOC in mobile. If disabled, the TOC will display by default based on the Sticky module.',
            'name'  => 'sticky_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_sticky_mobile')
        ),
        array(            
            'title' => 'Sticky Tablet',
            'desc'  => 'Enable for advanced, separate customization of the Sticky TOC in tablet. If disabled, the TOC will display by default based on the Sticky module.',
            'name'  => 'sticky_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_sticky_tablet')
        ),        
        array(            
            'title' => 'Floating Mobile',
            'desc'  => 'Enable for advanced, separate customization of the Floating TOC in mobile. If disabled, the TOC will display by default based on the floating module.',
            'name'  => 'floating_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_floating_mobile')
        ),
        array(            
            'title' => 'Floating Tablet',
            'desc'  => 'Enable for advanced, separate customization of the Floating TOC in tablet. If disabled, the TOC will display by default based on the floating module.',
            'name'  => 'floating_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_floating_tablet')
        ),        
        array(            
            'title' => 'Shortcode Mobile',
            'desc'  => 'Enable for advanced, separate customization of the Shortcode in mobile. If disabled, the TOC will display by default based on the Shortcode module.',
            'name'  => 'shortcode_mobile',
            'url'   => admin_url( 'admin.php?page=dtoc_shortcode_mobile')
        ),
        array(            
            'title' => 'Shortcode Tablet',
            'desc'  => 'Enable for advanced, separate customization of the Shortcode in tablet. If disabled, the TOC will display by default based on the Shortcode module.',
            'name'  => 'shortcode_tablet',
            'url'   => admin_url( 'admin.php?page=dtoc_shortcode_tablet')
        )                
    );
    ?> <div class="dtoc-grid-container"> <?php
    foreach ($modules as $value) {
        ?>
            <div class="dtoc-grid-item">    
            <div class="dtoc-grid-header">
                <img class="dtoc-grid-image" src="<?php echo esc_url( DTOC_URL.'/assets/admin/images/'.$value['name'].'.svg' ); ?>">
                <h3><?php esc_html_e($value['title'], 'digital-table-of-contents'); ?></h3>
                <p><?php esc_html_e($value['desc'], 'digital-table-of-contents'); ?></p>
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

    register_setting( 'dtoc_dashboard_options_group', 'dtoc_dashboard_options' );
    // Modules
    
    add_settings_section('dtoc_dashboard_setting_section', __return_false(), '__return_false', 'dtoc_dashboard_setting_section');
                    
    add_settings_section( 'dtoc_dashboard_tools_setting_section', esc_html__( 'Import / Export', 'digital-table-of-contents' ), '__return_false', 'dtoc_dashboard_tools_setting_section' );
    add_settings_field(
        'dtoc_dashboard_export',
         esc_html__('Export Settings', 'digital-table-of-contents'),
        'dtoc_dashboard_export_cb',		
        'dtoc_dashboard_tools_setting_section',
        'dtoc_dashboard_tools_setting_section',
    );
	    add_settings_field(
        'dtoc_dashboard_import',
         esc_html__('Import Settings', 'digital-table-of-contents'),
        'dtoc_dashboard_import_cb',		
        'dtoc_dashboard_tools_setting_section',
        'dtoc_dashboard_tools_setting_section',
    );
    

}
function dtoc_dashboard_export_cb(){
    global $dtoc_dashboard;	
    ?>  
         <div class="wrap">
			
            <button type="button" name="export" class="button button-primary" id="dtoc-export-button"><?php echo esc_html__('Export Options', 'digital-table-of-contents'); ?></button>
			<div id="dtoc-export-loader" style="display: none;"><?php echo esc_html__('Loading...', 'digital-table-of-contents'); ?></div>
   
		</div>
    <?php
}

function dtoc_dashboard_import_cb() {
    ?>
    <div class="wrap">
    
        <div style="display: flex; align-items: center; gap: 10px; max-width: 600px;">
            <input type="file" name="import_file" id="dtoc-import-file" accept=".json" required 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            
            <button type="button" id="dtoc-import-button" class="button button-primary">
                <?php esc_html_e('Import Options', 'digital-table-of-contents'); ?>
            </button>
        </div>

        <div id="dtoc-import-loader" style="display: none; margin-top: 10px;">
            <span class="spinner is-active"></span>
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
        <h1 class="wp-heading-inline"><?php esc_html_e('Support Center: Get Help, Resources & Pro Features', 'digital-table-of-contents'); ?></h1>
        <p class="description"><?php esc_html_e('Need assistance? Submit a support request, explore helpful resources, or upgrade to Pro for premium features.', 'digital-table-of-contents'); ?></p>

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
                        <h2 class="hndle"><span><?php esc_html_e('Help & Resources', 'digital-table-of-contents'); ?></span></h2>
                        <div class="inside">
                            <ul>
                                <li><a href="#" target="_blank"><?php esc_html_e('Documentation', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('FAQs', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('Community Forum', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('Feature Requests', 'digital-table-of-contents'); ?></a></li>
                                <li><a href="#" target="_blank"><?php esc_html_e('Contact Support', 'digital-table-of-contents'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Right Column: Upgrade to Pro -->
                    <div class="dtoc-upgrade-to-pro postbox">
                        <h2 class="hndle"><span><?php esc_html_e('Upgrade to Pro: Unlock Premium Features', 'digital-table-of-contents'); ?></span></h2>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <?php
}
