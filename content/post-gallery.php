<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

		</header><!-- .entry-header -->

		<?php add_filter( 'post_gallery', 'news_gallery_slideshow', 95, 2 ); ?>

		<?php echo hybrid_media_grabber(
			array(
				'type'        => 'gallery',
				'split_media' => true,
			//	'before'      => '<div class="featured-media">',
			//	'after'       => '</div>'
			)
		); ?>

		<?php remove_filter( 'post_gallery', 'news_gallery_slideshow', 95 ); ?>

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<span class="entry-share">
	<?php _e( 'Share on:', 'news' ); ?>

<!-- Sharingbutton Facebook -->
<a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php" target="_blank" aria-label="Facebook">
Facebook</a>
<a href="#">Twitter</a>
</span>
		</footer><!-- .entry-footer -->

	<?php else : // If not viewing a single post. ?>

	<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

			<div class="entry-byline">
				<?php hybrid_post_author(); ?>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<?php comments_popup_link( false, false, false, 'comments-link' ); ?>
			</div><!-- .entry-byline -->

	<?php get_the_image( array( 'size' => 'extant-landscape' ) ); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->


	<?php endif; // End single post check. ?>

</article><!-- .entry -->
