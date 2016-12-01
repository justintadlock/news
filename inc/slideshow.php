<?php


//add_filter( 'post_gallery', 'news_gallery_slideshow', 95, 2 );

function news_gallery_slideshow( $output, $attr ) {

	// We're not worried about galleries in feeds, so just return the output here.
	if ( is_feed() )
		return $output;

	// Orderby.
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	// Default gallery settings.
	$defaults = array(
		'order'       => 'ASC',
		'orderby'     => 'menu_order ID',
		'id'          => get_the_ID(),
		'link'        => '',
		'itemtag'     => 'figure',
		'icontag'     => 'div',
		'captiontag'  => 'figcaption',
		'columns'     => 3,
		'size'        => has_image_size( 'post-thumbnail' ) ? 'post-thumbnail' : 'thumbnail',
		'ids'         => '',
		'include'     => '',
		'exclude'     => '',
		'numberposts' => -1,
		'offset'      => ''
	);

	// Merge the defaults with user input.
	$args = shortcode_atts( $defaults, $attr );

	// Make sure the post ID is a valid integer.
	$args['size']       = 'extant-landscape';
	$args['id']         = intval( $args['id'] );
	$args['itemtag']    = tag_escape( $args['itemtag'] );
	$args['icontag']    = tag_escape( $args['icontag'] );
	$args['captiontag'] = tag_escape( $args['captiontag'] );

	// Set up the query arguments for getting the attachments.
	$children = array(
		'post_status'      => 'inherit',
		'post_type'        => 'attachment',
		'post_mime_type'   => 'image',
		'order'            => $args['order'],
		'orderby'          => $args['orderby'],
		'exclude'          => $args['exclude'],
		'include'          => $args['include'],
		'numberposts'      => $args['numberposts'],
		'offset'           => $args['offset'],
		'suppress_filters' => true
	);

	// If specific IDs should not be included, use the get_children() function.
	if ( empty( $args['include'] ) ) {
		$attachments = get_children( array_merge( array( 'post_parent' => $args['id'] ), $children ) );
	}

	// If getting specific attachments by ID, use get_posts().
	else {
		$attachments = get_posts( $children );
	}

	// If there are no attachments, return an empty string.
	if ( empty( $attachments ) )
		return '';

	wp_enqueue_script( 'jquery-cycle' );

	$output = '';

	// Get each gallery item.
	foreach ( $attachments as $attachment ) {

		// Get the image if it should link to the image file.
		if ( isset( $args['link'] ) && 'file' == $args['link'] ) {
			$image = wp_get_attachment_link( $attachment->ID, $args['size'], false, true );
		}

		// Else if, get the image if it should link to nothing.
		elseif ( isset( $args['link'] ) && 'none' == $args['link'] ) {
			$image = wp_get_attachment_image( $attachment->ID, $args['size'], false );
		}

		// Else, get the image (links to attachment page).
		else {
			$image = wp_get_attachment_link( $attachment->ID, $args['size'], true, true );
		}

		// Get the caption.
		$caption = wptexturize( $attachment->post_excerpt );

		// Open each gallery item.
		$output .= sprintf( '<%s class="slideshow-item">', $args['itemtag'] );

		// Open the gallery icon element.
		$output .= sprintf( '<%1$s class="slideshow-icon">%2$s</%1$s>', $args['icontag'], $image );

		// If image caption is set, format and return.
		if ( $caption )
			$output .= sprintf( '<%1$s class="slideshow-caption cycle-caption">%2$s</%1$s>', $args['captiontag'], $caption );

		// Close individual gallery item.
		$output .= "</{$args['itemtag']}>";
	}

	return sprintf(
		'<div class="slideshow"><div
			class="wrap cycle-slideshow"
			data-cycle-slides="figure"
			data-cycle-timeout="0"
			data-cycle-auto-height="container"
			data-cycle-prev=".slideshow-prev"
			data-cycle-next=".slideshow-next"
			data-cycle-caption=".slideshow-count"
			data-cycle-caption-template="<span class=\'slide-count-num\'>{{slideNum}}</span><span class=\'slide-count-sep\'>/</span><span class=\'slide-count-total\'>{{slideCount}}</span>"

		>%s
		</div>
		<div class="slideshow-nav">
			<span class="slideshow-count"></span>
			<button type="button" class="slideshow-prev"><span class="screen-reader-text">%s</span></button>
			<button type="button" class="slideshow-next"><span class="screen-reader-text">%s</span></button>
		</div></div>',
		$output, esc_html__( 'Previous Slide', 'news' ), esc_html__( 'Next Slide', 'news' ) );
}










