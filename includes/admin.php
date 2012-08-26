<?php
/**
 * Admin functions.
 *
 * @package News
 * @subpackage Includes
 * @since 0.1.0
 */

/* Set up the admin functionality. */
add_action( 'admin_menu', 'news_admin_setup', 11 );

/**
 * Sets up the admin functionality for the News theme.
 *
 * @since 0.2.0
 */
function news_admin_setup() {

	$prefix = hybrid_get_prefix();
	$settings_page = hybrid_get_settings_page_name();

	/* Load theme settings meta boxes. */
	add_action( "load-{$settings_page}", 'news_create_settings_meta_boxes' );

	/* Validate theme settings. */
	add_filter( "sanitize_option_{$prefix}_theme_settings", 'news_validate_theme_settings' );
}

/**
 * Validates the theme settings.
 *
 * @since 0.1.0
 */
function news_validate_theme_settings( $settings ) {

	$settings['home_template_categories'] = ( ( isset( $settings['home_template_categories'] ) && is_array( $settings['home_template_categories'] ) ) ? array_map( 'absint', $settings['home_template_categories'] ) : array() );

	return $settings;
}

/**
 * Add meta boxes to the theme settings page.
 *
 * @since 0.1.0
 */
function news_create_settings_meta_boxes() {
	add_meta_box( "news-home-template-meta-box", __( 'Home Page Template Settings', 'news' ), 'news_home_template_theme_meta_box', 'appearance_page_theme-settings', 'normal', 'low' );
 }

/**
 * Display the home template meta box.
 *
 * @since 0.1.0
 */
function news_home_template_theme_meta_box() {
	$prefix = hybrid_get_prefix();

	/* Settings used. */
	$category_highlight = hybrid_get_setting( 'home_template_categories' );

	/* Get categories. */
	$categories = get_categories(); ?>

	<table class="form-table">

		<tr>
			<th><?php _e( 'About:', 'news' ); ?></th>
			<td>
				<?php _e( 'Settings used on pages that use the "Home" page template.  This template must be assigned to a page before its settings take effect.', 'news' ); ?>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo hybrid_settings_field_id( 'home_template_categories' ); ?>"><?php _e( 'Category Highlight:', 'news' ); ?></label></th>
			<td>
				<label for="<?php echo hybrid_settings_field_id( 'home_template_categories' ); ?>"><?php _e( 'Categories to show blog posts from in the category highlight section.  Multiple categories may be chosen by holding the <code>Ctrl</code> key and selecting.', 'news' ); ?></label>
				<br />
				<select id="<?php echo hybrid_settings_field_id( 'home_template_categories' ); ?>" name="<?php echo hybrid_settings_field_name( 'home_template_categories' ); ?>[]" multiple="multiple" style="height:150px;">
				<?php foreach( $categories as $cat ) { ?>
					<option value="<?php echo $cat->term_id; ?>" <?php if ( is_array( $category_highlight ) && in_array( $cat->term_id, $category_highlight ) ) echo ' selected="selected"'; ?>><?php echo esc_html( $cat->name ); ?></option>
				<?php } ?>
				</select>
			</td>
		</tr>

	</table><?php
}

?>