<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

function dtoc_is_plugins_page() {

    if ( function_exists( 'get_current_screen' ) ) {

        $screen = get_current_screen();

            if ( is_object( $screen ) ) {

                if ( $screen->id == 'plugins' || $screen->id == 'plugins-network' ) {
                    return true;
                }

            }
    }

    return false;
}

add_filter( 'admin_footer', 'dtoc_deactivation_feedback_modal' );

function dtoc_deactivation_feedback_modal() {

    if ( is_admin() && dtoc_is_plugins_page() ) {

        $email = '';

        if ( function_exists( 'wp_get_current_user' ) ) {

            $current_user = wp_get_current_user();

            if ( $current_user instanceof WP_User ) {
                $email = trim( $current_user->user_email );	
            }

        }
        
        ?>

<div id="dtoc-feedback-overlay" style="display: none;">
	
    <div id="dtoc-feedback-content">
		<div class="dtoc-dp-header">
            <h3><?php esc_html_e('Deactivating Digital Table Of Contents ', 'digital-table-of-contents') ?></h3>
            <button class="close dashicons dashicons-no dtoc-fd-stop-deactivation">
                <span class="screen-reader-text"></span>
            </button>
        </div>
    	<form action="" method="post">
		<div class="dtoc-dp-body">
	    <p><strong><?php esc_html_e('Help us improve — why are you deactivating the plugin?', 'digital-table-of-contents'); ?></strong></p>
        <ul class="dtoc-dp-reasons">
            <li>
                <input type="radio" id="dtoc-reason1" name="dtoc_disable_reason" value="temporary" />
                <label for="dtoc-reason1"><?php esc_html_e('The deactivation is temporary', 'digital-table-of-contents') ?></label>
            </li>
            <li>
                <input type="radio" id="dtoc-reason2" name="dtoc_disable_reason" value="stopped_using" />
                <label for="dtoc-reason2"><?php esc_html_e('No longer using schema markup', 'digital-table-of-contents') ?></label>
            </li>
            <li>
                <input type="radio" id="dtoc-reason3" name="dtoc_disable_reason" value="missing_feature" />
                <label for="dtoc-reason3"><?php esc_html_e('Needed feature not available', 'digital-table-of-contents') ?></label>
            </li>
            <li>
                <input type="radio" id="dtoc-reason4" name="dtoc_disable_reason" value="technical_difficulties" />
                <label for="dtoc-reason4"><?php esc_html_e('Facing Technical Difficulties', 'digital-table-of-contents') ?></label>
            </li>
            <li>
                <input type="radio" id="dtoc-reason5" name="dtoc_disable_reason" value="switched_plugin" />
                <label for="dtoc-reason5"><?php esc_html_e('Switched to a different plugin', 'digital-table-of-contents') ?></label>
            </li>
            <li>
                <input type="radio" id="dtoc-reason6" name="dtoc_disable_reason" value="other_reason" />
                <label for="dtoc-reason6"><?php esc_html_e('Other reason', 'digital-table-of-contents') ?></label>
            </li>
        </ul>
	    <div class="dtoc-reason-details">
				<textarea data-id="dtoc-reason3" class="dtoc-d-none" rows="3" name="dtoc_missing_feature_text" placeholder="<?php esc_attr_e( 'Kindly describe the feature you found missing.', 'digital-table-of-contents' ); ?>"></textarea>
                <textarea data-id="dtoc-reason4" class="dtoc-d-none" rows="3" name="dtoc_technical_difficulties_text" placeholder="<?php esc_attr_e( 'Kindly provide details about the difficulties you\'re facing.', 'digital-table-of-contents' ); ?>"></textarea>
                <textarea data-id="dtoc-reason5" class="dtoc-d-none" rows="3" name="dtoc_switched_plugin_text" placeholder="<?php esc_attr_e( 'If you don\'t mind, name the plugin you switched to.', 'digital-table-of-contents' ); ?>"></textarea>
                <textarea data-id="dtoc-reason6" class="dtoc-d-none" rows="3" name="dtoc_other_reason_text" placeholder="<?php esc_attr_e( 'Kindly provide a brief explanation.', 'digital-table-of-contents' ); ?>"></textarea>
		</div>
		</div>
		<hr/>
		<div class="dtoc-dp-footer">
			<?php if( null !== $email && !empty( $email ) ) : ?>
    	    	<input type="hidden" name="dtoc_deactivated_from" value="<?php echo esc_attr($email); ?>" />
	    	<?php endif; ?>

			<input id="dtoc-feedback-submit" class="button button-primary" type="submit" name="dtoc_disable_submit" value="<?php esc_html_e('Submit & Deactivate', 'digital-table-of-contents'); ?>"/>
	    	<a class="button dtoc-only-deactivate"><?php esc_html_e('Skip & Deactivate', 'digital-table-of-contents'); ?></a>
	    	<a class="button dtoc-dt-de dtoc-fd-stop-deactivation"><?php esc_html_e('Don\'t Deactivate', 'digital-table-of-contents'); ?></a>
		</div>	    
	</form>
    </div>
</div>
<?php
        

    }
    
}


