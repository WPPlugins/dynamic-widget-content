<?php

class DWC_Widget_3 extends WP_Widget {

    public function __construct()
    {
        parent::__construct(
            'dwc_widget_3',
            'Dynamic Widget Content (3)',
            array(
                'description' => __( 'Page and post specific widget content.', 'dynamic-widget-content' )
            )
        );
    }

    public function widget( $args, $instance )
    {
        if( !is_singular() ) return;

        $post_id = get_the_ID();

        // Check post type
        $post_type = get_post_type( $post_id );
        $post_types = DynamicWidgetContent::option( 'meta_box_post_types', array( 'post', 'page' ) );

        if( !in_array( $post_type, $post_types ) ) return;

        // Get data
        $title = get_post_meta( $post_id, 'dwc-title-3', true );
        $content = get_post_meta( $post_id, 'dwc-content-3', true );

        if( $title == '' && $content == '') {
            if( !isset( $instance['title'] ) || !isset( $instance['content'] ) || ( $instance['title'] == '' && $instance['content'] == '' ) ) {
                return;
            } else {
                $title = $instance['title'];
                $content = $instance['content'];
            }

        };

        // Create output
        $title = apply_filters( 'widget_title', $title );

        $output = $args['before_widget'];
        if ( !empty( $title ) ) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }

        $output .= do_shortcode( wpautop( $content ) );
        $output .= $args['after_widget'];

        $output = apply_filters( 'dwc_widget_output', $output, $post_id );

        // Echo output
        echo $output;
    }

    public function form( $instance )
    {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $content = isset( $instance['content'] ) ? $instance['content'] : '';
        echo '<p>' . __( 'The content should be set for each page of post where you want the widget to show up.', 'dynamic-widget-content' ) . '</p>';
        echo '<p>' . __( 'Optionally set default values to display when no specific content has been set. Leave blank to not display anything.', 'dynamic-widget-content' ) . '</p>';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Default title', 'dynamic-widget-content' ); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e( 'Default content', 'dynamic-widget-content' ); ?>:</label>
            <textarea class="widefat" rows="7" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo $content; ?></textarea>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['content'] = ( !empty( $new_instance['content'] ) ) ? $new_instance['content'] : '';
        
        return $instance;
    }
}

add_action( 'widgets_init', create_function( '', 'return register_widget("DWC_Widget_3");' ) );