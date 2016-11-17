<article <?php hybrid_attr( 'post' ); ?>>

<?php if ( is_singular( get_post_type() ) ) : ?>

	<div class="entry-utility">
		<?php news_post_print_link(); ?>
		<?php news_post_email_link(); ?>
	</div>

						<h1 class="entry-title"><?php single_post_title(); ?></h1>

			<div class="entry-byline">
				<?php hybrid_post_author(); ?>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<?php comments_popup_link( false, false, false, 'comments-link' ); ?>
			</div><!-- .entry-byline -->

						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'news' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'news' ), 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->

					<footer class="entry-footer">

<span class="entry-share">
	<?php _e( 'Share on:', 'news' ); ?>

<!-- Sharingbutton Facebook -->
<a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php" target="_blank" aria-label="Facebook">
Facebook</a>

<!-- Sharingbutton Twitter -->
<a class="resp-sharing-button__link" href="https://twitter.com/intent/tweet/?text=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.&amp;url=http%3A%2F%2Fsharingbuttons.io" target="_blank" aria-label="Twitter">
Twitter</a>

<!-- Sharingbutton Pinterest -->
<a class="resp-sharing-button__link" href="https://pinterest.com/pin/create/button/?url=http%3A%2F%2Fsharingbuttons.io&amp;media=http%3A%2F%2Fsharingbuttons.io&amp;summary=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking." target="_blank" aria-label="Pinterest">
Pinterest</a>

<!-- Sharingbutton LinkedIn -->
<a class="resp-sharing-button__link" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http%3A%2F%2Fsharingbuttons.io&amp;title=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.&amp;summary=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.&amp;source=http%3A%2F%2Fsharingbuttons.io" target="_blank" aria-label="LinkedIn">
LinkedIn</a>

<!-- Sharingbutton Reddit -->
<a class="resp-sharing-button__link" href="https://reddit.com/submit/?url=http%3A%2F%2Fsharingbuttons.io" target="_blank" aria-label="Reddit">
Reddit</a>
	</span>

	</footer>

<?php else : ?>

	<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

			<div class="entry-byline">
				<?php hybrid_post_author(); ?>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
				<?php comments_popup_link( false, false, false, 'comments-link' ); ?>
			</div><!-- .entry-byline -->

	<?php get_the_image( array( 'size' => 'extant-landscape' ) ); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

<?php endif; ?>

</article>

<?php if ( is_singular() ) hybrid_post_terms( array( 'taxonomy' => 'post_tag', 'sep' => '' ) ); ?>
