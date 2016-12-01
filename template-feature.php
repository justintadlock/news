<?php


get_header(); ?>

	<!-- Begin feature area. -->
	<div class="feature">

		<div class="feature-post">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php hybrid_get_content_template(); ?>

		<?php endwhile; ?>
		</div>

		<?php hybrid_get_sidebar( 'feature' ); ?>

	</div>
	<!-- End feature area. -->

	<div id="content" class="site-content">

		<div class="wrap">

				<?php while ( have_posts() ) : the_post(); ?>

				<?php comments_template( '', true ); // Loads the comments.php template. ?>

				<?php endwhile; ?>

		</div><!-- .hfeed -->

	</div><!-- #content -->

<?php get_footer(); ?>
