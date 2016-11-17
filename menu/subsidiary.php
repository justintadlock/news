<?php if ( has_nav_menu( 'subsidiary' ) ) : // Check if there's a menu assigned to the 'subsidiary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'subsidiary' ); ?>>

		<h3 id="menu-subsidiary-title" class="screen-reader-text">
			<?php echo hybrid_get_menu_name( 'subsidiary' ); ?>
		</h3><!-- .menu-toggle -->

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'subsidiary',
				'container'       => '',
				'menu_id'         => 'menu-subsidiary-items',
				'menu_class'      => 'menu-items',
				'depth'           => 1,
				'fallback_cb'     => '',
			)
		); ?>

	</nav><!-- #menu-subsidiary -->

<?php endif; // End check for menu. ?>