function dtoc_send_feedback() {

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die();
    }

        //phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason : Since form is serialised nonce is verified after parsing the recieved data.
    if ( isset( $_POST['data'] ) ) {
        //phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason : Since form is serialised nonce is verified after parsing the recieved data.
        parse_str( $_POST['data'], $form );
    }
    
    if ( ! isset( $form['dtoc_security_nonce'] ) || isset( $form['dtoc_security_nonce'] ) && !wp_verify_nonce( sanitize_text_field( $form['dtoc_security_nonce'] ), 'dtoc_ajax_check_nonce' ) ) {

        echo esc_html__('Nonce Not Verified', 'digital-table-of-contents');
        
        wp_die();
    }    
    
    $text = $subject = '';
        
    $headers = [];

    $from = isset( $form['dtoc_deactivated_from'] ) ? $form['dtoc_deactivated_from'] : '';

    if ( $from ) {
        $headers[] = "From: $from";
        $headers[] = "Reply-To: $from";
    }

    $reason = isset( $form['dtoc_disable_reason'] ) ? $form['dtoc_disable_reason'] : 'No Reason Given';

    switch ( $reason ) {

        case 'temporary':
            $subject = 'The deactivation is temporary';        
            $text    = 'The deactivation is temporary';
        break;
        case 'stopped_using':
            $subject = 'No longer using schema markup';
            $text    = 'No longer using schema markup';
        break;
        case 'missing_feature':
            $subject = 'Needed feature not available';
            if ( ! empty( $form['dtoc_missing_feature_text'] ) ) {
                $text    = $form['dtoc_missing_feature_text'];
            }
        
        break;
        case 'technical_difficulties':
            $subject = 'Facing Technical Difficulties';
            if ( ! empty( $form['dtoc_technical_difficulties_text'] ) ) {
                $text    = $form['dtoc_technical_difficulties_text'];
            }
        break;
        case 'switched_plugin':
            $subject = 'Switched to a different plugin';
            if ( ! empty( $form['dtoc_switched_plugin_text'] ) ) {
                $text    = $form['dtoc_switched_plugin_text'];
            }
        break;
        case 'other_reason':
            $subject = 'Other reason';
            if ( ! empty( $form['dtoc_other_reason_text'] ) ) {
                $text    = $form['dtoc_other_reason_text'];
            }
        break;        
        default:
            $subject = 'No Reason Given';
            $text    = 'No Reason Given';
        break;

    }
    
    wp_mail( 'support@schemapackage.com', $subject, $text, $headers );
    
    echo 'sent';
    wp_die();

}

add_action( 'wp_ajax_dtoc_send_feedback', 'dtoc_send_feedback' );

function dtoc_enqueue_feedback_scripts() {

    if ( is_admin() && dtoc_is_plugins_page() ) {

        $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style( 'dtoc-feedback-css', DTOC_URL . "feedback/feedback{$min}.css", false,  DTOC_VERSION );
        wp_register_script( 'dtoc-feedback-js', DTOC_URL . "feedback/feedback{$min}.js", [ 'jquery' ],  DTOC_VERSION, true );

         $localdata = [
                'ajax_url'      		       => admin_url( 'admin-ajax.php' ),
                'dtoc_security_nonce'          => wp_create_nonce( 'dtoc_ajax_check_nonce' )
         ];

        wp_localize_script( 'dtoc-feedback-js', 'dtoc_feedback_local', $localdata );
        wp_enqueue_script( 'dtoc-feedback-js' );
                
    }
    
}

add_action( 'admin_enqueue_scripts', 'dtoc_enqueue_feedback_scripts' );