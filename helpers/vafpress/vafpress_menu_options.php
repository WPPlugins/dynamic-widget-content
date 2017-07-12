<?php

// Include part of site URL hash in HTML settings to update when site URL changes
$sitehash = substr( base64_encode( site_url() ), 0, 8 );

$admin_menu = array(
    'title' => 'Dynamic Widget Content ' . __( 'Settings', 'dynamic-widget-content' ),
    'logo'  => DynamicWidgetContent::get()->coreUrl . '/img/logo.png',
    'menus' => array(
//=-=-=-=-=-=-= GENERAL =-=-=-=-=-=-=
        array(
            'title' => __( 'General', 'dynamic-widget-content' ),
            'name' => 'general',
            'icon' => 'font-awesome:fa-cogs',
            'controls' => array(
                array(
                    'type' => 'section',
                    'title' => __( 'Meta Box', 'dynamic-widget-content' ),
                    'name' => 'general_section_meta_box',
                    'fields' => array(
                        array(
                            'type' => 'multiselect',
                            'name' => 'meta_box_post_types',
                            'label' => __('Enable for post types', 'dynamic-widget-content'),
                            'description' => __( 'Meta box will only show up for these post types.', 'dynamic-widget-content' ),
                            'items' => array(
                                'data' => array(
                                    array(
                                        'source' => 'function',
                                        'value' => 'dwc_available_post_types',
                                    ),
                                ),
                            ),
                            'default' => array(
                                'post',
                                'page',
                            ),
                        ),
                        array(
                            'type' => 'textbox',
                            'name' => 'meta_box_capability',
                            'label' => __( 'Required Capability', 'dynamic-widget-content' ),
                            'description' => __( 'Meta box will only show up for users with this capability.', 'dynamic-widget-content' ),
                            'default' => 'edit_posts',
                            'validation' => 'required',
                        ),
                    ),
                ),
                array(
                    'type' => 'section',
                    'title' => __( 'Advanced', 'dynamic-widget-content' ),
                    'name' => 'general_section_advanced',
                    'fields' => array(
                        array(
                            'type' => 'slider',
                            'name' => 'number_of_widgets',
                            'label' => __( 'Number of Dynamic Widgets', 'dynamic-widget-content' ),
                            'description' => __( 'Define multiple dynamic widgets for one post or page. Useful in combination with multiple sidebars.', 'dynamic-widget-content' ),
                            'min' => '1',
                            'max' => '3',
                            'step' => '1',
                            'default' => '1',
                        ),
                    ),
                ),
            ),
        ),
//=-=-=-=-=-=-= FAQ & SUPPORT =-=-=-=-=-=-=
        array(
            'title' => __( 'FAQ & Support', 'dynamic-widget-content' ),
            'name' => 'faq_support',
            'icon' => 'font-awesome:fa-book',
            'controls' => array(
                array(
                    'type' => 'notebox',
                    'name' => 'faq_support_notebox',
                    'label' => __( 'Need more help?', 'dynamic-widget-content' ),
                    // TODO Support link
                    'description' => '<a href="mailto:support@bootstrapped.ventures" target="_blank">Dynamic Widget Content ' .__( 'FAQ & Support', 'dynamic-widget-content' ) . '</a>',
                    'status' => 'info',
                ),
            ),
        ),
    ),
);