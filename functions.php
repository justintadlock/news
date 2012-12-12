<?php
/**
 * The functions file is used to initialize everything in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).  Friends don't let 
 * friends modify parent theme files. ;)
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package News
 * @subpackage Functions
 * @version 0.3.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Tung Do <ttsondo@gmail.com>
 * @copyright Copyright (c) 2010 - 2012
 * @link http://themehybrid.com/themes/news
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'news_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function news_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Load shortcodes file. */
	require_once( trailingslashit( THEME_DIR ) . 'includes/shortcodes.php' );

	/* Load admin functions. */
	if ( is_admin() )
		require_once( trailingslashit( THEME_DIR ) . 'includes/admin.php' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'secondary', 'header', 'after-singular' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-seo' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'hybrid-core-javascript', array( 'drop-downs' ) );

	/* Add theme support for extensions. */
	add_theme_support( 'dev-stylesheet' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'entry-views' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );

	/* Register shortcodes. */
	add_action( 'init', 'news_register_shortcodes' );

	/* Register new image sizes. */
	add_action( 'init', 'news_register_image_sizes' );

	/* Register additional widgets. */
	add_action( 'widgets_init', 'news_register_widgets' );

	/* Load JavaScript. */
	add_action( 'wp_enqueue_scripts', 'news_enqueue_script' );

	/* Site description. */
	add_action( "{$prefix}_before_menu_secondary", 'hybrid_site_description' );

	/* Hook additional items to the nav menus. */
	add_filter( 'wp_nav_menu', 'news_nav_menu_add_items', 10, 2 );

	/* Content. */
	add_action( "{$prefix}_singular-post_after_loop", 'news_singular_post_tags' );

	/* Tag cloud. */
	add_filter( 'wp_tag_cloud', 'news_add_span_to_tag_cloud' );
	add_filter( 'term_links-post_tag', 'news_add_span_to_tag_cloud' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'news_embed_defaults' );

	/* Set content width. */
	hybrid_set_content_width( 600 );

	/* Allow all post types to have shortlinks. Do this early so plugins can still override. */
	add_filter( 'get_shortlink', 'news_filter_shortlink', 1, 3 );

	/* Add classes to the comments pagination. */
	add_filter( 'previous_comments_link_attributes', 'news_previous_comments_link_attributes' );
	add_filter( 'next_comments_link_attributes', 'news_next_comments_link_attributes' );

	/* Add a wrapper class for singular videos. */
	add_filter( 'the_content', 'news_video_embed_wrapper', 20 );

	/* Shorter excerpt length. */
	add_filter( 'excerpt_length', 'news_excerpt_length' );

	/* Comment form arguments. */
	add_filter( 'comment_form_defaults', 'news_comment_form_defaults', 11 );

	/* Additional default theme settings. */
	add_filter( "{$prefix}_default_theme_settings", 'news_theme_settings' );
}

/**
 * Registers additional image sizes, in particular, the 'news-thumbnail' and 'news-slideshow' sizes.
 *
 * @since 0.1.0
 */
function news_register_image_sizes() {
	add_image_size( 'news-slideshow', 600, 400, true );
	add_image_size( 'news-slideshow-large', 640, 430, true );
	add_image_size( 'news-thumbnail', 100, 75, true );
}

/**
 * Loads extra widget files and registers the widgets.
 * 
 * @since 0.1.0
 */
function news_register_widgets() {

	/* Load the popular tabs widget. */
	if ( current_theme_supports( 'entry-views' ) ) {
		require_once( trailingslashit( THEME_DIR ) . 'includes/widget-popular-tabs.php' );
		register_widget( 'News_Widget_Popular_Tabs' );
	}

	/* Load the image stream widget. */
	require_once( trailingslashit( THEME_DIR ) . 'includes/widget-image-stream.php' );
	register_widget( 'News_Widget_Image_Stream' );

	/* Load the newsletter widget. */
	require_once( trailingslashit( THEME_DIR ) . 'includes/widget-newsletter.php' );
	register_widget( 'News_Widget_Newsletter' );
}

/**
 * Loads the theme JavaScript files.
 *
 * @since 0.1.0
 */
function news_enqueue_script() {
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'news-theme', trailingslashit( THEME_URI ) . 'js/news-theme.js', array( 'jquery' ), '20120825', true );
}

/**
 * Adds a log in/out link to the secondary menu.
 *
 * @since 0.1.0
 */
function news_nav_menu_add_items( $menu, $args ) {

	if ( 'secondary' == $args->theme_location ) {
		$links = '<li class="loginout">' . wp_loginout( home_url( esc_url( $_SERVER['REQUEST_URI'] ) ), false ) . '</li>';
		$menu = str_replace( '</ul></div>', $links . '</ul></div>', $menu );
	}

	return $menu;
}

/**
 * Displays the post tags for singular posts.
 *
 * @since 0.1.0
 */
function news_singular_post_tags() {
	if ( has_tag() )
		echo '<div class="entry-tags">' . do_shortcode( '[entry-terms type="post_tag" separator=""]' ) . '</div>';
}

/**
 * Wraps tag cloud links with a span for easier background image styling.
 *
 * @todo If anyone can figure out a way to style this without the <span>, we can remove this.
 *
 * @since 0.1.0
 */
