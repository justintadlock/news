<?php
/**
 * Search Form Template
 *
 * The search form template displays the search form.
 *
 * @package News
 * @subpackage Template
 */

	global $search_num;
	++$search_num;
	$search_id = if ( $search_num ) ? esc_attr( '-' . $search_num ) : '';
?>
			<div id="search<?php echo $search_id; ?>" class="search">

				<form method="get" class="search-form" id="search-form<?php echo $search_id; ?>" action="<?php echo trailingslashit( home_url() ); ?>">
				<div>
					<input class="search-text" type="text" name="s" id="search-text<?php echo $search_id; ?>" value="<?php if ( is_search() ) echo esc_attr( get_search_query() ); else esc_attr_e( 'Search this site...', hybrid_get_textdomain() ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
					<input class="search-submit button" name="submit" type="submit" id="search-submit<?php echo $search_id; ?>" value="<?php esc_attr_e( 'Search', hybrid_get_textdomain() ); ?>" />
				</div>
				</form><!-- .search-form -->

			</div><!-- .search -->