<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'dtoc_sliding_sticky_modules_enqueue' );


function dtoc_sliding_sticky_modules_enqueue() {

        global $dtoc_dashboard, $dtoc_sliding_sticky;

        if ( empty( $dtoc_dashboard['modules']['sliding_sticky'] ) ) {
           return '';
        }                
                
        $data = [];

        if ( $dtoc_sliding_sticky[ 'rendering_style' ] == 'js' ) {

                $data['scroll_behaviour'] = isset( $dtoc_sliding_sticky['scroll_behavior'] ) ? $dtoc_sliding_sticky['scroll_behavior'] : 'auto';
                $data['toggle_body']      = isset( $dtoc_sliding_sticky['toggle_body'] ) ? 1 : 0;
                $data['display_position'] = $dtoc_sliding_sticky['display_position'];                                                

                wp_register_script( 'dtoc-sliding-sticky-frontend', DTOC_URL  . 'assets/frontend/js/dtoc-sliding-sticky.js', array('jquery'), DTOC_VERSION , true );                        
                wp_localize_script( 'dtoc-sliding-sticky-frontend', 'dtoc_localize_frontend_sticky_data', $data );        
                wp_enqueue_script( 'dtoc-sliding-sticky-frontend' );                        
                wp_enqueue_style( 'dtoc-sliding-sticky-frontend', DTOC_URL  . 'assets/frontend/css/dtoc-sliding-sticky-front-js-based.css', false , DTOC_VERSION );

        }else{

                wp_enqueue_style( 'dtoc-sliding-sticky-frontend', DTOC_URL  . 'assets/frontend/css/dtoc-sliding-sticky-front-css-based.css', false , DTOC_VERSION );
        }
                
                    

        $list_style_type = 'decimal';
        $counter_end =  "'.'";

        if ( ! empty( $dtoc_sliding_sticky['list_style_type'] ) ) {

                $list_style_type = $dtoc_sliding_sticky['list_style_type'];

                if ( in_array( $list_style_type, array( 'circle','disc','square' ) ) ) {
                        $counter_end =  '';
                }
                                
        }
        $custom_css = "";
        $custom_css = "
                .dtoc-sliding-sticky-container ul{
                        counter-reset: dtoc_item;
                        list-style-type: none;                 
                }
                .dtoc-sliding-sticky-container ul li::before{
                        counter-increment: dtoc_item;
                        content: counters(dtoc_item,'.', $list_style_type) $counter_end;
                        padding-right: 4px;
                }";                                
                if ( isset( $dtoc_sliding_sticky['scroll_behavior'] ) && $dtoc_sliding_sticky['scroll_behavior'] == 'smooth' ) {
                        $custom_css .= "html {
                                scroll-behavior: smooth;
                        }";
                }
                
                
        if(isset($dtoc_sliding_sticky['custom_css']) && !empty($dtoc_sliding_sticky['custom_css'])){
                $custom_css .= $dtoc_sliding_sticky['custom_css'];
        }    
        wp_add_inline_style( 'dtoc-sliding-sticky-frontend', $custom_css );

}

add_action( 'wp_enqueue_scripts', 'dtoc_incontent_and_shortcode_modules_enqueue' );

