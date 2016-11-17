<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins.
 *
 * @package News
 * @subpackage Template
 */
?>
			<?php hybrid_get_sidebar( 'primary' ); ?>

			</div><!-- .wrap -->

		</div><!-- #container -->

		<div id="footer" class="site-footer">

			<div class="wrap">

				<?php hybrid_get_menu( 'subsidiary' ); // Loads the `menu/subsidiary.php` file. ?>

				<div class="footer-content">
					<p class="credit">
						<?php printf(
							// Translators: 1 is current year, 2 is site name/link, 3 is WordPress name/link and 4 is theme name/link.
							esc_html__( 'Copyright &#169; %1$s %2$s. Powered by %3$s and %4$s.', 'extant' ),
							date_i18n( 'Y' ),
							hybrid_get_site_link(),
							hybrid_get_wp_link(),
							hybrid_get_theme_link()
						); ?>
					</p><!-- .credit -->
				</div>

			</div><!-- .wrap -->

		</div><!-- #footer -->

		</div><!-- .below-header -->

	</div><!-- #body-container -->

	<?php wp_footer(); // WordPress footer hook ?>

</body>
</html>