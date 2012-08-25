<?php
/**
 * Plugin Name: News Post Types
 * Plugin URI: http://justintadlock.com/archives/2009/09/17/members-wordpress-plugin
 * Description: Registers post types for the News theme for backward compatibility with the original theme release.
 * Version: 0.1
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
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
 * @package NewsPostTypes
 * @version 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2010 - 2012
 * @link http://themehybrid.com/themes/news
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom post types. */
add_action( 'init', 'news_register_post_types' );

/**
 * Registers custom post types.  We're registering the Video and Slideshow post types.
 *
 * @since 0.1.0
 */
function news_register_post_types() {

	/* Labels for the video post type. */
	$video_labels = array(
		'name' => __( 'Videos', 'news' ),
		'singular_name' => __( 'Video', 'news' ),
		'add_new' => __( 'Add New', 'news' ),
		'add_new_item' => __( 'Add New Video', 'news' ),
		'edit' => __( 'Edit', 'news' ),
		'edit_item' => __( 'Edit Video', 'news' ),
		'new_item' => __( 'New Video', 'news' ),
		'view' => __( 'View Video', 'news' ),
		'view_item' => __( 'View Video', 'news' ),
		'search_items' => __( 'Search Videos', 'news' ),
		'not_found' => __( 'No videos found', 'news' ),
		'not_found_in_trash' => __( 'No videos found in Trash', 'news' ),
	);

	/* Arguments for the video post type. */
	$video_args = array(
		'labels' => $video_labels,
		'capability_type' => 'post',
		'public' => true,
		'can_export' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'videos', 'with_front' => false ),
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments', 'trackbacks', 'entry-views' ),
	);

	/* Labels for the slideshow post type. */
	$slideshow_labels = array(
		'name' => __( 'Slideshows', 'news' ),
		'singular_name' => __( 'Slideshow', 'news' ),
		'add_new' => __( 'Add New', 'news' ),
		'add_new_item' => __( 'Add New Slideshow', 'news' ),
		'edit' => __( 'Edit', 'news' ),
		'edit_item' => __( 'Edit Slideshow', 'news' ),
		'new_item' => __( 'New Slideshow', 'news' ),
		'view' => __( 'View Slideshow', 'news' ),
		'view_item' => __( 'View Slideshow', 'news' ),
		'search_items' => __( 'Search Slideshows', 'news' ),
		'not_found' => __( 'No slideshows found', 'news' ),
		'not_found_in_trash' => __( 'No slideshows found in Trash', 'news' ),
	);

	/* Arguments for the slideshow post type. */
	$slideshow_args = array(
		'labels' => $slideshow_labels,
		'capability_type' => 'post',
		'public' => true,
		'can_export' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'slideshows', 'with_front' => false ),
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments', 'trackbacks', 'entry-views' ),
	);

	/* Register the video post type. */
	register_post_type( apply_filters( 'news_video_post_type', 'video' ), apply_filters( 'news_video_post_type_args', $video_args ) );

	/* Register the slideshow post type. */
	register_post_type( apply_filters( 'news_slideshow_post_type', 'slideshow' ), apply_filters( 'news_slideshow_post_type_args', $slideshow_args ) );
}

?>