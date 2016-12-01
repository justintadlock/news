<?php

	//wp_enqueue_script( 'jquery-cycle' );
	//wp_enqueue_script( 'jquery-cycle' );


$do_not_duplicate = array();
$sticky = get_option( 'sticky_posts' );


get_header(); ?>

	<!-- Begin feature area. -->
	<div class="feature">

		<div class="feature-post">

		<?php wp_enqueue_script( 'jquery-cycle' );
			add_filter( 'excerpt_length', 'news_slideshow_excerpt_length' ); ?>

			<div class="slideshow">

			<div <?php news_slideshow_attr(); ?>>

			<?php $args = $sticky && 1 < count( $sticky ) ? array( 'post__in' => $sticky ) : array( 'ignore_sticky_posts' => true, 'posts_per_page' => 5 ); ?>

			<?php $loop = new WP_Query( $args ); ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID(); ?>

				<article class="slideshow-item">

					<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<div class="slideshow-icon">
						<?php get_the_image( array( 'size' => 'extant-landscape' ) ); ?>
					</div>
						<div class="slideshow-caption cycle-caption">
							<?php the_excerpt(); ?>
						</div>

				</article>

			<?php endwhile; ?>

			<?php add_filter( 'excerpt_length', 'news_slideshow_excerpt_length' );

			wp_reset_postdata(); ?>

			</div>

			<div class="slideshow-nav">
				<span class="slideshow-count"></span>
				<button type="button" class="slideshow-prev"><span class="screen-reader-text"><?php esc_html_e( 'Previous Post', 'news' ); ?></span></button>
				<button type="button" class="slideshow-next"><span class="screen-reader-text"><?php esc_html_e( 'Next Post', 'news' ); ?></span></button>
			</div>

			</div>

		</div>

		<?php hybrid_get_sidebar( 'feature' ); ?>

	</div>
	<!-- End feature area. -->

	<div id="content" class="site-content">

		<div class="wrap">

		<?php $categories = array( 1, 81, 142 ); ?>

		<?php foreach ( $categories as $term_id ) : ?>

			<div class="section section-category">

				<?php $term = get_term( $term_id, 'category' ); ?>

				<h2 class="section-title"><a href="<?php echo esc_url( get_term_link( $term, 'category' ) ); ?>"><?php echo esc_html( $term->name ); ?></a></h2>

				<div class="section-content">
			<?php $loop = new WP_Query(
				array(
					'post__not_in' => $do_not_duplicate,
					'ignore_sticky_posts' => true,
					'posts_per_page' => 6,
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field'    => 'id',
							'terms'    => $term_id
						)
					)
				)
			); ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php $do_not_duplicate[] = get_the_ID(); ?>

						<?php if ( 0 == $loop->current_post ) : // If first post, show title, excerpt, and image. ?>

						<div class="side-post">

					<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

							<?php get_the_image( array( 'size' => 'extant-large' ) ); ?>

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->

						</div><!-- .hentry -->

						<?php else : // If not the first post, add the entry titles as list items. ?>

							<?php if ( 1 == $loop->current_post ) : ?>
								<ul class="xoxo post-list">
							<?php endif; ?>

							<li>

				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

				<div class="entry-byline">
					<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				</div><!-- .entry-byline -->

							</li>

						<?php endif; ?>

					<?php endwhile; ?>

					<?php if ( 1 < $loop->post_count ) : ?>
						</ul>
					<?php endif; ?>
				</div>

			</div>


		<?php endforeach; ?>

	<?php /*

		<div class="section section-more">

			<h2 class="section-title"><?php esc_html_e( 'More Articles', 'news' ); ?></h2>

			<div class="section-content">
			<?php $loop = new WP_Query(
				array(
					'post__not_in' => $do_not_duplicate,
					'ignore_sticky_posts' => true,
					'posts_per_page' => 3
				)
			); ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<?php hybrid_get_content_template(); ?>

			<?php endwhile; ?>

			<?php wp_reset_postdata(); ?>

			</div>
		</div>
	*/ ?>
















		</div><!-- .hfeed -->

	</div><!-- #content -->

<?php get_footer(); ?>
