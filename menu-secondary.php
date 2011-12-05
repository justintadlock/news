<?php
/**
 * Secondary Menu Template
 *
 * Displays the Secondary Menu if it has active menu items.
 *
 * @package News
 * @subpackage Template
 */

if ( has_nav_menu( 'secondary' ) ) : ?>

	<div id="menu-secondary" class="menu-container">

		<div class="wrap">

			<?php do_atomic( 'before_menu_secondary' ); // Before secondary menu hook ?>

			<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-secondary-items', 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'after_menu_secondary' ); // After secondary menu hook ?>

		</div>

	</div><!-- #menu-secondary .menu-container -->

<?php endif; ?>