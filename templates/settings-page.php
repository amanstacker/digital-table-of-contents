<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">
    <h1><?php esc_html_e( 'Digital Table of Contents Settings', 'digital-table-of-contents' ); ?></h1>
    <form method="post" action="options.php">
        <?php
        // Display settings fields
        settings_fields( 'digital_toc_settings' );
        $options = get_option( 'digital_toc_options', [
            'post_types' => [ 'post' ],
            'headings'   => [ 'h2' ],
            'hierarchy'  => false,
            'toggle'     => false,
            'title'      => 'Table of Contents',
        ] );
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Select Post Types', 'digital-table-of-contents' ); ?></th>
                <td>
                    <?php
                    $post_types = get_post_types( [ 'public' => true ], 'objects' );
					$checked = false;
                    foreach ( $post_types as $post_type ) {
						if(isset($options['post_types'])){
							$checked = in_array( $post_type->name, $options['post_types'] );
						}
                        ?>
                        <label>
                            <input type="checkbox" name="digital_toc_options[post_types][]" value="<?php echo esc_attr( $post_type->name ); ?>" <?php checked( $checked ); ?>>
                            <?php echo esc_html( $post_type->label ); ?>
                        </label><br>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Headings to Include', 'digital-table-of-contents' ); ?></th>
                <td>
                    <?php
                    $headings = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
					$checked = false;
                    foreach ( $headings as $heading ) {
						if(isset($options['headings'])){
							$checked = in_array( $heading, $options['headings'] );
						}
                        ?>
                        <label>
                            <input type="checkbox" name="digital_toc_options[headings][]" value="<?php echo esc_attr( $heading ); ?>" <?php checked( $checked ); ?>>
                            <?php echo esc_html( strtoupper( $heading ) ); ?>
                        </label><br>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Enable Hierarchy', 'digital-table-of-contents' ); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="digital_toc_options[hierarchy]" value="1" <?php checked( $options['hierarchy'], 1 ); ?>>
                        <?php esc_html_e( 'Enable nested hierarchy for TOC', 'digital-table-of-contents' ); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Enable TOC Toggle', 'digital-table-of-contents' ); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="digital_toc_options[toggle]" value="1" <?php checked( $options['toggle'], 1 ); ?>>
                        <?php esc_html_e( 'Enable toggle for TOC', 'digital-table-of-contents' ); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'TOC Title', 'digital-table-of-contents' ); ?></th>
                <td>
                    <input type="text" name="digital_toc_options[title]" value="<?php echo esc_attr( $options['title'] ); ?>" class="regular-text">
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
	
	 <!-- Shortcode Instructions -->
    <div style="margin-top: 40px; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd;">
        <h2><?php esc_html_e( 'How to Use the Shortcode', 'digital-table-of-contents' ); ?></h2>
        <p><?php esc_html_e( 'You can use the following shortcode to manually insert a TOC into any content:', 'digital-table-of-contents' ); ?></p>
        <pre style="background: #f1f1f1; padding: 10px; border-radius: 4px;">[digital_toc headings="h2,h3" toggle="true" hierarchy="true" title="My Custom TOC"]</pre>
        <p><?php esc_html_e( 'Supported arguments:', 'digital-table-of-contents' ); ?></p>
        <ul>
            <li><strong><?php esc_html_e( 'headings', 'digital-table-of-contents' ); ?>:</strong> <?php esc_html_e( 'Specify heading levels to include (e.g., h2,h3,h4).', 'digital-table-of-contents' ); ?></li>
            <li><strong><?php esc_html_e( 'toggle', 'digital-table-of-contents' ); ?>:</strong> <?php esc_html_e( 'Enable or disable toggle functionality (true or false).', 'digital-table-of-contents' ); ?></li>
            <li><strong><?php esc_html_e( 'hierarchy', 'digital-table-of-contents' ); ?>:</strong> <?php esc_html_e( 'Enable or disable nested hierarchy (true or false).', 'digital-table-of-contents' ); ?></li>
            <li><strong><?php esc_html_e( 'title', 'digital-table-of-contents' ); ?>:</strong> <?php esc_html_e( 'Customize the TOC title.', 'digital-table-of-contents' ); ?></li>
        </ul>
        <p><?php esc_html_e( 'Example usage:', 'digital-table-of-contents' ); ?></p>
        <pre style="background: #f1f1f1; padding: 10px; border-radius: 4px;">[digital_toc headings="h2,h3" toggle="true" hierarchy="true" title="Table of Contents"]</pre>
    </div>
</div>
