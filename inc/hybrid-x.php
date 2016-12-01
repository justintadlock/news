<?php
/**
 * Note: Experimental functions proposed for next version of the Hybrid Core framework.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * This is a wrapper function for core WP's `get_theme_mod()` function.  Core doesn't
 * provide a filter hook for the default value (useful for child themes).  The purpose
 * of this function is to provide that additional filter hook.  To filter the final
 * theme mod, use the core `theme_mod_{$name}` filter hook.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $name
 * @param  mixed   $default
 * @return mixed
 */
function hybrid_get_theme_mod( $name, $default = false ) {

	return get_theme_mod( $name, apply_filters( "hybrid_theme_mod_{$name}_default", $default ) );
}

function hybrid_has_body_class( $class ) {

	return in_array( $class, get_body_class() );
}

function hybrid_has_post_class( $class, $post_id = null ) {

	return in_array( $class, get_post_class( '', $post_id ) );
}

function hybrid_has_comment_class( $class, $comment_id = null, $post_id = null ) {

	return in_array( $class, get_comment_class( '', $comment_id, $post_id ) );
}

/**
 * Checks if the current layout matches the layout to check against.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $layout
 * @return bool
 */
function hybrid_is_layout( $layout ) {

	return $layout === hybrid_get_theme_layout();
}

/**
 * Conditional check to determine if we are in script debug mode.  This is generally used
 * to decide whether to load development versions of scripts/styles.
 *
 * @since  2.0.0
 * @access public
 * @return bool
 */
function hybrid_is_script_debug() {

	return apply_filters( 'hybrid_is_script_debug', defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
}

/**
 * Replaces `%1$s` and `%2$s` with the template and stylesheet directory paths.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $value
 * @return string
 */
function hybrid_sprintf_theme_dir( $value ) {

	return sprintf( $value, get_template_directory(), get_stylesheet_directory() );
}

/**
 * Replaces `%1$s` and `%2$s` with the template and stylesheet directory URIs.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $value
 * @return string
 */
function hybrid_sprintf_theme_uri( $value ) {

	return sprintf( $value, get_template_directory_uri(), get_stylesheet_directory_uri() );
}

/**
 * Gets the embed template used for embedding posts from the site.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function hybrid_get_embed_template() {

	// Set up an empty array and get the post type.
	$templates = array();
	$post_type = get_post_type();

	// Assume the theme developer is creating an attachment template.
	if ( 'attachment' === $post_type ) {
		remove_filter( 'the_content',       'prepend_attachment'          );
		remove_filter( 'the_excerpt_embed', 'wp_embed_excerpt_attachment' );

		$type = hybrid_get_attachment_type();

		$templates[] = "embed-attachment-{$type}.php";
		$templates[] = "embed/attachment-{$type}.php";
	}

	// If the post type supports 'post-formats', get the template based on the format.
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		// Get the post format.
		$post_format = get_post_format() ? get_post_format() : 'standard';

		// Template based off post type and post format.
		$templates[] = "embed-{$post_type}-{$post_format}.php";
		$templates[] = "embed/{$post_type}-{$post_format}.php";

		// Template based off the post format.
		$templates[] = "embed-{$post_format}.php";
		$templates[] = "embed/{$post_format}.php";
	}

	// Template based off the post type.
	$templates[] = "embed-{$post_type}.php";
	$templates[] = "embed/{$post_type}.php";

	// Fallback 'embed/content.php' template.
	$templates[] = 'embed/content.php';

	// Apply filters to the templates array.
	$templates = apply_filters( 'hybrid_embed_template_hierarchy', $templates );

	// Locate the template.
	$template = locate_template( $templates );

	// If template is found, include it.
	if ( apply_filters( 'hybrid_embed_template', $template, $templates ) )
		include( $template );
}


/**
 * Checks if a widget exists.  Pass in the widget class name.  This function is useful for
 * checking if the widget exists before directly calling `the_widget()` within a template.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $widget
 * @return bool
 */
function hybrid_widget_exists( $widget ) {

	return isset( $GLOBALS['wp_widget_factory']->widgets[ $widget ] );
}

/**
 * Prints the comment parent link.
 *
 * @since  2.0.0
 * @access public
 * @param  array   $args
 * @return void
 */
function hybrid_comment_parent_link( $args = array() ) {

	echo hybrid_get_comment_parent_link( $args );
}

/**
 * Returns the comment parent link.
 *
 * @since  2.0.0
 * @access public
 * @param  array   $args
 * @return string
 */
function hybrid_get_comment_parent_link( $args = array() ) {

	$link = '';

	$defaults = array(
		'text'   => '%s', // Defaults to comment author.
		'depth'  => 2,    // At what level should the link show.
		'before' => '',
		'after'  => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( $args['depth'] <= $GLOBALS['comment_depth'] ) {

		$parent = get_comment()->comment_parent;

		if ( 0 < $parent ) {

			$url  = esc_url( get_comment_link( $parent ) );
			$text = sprintf( $args['text'], esc_html( get_comment_author( $parent ) ) );

			$link = sprintf( '%s<a class="comment-parent-link" href="%s">%s</a>%s', $args['before'], $url, $text, $args['after'] );
		}
	}

	return apply_filters( 'news_comment_parent_link', $link, $args );
}
