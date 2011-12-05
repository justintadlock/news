<?php
/**
 * Primary Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 * @package News
 * @subpackage Template
 */

if ( has_nav_menu( 'primary' ) ) : ?>

	<div id="menu-primary" class="menu-container">

		<div class="wrap">

			<?php do_atomic( 'before_menu_primary' ); // Before primary menu hook ?>

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-primary-items', 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'after_menu_primary' ); // After primary menu hook ?>

		</div>

	</div><!-- #menu-primary .menu-container -->

<?php endif; ?>