function dtoc_incontent_and_shortcode_modules_enqueue() {

        global $dtoc_dashboard, $dtoc_incontent;

        if ( !empty( $dtoc_dashboard['modules']['incontent'] ) || !empty( $dtoc_dashboard['modules']['shortcode'] ) ) {
                        
                $data = [];

                if ( $dtoc_incontent[ 'rendering_style' ] == 'js' ) {

                        $data['scroll_behaviour'] = isset( $dtoc_incontent['scroll_behavior'] ) ? $dtoc_incontent['scroll_behavior'] : 'auto';
                        $data['toggle_body']      = isset( $dtoc_incontent['toggle_body'] ) ? 1 : 0;
                                        
                        $data = apply_filters( 'dtoc_localize_frontend_assets', $data, 'dtoc_localize_frontend_data' );

                        wp_register_script( 'dtoc-frontend', DTOC_URL  . 'assets/frontend/js/dtoc_auto_place.js', array('jquery'), DTOC_VERSION , true );                        
                        wp_localize_script( 'dtoc-frontend', 'dtoc_localize_frontend_data', $data );        
                        wp_enqueue_script( 'dtoc-frontend' );                        

                }
                        
                wp_enqueue_style( 'dtoc-frontend', DTOC_URL  . 'assets/frontend/css/dtoc-front.css', false , DTOC_VERSION );    
                                
                $list_style_type = 'decimal';
                        $counter_end =  "'.'";
                if(!empty($dtoc_incontent['list_style_type'])){
                        $list_style_type = $dtoc_incontent['list_style_type'];
                                        if(in_array($list_style_type,array('circle','disc','square'))){
                                                $counter_end =  '';
                                        }
                                        
                }
                $custom_css = "";
                $custom_css = "
                        .dtoc-box-container ul{
                                counter-reset: dtoc_item;
                                list-style-type: none;                 
                        }
                        .dtoc-box-container ul li::before{
                                counter-increment: dtoc_item;
                                content: counters(dtoc_item,'.', $list_style_type) $counter_end;
                                                        padding-right: 4px;
                        }";
        

                if ( $dtoc_incontent['rendering_style'] == 'js' ) {

                        if ( isset( $dtoc_incontent['display_title'] ) && isset( $dtoc_incontent['toggle_body'] ) ) {        

                                if ( $dtoc_incontent['toggle_initial'] == 'hide' ) {

                                        $custom_css .= ".dtoc-box-on-js-body{
                                                display: none;
                                        }
                                        .dtoc-hide-text {
                                                display: none;
                                        }                                
                                        ";      
                                        
                                }else{

                                        $custom_css .= "
                                        .dtoc-show-text {
                                                display: none;
                                        }                                
                                        ";      
                                }

                                $custom_css .= "
                                        .dtoc-toggle-label{
                                                cursor: pointer;
                                        }                                
                                        ";

                                
                        }                        
                }

                        
                if ( $dtoc_incontent['rendering_style'] == 'css' ) {

                        if ( isset( $dtoc_incontent['display_title'] ) && isset( $dtoc_incontent['toggle_body'] ) ) {
                                $custom_css .= ".dtoc-box-on-css-body{
                                                display: none;
                                        }
                                        .dtoc-show-text {
                                                display: none;
                                        }
                                        .dtoc-toggle-label{
                                                cursor: pointer;
                                        }
                                        #dtoc-toggle-check:checked ~ .dtoc-box-on-css-body {
                                                display: block;
                                        }                                        
                                        #dtoc-toggle-check:checked ~ .dtoc-toggle-label .dtoc-hide-text {
                                                display: inline;
                                        }
                                        #dtoc-toggle-check:checked ~ .dtoc-toggle-label .dtoc-show-text {
                                                display: none;
                                        }

                                        #dtoc-toggle-check:not(:checked) ~ .dtoc-toggle-label .dtoc-show-text {
                                                display: inline;
                                        }
                                        #dtoc-toggle-check:not(:checked) ~ .dtoc-toggle-label .dtoc-hide-text {
                                                display: none;
                                        }
                                        ";      
                        }        
                        if ( isset( $dtoc_incontent['scroll_behavior'] ) && $dtoc_incontent['scroll_behavior'] == 'smooth' ) {
                                $custom_css .= "html {
                                        scroll-behavior: smooth;
                                }";
                        }
                }        
                
                if($dtoc_incontent['alignment'] == 'left'){
                        $custom_css .= "body .dtoc-box-container {
                                margin: 0px auto 0px 0px !important;
                        }";
                }
                if($dtoc_incontent['alignment'] == 'centre'){
                        $custom_css .= "body .dtoc-box-container {
                                margin: 0 auto !important;
                        }";
                }        
                if($dtoc_incontent['alignment'] == 'right'){
                        $custom_css .= "body .dtoc-box-container {
                                margin: 0px 0px 0px auto !important;
                        }";
                }
                if(isset($dtoc_incontent['custom_css']) && !empty($dtoc_incontent['custom_css'])){
                        $custom_css .= $dtoc_incontent['custom_css'];
                }    
                wp_add_inline_style( 'dtoc-frontend', $custom_css );

        }                        
        		        
}

add_action( 'init', 'dtoc_init_misc' );

function dtoc_init_misc() {
        ob_start('dtoc_remove_unused_scripts');
}

function dtoc_remove_unused_scripts($content){

        global $dtoc_incontent;		

        if(isset($dtoc_incontent['remove_unused_css_js']) && $dtoc_incontent['remove_unused_css_js'] == 1){
                
                if(strpos($content, 'class="dtoc-box-container"') === false){
                        
                        $css_url = "<link rel='stylesheet' id='dtoc-frontend-css' href='".DTOC_URL  . 'assets/frontend/css/dtoc_front.css?ver='.DTOC_VERSION."' media='all' />";
                        $script_url = "<script src='".DTOC_URL  . 'assets/frontend/js/dtoc_auto_place.js?ver='.DTOC_VERSION."' id='dtoc-frontend-js'></script>";                                    
                        $content = str_replace(array($css_url, $script_url), array('',''),$content);
                        $content = preg_replace("/<style id='dtoc-frontend-inline-css'>(.*?)<\/style>/s", "", $content);
                        $content = preg_replace("/<script id='dtoc-frontend-js-extra'>(.*?)<\/script>/s", "", $content);
                        
                        $regex = '/<span class="dtoc-section(.*?)><\/span>(.*?)<span class="dtoc-section-end"><\/span>/';
                        preg_match_all($regex, $content, $matches);
                        
                        if(!empty($matches) && isset($matches[0]) && isset($matches[2])){                                
                                $content = str_replace($matches[0], $matches[2], $content);
                        }
                }                
    
        }
        
        return $content;
}

