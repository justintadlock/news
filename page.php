<?php
/**
 * Page Template
 *
 * This is the default page template.  It is used when a more-specific page template isn't used.
 *
 * @package News
 * @subpackage Template
 */

get_header(); ?>

	<?php do_atomic( 'before_content' ); // Before content hook ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // Open content hook ?>

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php do_atomic( 'before_loop' ); // Before loop hook ?>

					<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<?php do_atomic( 'open_loop' ); // Open loop hook ?>

						<?php echo apply_atomic_shortcode( 'entry_utility', '<div class="entry-utility">' . __( '[entry-print-link] [entry-email-link] [entry-popup-shortlink] [entry-edit-link before="| "]', 'news' ) . '</div>' ); ?>

						<?php echo apply_atomic( 'entry_title', the_title( '<h1 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h1>', false ) ); ?>

						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'news' ), 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->

						<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '<span class="share">Share this on:</span> [entry-mixx-link] [entry-delicious-link] [entry-digg-link] [entry-facebook-link] [entry-twitter-link]', 'news' ) . '</div>' ); ?>

						<?php do_atomic( 'close_loop' ); // Close loop hook ?>

					</div><!-- .hentry -->

					<?php do_atomic( 'after_loop' ); // After loop hook ?>

					<?php get_sidebar( 'after-singular' ); ?>

					<?php do_atomic( 'after_singular' ); // After singular hook ?>

					<?php comments_template( '/comments.php', true ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // Close content hook ?>

		<?php get_template_part( 'loop-nav' ); ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // After content hook ?>

<?php get_footer(); ?>