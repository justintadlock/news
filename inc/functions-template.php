<?php
/**
 * Functions for use within theme templates.
 *
 * @package    News
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @author     Tung Do <ttsondo@gmail.com>
 * @copyright  Copyright (c) 2010-2016
 * @link       http://themehybrid.com/themes/news
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function news_get_feature_recent_query_args() {

	return array(
		'posts_per_page' => 3,
		'ignore_sticky_posts' => true,
		'post__not_in' => array( get_queried_object_id() ),
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => 'post-format-' . get_post_format( get_queried_object_id() ),
			),
		)
	);
}

function news_get_feature_popular_query_args() {

	return array(
		'posts_per_page' => 3,
		'ignore_sticky_posts' => true,
		'post__not_in' => array( get_queried_object_id() ),
		'orderby' => 'comment_count',
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => 'post-format-' . get_post_format( get_queried_object_id() ),
			),
		)
	);
}

/**
 * Prints the the post comments link.  Wrapper for `comments_popup_link()`.  This function
 * doesn't output anything if there are no comments and comments are closed.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function news_comments_link( $args = array() ) {

	if ( ! get_comments_number() && ! comments_open() )
		return;

	$defaults = array(
		'zero'      => false,
		'one'       => false,
		'more'      => false,
		'css_class' => 'comments-link',
		'none'      => false,
		'before'    => '',
		'after'     => ''
	);

	$args = wp_parse_args( $args, $defaults );

	echo $args['before'];

	comments_popup_link( $args['zero'], $args['one'], $args['more'], $args['css_class'], $args['none'] );

	echo $args['after'];
}

/**
 * Prints the the post format permalink.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function news_post_format_permalink() {
	echo news_get_post_format_permalink();
}

/**
 * Returns the post permalink (URL) with the post format as the link text.
 *
 * @since  2.0.0
 * @access public
 * @return string
 */
function news_get_post_format_permalink() {

	$format = get_post_format();

	return $format ? sprintf( '<a href="%s" class="post-format-permalink"><span class="screen-reader-text">%s</span></a>', esc_url( get_permalink() ), get_post_format_string( $format ) ) : '';
}


function news_get_max_num_pages() {

	return absint( $GLOBALS['wp_query']->max_num_pages );
}

function news_get_current_page() {

	$page = absint( get_query_var( 'paged' ) );

	return $page ? $page : 1;
}

add_filter( 'navigation_markup_template', 'news_navigation_markup_template' );

function news_navigation_markup_template( $template ) {

	return str_replace( 'screen-reader-text', 'page-count', $template );
}

function news_post_print_link() {
	echo news_get_post_print_link();
}

function news_get_post_print_link() {

	return '<a class="post-print-link hide-if-no-js" href="#">' . __( 'Print', 'news' ) . '</a>';
}

function news_post_email_link() {
	echo news_get_post_email_link();
}

function news_get_post_email_link() {
	$subject = urlencode( esc_attr( '[' . get_bloginfo( 'name' ) . ']' . the_title_attribute( 'echo=0' ) ) );
	$body = urlencode( esc_attr( sprintf( __( 'Check out this post: %1$s', 'news' ), get_permalink( get_the_ID() ) ) ) );
	return '<a class="post-email-link" href="mailto:?subject=' . $subject . '&amp;body=' . $body . '">' . __( 'Email', 'news' ) . '</a>';
}

function news_comment_policy_link() {

	echo news_get_comment_policy_link();
}

function news_get_comment_policy_link() {

	$link    = '';
	$post_id = news_get_comment_policy_post_id();

	if ( $post_id > 0 )
		$link = sprintf( '<a href="%s" class="comment-policy-link">%s</a>', esc_url( get_permalink( $post_id ) ), esc_html( get_post_field( 'post_title', $post_id ) ) );

	return apply_filters( 'news_get_comment_policy_link', $link, $post_id );
}

add_action( 'comment_form', 'news_output_comment_policy', 0 );

function news_output_comment_policy() {

	if ( $link = news_get_comment_policy_link() )
		printf( '<p class="comment-form-policy">%s</p>', $link );
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
