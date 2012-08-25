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
<title><?php hybrid_document_title(); ?></title>

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); // WP head hook ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

	<?php do_atomic( 'before_html' ); // Before HTML hook ?>

	<div id="body-container">

		<?php get_template_part( 'menu', 'secondary' ); // Loads the menu-secondary.php file ?>

		<?php do_atomic( 'before_header' ); // Before header hook ?>

		<div id="header">

			<?php do_atomic( 'open_header' ); // Open header hook ?>

			<div class="wrap">

				<?php hybrid_site_title(); // Displays the site title ?>

				<?php get_sidebar( 'header' ); // Loads the sidebar-header.php file ?>

				<?php do_atomic( 'header' ); // Header hook ?>

			</div><!-- .wrap -->

			<?php do_atomic( 'close_header' ); // Close header hook ?>

		</div><!-- #header -->

		<?php do_atomic( 'after_header' ); // After header hook ?>

		<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php file ?>

		<?php do_atomic( 'before_container' ); // Before container hook ?>

		<div id="container">

			<div class="wrap">

			<?php do_atomic( 'open_container' ); // Open container hook ?>

			<?php if ( current_theme_supports( 'breadcrumb-trail' ) ) breadcrumb_trail( array( 'before' => __( 'Browsing:', 'news' ) . ' <span class="sep">/</span>' ) ); ?>