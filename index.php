<?php
/**
 * Index Template
 *
 * This is the default template.  It is used when a more specific template can't be found to display
 * posts.  It is unlikely that this template will ever be used, but there may be rare cases.
 *
 * @package News
 * @subpackage Template
 */

get_header(); ?>

	<?php do_atomic( 'before_content' ); // Before content hook ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // Open content hook ?>

		<div class="hfeed">

			<?php get_template_part( 'loop-meta' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php do_atomic( 'before_entry' ); // Before entry hook ?>

					<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<?php do_atomic( 'open_entry' ); // Open entry hook ?>

						<?php echo apply_atomic_shortcode( 'entry_utility', '<div class="entry-utility">' . __( '[entry-popup-shortlink]', 'news' ) . '</div>' ); ?>

						<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>

						<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __( 'By [entry-author] on [entry-published] [entry-terms taxonomy="category" before=" in "] [entry-edit-link before=" | "]', 'news' ) . '</div>' ); ?>

						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'news' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'news' ), 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->

						<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '<span class="share">Share this on:</span> [entry-mixx-link] [entry-delicious-link] [entry-digg-link] [entry-facebook-link] [entry-twitter-link]', 'news' ) . '</div>' ); ?>

						<?php do_atomic( 'close_entry' ); // Close entry hook ?>

					</div><!-- .hentry -->

					<?php do_atomic( 'after_entry' ); // After entry hook ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // Close content hook ?>

		<?php get_template_part( 'loop-nav' ); ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // After content hook ?>

<?php get_footer(); ?>