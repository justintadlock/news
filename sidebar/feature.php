<aside <?php hybrid_attr( 'sidebar', 'feature' ); ?>>

	<?php if ( is_front_page() ) : ?>

	<section class="widget widget-popular">

		<h3 class="widget-title"><?php esc_html_e( 'Popular Articles', 'news' ); ?></h3>

		<div class="widget-content">

		<?php $loop = new WP_Query( array( 'orderby' => 'comment_count', 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) ); ?>

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<article <?php hybrid_attr( 'post' ); ?>>

				<?php get_the_image(); ?>

				<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<div class="entry-byline">
					<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				</div><!-- .entry-byline -->

			</article>

		<?php endwhile; wp_reset_postdata(); ?>

		</div>

	</section>

	<?php elseif ( is_single() && has_post_format() ) : ?>

	<h3 id="sidebar-feature-title" class="screen-reader-text">
		<?php _ex( 'Featured Sidebar', 'sidebar title', 'news' ); ?>
	</h3>

	<section class="news-tabs">

		<ul class="news-tabs-nav">
			<li class="news-tabs-title"><a href="#news-tabs-feature-recent"><?php esc_html_e( 'Recent', 'news' ); ?></a></li>
			<li class="news-tabs-title"><a href="#news-tabs-feature-popular"><?php esc_html_e( 'Popular', 'news' ); ?></a></li>
		</ul>

		<div class="news-tabs-wrap">

			<div id="news-tabs-feature-recent" class="news-tabs-content">

				<?php $loop = new WP_Query( news_get_feature_recent_query_args() ); ?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<article <?php hybrid_attr( 'post' ); ?>>

						<?php get_the_image(); ?>

						<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

						<div class="entry-byline">
							<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
						</div><!-- .entry-byline -->

					</article>

				<?php endwhile; wp_reset_postdata(); ?>

			</div>

			<div id="news-tabs-feature-popular" class="news-tabs-content">

				<?php $loop = new WP_Query( news_get_feature_popular_query_args() ); ?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<article <?php hybrid_attr( 'post' ); ?>>

						<?php get_the_image(); ?>

						<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

						<div class="entry-byline">
							<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
						</div><!-- .entry-byline -->

					</article>

				<?php endwhile; wp_reset_postdata(); ?>

			</div>

		</div>

		<?php $format = get_post_format( get_queried_object_id() ); ?>

		<?php if ( $format ) : ?>
			<a href="<?php echo esc_url( get_post_format_link( $format ) ); ?>" class="post-format-link"><?php printf( esc_html__( '%s Archives', 'news' ), get_post_format_string( $format ) ); ?></a>
		<?php endif; ?>

	</section>

	<?php endif; ?>

</aside><!-- #sidebar-feature -->
