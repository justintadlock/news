<li <?php hybrid_attr( 'comment' ); ?>>

	<article>
		<?php hybrid_comment_parent_link(
			array(
				'depth'  => 3,
				'text'   => __( 'In reply to %s', 'news' ),
				'before' => '<div class="comment-parent">',
				'after'  => '</div>'
			)
		); ?>

		<?php echo get_avatar( $comment ); ?>

			<header class="comment-header">
				<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite>

				<div class="comment-meta">
					<a <?php hybrid_attr( 'comment-permalink' ); ?>><time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%s ago', 'extant' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
					<?php edit_comment_link( null, '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'extant' ) . '</span>' ); ?>
					<?php hybrid_comment_reply_link( array( 'before' => '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'extant' ) . '</span>' ) ); ?>
				</div>
			</header>

			<div <?php hybrid_attr( 'comment-content' ); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

	</article>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
