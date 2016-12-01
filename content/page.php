<article <?php hybrid_attr( 'post' ); ?>>

<?php if ( is_singular( get_post_type() ) ) : ?>

	<header class="entry-header">

						<h1 class="entry-title"><?php single_post_title(); ?></h1>
	</header>

						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'news' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'news' ), 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->

<?php else : ?>

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

<?php endif; ?>

</article>
