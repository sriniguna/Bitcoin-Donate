<?php
/**
 * Adds Bitcoin Donate Widget.
 */

class Bitcoin_Donate_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bitcoin_donate_widget', // Base ID
			__('Bitcoin Donate', 'bitcoin_donate'), // Name
			array( 'description' => __( 'A widget that displays a Bitcoin donate button', 'bitcoin_donate' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'bitcoin_donate', $instance['title'] );
		$address = $instance['address'];
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		if ( ! empty( $address ) ) {
			echo '<p style="word-wrap:break-word;">';
			echo __( 'Donate bitcoins to: ', 'bitcoin_donate');
			echo '<a href="bitcoin:'.$address.'">';
			echo $address;
			echo '<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=bitcoin:'.$address.'" />';
			echo '</a>';
			echo '</p>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Donate', 'bitcoin_donate' );
		}

		if ( isset( $instance[ 'address' ] ) ) {
			$address = $instance[ 'address' ];
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Bitcoin address:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';
		return $instance;
	}

} // class Bitcoin Donate Widget

// register Foo_Widget widget
function register_bitcoin_donate_widget() {
    register_widget( 'Bitcoin_Donate_Widget' );
}
add_action( 'widgets_init', 'register_bitcoin_donate_widget' );

?>