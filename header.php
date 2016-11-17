<?php
/**
 * Header Template
 *
 * The header template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the top of the file. It is used mostly as an opening
 * wrapper, which is closed with the footer.php file. It also executes key functions needed
 * by the theme, child themes, and plugins.
 *
 * @package News
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />

<?php wp_head(); // WP head hook ?>

</head>

<body <?php hybrid_attr( 'body' ); ?>>

	<div id="body-container">

		<?php hybrid_get_menu( 'social' ); ?>

		<div id="header">

			<div class="wrap">

				<?php hybrid_site_title(); // Displays the site title ?>

			</div><!-- .wrap -->

		</div><!-- #header -->

		<?php hybrid_get_menu( 'primary' ); // Loads the `menu/primary.php` template. ?>

		<div class="below-header">

		<div id="container">

				<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the `menu/breadcrumbs.php` template. ?>

			<div class="wrap">
