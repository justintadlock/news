<?php
/**
 * Newsletter Widget Class
 *
 * Provides a subscribe form for integration with the Google/Feedburner service.
 *
 * @package News
 * @subpackage Includes
 * @since 0.1.0
 */

class News_Widget_Newsletter extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.3.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'newsletter',
			'description' => esc_html__( 'Displays a subscription form for your Google/Feedburner account.', 'news' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'news-newsletter',				// $this->id_base
			__( 'News: Newsletter', 'news' ),	// $this->name
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
		<div class="newsletter-wrap">
		<form action="http://feedburner.google.com/fb/a/mailverify" method="post">
		<p>
			<input class="newsletter-text" type="text" name="email" value="<?php echo esc_attr( $instance['input_text'] ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
			<input class="newsletter-submit" type="submit" value="<?php echo esc_attr( $instance['submit_text'] ); ?>" />
			<input type="hidden" value="<?php echo esc_attr( $instance['id'] ); ?>" name="uri" />
			<input type="hidden" name="loc" value="en_US" />
		</p>
		</form>
		</div><?php

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
		$instance['id'] = strip_tags( $new_instance['id'] );
		$instance['input_text'] = strip_tags( $new_instance['input_text'] );
		$instance['submit_text'] = strip_tags( $new_instance['submit_text'] );

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
			'title' => 			esc_attr__( 'Newsletter', 'news' ),
			'input_text' => 		esc_attr__( 'you@site.com', 'news' ),
			'submit_text' => 	esc_attr__( 'Subscribe', 'news' ),
			'id' => 			''
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="hybrid-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Google/Feedburner ID:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'input_text' ); ?>"><?php _e( 'Input Text:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'input_text' ); ?>" name="<?php echo $this->get_field_name( 'input_text' ); ?>" value="<?php echo esc_attr( $instance['input_text'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'submit_text' ); ?>"><?php _e( 'Submit Text:', 'news' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'submit_text' ); ?>" name="<?php echo $this->get_field_name( 'submit_text' ); ?>" value="<?php echo esc_attr( $instance['submit_text'] ); ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>