<?php
/**
 * Functions that deal with theme options.
 *
 * @package    News
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @author     Tung Do <ttsondo@gmail.com>
 * @copyright  Copyright (c) 2010-2016
 * @link       http://themehybrid.com/themes/news
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function news_get_comment_policy_post_id() {

	return hybrid_get_theme_mod( 'comment_policy_post_id', 174 );
}
