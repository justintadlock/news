<?php
/**
 * Gallery Stream Widget Class
 *
 * Pulls post thumbnails by category or tag.
 *
 * @since 0.1.0
 *
 * @package News
 * @subpackage Classes
 */

class News_Widget_Image_Stream extends WP_Widget {

	var $prefix;
	var $textdomain;

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 * @since 0.1.0
	 */
	function News_Widget_Image_Stream() {
		$this->prefix = hybrid_get_prefix();
		$this->textdomain = hybrid_get_textdomain();

		$widget_ops = array( 'classname' => 'image-stream', 'description' => __( 'Displays image thumbnails in a gallery-like format.', $this->textdomain ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => "{$this->prefix}-image-stream" );
		$this->WP_Widget( "{$this->prefix}-image-stream", __( 'News: Image Stream', $this->textdomain ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 * @since 0.1.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$args = array();

		$posts_per_page = intval( $instance['posts_per_page'] );

		echo $before_widget;

		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;

		$loop = new WP_Query( array( 'post_type' => 'attachment', 'post_mime_type' => 'image', 'post_status' => 'inherit', 'posts_per_page' => $posts_per_page, 'orderby' => 'parent' ) );

		echo '<div>';

		if ( $loop->have_posts() ) {

			while ( $loop->have_posts() ) {

				$loop->the_post();

				get_the_image( array( 'size' => 'thumbnail' ) );
			}
		} else {
			echo '<p>' . __( 'There are currently no images found.', $this->textdomain ) . '</p>';
		}

		echo '</div>';

		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 * @since 0.1.0
	 */
	function form( $instance ) {

		//Defaults
		$defaults = array(
			'title' => __( 'Image Stream', $this->textdomain ),
			'posts_per_page' => 6,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="hybrid-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', $this->textdomain ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', $this->textdomain ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>