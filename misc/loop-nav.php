<?php if ( hybrid_is_plural() ) : // If viewing the blog, an archive, or search results. ?>

	<?php the_posts_pagination(
		array(
			'type'      => 'list',
			'prev_text' => _x( 'Newer', 'posts navigation', 'extant' ),
			'next_text' => _x( 'Older', 'posts navigation', 'extant' ),
			'screen_reader_text' => sprintf( esc_html__( 'Page %1$s of %2$s:', 'news' ), news_get_current_page(), news_get_max_num_pages() )
		)
	); ?>

<?php endif; // End check for type of page being viewed. ?>
