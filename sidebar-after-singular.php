<?php
/**
 * After Singular Sidebar Template
 *
 * The After Singular sidebar template houses the HTML used for the 'Utility: After Singular' 
 * sidebar.  If widgets are present, they will be displayed.  If no widgets are present and the reader
 * is viewing a singular post, a tabbed list of related posts will be displayed by recent/popular.
 *
 * @package News
 * @subpackage Template
 */

if ( is_active_sidebar( 'after-singular' ) ) : ?>

	<div id="sidebar-after-singular" class="sidebar utility">

		<?php dynamic_sidebar( 'after-singular' ); ?>

	</div><!-- #sidebar-after-singular .utility -->

<?php elseif ( is_singular( 'post' ) ) : ?>

	<?php
		/* Put the categories in an array for related posts. */
		$terms = get_the_terms( get_the_ID(), 'category' );
		$cat__in = array();
		foreach ( $terms as $term )
			$cat__in[] = $term->term_id;
	?>

	<div id="sidebar-after-singular" class="sidebar utility">

		<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#singular-post-tabs-1"><?php _e( 'Related Stories', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#singular-post-tabs-2"><?php _e( 'Most Popular', hybrid_get_textdomain() ); ?></a></li>
				</ul><!-- .ui-tabs-nav -->

				<div id="singular-post-tabs-1" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'cat__in' => $cat__in, 'posts_per_page' => 6, 'ignore_sticky_posts' => true ) ); ?>

					<?php $i = 0; ?>

					<?php if ( $loop->have_posts() ) : ?>

						<ul class="alignleft">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

							<?php if ( ++$i == 4 ) { ?>
								</ul><ul class="alignright">
							<?php } ?>

							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></li>' ); ?>

						<?php endwhile; ?>

						</ul>

					<?php endif; ?>

				</div><!-- #singular-post-tabs-1 .ui-tabs-panel -->

				<div id="singular-post-tabs-2" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'cat__in' => $cat__in, 'orderby' => 'comment_count', 'posts_per_page' => 6, 'ignore_sticky_posts' => true ) ); ?>

					<?php $i = 0; ?>

					<?php if ( $loop->have_posts() ) : ?>

						<ul class="alignleft">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

							<?php if ( ++$i == 4 ) { ?>
								</ul><ul class="alignright">
							<?php } ?>

							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></li>' ); ?>

						<?php endwhile; wp_reset_query(); ?>

						</ul>

					<?php endif; ?>

				</div><!-- #singular-post-tabs-2 .ui-tabs-panel -->

			</div><!-- .ui-tabs-wrap -->

		</div><!-- .ui-tabs -->

	</div><!-- #sidebar-singular -->

<?php endif; ?>