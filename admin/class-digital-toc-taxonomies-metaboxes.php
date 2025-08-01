<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Register a meta box using a class.
 */
class Digital_TOC_Taxonomies_Metaboxes {

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

	private $_taxterm = [ 
		'category', 
		'post_tag', 
		'product_cat', 
		'product_tag',
	];

	/**
	 * Constructor.
	 */
	public function __construct() {

		if ( is_admin() ) {

			foreach ( $this->_taxterm as $value ) {

				//add_action( "{$value}_edit_form_fields", [ $this, 'edit_form_fields' ],10,2 );
				//add_action( "created_{$value}", [ $this, "save_term_fields" ]);
				//add_action( "edited_{$value}",  [ $this, "save_term_fields" ]);	

			}

		}

	}


	public function edit_form_fields( $term, $taxonomy ) {

		wp_nonce_field( 'taxonomy_specific_nonce_data', 'taxonomy_specific_nonce' );  

		foreach ($this->_metaboxes as $key => $value) {
			?>
				<tr>
				<th scope="row"></th>
				<td>

				<div class="postbox">
				<div class="postbox-header">
					<h2 class="hndle ui-sortable-handle"><?php echo $value; ?></h2>
				<div class="handle-actions hide-if-no-js">
					<button type="button" class="handle-order-higher" aria-disabled="false" aria-describedby="dtoc_incontent-handle-order-higher-description">
						<span class="screen-reader-text">Move up</span><span class="order-higher-indicator" aria-hidden="true"></span>
					</button><span class="hidden" id="dtoc_incontent-handle-order-higher-description">Move Digital TOC In-Content box up</span>
					<button type="button" class="handle-order-lower" aria-disabled="false" aria-describedby="dtoc_incontent-handle-order-lower-description"><span class="screen-reader-text">Move down</span><span class="order-lower-indicator" aria-hidden="true"></span></button><span class="hidden" id="dtoc_incontent-handle-order-lower-description">Move Digital TOC In-Content box down</span><button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Digital TOC In-Content</span><span class="toggle-indicator" aria-hidden="true"></span></button>
				</div></div>
				<div class="inside">
						ddd
				</div>
				</div>

				</td>
				</tr>
	  		<?php	
		}
				
		
	}

	public function save_term_fields( $term_id ) {
                
        if ( ! isset( $_POST['taxonomy_specific_nonce'] ) ) return $term_id;

		if ( !wp_verify_nonce( $_POST['taxonomy_specific_nonce'], 'taxonomy_specific_nonce_data' ) ) return $term_id;	

        
		update_term_meta( $term_id, 'saswp_custom_schema_field', '' );                 
		delete_term_meta( $term_id, 'saswp_custom_schema_field');                                                                                                         

    }
	
}

if ( class_exists( 'Digital_TOC_Taxonomies_Metaboxes' ) ) {
	new Digital_TOC_Taxonomies_Metaboxes();
};