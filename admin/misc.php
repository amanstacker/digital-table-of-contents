<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'plugin_action_links_' . DTOC_BASE_NAME, 'dtoc_plugin_action_links');

function dtoc_plugin_action_links( $actions ) {

     $url = add_query_arg( 'page', 'dtoc', self_admin_url( 'options-general.php' ) );
     $actions[]  = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'digital-table-of-contents' ) . '</a>';     
    return $actions;
}

add_action( 'admin_enqueue_scripts', 'dtoc_enqueue_admin_assets' );

function dtoc_enqueue_admin_assets( $hook ) {
    
    //if($hook != 'dtoc_incontent') return;        

        // Enqueue select2

        wp_enqueue_style( 'dtoc-admin-select2', DTOC_URL . 'assets/admin/select2/css/select2.min.css', false , DTOC_VERSION );
        wp_enqueue_script( 'dtoc-admin-select2', DTOC_URL . 'assets/admin/select2/js/select2.min.js', array('jquery'), DTOC_VERSION , true );

        wp_register_script( 'dtoc-ace', DTOC_URL . 'assets/admin/ace_editor/js/ace.js',false, DTOC_VERSION , true );
        wp_enqueue_script( 'dtoc-ace' );
         wp_register_script( 'dtoc-ace-tools', DTOC_URL . 'assets/admin/ace_editor/js/ext-language_tools.js',false, DTOC_VERSION , true );
        wp_enqueue_script( 'dtoc-ace-tools' );

        //Enqueue custom scripts
        global $dtoc_dashboard;        
        $data = array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'dtoc_ajax_nonce' => wp_create_nonce( "dtoc_ajax_nonce_string" ),
			'dtoc_modules_status' => $dtoc_dashboard['modules']
        );
                        
        $data = apply_filters('dtoc_localize_admin_assets_filter', $data, 'dtoc_admin_cdata');
        wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_media();
        wp_register_script( 'dtoc-admin', DTOC_URL . 'assets/admin/js/admin.js', array('jquery'), DTOC_VERSION , true );

                        
        wp_localize_script( 'dtoc-admin', 'dtoc_admin_cdata', $data );
        
        
        wp_enqueue_script( 'dtoc-admin' );
        wp_enqueue_style( 'dtoc-admin', DTOC_URL . 'assets/admin/css/admin.css', false , DTOC_VERSION );            

}   

function dtoc_categories_action_fn() {
    
	check_ajax_referer( 'dtoc_ajax_nonce_string', 'security' );
    
    $query = $type = $skip_type = '';
    $response = [];

    if(isset($_GET['q'])){
        $query = sanitize_text_field($_GET['q']);
    }    
    if(isset($_GET['type'])){
        $type = sanitize_text_field($_GET['type']);
    }
    if(isset($_GET['skip_type'])){
        $skip_type = sanitize_text_field($_GET['skip_type']);
    }
    if($skip_type){
        $result = get_posts( array(
            'post_type'       => $skip_type,            
            'numberposts'     => 10,
            'name__like'      => $query
        ) );    

        $posts_array = [];
        if (! is_wp_error( $result ) && ! empty( $result ) ) {
            foreach ($result as $value) {
                $posts_array[] = ['id' => $value->ID, 'text' => $value->post_title];
            }        
        }	    
        $response = ['results' => $posts_array];
        
    }
    if($type){

        $terms = get_terms( array(
            'taxonomy'   => $type,
            'hide_empty' => false,
            'number'     => 10,
            'name__like' => $query
        ) );    
        $terms_array = [];
        if (! is_wp_error( $terms ) && ! empty( $terms ) ) {
            foreach ($terms as $value) {
                $terms_array[] = ['id' => $value->term_id, 'text' => $value->name];
            }        
        }	    
        $response = ['results' => $terms_array];
    }
    

    echo wp_json_encode($response);

	die;
}
add_action( 'wp_ajax_dtoc_categories_action', 'dtoc_categories_action_fn' );



add_action( 'wp_ajax_dtoc_update_modules_status', 'dtoc_update_modules_status_fn' );

