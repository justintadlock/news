<?php
/**
 * Handles the theme's theme customizer functionality.
 *
 * @package    News
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @author     Tung Do <ttsondo@gmail.com>
 * @copyright  Copyright (c) 2010-2016
 * @link       http://themehybrid.com/themes/news
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  2.0.0
 * @access public
 */
final class News_Customize {

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
	 * Sets up initial actions.
	 *
	 * @since  2.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'panels'   ) );
		add_action( 'customize_register', array( $this, 'sections' ) );
		add_action( 'customize_register', array( $this, 'settings' ) );
		add_action( 'customize_register', array( $this, 'controls' ) );
		add_action( 'customize_register', array( $this, 'partials' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_control_scripts' ), 0 );

		// Enqueue scripts and styles for the preview.
		add_action( 'customize_preview_init', array( $this, 'preview_enqueue' ) );
	}

	/**
	 * Sets up the customizer panels.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function panels( $manager ) {

		$manager->add_panel(
			'theme_options',
			array(
				'priority' => 5,
				'title'    => __( 'Theme Options', 'news' )
			)
		);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( news_theme()->dir_path . 'inc/customize/section-locked.php' );

		// Register custom section types.
		$manager->register_section_type( 'News_Customize_Section_Locked' );

		// Move theme-specific sections to our theme options panel.
		$manager->get_section( 'header_image' )->panel     = 'theme_options';
		$manager->get_section( 'background_image' )->panel = 'theme_options';
		$manager->get_section( 'layout' )->panel           = 'theme_options';
		$manager->get_section( 'colors' )->panel           = 'theme_options';

		// Change active callback of sections.
		$manager->get_section( 'background_image' )->active_callback = 'news_is_boxed';

		/* === Custom Sections === */

		$manager->add_section(
			'icons',
			array(
				'panel' => 'theme_options',
				'title' => __( 'Icons', 'news' )
			)
		);

		$manager->add_section(
			new News_Customize_Section_Locked(
				$manager,
				'pro_options',
				array(
					'panel'           => 'theme_options',
					'priority'        => 995,
					'title'           => esc_html__( 'Go Pro', 'news' ),
					'button'          => esc_html__( 'Unlock', 'news' ),
					'active_callback' => array( $this, 'show_pro_options' )
				)
			)
		);
	}

	/**
	 * Sets up the customizer settings.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function settings( $manager ) {

		// Set the transport property of existing settings.
		$manager->get_setting( 'blogname' )->transport              = 'postMessage';
		$manager->get_setting( 'blogdescription' )->transport       = 'postMessage';
		$manager->get_setting( 'background_color' )->transport      = 'postMessage';
		$manager->get_setting( 'background_image' )->transport      = 'postMessage';
		$manager->get_setting( 'background_position_x' )->transport = 'postMessage';
		$manager->get_setting( 'background_repeat' )->transport     = 'postMessage';
		$manager->get_setting( 'background_attachment' )->transport = 'postMessage';
		$manager->get_setting( 'theme_layout' )->transport          = 'refresh';

		/* === Layouts === */

		$manager->add_setting(
			'layout_type',
			array(
				'default'              => news_get_layout_type(),
				'sanitize_callback'    => 'news_validate_layout_type',
				'sanitize_js_callback' => 'news_validate_layout_type',
				'transport'            => 'postMessage'
			)
		);

		/* === Icons === */

		$manager->add_setting(
			'show_header_icon',
			array(
				'default'           => news_show_header_icon(),
				'sanitize_callback' => 'wp_validate_boolean',
				'transport'         => 'postMessage'
			)
		);

		$icons = array(
			'header_icon'         => news_get_header_icon(),
			'menu_primary_icon'   => news_get_menu_primary_icon(),
			'menu_secondary_icon' => news_get_menu_secondary_icon(),
			'menu_search_icon'    => news_get_menu_search_icon()
		);

		foreach ( $icons as $setting => $default ) {

			$manager->add_setting(
				$setting,
				array(
					'default'            => $default,
					'sanitize_callback'  => 'news_validate_font_icon',
					'transport'          => 'postMessage',
				)
			);
		}

		/* === Pro === */

		$manager->add_setting( new WP_Customize_Filter_Setting( $manager, 'go_pro' ) );
	}

	/**
	 * Sets up the customizer controls.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function controls( $manager ) {

		// Load custom controls.
		require_once( news_theme()->dir_path . 'inc/customize/control-select-icon.php' );
		require_once( news_theme()->dir_path . 'inc/customize/control-custom-html.php' );

		// Register custom control types.
		$manager->register_control_type( 'News_Customize_Control_Select_Icon' );
		$manager->register_control_type( 'News_Customize_Control_Custom_HTML' );

		// Change active callback of controls.
		$manager->get_control( 'background_color' )->active_callback = 'news_is_boxed';

		/* == Layouts == */

		$manager->add_control(
			'layout_type',
			array(
				'label'           => esc_html__( 'Layout Type', 'news' ),
				'section'         => 'layout',
				'type'            => 'radio',
				'choices'         => news_get_layout_types()
			)
		);

		/* === Icons === */

		$manager->add_control(
			'show_header_icon',
			array(
				'label'           => esc_html__( 'Always Display Header Icon', 'news' ),
				'description'     => __( 'Icon is only shown on mobile devices by default.', 'news' ),
				'section'         => 'icons',
				'type'            => 'checkbox'
			)
		);

		$icons = array(
			'header_icon'         => esc_html__( 'Header Icon',         'news' ),
			'menu_primary_icon'   => esc_html__( 'Primary Menu Icon',   'news' ),
			'menu_secondary_icon' => esc_html__( 'Secondary Menu Icon', 'news' ),
			'menu_search_icon'    => esc_html__( 'Search Menu Icon',    'news' )
		);

		foreach ( $icons as $control => $label ) {

			$manager->add_control(
				new News_Customize_Control_Select_Icon(
					$manager,
					$control,
					array( 'label' => $label )
				)
			);
		}

		/* === Pro Options === */

		$manager->add_control(
			new News_Customize_Control_Custom_HTML(
				$manager,
				'go_pro',
				array(
					'section' => 'pro_options',
					'label'   => esc_html__( 'Go Pro', 'news' ),
					'html'    => $this->get_custom_control_html()
				)
			)
		);
	}

	/**
	 * Sets up the customizer partials.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function partials( $manager ) {

		$manager->selective_refresh->add_partial(
			'header_icon',
			array(
				'selector'            => '.site-title i',
				'container_inclusive' => true,
				'render_callback'     => 'news_get_header_i'
			)
		);

		$manager->selective_refresh->add_partial(
			'menu_primary_icon',
			array(
				'selector'            => '.menu-toggle-primary button i',
				'container_inclusive' => true,
				'render_callback'     => 'news_get_menu_primary_i'
			)
		);

		$manager->selective_refresh->add_partial(
			'menu_secondary_icon',
			array(
				'selector'            => '.menu-toggle-secondary button i',
				'container_inclusive' => true,
				'render_callback'     => 'news_get_menu_secondary_i'
			)
		);

		$manager->selective_refresh->add_partial(
			'menu_search_icon',
			array(
				'selector'            => '.menu-toggle-search button i',
				'container_inclusive' => true,
				'render_callback'     => 'news_get_menu_search_i'
			)
		);
	}

	/**
	 * Whether to show the pro options.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return bool
	 */
	public function show_pro_options() {

		return ! news_is_pro();
	}

	/**
	 * Returns the HTML for the custom HTML control.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return string
	 */
	public function get_custom_control_html() {

		$html = sprintf(
			'<p>%s</p>
			 <p>%s</p>
			 <p><a class="button button-primary" href="http://themehybrid.com/club" target="_blank">%s</a></p>',
			__( 'I have never been a fan of crippleware (i.e., "lite" themes) that upsell you all the cool stuff. With the News theme, you get the full theme.', 'news' ),
			__( 'Instead, let me offer you a full year of dedicated support (forums and live chat). This includes support for all of my themes and plugins.', 'news' ),
			__( 'Join The Club', 'news' )
		);

		return $html;
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register_control_scripts() {

		wp_register_script( 'news-customize-controls', news_get_script_uri( 'customize-controls' ), array( 'customize-controls' ), null, true );

		wp_register_style( 'font-awesome',              news_get_style_uri( 'font-awesome'       ) );
		wp_register_style( 'news-customize-controls', news_get_style_uri( 'customize-controls' ) );
	}

	/**
	 * Loads theme customizer JavaScript.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function preview_enqueue() {

		wp_enqueue_script( 'news-customize-preview', news_get_script_uri( 'customize-preview' ), array( 'jquery' ), null, true );
	}
}

// Doing this customizer thang!
News_Customize::get_instance();
