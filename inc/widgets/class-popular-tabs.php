<?php
/**
 * Popular Tabs Widget Class
 *
 * The Popular Tabs widget lists posts by view count and comment count in a tabbed display using the 
 * jQuery UI Tabs feature.
 *
 * @package News
 * @subpackage Includes
 * @since 0.1.0
 */

class News_Widget_Popular_Tabs extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.3.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'popular-tabs',
			'description' => esc_html__( 'Displays popular posts by number of views and comments in tab format.', 'news' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'news-popular-tabs',				// $this->id_base
			__( 'News: Popular Tabs', 'news' ),	// $this->name
			$widget_options,				// $this->widget_options
			$control_options				// $this->control_options
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		?>
		<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#<?php echo sanitize_html_class( "{$this->id}-1" ); ?>"><?php echo $instance['views_tab_title']; ?></a></li>
					<li><a href="#<?php echo sanitize_html_class( "{$this->id}-2" ); ?>"><?php echo $instance['comments_tab_title']; ?></a></li>
				</ul><!-- .ui-tabs-nav -->

				<div id="<?php echo sanitize_html_class( "{$this->id}-1" ); ?>" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'post_type' => $instance['post_type'], 'ignore_sticky_posts' => true, 'posts_per_page' => intval( $instance['posts_per_page'] ), 'meta_key' => 'Views', 'orderby' => 'meta_value_num', 'order' => 'DESC' ) ); ?>

					<?php if ( $loop->have_posts() ) : ?>

						<ul class="xoxo">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a>' ); ?>
							<span class="count view-count"><?php printf( __( '(%s)', 'news' ), get_post_meta( get_the_ID(), 'Views', true ) ); ?></span>
							</li>
						<?php endwhile; ?>

						</ul>

					<?php endif; ?>

				</div><!-- .ui-tabs-panel -->

				<div id="<?php echo sanitize_html_class( "{$this->id}-2" ); ?>" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'post_type' => $instance['post_type'], 'ignore_sticky_posts' => true, 'posts_per_page' => intval( $instance['posts_per_page'] ),  'orderby' => 'comment_count' ) ); ?>

					<?php if ( $loop->have_posts() ) : ?>

						<ul class="xoxo">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a>' ); ?>
							<span class="count view-count"><?php printf( __( '(%s)', 'news' ), get_comments_number() ); ?></span>
							</li>
						<?php endwhile; ?>

						</ul>

					<?php endif; wp_reset_query(); ?>

				</div><!-- .ui-tabs-panel -->

			</div><!-- .ui-tabs-wrap -->

		</div><!-- .ui-tabs --> <?php

		/* Close the theme's widget wrapper. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['views_tab_title'] = strip_tags( $new_instance['views_tab_title'] );
		$instance['comments_tab_title'] = strip_tags( $new_instance['comments_tab_title'] );
		$instance['posts_per_page'] = intval( $new_instance['posts_per_page'] );
		$instance['post_type'] = strip_tags( $new_instance['post_type'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => 				esc_attr__( 'Most', 'news' ),
			'posts_per_page' => 		3,
			'post_type' => 			'post',
			'views_tab_title' => 		esc_attr__( 'Viewed', 'news' ),
			'comments_tab_title' => 	esc_attr__( 'Commented', 'news' )
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="hybrid-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type:', 'news' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
			<?php foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) {
				if ( post_type_supports( $post_type->name, 'entry-views' ) ) { ?>
					<option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( $instance['post_type'], $post_type->name ); ?>><?php echo esc_html( $post_type->labels->singular_name ); ?></option>
				<?php }
			} ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'views_tab_title' ); ?>"><?php _e( 'Views Tab Title:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'views_tab_title' ); ?>" name="<?php echo $this->get_field_name( 'views_tab_title' ); ?>" value="<?php echo esc_attr( $instance['views_tab_title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'comments_tab_title' ); ?>"><?php _e( 'Comments Tab Title:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'comments_tab_title' ); ?>" name="<?php echo $this->get_field_name( 'comments_tab_title' ); ?>" value="<?php echo esc_attr( $instance['comments_tab_title'] ); ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>