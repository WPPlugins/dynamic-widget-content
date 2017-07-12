<?php
wp_nonce_field( 'dynamic-widget-content', 'dwc_nonce' );
$meta = get_post_meta( $post->ID );
?>
 
<h3><?php _e( 'Title', 'dynamic-widget-content' ); ?></h3>
<input type="text" name="dwc-title<?php echo $widget_number; ?>" id="dwc-title<?php echo $widget_number; ?>" value="<?php if ( isset ( $meta['dwc-title' . $widget_number] ) ) echo $meta['dwc-title' . $widget_number][0]; ?>" />

<h3><?php _e( 'Content', 'dynamic-widget-content' ); ?></h3>
<?php
$options = array(
    'textarea_rows' => 7
);

$content = isset ( $meta['dwc-content' . $widget_number] ) ? $meta['dwc-content' . $widget_number][0] : '';

wp_editor( $content, 'dwc-content' . $widget_number,  $options );
?>