function dtoc_update_modules_status_fn(){
    global $dtoc_dashboard;
	$response = ['status' => false];
	check_ajax_referer( 'dtoc_ajax_nonce_string', 'security' );
	if(current_user_can('manage_options')){
			$module = '';
			$status = true;
		
			if(isset($_POST['module'])){
				$module = sanitize_text_field($_POST['module']);
			}    
			if(isset($_POST['status'])){
				$status = rest_sanitize_boolean($_POST['status']);
			}						
			if(isset($dtoc_dashboard['modules'][$module])){
				if($dtoc_dashboard['modules'][$module] != $status)
				{	
					$dtoc_dashboard['modules'][$module] = $status;                    
					update_option('dtoc_dashboard',$dtoc_dashboard,false);
					$response = ['status' => 'success'];
					
				}else{
					$response = ['status' => 'success'];
				}
			}
	}
	
	wp_send_json($response);
}

function dtoc_ace_editor_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'theme' => 'monokai', // default theme
        'mode' => 'javascript', // default mode
        'height' => '500px', // default height
        'class' => 'ace-editor', // default class for editors
    ), $atts, 'ace_editor');

    // Output the HTML for the editor
    ob_start(); ?>
    <div class="<?php echo esc_attr($atts['class']); ?>" style="width: 100%; height: <?php echo esc_attr($atts['height']); ?>;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editors = document.querySelectorAll('.<?php echo esc_attr($atts['class']); ?>');
            editors.forEach(function(editorElement) {
                var editor = ace.edit(editorElement);
                editor.setTheme("ace/theme/<?php echo esc_attr($atts['theme']); ?>");
                editor.session.setMode("ace/mode/<?php echo esc_attr($atts['mode']); ?>");
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
//add_shortcode('dtoc_ace_editor', 'dtoc_ace_editor_shortcode');

add_action('wp_ajax_dtoc_import_options', 'dtoc_import_options_ajax');

function dtoc_import_options_ajax() {

    if (!current_user_can('manage_options')) {
        wp_send_json_error(__('You do not have sufficient permissions to perform this action.'));
        wp_die();
    }

 
    check_ajax_referer('dtoc_ajax_nonce_string', 'nonce');

    // Check if a file was uploaded
    if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['import_file'];

        // Check if the file is a JSON file
        if (pathinfo($file['name'], PATHINFO_EXTENSION) !== 'json') {
            wp_send_json_error(__('Uploaded file is not a valid JSON file.'));
            wp_die();
        }

        // Read the file content
        $json_data = file_get_contents($file['tmp_name']);
        $options = json_decode($json_data, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            // Update options only if the keys exist in the imported data
            if (isset($options['dashboard'])) {
                update_option('dtoc_dashboard', $options['dashboard']);
            }
            if (isset($options['incontent'])) {
                update_option('dtoc_incontent', $options['incontent']);
            }
            if (isset($options['incontent_mobile'])) {
                update_option('dtoc_incontent_mobile', $options['incontent_mobile']);
            }
            if (isset($options['incontent_tablet'])) {
                update_option('dtoc_incontent_tablet', $options['incontent_tablet']);
            }
            if (isset($options['shortcode'])) {
                update_option('dtoc_shortcode', $options['shortcode']);
            }
            if (isset($options['shortcode_mobile'])) {
                update_option('dtoc_shortcode_mobile', $options['shortcode_mobile']);
            }
            if (isset($options['shortcode_tablet'])) {
                update_option('dtoc_shortcode_tablet', $options['shortcode_tablet']);
            }
            if (isset($options['sticky'])) {
                update_option('dtoc_sticky', $options['sticky']);
            }
            if (isset($options['sticky_mobile'])) {
                update_option('dtoc_sticky_mobile', $options['sticky_mobile']);
            }
            if (isset($options['sticky_tablet'])) {
                update_option('dtoc_sticky_tablet', $options['sticky_tablet']);
            }
            if (isset($options['floating'])) {
                update_option('dtoc_floating', $options['floating']);
            }
            if (isset($options['floating_mobile'])) {
                update_option('dtoc_floating_mobile', $options['floating_mobile']);
            }
            if (isset($options['floating_tablet'])) {
                update_option('dtoc_floating_tablet', $options['floating_tablet']);
            }
            if (isset($options['compatibility'])) {
                update_option('dtoc_compatibility', $options['compatibility']);
            }

            wp_send_json_success(__('Settings imported successfully.'));
        } else {
            wp_send_json_error(__('Failed to import settings. Invalid JSON.'));
        }
    } else {
        wp_send_json_error(__('No file uploaded or an error occurred during upload.'));
    }
}

add_action('wp_ajax_dtoc_export_options', 'dtoc_export_options_ajax');

function dtoc_export_options_ajax() {
  
    if (!current_user_can('manage_options')) {
        wp_send_json_error(__('You do not have sufficient permissions to perform this action.'));
        wp_die();
    }

    // Check the nonce
    check_ajax_referer('dtoc_ajax_nonce_string', 'nonce');


    $options = [
        'dashboard' => get_option('dtoc_dashboard'),
        'incontent' => get_option('dtoc_incontent'),
        'incontent_mobile' => get_option('dtoc_incontent_mobile'),
        'incontent_tablet' => get_option('dtoc_incontent_tablet'),
        'shortcode' => get_option('dtoc_shortcode'),
        'shortcode_mobile' => get_option('dtoc_shortcode_mobile'),
        'shortcode_tablet' => get_option('dtoc_shortcode_tablet'),
        'sticky' => get_option('dtoc_sticky'),
        'sticky_mobile' => get_option('dtoc_sticky_mobile'),
        'sticky_tablet' => get_option('dtoc_sticky_tablet'),
        'floating' => get_option('dtoc_floating'),
        'floating_mobile' => get_option('dtoc_floating_mobile'),
        'floating_tablet' => get_option('dtoc_floating_tablet'),
        'compatibility' => get_option('dtoc_compatibility')
    ];

    wp_send_json_success($options);
}

function dtoc_handle_support_request() {
	// Verify nonce for security
	check_ajax_referer( 'dtoc_ajax_nonce_string', 'security' );

	// Sanitize input data
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	// Check for empty fields
	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		wp_send_json_error( __( 'All fields are required.', 'digital-table-of-contents' ) );
	}

	// Process the support request (e.g., send an email)
	
	$subject     = __( 'New Support Request', 'digital-table-of-contents' );
	$headers     = array( 'Content-Type: text/html; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>' );

	$body = sprintf(
		__( 'Name: %s <br>Email: %s <br>Message: %s', 'digital-table-of-contents' ),
		esc_html( $name ),
		esc_html( $email ),
		nl2br( esc_html( $message ) )
	);

	$mail_sent = wp_mail( $email, $subject, $body, $headers );

	if ( $mail_sent ) {
		wp_send_json_success( __( 'Your support request has been submitted successfully.', 'digital-table-of-contents' ) );
	} else {
		wp_send_json_error( __( 'Something went wrong. Please try again.', 'digital-table-of-contents' ) );
	}
}

