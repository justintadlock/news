<?php
/**
 * Gallery Stream Widget Class
 *
 * Pulls post thumbnails by category or tag.
 *
 * @package News
 * @subpackage Includes
 * @since 0.1.0
 */

class News_Widget_Image_Stream extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.3.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'image-stream',
			'description' => esc_html__( 'Displays image thumbnails in a gallery-like format.', 'news' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'news-image-stream',				// $this->id_base
			__( 'News: Image Stream', 'news' ),	// $this->name
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

		/* Query images. */
		$loop = new WP_Query( 
			array( 
				'post_type' => 'attachment', 
				'post_mime_type' => 'image', 
				'post_status' => 'inherit', 
				'posts_per_page' => intval( $instance['posts_per_page'] ), 
				'orderby' => 'parent' 
			) 
		);

		echo '<div>';

		if ( $loop->have_posts() ) {

			while ( $loop->have_posts() ) {

				$loop->the_post();

				echo wp_get_attachment_link(  get_the_ID(), 'thumbnail', true );
			}
		} else {
			echo '<p>' . __( 'There are currently no images found.', 'news' ) . '</p>';
		}

		echo '</div>';

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
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );

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
			'title' => esc_attr__( 'Image Stream', 'news' ),
			'posts_per_page' => 6,
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="hybrid-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>