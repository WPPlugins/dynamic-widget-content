<?php

function dwc_available_post_types()
{
    $post_types = get_post_types( '', 'names' );
    $types = array();

    foreach( $post_types as $post_type ) {
        $types[] = array(
            'value' => $post_type,
            'label' => ucfirst( $post_type )
        );
    }

    return $types;
}

VP_Security::instance()->whitelist_function( 'dwc_available_post_types' );