<?php if ( function_exists( 'breadcrumb_trail' ) ) : // Check for breadcrumb support. ?>

	<?php breadcrumb_trail(
		array(
			'container'     => 'nav',
			'show_on_front' => true,
			'post_taxonomy' => array(
				'portfolio_project' => 'portfolio_category',
				'download'          => 'download_category',
			),
			'labels'        => array(
				'browse' => __( 'Browsing:', 'news' )
			)
		)
	); ?>

<?php endif; // End check for breadcrumb support. ?>
