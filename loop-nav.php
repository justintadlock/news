<?php
/**
 * Loop Nav Template
 *
 * This template is used to show your your next/previous post links on singular pages and
 * the next/previous posts links on the home/posts page and archive pages.
 *
 * @package News
 * @subpackage Template
 */
?>

	<?php if ( is_singular( 'post' ) ) : ?>

		<div class="loop-nav navigation-links">
			<?php previous_post_link( '%link', '<span class="previous">' . __( '&larr; Previous', hybrid_get_textdomain() ) . '</span>' ); ?>
			<?php next_post_link( '%link', '<span class="next">' . __( 'Next &rarr;', hybrid_get_textdomain() ) . '</span>' ); ?>
		</div><!-- .navigation-links -->

	<?php elseif ( !is_singular() && current_theme_supports( 'loop-pagination' ) ) : loop_pagination(); ?>

	<?php elseif ( !is_singular() && $nav = get_posts_nav_link( array( 'sep' => '', 'prelabel' => '<span class="previous">' . __( '&larr; Previous', hybrid_get_textdomain() ) . '</span>', 'nxtlabel' => '<span class="next">' . __( 'Next &rarr;', hybrid_get_textdomain() ) . '</span>' ) ) ) : ?>

		<div class="loop-nav navigation-links">
			<?php echo $nav; ?>
		</div><!-- .navigation-links -->

	<?php endif; ?>