<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'dtoc_frontend_enqueue' );
add_action( 'init', 'dtoc_init_misc' );

function dtoc_init_misc() {
        ob_start('dtoc_remove_unused_scripts');
}

function dtoc_frontend_enqueue(){

        global $dtoc_incontent;
		
        $data = array();

        $data['scroll_behaviour'] = isset($dtoc_incontent['scroll_behavior'])?$dtoc_incontent['scroll_behavior']:'auto';
        $data['toggle_body']      = isset($dtoc_incontent['toggle_body']) ? 1 : 0;
                        
        $data = apply_filters('dtoc_localize_frontend_assets', $data, 'dtoc_localize_frontend_data');
        
        wp_enqueue_style( 'dtoc-frontend', DTOC_URL  . 'assets/shared/css/dtoc-front.css', false , DTOC_VERSION );    
        
        wp_register_script( 'dtoc-frontend', DTOC_URL  . 'assets/frontend/js/dtoc_auto_place.js', array('jquery'), DTOC_VERSION , true );                        
        wp_localize_script( 'dtoc-frontend', 'dtoc_localize_frontend_data', $data );        
        wp_enqueue_script( 'dtoc-frontend' );                        
        
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
       
        if($dtoc_incontent['loading_type'] == 'css' && isset($dtoc_incontent['display_title']) && isset($dtoc_incontent['toggle_body'])){        
                $custom_css .= ".dtoc-box-on-css-body{
                        display: none;
                    }
                        .dtoc-toggle-label{
                                cursor: pointer;
                        }
                    #dtoc-toggle-check:checked ~ .dtoc-box-on-css-body {
                                 display: block;
                     }";      
        }        
        if($dtoc_incontent['loading_type'] == 'css' && $dtoc_incontent['scroll_behavior'] == 'smooth'){
                $custom_css .= "html {
                        scroll-behavior: smooth;
                }";
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
function dtoc_remove_unused_scripts($content){

        global $dtoc_incontent;		

        if(isset($dtoc_incontent['remove_unused_css_js']) && $dtoc_incontent['remove_unused_css_js'] == 1){
                
                if(strpos($content, 'class="dtoc-box-container"') === false){
                        
                        $css_url = "<link rel='stylesheet' id='dtoc-frontend-css' href='".DTOC_URL  . 'assets/frontend/css/dtoc_common.css?ver='.DTOC_VERSION."' media='all' />";
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

function dtoc_placement_condition_matched($options){
        return true;
        $status = false;                
        $curr_post_type = get_post_type();
        
        if(isset($options['placement'][$curr_post_type]['is_enabled'])){
                $status = true;
                
        if(isset($options['placement'][$curr_post_type]['skip'])){
                $skip_arr = $options['placement'][$curr_post_type]['skip'];
                $ID = get_the_ID();
                if(in_array($ID, $skip_arr)){                   
                   return false;
                }                    
        }

        if(isset($options['placement'][$curr_post_type]['taxonomy'])){

                $taxonomy = $options['placement'][$curr_post_type]['taxonomy'];
                if(is_array($taxonomy)){
                        
                        $operation = [];
                        $j = 0;
                        foreach ($taxonomy as $key => $value) {
                                if(!empty($value['ids'])){
                                        $terms = get_the_terms( get_the_ID(), $key );
                                        
                                        if ( !is_wp_error( $terms ) && !empty($terms) ) {

                                                foreach ($terms as $term) {
                                                        if(in_array($term->term_id, $value['ids'])){
                                                                $status = true;                                                                
                                                                $operation[$j] = true;
                                                        }else{
                                                                
                                                        }                                                         
                                                }                                                         
                                                
                                        }
                                        
                                }
                                $j++;
                        }
                }

        }

        }                        
        return $status;
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