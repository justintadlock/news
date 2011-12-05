<?php
/**
 * Subsidiary Menu Template
 *
 * Displays the Subsidiary Menu if it has active menu items.  Note that this template uses the #menu-footer ID 
 * so that it will be backwards compatible with version 0.1 of the News theme.
 *
 * @package News
 * @subpackage Template
 */

if ( has_nav_menu( 'subsidiary' ) ) : ?>

	<div id="menu-footer" class="menu-container">

		<div class="wrap">

			<?php do_atomic( 'before_menu_subsidiary' ); // Before subsidiary menu hook ?>

			<?php wp_nav_menu( array( 'theme_location' => 'subsidiary', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-footer-items', 'depth' => 1, 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'after_menu_subsidiary' ); // After subsidiary menu hook ?>

		</div>

	</div><!-- #menu-footer .menu-container -->

<?php endif; ?>