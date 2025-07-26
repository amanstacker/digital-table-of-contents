<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Register a meta box using a class.
 */
class Digital_TOC_POSTS_Metaboxes {

    private $_metaboxes = [
        'dtoc_incontent'            => 'Digital TOC In-Content',
        'dtoc_incontent_mobile'     => 'Digital TOC In-Content Mobile',
        'dtoc_incontent_tablet'     => 'Digital TOC In-Content Tablet',
        'dtoc_sticky'               => 'Digital TOC Sticky',
        'dtoc_sticky_mobile'        => 'Digital TOC Sticky Mobile',
        'dtoc_sticky_tablet'        => 'Digital TOC Sticky Tablet',
        'dtoc_floating'             => 'Digital TOC Floating',
        'dtoc_floating_mobile'      => 'Digital TOC Floating Mobile',
        'dtoc_floating_tablet'      => 'Digital TOC Floating Tablet',
    ];

    /**
     * Constructor.
     */
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     [ $this, 'init_metabox' ] );
            add_action( 'load-post-new.php', [ $this, 'init_metabox' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts_and_styles' ] );
        }
    }

    /**
     * Meta box initialization.
     */
    public function init_metabox() {
        add_action( 'add_meta_boxes', [ $this, 'add_metabox' ] );
        add_action( 'save_post', [ $this, 'save_metabox' ], 10, 2 );
    }
	
	 /**
     * Enqueue scripts and styles for the meta boxes.
     */
    public function enqueue_scripts_and_styles($hook) {
        // Check if we are on the post edit page
        if ($hook !== 'post.php' && $hook !== 'post-new.php') {
            return;
        }
        wp_enqueue_style('dtoc-meta-box-css', DTOC_URL . 'assets/admin/css/dtoc-meta-box.css');
        wp_enqueue_script('dtoc-meta-box-js', DTOC_URL . 'assets/admin/js/dtoc-meta-box.js', [ 'jquery' ], null, true);
    }

    /**
     * Adds the meta box.
     */
    public function add_metabox() {
		global $dtoc_dashboard;
        foreach ($this->_metaboxes as $key => $value) {
			$match_key = str_replace('dtoc_','',$key);
			if((isset($dtoc_dashboard['modules'][$match_key]) && $dtoc_dashboard['modules'][$match_key] == 1) || $match_key == 'incontent' ){
				add_meta_box(
					$key,
					$value,
					[ $this,'render_metabox' ],
					'post',
					'advanced',
					'default',
					 [ 'metabox_key' => $key ]
				);
			}
        }
    }

    /**
     * Renders the meta box.
     */
    public function render_metabox( $post , $metabox ) {
        // Add nonce for security.
        wp_nonce_field( 'dtoc_metaboxes_nonce_action', 'dtoc_metaboxes_nonce' );

		$key = $metabox['args']['metabox_key'];
        // Get saved options
        $options = get_post_meta( $post->ID, '_'.$key, false ) ?: [];
		
		$tab_titles = ['General', 'Display', 'Customization'];
		$tmp_id = wp_rand(111,999);
		echo '<div class="dtoc-meta-tabs">';
		echo '<ul class="dtoc-meta-tab-titles">';
		foreach ($tab_titles as $index => $title) {
			echo '<li><a href="#dtoc-meta-tab-' . $tmp_id . $title.'" class="' . ($index === 0 ? 'active' : '') . '">' . esc_html($title) . '</a></li>';
		}
		echo '</ul>';

		foreach ($tab_titles as $index => $title) {
			echo '<div id="dtoc-meta-tab-' . $tmp_id . $title . '" class="dtoc-meta-tab-content" style="display: ' . ($index === 0 ? 'block' : 'none') . ';">';
			$this->render_options( $key, $options , $title );
			echo '</div>';
		}
		echo '</div>';
	}

    /**
     * Renders the options for a meta box.
     */
    private function render_options( $meta_key, $saved_values , $tab ) {
		
		$type = "";
		switch($meta_key){
			case 'dtoc_incontent' :
				$type = '_dtoc_options[incontent]';
			break;
			case 'dtoc_incontent_mobile':
				$type = '_dtoc_options[incontent_mobile]';
			break;
			case 'dtoc_incontent_tablet':
			    $type = '_dtoc_options[incontent_tablet]';
			break;
			case 'dtoc_sticky' :
				 $type = '_dtoc_options[sticky]';
			break;
			case 'dtoc_sticky_mobile':
				 $type = '_dtoc_options[sticky_mobile]';
			break;
			case 'dtoc_sticky_tablet':
			    $type = '_dtoc_options[sticky_tablet]';
			break;
			case 'dtoc_floating' :
				 $type = '_dtoc_options[floating]';
			break;
			case 'dtoc_floating_mobile':
				 $type = '_dtoc_options[floating_mobile]';
			break;
			case 'dtoc_floating_tablet':
			    $type = '_dtoc_options[floating_tablet]';
			break;
			
		}
		set_transient('dtoc_meta_type',$type,60);
		if($tab == 'General'){
			do_settings_sections('dtoc_general_setting_section');
		}else if($tab == 'Display'){
			do_settings_sections('dtoc_display_setting_section');
		}else if($tab == 'Customization'){
			do_settings_sections('dtoc_customization_container_section');
		}
		delete_transient('dtoc_meta_type');
       
    }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     */
    public function save_metabox( $post_id, $post ) {
        // Check nonce and permissions (same as before)
        $nonce_name = isset( $_POST['dtoc_metaboxes_nonce'] ) ? $_POST['dtoc_metaboxes_nonce'] : '';
        if ( ! wp_verify_nonce( $nonce_name, 'dtoc_metaboxes_nonce_action' ) ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
            return;
        }

        // Save options as a single post meta field
        if ( isset( $_POST['_dtoc_options'] ) ) {
            update_post_meta( $post_id, '_dtoc_options', array_map('array_filter', $_POST['_dtoc_options']) );
        } else {
            delete_post_meta( $post_id, '_dtoc_options' );
        }
    }

}

if ( class_exists( 'Digital_TOC_POSTS_Metaboxes' ) ) {
    new Digital_TOC_POSTS_Metaboxes();
}

