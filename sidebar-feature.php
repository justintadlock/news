<?php
/**
 * Feature Sidebar Template
 *
 * The Feature sidebar first checks for an active sidebar of 'utility-feature'.  If this sidebar isn't
 * active, it displays a list of top articles from the month.  The 'utility-feature' sidebar isn't registered
 * by default.  If you want to use it, you must register a sidebar with that specific ID.
 *
 * @package News
 * @subpackage Template
 */

if ( is_active_sidebar( 'feature' ) ) : ?>

	<div id="sidebar-feature" class="sidebar utility">

		<?php dynamic_sidebar( 'feature' ); ?>

	</div><!-- #sidebar-feature .utility -->

<?php else : ?>

	<div id="sidebar-feature" class="sidebar utility">

		<div class="widget widget-top-articles">

			<div class="widget-inside">

				<h3 class="widget-title"><?php _e( 'Top Articles', hybrid_get_textdomain() ); ?></h3>

				<?php $loop = new WP_Query( array( 'meta_key' => 'Views', 'orderby' => 'meta_value', 'monthnum' => date( 'm' ), 'posts_per_page' => 3 ) ); ?>

				<?php if ( !$loop->have_posts() ) $loop = new WP_Query( array( 'orderby' => 'comment_count', 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) ); ?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<div class="<?php hybrid_entry_class(); ?>">

						<?php get_the_image( array( 'meta_key' => array( 'Thumbnail' ), 'size' => 'news-thumbnail' ) ); ?>

						<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h4>', false ) ); ?>

						<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">[entry-published]</div>' ); ?>

					</div><!-- .hentry -->

				<?php endwhile; ?>

				<?php $view_more = news_get_post_by_meta( '_wp_page_template', 'page-template-popular.php' ); ?>

				<?php if ( !empty( $view_more ) ) { ?>
					<a class="view-more" href="<?php echo get_permalink( $view_more ); ?>" title="<?php esc_attr_e( 'View more popular posts', hybrid_get_textdomain() ); ?>"><?php _e( 'View More', hybrid_get_textdomain() ); ?></a>
				<?php } ?>

			</div><!-- .widget-inside -->

		</div><!-- .widget -->

		<?php wp_reset_query(); ?>

	</div><!-- #sidebar-feature .utility -->

<?php endif; ?>