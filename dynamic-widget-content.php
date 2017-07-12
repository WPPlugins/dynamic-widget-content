<?php
/*
Plugin Name: Dynamic Widget Content
Plugin URI: 
Description: Dynamic widget content for single pages and posts
Version: 1.2
Author: Bootstrapped Ventures
Author URI: http://bootstrapped.ventures
License: GPLv2
*/

define( 'DWC_VERSION', '1.2' );

class DynamicWidgetContent {

    private static $instance;
    private static $instantiated_by_premium;
    private static $addons = array();

    /**
     * Return instance of self
     */
    public static function get( $instantiated_by_premium = false )
    {
        // Instantiate self only once
        if( is_null( self::$instance ) ) {
            self::$instantiated_by_premium = $instantiated_by_premium;
            self::$instance = new self;
            self::$instance->init();
        }

        return self::$instance;
    }

    /**
     * Returns true if we are using the Premium version
     */
    public static function is_premium_active()
    {
        return self::$instantiated_by_premium;
    }

    /**
     * Access a VafPress option with optional default value
     */
    public static function option( $name, $default = null )
    {
        $option = vp_option( 'dwc_option.' . $name );

        return is_null( $option ) ? $default : $option;
    }

    public $pluginName = 'dynamic-widget-content';
    public $coreDir;
    public $coreUrl;
    public $pluginFile;

    protected $helper_dirs = array();
    protected $helpers = array();

    /**
     * Initialize
     */
    public function init()
    {
        // Load external libraries
        require_once( 'vendor/vafpress/bootstrap.php' );

        // Update plugin version
        update_option( $this->pluginName . '_version', DWC_VERSION );

        // Set core directory, URL and main plugin file
        $this->coreDir = apply_filters( 'dwc_core_dir', WP_PLUGIN_DIR . '/' . $this->pluginName );
        $this->coreUrl = apply_filters( 'dwc_core_url', plugins_url() . '/' . $this->pluginName );
        $this->pluginFile = apply_filters( 'dwc_plugin_file', __FILE__ );

        // Load textdomain
        if( !self::is_premium_active() ) {
            $domain = 'dynamic-widget-content';
            $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

            load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
            load_plugin_textdomain( $domain, false, basename( dirname( __FILE__ ) ) . '/lang/' );
        }

        // Add core helper directory
        $this->add_helper_directory( $this->coreDir . '/helpers' );

        // Load required helpers
        $this->helper( 'meta_box' );
        $this->helper( 'vafpress' );

        // Widgets
        add_action( 'init', array( $this, 'init_widgets' ), 0 );

    }

    public function init_widgets()
    {
        $number_of_widgets = intval( DynamicWidgetContent::option( 'number_of_widgets', 1 ) );

        for( $i = 1; $i <= $number_of_widgets; $i++ ) {
            $widget_number = $i == 1 ? '' : '_' . $i;
            $this->helper( 'widget' . $widget_number );
        }
    }

    /**
     * Access a helper. Will instantiate if helper hasn't been loaded before.
     */
    public function helper( $helper )
    {
        // Lazy instantiate helper
        if( !isset( $this->helpers[$helper] ) ) {
            $this->include_helper( $helper );

            // Get class name from filename
            $class_name = 'DWC';

            $dirs = explode( '/', $helper );
            $file = end( $dirs );
            $name_parts = explode( '_', $file );
            foreach( $name_parts as $name_part ) {
                $class_name .= '_' . ucfirst( $name_part );
            }

            // Instantiate class if exists
            if( class_exists( $class_name ) ) {
                $this->helpers[$helper] = new $class_name();
            }
        }

        // Return helper instance
        return $this->helpers[$helper];
    }

    /**
     * Include a helper. Looks through all helper directories that have been added.
     */
    public function include_helper( $helper )
    {
        foreach( $this->helper_dirs as $dir )
        {
            $file = $dir . '/'.$helper.'.php';

            if( file_exists( $file ) ) {
                require_once( $file );
            }
        }
    }

    /**
     * Add a directory to look for helpers.
     */
    public function add_helper_directory( $dir )
    {
        if( is_dir( $dir ) ) {
            $this->helper_dirs[] = $dir;
        }
    }

    /*
     * Quick access functions
     */
}

DynamicWidgetContent::get();