<?php
/**
 * Video Sidebar Template
 *
 * @package News
 * @subpackage Template
 * @since 0.1.0
 * @deprecated 0.3.0 Please include this template in your child theme if you plan to continue using it.
 */

/* Deprecated file in version 0.3.0. */
_deprecated_file( basename( __FILE__ ), '0.3.0', null, sprintf( __( 'Please copy the %s template from this theme into your child theme folder.', 'news' ), basename( __FILE__ ) ) );

if ( is_active_sidebar( 'video' ) ) : ?>

	<div id="sidebar-video" class="sidebar utility">

		<?php dynamic_sidebar( 'video' ); ?>

	</div><!-- #sidebar-video .utility -->

<?php else : ?>

	<div id="sidebar-video" class="sidebar utility">

		<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#video-tabs-1"><?php _e( 'Recent', 'news' ); ?></a></li>
					<li><a href="#video-tabs-2"><?php _e( 'Popular', 'news' ); ?></a></li>
				</ul><!-- .ui-tabs-nav -->

				<div id="video-tabs-1" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'post_type' => apply_filters( 'news_video_post_type', 'video' ), 'posts_per_page' => 3 ) ); ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<div class="<?php hybrid_entry_class(); ?>">

							<?php get_the_image( array( 'meta_key' => array( 'Thumbnail' ), 'size' => 'news-thumbnail' ) ); ?>

							<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h4>', false ) ); ?>

							<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">[entry-published]</div>' ); ?>

						</div><!-- .hentry -->

					<?php endwhile; ?>

				</div><!-- .ui-tabs-panel -->

				<div id="video-tabs-2" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'post_type' => apply_filters( 'news_video_post_type', 'video' ), 'orderby' => 'comment_count', 'posts_per_page' => 3 ) ); ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<div class="<?php hybrid_entry_class(); ?>">

							<?php get_the_image( array( 'meta_key' => array( 'Thumbnail' ), 'size' => 'news-thumbnail' ) ); ?>

							<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h4>', false ) ); ?>

							<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">[entry-published]</div>' ); ?>

						</div><!-- .hentry -->

					<?php endwhile; ?>

				</div><!-- .ui-tabs-panel -->

			</div><!-- .ui-tabs-wrap -->

		</div><!-- .ui-tabs -->

		<?php wp_reset_query(); ?>

	</div><!-- #sidebar-video .utility -->

<?php endif; ?>