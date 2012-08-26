<?php
/**
 * Loop Meta Template
 *
 * Displays information at the top of the page about archive and search results when viewing those pages.  
 * This is not shown on the home page and singular views.
 *
 * @package News
 * @subpackage Template
 */
?>

	<?php if ( is_category() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php single_cat_title(); ?></h1>

			<?php $description = category_description(); ?>

			<?php if ( !empty( $description ) ) echo '<div class="loop-description">' . $description . '</div>'; ?>

		</div><!-- .loop-meta -->

	<?php elseif ( is_tag() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php single_tag_title(); ?></h1>

			<?php $description = tag_description(); ?>

			<?php if ( !empty( $description ) ) echo '<div class="loop-description">' . $description . '</div>'; ?>

		</div><!-- .loop-meta -->

	<?php elseif ( is_tax() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></h1>

			<?php $description = term_description( '', get_query_var( 'taxonomy' ) ); ?>

			<?php if ( !empty( $description ) ) echo '<div class="loop-description">' . $description . '</div>'; ?>

		</div><!-- .loop-meta -->

	<?php elseif ( is_author() ) : ?>

		<?php $id = get_query_var( 'author' ); ?>

		<div id="hcard-<?php the_author_meta( 'user_nicename', $id ); ?>" class="loop-meta vcard">

			<h1 class="loop-title fn n"><?php the_author_meta( 'display_name', $id ); ?></h1>

			<?php $description = get_the_author_meta( 'description', $id ); ?>

			<?php if ( !empty( $description ) ) {
				$avatar = get_avatar( get_the_author_meta( 'user_email', $id ), '100', '', get_the_author_meta( 'display_name', $id ) );
				echo '<div class="loop-description">' . $avatar . wpautop( $description ) . '</div>';
			} ?>

		</div><!-- .loop-meta -->

	<?php elseif ( is_search() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php echo esc_attr( get_search_query() ); ?></h1>

			<div class="loop-description">
				<p>
				<?php printf( __( 'You are browsing the search results for &quot;%1$s&quot;', 'news' ), esc_attr( get_search_query() ) ); ?>
				</p>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_date() ) : ?>

		<div class="loop-meta">
			<h1 class="loop-title"><?php _e( 'Archives by date', 'news' ); ?></h1>

			<div class="loop-description">
				<p>
				<?php _e( 'You are browsing the site archives by date.', 'news' ); ?>
				</p>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_archive() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php _e( 'Archives', 'news' ); ?></h1>

			<div class="loop-description">
				<p>
				<?php _e( 'You are browsing the site archives.', 'news' ); ?>
				</p>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->
		
	<?php elseif ( is_page_template( 'page-template-popular.php' ) ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php _e( 'Most Popular', 'news' ); ?></h1>

			<div class="loop-description">
				<p>
				<?php _e( 'You are browsing the site archives by popularity.', 'news' ); ?>
				</p>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php endif; ?>