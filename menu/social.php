<?php if ( has_nav_menu( 'social' ) ) : // Check if there's a menu assigned to the 'social' location. ?>

	<?php $desc = sprintf( '<p class="site-description">%s</p>', get_bloginfo( 'description' ) ); ?>

	<?php wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => 'div',
			'container_id'    => 'menu-social',
			'container_class' => 'menu',
			'menu_id'         => 'menu-social-items',
			'menu_class'      => 'menu-items',
			'depth'           => 1,
			'link_before'     => '<span class="maybe-screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
			'items_wrap'      => '<div class="wrap">' . $desc . '<ul id="%s" class="%s">%s</ul></div>'
		)
	); ?>

<?php endif; // End check for menu. ?>