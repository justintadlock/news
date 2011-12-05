<?php
/**
 * Secondary Sidebar Template
 *
 * The Secondary sidebar template houses the HTML used for the 'Secondary' sidebar.
 * It will first check if the sidebar is active before displaying anything.
 *
 * @package News
 * @subpackage Template
 */

if ( is_active_sidebar( 'secondary' ) ) : ?>

	<div id="sidebar-secondary" class="sidebar aside">

		<?php do_atomic( 'before_sidebar_secondary' ); // Before secondary sidebar hook ?>

		<?php dynamic_sidebar( 'secondary' ); ?>

		<?php do_atomic( 'after_sidebar_secondary' ); // After secondary sidebar hook ?>

	</div><!-- #sidebar-secondary .aside -->

<?php endif; ?>