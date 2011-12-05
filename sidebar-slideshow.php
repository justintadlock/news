<?php
/**
 * Video Sidebar Template
 *
 * The Slideshow sidebar first checks for an active sidebar of 'utility-slideshow'.  If this sidebar isn't active, it 
 * displays a tabbed recent/popular list of slideshows.  The 'utility-slideshow' sidebar isn't registered by default.  
 * If you want to use it, you must register a sidebar with that specific ID.
 *
 * @package News
 * @subpackage Template
 */

if ( is_active_sidebar( 'slideshow' ) ) : ?>

	<div id="sidebar-slideshow" class="sidebar utility">

		<?php dynamic_sidebar( 'slideshow' ); ?>

	</div><!-- #sidebar-slideshow .utility -->

<?php else : ?>

	<div id="sidebar-slideshow" class="sidebar utility">

		<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#slideshow-tabs-1"><?php _e( 'Recent', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#slideshow-tabs-2"><?php _e( 'Popular', hybrid_get_textdomain() ); ?></a></li>
				</ul><!-- .ui-tabs-nav -->

				<div id="slideshow-tabs-1" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'post_type' => apply_filters( 'news_video_post_type', 'slideshow' ), 'posts_per_page' => 3 ) ); ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<div class="<?php hybrid_entry_class(); ?>">

							<?php get_the_image( array( 'meta_key' => array( 'Thumbnail' ), 'size' => 'news-thumbnail' ) ); ?>

							<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h4>', false ) ); ?>

							<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">[entry-published]</div>' ); ?>

						</div><!-- .hentry -->

					<?php endwhile; ?>

				</div><!-- #slideshow-tabs-1 .ui-tabs-panel -->

				<div id="slideshow-tabs-2" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'post_type' => apply_filters( 'news_video_post_type', 'slideshow' ), 'orderby' => 'comment_count', 'posts_per_page' => 3 ) ); ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<div class="<?php hybrid_entry_class(); ?>">

							<?php get_the_image( array( 'meta_key' => array( 'Thumbnail' ), 'size' => 'news-thumbnail' ) ); ?>

							<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h4>', false ) ); ?>

							<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">[entry-published]</div>' ); ?>

						</div><!-- .hentry -->

					<?php endwhile; ?>

				</div><!-- #slideshow-tabs-2 .ui-tabs-panel -->

			</div><!-- .ui-tabs-wrap -->

		</div><!-- .ui-tabs -->

		<?php wp_reset_query(); ?>

	</div><!-- #sidebar-slideshow .utility -->

<?php endif; ?>