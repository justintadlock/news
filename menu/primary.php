<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'primary' ); ?>>

		<h3 id="menu-primary-title" class="menu-title screen-reader-text">
			<button class="screen-reader-text"><?php echo hybrid_get_menu_name( 'primary' ); ?></button>
		</h3><!-- .menu-toggle -->

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => '',
				'menu_id'         => 'menu-primary-items',
				'menu_class'      => 'menu-items',
				'fallback_cb'     => '',
				'item_spacing'    => 'discard'
			)
		); ?>

	</nav><!-- #menu-primary -->

<?php endif; // End check for menu. ?>
