<?php
/**
 * Header Sidebar Template
 *
 * The Header sidebar template houses the HTML used for the 'Utility: Header' 
 * sidebar. It will first check if the sidebar is active before displaying anything.
 *
 * @package News
 * @subpackage Template
 */

if ( is_active_sidebar( 'header' ) ) : ?>

	<div id="sidebar-header" class="sidebar utility">

		<?php dynamic_sidebar( 'header' ); ?>

	</div><!-- #sidebar-header .utility -->

<?php endif; ?>