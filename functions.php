<?php
/**
 * === \/\ ===
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    News
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/news
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for launching the theme and setup configuration.
 *
 * @since  2.0.0
 * @access public
 */
final class News_Theme {

	/**
	 * Directory path to the theme folder.
	 *
	 * @since  2.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_path = '';

	/**
	 * Directory URI to the theme folder.
	 *
	 * @since  2.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_uri = '';

	/**
	 * Returns the instance.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  2.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Initial theme setup.
	 *
	 * @since  2.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {

		$this->dir_path = trailingslashit( get_template_directory()     );
		$this->dir_uri  = trailingslashit( get_template_directory_uri() );
	}

	/**
	 * Loads include and admin files for the plugin.
	 *
	 * @since  2.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {

		// Load the Hybrid Core framework and theme files.
		require_once( $this->dir_path . 'lib/hybrid.php'       );
		require_once( $this->dir_path . 'inc/hybrid-x.php'     );
		require_once( $this->dir_path . 'inc/hybrid-fonts.php' );

		// Load theme includes.
	//	require_once( $this->dir_path . 'inc/class-customize.php'     );
		require_once( $this->dir_path . 'inc/functions-filters.php'   );
		require_once( $this->dir_path . 'inc/functions-icons.php'     );
		require_once( $this->dir_path . 'inc/functions-options.php'   );
		require_once( $this->dir_path . 'inc/functions-scripts.php'   );
		require_once( $this->dir_path . 'inc/slideshow.php' );
		require_once( $this->dir_path . 'inc/functions-template.php'  );

		// Launch the Hybrid Core framework.
		new Hybrid();
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  2.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Theme setup.
		add_action( 'after_setup_theme', array( $this, 'theme_setup'             ),  5 );
		add_action( 'after_setup_theme', array( $this, 'custom_background_setup' ), 15 );

		// Register menus.
		add_action( 'init', array( $this, 'register_menus' ) );

		// Register image sizes.
		add_action( 'init', array( $this, 'register_image_sizes' ) );

		// Register sidebars.
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Register layouts.
		add_action( 'hybrid_register_layouts', array( $this, 'register_layouts' ) );

		// Register scripts, styles, and fonts.
		add_action( 'wp_enqueue_scripts',    array( $this, 'register_scripts' ), 0 );
		add_action( 'enqueue_embed_scripts', array( $this, 'register_scripts' ), 0 );
	}

	/**
	 * The theme setup function.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function theme_setup() {

		// Theme layouts.
	//	add_theme_support( 'theme-layouts', array( 'default' => 'grid-landscape', 'post_meta' => false ) );

		// Breadcrumbs.
		add_theme_support( 'breadcrumb-trail' );

		// Template hierarchy.
		add_theme_support( 'hybrid-core-template-hierarchy' );

		// The best thumbnail/image script ever.
		add_theme_support( 'get-the-image' );

		// Nicer [gallery] shortcode implementation.
		add_theme_support( 'cleaner-gallery' );

		// Automatically add feed links to `<head>`.
		add_theme_support( 'automatic-feed-links' );

		// Post formats.
		add_theme_support(
			'post-formats',
			array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' )
		);

		// Handle content width for embeds and images.
		hybrid_set_content_width( 700 );
	}

	/**
	 * Adds support for the WordPress 'custom-background' theme feature.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function custom_background_setup() {

		add_theme_support(
			'custom-background',
			array(
				'default-color'    => '',
				'default-image'    => '',
				'wp-head-callback' => 'news_custom_background_callback',
			)
		);
	}

	/**
	 * Registers nav menus.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register_menus() {

		register_nav_menu( 'primary',    _x( 'Primary',    'nav menu location', 'news' ) );
		register_nav_menu( 'subsidiary', _x( 'Subsidiary', 'nav menu location', 'news' ) );
		register_nav_menu( 'social',     _x( 'Social',     'nav menu location',  'news' ) );
	}

	/**
	 * Registers image sizes.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register_image_sizes() {

		// Landscape sizes.
		set_post_thumbnail_size(              240, 135, true );
		add_image_size( 'news-landscape',     750, 422, true );
		add_image_size( 'news-landscape-2x', 1500, 844, true );

		// Old sizes.
	//	add_image_size( 'news-slideshow', 600, 400, true );
	//	add_image_size( 'news-slideshow-large', 640, 430, true );
	//	add_image_size( 'news-thumbnail', 100, 75, true );
	}

	/**
	 * Registers sidebars.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register_sidebars() {

		hybrid_register_sidebar(
			array(
				'id'    => 'primary',
				'title' => _x( 'Primary', 'sidebar', 'news' )
			)
		);
	}

	/**
	 * Registers widgets.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register_widgets() {

		register_widget( 'News_Widget_Popular_Tabs' );
		register_widget( 'News_Widget_Image_Stream' );
	}

	/**
	 * Registers layouts.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register_layouts() {

	}

	/**
	 * Registers scripts/styles.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register_scripts() {

		// Register scripts.
		wp_register_script( 'news', news_get_script_uri( 'theme' ), array( 'jquery' ), null, true );
		wp_register_script( 'jquery-cycle', news_get_script_uri( 'jquery-cycle' ), array( 'jquery' ), null, true );

		// Register fonts.
		hybrid_register_font( 'news', news_get_locale_font_args() );

		// Register styles.
		wp_register_style( 'font-awesome', news_get_style_uri( 'font-awesome' ) );
	//	wp_register_style( 'news-embed', news_get_style_uri( 'embed'        ) );

		if ( is_child_theme() )
			wp_register_style( 'news-child-embed', news_get_child_style_uri( 'embed' ) );
	}
}

/**
 * Gets the instance of the `News_Theme` class.  This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  2.0.0
 * @access public
 * @return object
 */
function news_theme() {
	return News_Theme::get_instance();
}

// Let's roll!
news_theme();

/* == Functions removed in 2.0.0 == */

function news_theme_setup() {}
function news_enqueue_script() {}
function news_register_image_sizes() {}
function news_register_widgets() {}
function news_nav_menu_add_items() {}
function news_singular_post_tags() {}
function news_add_span_to_tag_cloud() {}
function news_previous_comments_link_attributes() {}
function news_next_comments_link_attributes() {}
function news_get_current_comments_page() {}
function news_comment_form_defaults() {}
function news_filter_shortlink() {}
function news_video_embed_wrapper() {}
function news_embed_defaults() {}
function news_excerpt_length() {}
function news_theme_settings() {}
function news_admin_setup() {}
function news_validate_theme_settings() {}
function news_create_settings_meta_boxes() {}
function news_home_template_theme_meta_box() {}
function news_register_shortcodes() {}
function news_entry_shortlink_popup_shortcode() {}
function news_entry_print_link_shortcode() {}
function news_entry_email_link_shortcode() {}
function news_entry_mixx_link_shortcode() {}
function news_entry_delicious_link_shortcode() {}
function news_entry_digg_link_shortcode() {}
function news_entry_facebook_link_shortcode() {}
function news_entry_twitter_link_shortcode() {}
function news_slideshow_shortcode() {}
class News_Widget_Newsletter extends WP_Widget {}

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
