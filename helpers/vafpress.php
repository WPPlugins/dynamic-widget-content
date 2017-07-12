<?php

class DWC_Vafpress {

    public function __construct()
    {
        add_action( 'after_setup_theme', array( $this, 'vafpress_menu_init' ) );
    }

    public function vafpress_menu_init()
    {
        require_once( DynamicWidgetContent::get()->coreDir . '/helpers/vafpress/vafpress_menu_whitelist.php');
        require_once( DynamicWidgetContent::get()->coreDir . '/helpers/vafpress/vafpress_menu_options.php');

        new VP_Option(array(
            'is_dev_mode'           => false,
            'option_key'            => 'dwc_option',
            'page_slug'             => 'dwc_settings',
            'template'              => $admin_menu,
            'menu_page'             => 'options-general.php',
            'use_auto_group_naming' => true,
            'use_exim_menu'         => true,
            'minimum_role'          => 'manage_options',
            'layout'                => 'fluid',
            'page_title'            => 'Dynamic Widget Content',
            'menu_label'            => 'Dynamic Widget Content',
        ));
    }
}