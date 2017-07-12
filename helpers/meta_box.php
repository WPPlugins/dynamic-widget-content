<?php

class DWC_Meta_Box {

    private $buttons_added = false;

    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_meta_box' ) );
    }

    public function add_meta_box()
    {
        if( current_user_can( DynamicWidgetContent::option( 'meta_box_capability', 'edit_posts' ) ) ) {
            $post_types = DynamicWidgetContent::option( 'meta_box_post_types', array( 'post', 'page' ) );
            $number_of_widgets = intval( DynamicWidgetContent::option( 'number_of_widgets', 1 ) );

            foreach( $post_types as $post_type ) {
                for( $i = 1; $i <= $number_of_widgets; $i++ ) {

                    $widget_number = $i == 1 ? '' : '_' . $i;
                    $meta_box_name = $number_of_widgets > 1 ? 'Dynamic Widget Content (' . $i . ')' : 'Dynamic Widget Content';

                    add_meta_box(
                        'dwc_meta_box' . $widget_number,
                        $meta_box_name,
                        array( $this, 'meta_box_content' . $widget_number ),
                        $post_type,
                        'normal',
                        'default'
                    );
                }
            }
        }
    }

    public function meta_box_content( $post )
    {
        $widget_number = '';
        include( DynamicWidgetContent::get()->coreDir . '/helpers/meta_box_content.php' );
    }

    public function meta_box_content_2( $post )
    {
        $widget_number = '-2';
        include( DynamicWidgetContent::get()->coreDir . '/helpers/meta_box_content.php' );
    }

    public function meta_box_content_3( $post )
    {
        $widget_number = '-3';
        include( DynamicWidgetContent::get()->coreDir . '/helpers/meta_box_content.php' );
    }

    public function save_meta_box( $post_id )
    {
        // Checks save status
        $is_autosave = wp_is_post_autosave( $post_id );
        $is_revision = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST[ 'dwc_nonce' ] ) && wp_verify_nonce( $_POST[ 'dwc_nonce' ], 'dynamic-widget-content' ) ) ? true : false;
     
        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }
     
        if( isset( $_POST[ 'dwc-title' ] ) ) {
            update_post_meta( $post_id, 'dwc-title', sanitize_text_field( $_POST[ 'dwc-title' ] ) );
        }
        if( isset( $_POST[ 'dwc-content' ] ) ) {
            update_post_meta( $post_id, 'dwc-content', $_POST[ 'dwc-content' ] );
        }

        if( isset( $_POST[ 'dwc-title-2' ] ) ) {
            update_post_meta( $post_id, 'dwc-title-2', sanitize_text_field( $_POST[ 'dwc-title-2' ] ) );
        }
        if( isset( $_POST[ 'dwc-content-2' ] ) ) {
            update_post_meta( $post_id, 'dwc-content-2', $_POST[ 'dwc-content-2' ] );
        }

        if( isset( $_POST[ 'dwc-title-3' ] ) ) {
            update_post_meta( $post_id, 'dwc-title-3', sanitize_text_field( $_POST[ 'dwc-title-3' ] ) );
        }
        if( isset( $_POST[ 'dwc-content-3' ] ) ) {
            update_post_meta( $post_id, 'dwc-content-3', $_POST[ 'dwc-content-3' ] );
        }
    }
}