function news_add_span_to_tag_cloud( $cloud ) {
	$cloud = preg_replace( "/>(.*?)<\/a>/", "><span>$1</span></a>", $cloud );
	return $cloud;
}

/**
 * Adds 'class="prev" to the previous comments link.
 *
 * @since 0.1.0
 */
function news_previous_comments_link_attributes( $attributes ) {
	return $attributes . ' class="prev"';
}

/**
 * Adds 'class="next" to the next comments link.
 *
 * @since 0.1.0
 */
function news_next_comments_link_attributes( $attributes ) {
	return $attributes . ' class="next"';
}

/**
 * Returns the current comments page.
 *
 * @since 0.1.0
 */
function news_get_current_comments_page() {
	$cpage = get_query_var( 'cpage' );

	return ( ( empty( $cpage ) ) ? 1 : absint( $cpage ) );
}

/**
 * Custom comment form arguments.
 *
 * @since 0.2.0
 * @param array $args The arguments for the comments form.

 */
function news_comment_form_defaults( $args ) {

	$args['label_submit'] = esc_attr__( 'Submit', 'news' );

	return $args;
}

/**
 * Filters 'get_shortlink' because WordPress only creates shortlinks for the 'post' post type. We need
 * a shortlink for pages and attachments.  Note that this doesn't handle custom post types since we 
 * wouldn't really be making them "short" anyway.  Most users looking for good shortlink solutions should
 * use a shortlink plugin, especially when dealing with custom post types.
 *
 * @since 0.1.0
 */
function news_filter_shortlink( $shortlink, $id, $context ) {

	/* Get the post based on ID. */
	$post = get_post( $id );

	/* If not a post, just return the shortlink. */
	if ( empty( $post ) )
		return $shortlink;

	/* Add a default shortlink for pages. */
	if ( 'page' == $post->post_type )
		$shortlink = home_url( "?page_id={$id}" );

	/* Add a default shortlink for attachments. */
	elseif ( 'attachment' == $post->post_type )
		$shortlink = home_url( "?attachment_id={$id}" );

	/* Return the shortlink. */
	return $shortlink;
}

/**
 * Adds "class='video-wrap'" to the opening <p> element around video embeds.
 *
 * @since 0.1.0
 */
function news_video_embed_wrapper( $content ) {

	if ( is_singular( 'video' ) && in_the_loop() )
		$content = preg_replace( array( "/<p>(.*?)<object/", "/<p>(.*?)<iframe/" ), array( "<p class='video-wrap'>$1<object", "<p class='video-wrap'>$1<iframe" ), $content );

	return $content;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 0.1.0
 */
function news_embed_defaults( $args ) {
	if ( is_singular( 'video' ) || is_singular( 'slideshow' ) )
		$args['width'] = 640;
	else
		$args['width'] = 560;

	return $args;
}

/**
 * Shortens the excerpt length so that auto-excerpts fit nicely into the design.  This isn't bulletproof since
 * the excerpt length is determined by words rather than characters.  Child themes can also filter the
 * 'excerpt_length' hook to make this longer or shorter.
 *
 * @since 0.1.0
 */
function news_excerpt_length( $length ) {
	return 40;
}

/**
 * Add additional settings to the theme settings array.
 *
 * @since 0.1.0
 */
function news_theme_settings( $settings ) {
	$settings['home_template_categories'] = array();

	return $settings;
}

/**
 * Function for grabbing a post ID by meta key and meta value.  We're using this in the sidebar-feature.php 
 * file to check if a page has been given the 'page-template-popular.php' page template.
 *
 * @since 0.1.0
 */
function news_get_post_by_meta( $meta_key = '', $meta_value = '' ) {
	global $wpdb;

	$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s LIMIT 1", $meta_key, $meta_value ) );

	if ( !empty( $post_id ) )
		return $post_id;

	return false;
}

/**
 * This function prohibits that wordpress stripes out rel tags
 *
 */
function allow_rel() {
	global $allowedtags;
	$allowedtags['a']['rel'] = array ();
}
add_action( 'wp_loaded', 'allow_rel' );

/**
 * Give the user the posibility to add a link to a Google+ profile 
 * to their author page.
 */
function add_google_profile( $contactmethods ) {
	$contactmethods['google_profile'] = 'Google Profile <abbr title="Uniform Resource Locator">URL</abbr>';
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_google_profile', 10, 1);

/**
 * Give the user the posibility to add a link to a Twitter profile 
 * to their author page.
 */
function add_twitter_profile( $contactmethods ) {
	$contactmethods['twitter_profile'] = 'Twitter Profile <abbr title="Uniform Resource Locator">URL</abbr>';
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_twitter_profile', 10, 1);

/* == Functions removed in version 0.3 == */

function news_flush_rewrite_rules() {}

/* == Functions removed in version 0.2 == */

function news_get_header_sidebar() {}
function news_get_secondary_menu() {}
function news_get_subsidiary_menu() {}
function news_breadcrumb_trail_args() {}
function news_unregister_sidebars() {}
function news_register_sidebars() {}
function news_register_menus() {}

?>
