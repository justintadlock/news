<?php
/**
 * Template Name: Home
 *
 * Used as a news-type home page.  It lists a featured section at the top and pulls in the sidebar-feature.php
 * file to sit beside the featured area.  In the normal content area, posts are listed by category.  These 
 * categories must be selected in the 'Home Template Settings' section of the 'News Settings' page.  After 
 * the category highlight section, a more articles section displays a set number of posts.
 *
 * @package News
 * @subpackage Template
 */

/* Set up a default array for posts we're not duplicating. */
$do_not_duplicate = array();

get_header(); ?>

	<!-- Begin feature area. -->
	<div id="feature">

		<!-- Begin slideshow. -->
		<div class="slideshow-set">

			<div class="slideshow-items">

			<?php
				/* Get the sticky posts. */
				$sticky = get_option( 'sticky_posts' );

				/* If more than one sticky post, use them for the slider.  Else, just get the 3 latest posts. */
				$args = ( ( !empty( $sticky ) && 1 < count( $sticky ) ) ? array( 'post__in' => $sticky ) : array( 'posts_per_page' => 5 ) );
			?>

			<?php $loop = new WP_Query( $args ); $i = 0; ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<?php $do_not_duplicate[] = get_the_ID(); ?>

				<div class="<?php hybrid_entry_class( 'slideshow-item item item-' . ++$i ); ?>">

					<?php get_the_image( array( 'meta_key' => array( 'Large' ), 'size' => 'news-slideshow-large' ) ); ?>

					<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></h2>', false ) ); ?>

					<div class="slideshow-caption">
						<div class="entry-summary slideshow-caption-text"><?php the_excerpt(); ?></div>
					</div><!-- .slideshow-caption -->

				</div><!-- .hentry -->

			<?php endwhile; ?>

			</div><!-- .slideshow-items -->

			<div class="slideshow-controls">
				<div class="slideshow-pager"></div>
				<div class="slideshow-nav">
					<a class="slider-prev"><?php _e( 'Previous', 'news' ); ?></a>
					<a class="slider-next"><?php _e( 'Next', 'news' ); ?></a>
				</div>
			</div><!-- .slideshow-controls -->

		</div><!-- .slideshow-set -->
		<!-- End slideshow. -->

		<?php get_sidebar( 'feature' ); ?>

	</div>
	<!-- End feature area. -->

	<?php do_atomic( 'before_content' ); // Before content hook ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // Open content hook ?>

		<div class="hfeed">

		<!-- Begin category highlight section. -->
		<?php $categories = hybrid_get_setting( 'home_template_categories' ); ?>

		<?php if ( !empty( $categories ) && is_array( $categories ) ) { ?>

			<!-- Begin category section. -->
			<div id="category-highlight">

			<?php foreach ( $categories as $category ) { ?>

				<?php $loop = new WP_Query( array( 'cat' => $category, 'posts_per_page' => 6, 'post__not_in' => $do_not_duplicate ) ); ?>

				<?php if ( $loop->have_posts() ) : ?>

				<div class="section category-section">

					<div class="section-wrap category-section-wrap">

					<?php $term = get_term( $category, 'category' ); ?>

					<h2 class="category-title section-title"><a href="<?php echo get_term_link( $term, 'category' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $term->name; ?></a></h2>

					<?php $i = 0; ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php $do_not_duplicate[] = get_the_ID(); ?>

						<?php if ( ++$i == 1 ) { // If first post, show title, excerpt, and image. ?>

						<div class="<?php hybrid_entry_class(); ?>">

							<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h3>', false ) ); ?>

							<?php get_the_image( array( 'meta_key' => array( 'Thumbnail' ), 'size' => 'news-thumbnail' ) ); ?>

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->

						</div><!-- .hentry -->

						<?php } else { // If not the first post, add the entry titles as list items. ?>

							<?php if ( $i == 2 ) echo '<ul class="xoxo post-list">'; // If second post, open the list. ?>

							<li>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
								<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">[entry-published] [entry-comments-link before=" // "]</div>' ); ?>
							</li>

						<?php } ?>

					<?php endwhile; ?>

					<?php if ( $i > 1 ) echo '</ul>'; // If there is more than one post, close the list after the loop. ?>

					</div><!-- .section-wrap -->

				</div><!-- .section -->
				<!-- End category section. -->

				<?php endif; ?>

			<?php } ?>

			</div><!-- .category-highlight -->

		<?php } ?>
		<!-- End category highlight section. -->

		<!-- Begin more articles section. -->
		<?php $loop = new WP_Query( array( 'posts_per_page' => 3, 'post__not_in' => $do_not_duplicate ) ); ?>

		<?php if ( $loop->have_posts() ) : ?>

			<div id="more-articles" class="section">

				<div class="section-wrap">

				<h2 class="section-title"><?php _e( 'More Articles', 'news' ); ?></h2>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<div class="<?php hybrid_entry_class(); ?>">

						<?php get_the_image( array( 'meta_key' => array( 'Thumbnail' ), 'size' => 'news-thumbnail' ) ); ?>

						<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h3>', false ) ); ?>

						<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">[entry-published] [entry-comments-link] [entry-popup-shortlink]</div>' ); ?>

						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->

					</div><!-- .hentry -->

				<?php endwhile; ?>

				</div><!-- .section-wrap -->

			</div><!-- .section -->

		<?php endif; ?>
		<!-- End more articles section. -->

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // Close content hook ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // After content hook ?>

<?php get_footer(); ?>