// Register AJAX actions for both logged-in and non-logged-in users
add_action( 'wp_ajax_dtoc_submit_support', 'dtoc_handle_support_request' );
add_action( 'wp_ajax_nopriv_dtoc_submit_support', 'dtoc_handle_support_request' );

add_action('wp_ajax_dtoc_reset_options', 'dtoc_reset_options_cb');

function dtoc_reset_options_cb() {

    check_ajax_referer( 'dtoc_ajax_nonce_string', 'security' );
    
    if (!current_user_can('manage_options')) {
        wp_send_json_success(['message' => esc_html__('You do not have sufficient permissions to perform this action.', 'digital-table-of-contents')]);        
        wp_die();
    }

    delete_option('dtoc_dashboard');
    delete_option('dtoc_incontent');
    delete_option('dtoc_incontent_mobile');
    delete_option('dtoc_incontent_tablet');
    delete_option('dtoc_shortcode');
    delete_option('dtoc_shortcode_mobile');
    delete_option('dtoc_shortcode_tablet');
    delete_option('dtoc_sticky');
    delete_option('dtoc_sticky_mobile');
    delete_option('dtoc_sticky_tablet');
    delete_option('dtoc_floating');
    delete_option('dtoc_floating_mobile');
    delete_option('dtoc_floating_tablet');
    delete_option('dtoc_compatibility');    

    wp_send_json_success(['message' => esc_html__('Options have been reset successfully.', 'digital-table-of-contents')]);

}