function dtoc_placement_condition_matched( $options ) {

    $post_id   = get_the_ID();
    $post_type = get_post_type();

    // Check if placement exists and is enabled for this post type
    if (
        ! isset( $options['placement'] ) ||
        ! isset( $options['placement'][ $post_type ] ) ||
        empty( $options['placement'][ $post_type ]['is_enabled'] )
    ) {
        return false;
    }

    $placement = $options['placement'][ $post_type ];

    // Check if this post is skipped
    if ( isset( $placement['skip'] ) && is_array( $placement['skip'] ) ) {
        if ( in_array( $post_id, $placement['skip'] ) ) {
            return false;
        }
    }

    // Taxonomy matching
    if ( isset( $placement['taxonomy'] ) && is_array( $placement['taxonomy'] ) ) {
        $has_valid_taxonomy = false;
        $match_found        = false;

        foreach ( $placement['taxonomy'] as $taxonomy => $settings ) {
            if ( empty( $settings['ids'] ) || ! is_array( $settings['ids'] ) ) {
                continue;
            }

            $has_valid_taxonomy = true;

            $required_ids = $settings['ids'];
            $operation    = isset( $settings['ope'] ) ? strtolower( $settings['ope'] ) : 'or';

            $terms = get_the_terms( $post_id, $taxonomy );
            if ( is_wp_error( $terms ) || empty( $terms ) ) {
                if ( $operation === 'and' ) {
                    return false;
                } else {
                    continue;
                }
            }

            $term_ids = wp_list_pluck( $terms, 'term_id' );

            if ( $operation === 'and' ) {
                foreach ( $required_ids as $rid ) {
                    if ( ! in_array( $rid, $term_ids ) ) {
                        return false;
                    }
                }
                $match_found = true;
            } else {
                foreach ( $required_ids as $rid ) {
                    if ( in_array( $rid, $term_ids ) ) {
                        $match_found = true;
                        break;
                    }
                }
            }
        }

        // If taxonomy rules exist but no matches were found
        if ( $has_valid_taxonomy && ! $match_found ) {
            return false;
        }
    }

    // Passed all checks
    return true;
}



function dtoc_get_device_type(){

        $device_type = 'laptop';

        $tablet_browser = 0;
        $mobile_browser = 0;
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $tablet_browser++;
        }
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $mobile_browser++;
        }
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
                $mobile_browser++;
        }
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda ','xda-');
        
        if (in_array($mobile_ua,$mobile_agents)) {
                $mobile_browser++;
        }
        
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
                $mobile_browser++;
                //Check for tablets on opera mini alternative headers
                $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
        }
        }
        if ($tablet_browser > 0) {
                $device_type = 'tablet';
        }
        else if ($mobile_browser > 0) {        
                $device_type = 'mobile';
        }        

        return $device_type;
}
function dtoc_get_options_by_device( $option = "incontent" ) {
        
        $option = "dtoc_{$option}"; $option_mobile = "dtoc_{$option}_mobile"; $option_tablet = "dtoc_{$option}_tablet";
        $options     = isset($GLOBALS[$option]) ? $GLOBALS[$option] : [];
        $device_type = dtoc_get_device_type();
		$post_id =  get_the_ID();
		$postmeta_settings = false;
		if($post_id){
			$postmeta_settings = get_post_meta('_dtoc_options', false);
		}
                                
        switch ($device_type) {
                case 'mobile':
                        if(isset($dtoc_dashboard['modules'][$option_mobile]) && $dtoc_dashboard['modules'][$option_mobile] == 1){
							$options = isset($GLOBALS[$option_mobile]) ? array_merge($GLOBALS[$option_mobile], $postmeta_settings[$option_mobile]) : $GLOBALS[$option_mobile];
							$options['type'] = $option; 
                        }                        
                        break;
                case 'tablet':
                        if(isset($dtoc_dashboard['modules'][$option_tablet]) && $dtoc_dashboard['modules'][$option_tablet] == 1){
							$options = isset($GLOBALS[$option_tablet]) ? array_merge($GLOBALS[$option_tablet], $postmeta_settings[$option_tablet]) : $GLOBALS[$option_tablet];
							$options['type'] = $option;
                        }                        
                        break;
                default:
						$options = $postmeta_settings ? dtoc_get_applied_settings($option,$postmeta_settings[$option]):$options;
						$options =isset($postmeta_settings[$option]) ? array_merge($option, $postmeta_settings[$option]):$options;
						$options['type'] = $option;
                        break;
        }
		
		
        return $options;
}