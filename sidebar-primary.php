<?php
/**
 * Primary Sidebar Template
 *
 * The Primary sidebar template houses the HTML used for the 'Primary' sidebar.
 * It will first check if the sidebar is active before displaying anything.
 *
 * @package News
 * @subpackage Template
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<div id="sidebar-primary" class="sidebar aside">

		<?php do_atomic( 'before_sidebar_primary' ); // Before primary sidebar hook ?>

		<?php dynamic_sidebar( 'primary' ); ?>

		<?php do_atomic( 'after_sidebar_primary' ); // After primary sidebar hook ?>

	</div><!-- #sidebar-primary .aside -->

<?php endif; ?>