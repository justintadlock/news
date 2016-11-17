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

	<div id="content" class="site-content">

		<div class="wrap">

	<?php if ( ! is_front_page() && hybrid_is_plural() ) : // If viewing a multi-post page ?>

		<?php locate_template( array( 'misc/loop-meta.php' ), true ); // Loads the misc/loop-meta.php template. ?>

	<?php endif; // End check for multi-post page. ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php hybrid_get_content_template(); ?>

			<?php if ( is_singular() ) : // If viewing a single post/page/CPT. ?>

				<?php comments_template( '', true ); // Loads the comments.php template. ?>

			<?php endif; // End check for single post. ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); ?>