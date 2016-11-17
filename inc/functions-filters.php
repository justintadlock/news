<?php
/**
 * Filters the theme adds.
 *
 * @package    News
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @author     Tung Do <ttsondo@gmail.com>
 * @copyright  Copyright (c) 2010-2016
 * @link       http://themehybrid.com/themes/news
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Filter the image sizes to choose from.
add_filter( 'image_size_names_choose', 'news_image_size_names_choose', 5 );

# Removes core's embed meta. We're rolling our own.
//remove_action( 'embed_content_meta', 'print_embed_comments_button' );
//remove_action( 'embed_content_meta', 'print_embed_sharing_button'  );

# Embed wrap.
add_filter( 'embed_oembed_html', 'news_maybe_wrap_embed', 10, 2 );

# Prev/Next comments link attributes.
add_filter( 'previous_comments_link_attributes', 'news_prev_comments_link_attr' );
add_filter( 'next_comments_link_attributes',     'news_next_comments_link_attr' );

/**
 * Wraps embeds with `.embed-wrap` class.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $html
 * @return string
 */
function news_wrap_embed_html( $html ) {

	return $html && is_string( $html ) ? sprintf( '<div class="embed-wrap">%s</div>', $html ) : $html;
}

/**
 * Checks embed URL patterns to see if they should be wrapped in some special HTML, particularly
 * for responsive videos.
 *
 * @author     Automattic
 * @link       http://jetpack.me
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since  2.0.0
 * @access public
 * @param  string  $html
 * @param  string  $url
 * @return string
 */
function news_maybe_wrap_embed( $html, $url ) {

	if ( ! $html || ! is_string( $html ) || ! $url )
		return $html;

	$do_wrap = false;

	$patterns = array(
		'#http://((m|www)\.)?youtube\.com/watch.*#i',
		'#https://((m|www)\.)?youtube\.com/watch.*#i',
		'#http://((m|www)\.)?youtube\.com/playlist.*#i',
		'#https://((m|www)\.)?youtube\.com/playlist.*#i',
		'#http://youtu\.be/.*#i',
		'#https://youtu\.be/.*#i',
		'#https?://(.+\.)?vimeo\.com/.*#i',
		'#https?://(www\.)?dailymotion\.com/.*#i',
		'#https?://dai.ly/*#i',
		'#https?://(www\.)?hulu\.com/watch/.*#i',
		'#https?://wordpress.tv/.*#i',
		'#https?://(www\.)?funnyordie\.com/videos/.*#i',
		'#https?://vine.co/v/.*#i',
		'#https?://(www\.)?collegehumor\.com/video/.*#i',
		'#https?://(www\.|embed\.)?ted\.com/talks/.*#i'
	);

	$patterns = apply_filters( 'news_maybe_wrap_embed_patterns', $patterns );

	foreach ( $patterns as $pattern ) {

		$do_wrap = preg_match( $pattern, $url );

		if ( $do_wrap )
			return news_wrap_embed_html( $html );
	}

	return $html;
}

/**
 * Adds a custom class to the previous comments link.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function news_prev_comments_link_attr( $attr ) {

	return $attr .= ' class="prev-comments-link"';
}

/**
 * Adds a custom class to the next comments link.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function news_next_comments_link_attr( $attr ) {

	return $attr .= ' class="next-comments-link"';
}

/**
 * Filters the WordPress image selector to add custom image sizes.
 *
 * @since  2.0.0
 * @access public
 * @param  array  $sizes
 * @return array
 */
function news_image_size_names_choose( $sizes ) {

	$sizes['news-landscape'] = esc_html__( 'Landscape', 'news' );

	return $sizes;
}
