<?php
/**
 * Main Admin class responsible for handling admin section functions, hooks and files
 *
 * @package Theme Wing
 * @since 1.0.0
 */

if( !class_exists( 'Theme_Wing_Admin' ) ) :
  class Theme_Wing_Admin {
    protected $_instance;
    /**
     * Array of registered post types
     *
     */
     private $custom_post_types = array();

     /**
      * Ensures only one instance of the class is loaded or can be loaded
      *
      * @access public
      * @static
      *
      */
     public static function instance() {
         if( is_null( self::$_instance ) ) {
             self::$_instance = new self();
         }
         return self::$_instance;
     }

     /**
      * Load Class functionality
      *
      */
     public function __construct() {
         $this->init();
     }

     /**
      * Initialization of the plugin class
      *
      * Theme_Wing_Admin
      *
      */
     public function init() {
         $this->load_files(); // call load files fnc
         add_action( 'admin_menu', array( $this, 'register_plugin_page' ), 10 );
         add_action( 'admin_init', array( $this, 'register_plugin_settings' ), 99999 );
         add_action( 'rest_api_init', array( $this, 'register_plugin_settings' ) );
         add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10 );
         $this->load_textdomain();
     }

     /**
      * Load dependency files
      *
      */
      function load_files() {
        include THEME_WING_PATH . '/admin/class-posttypes.php';
        include THEME_WING_PATH . '/admin/admin-helpers.php';
        include THEME_WING_PATH . '/admin/metaboxes/metaboxes.php';
      }

    /**
     * Loads the plugin language files.
     *
     * @since 1.0.0
     */
    public function load_textdomain() {

        load_plugin_textdomain( 'theme-wing', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

      /**
       * Enqueue plugin admin scripts
       * 
       * @package Theme Wing
       * @since 1.0.0
       */ 
      function admin_enqueue_scripts( $hook ) {
        if ( $hook != 'appearance_page_theme_wing_settings' ) return;
        wp_enqueue_style( 'theme-wing-admin-style', THEME_WING_URI . '/admin/core/build/index.css', array( 'wp-components' ), THEME_WING_VERSION, 'all');
        wp_enqueue_script( 'theme-wing-admin-script', THEME_WING_URI . '/admin/core/build/index.js', array( 'react', 'wp-api', 'wp-element', 'wp-polyfill', 'wp-components' ), THEME_WING_VERSION, true);
        wp_set_script_translations( 'theme-wing-admin-script', 'theme-wing' );
      }

      /**
       * Register plugin admin page settings
       * 
       * @package Theme Wing
       * @since 1.0.0
       */
       function register_plugin_page() {
            // adds plugin page 
            add_theme_page(
                __( 'Theme Wing', 'theme-wing' ),
                __( 'Theme Wing', 'theme-wing' ),
                'manage_options',
                'theme_wing_settings',
                array( $this, 'admin_html' )
            );
       }

      /**
       * Register plugin settings
       * 
       * @package Theme Wing
       * @since 1.0.0
       */
      function register_plugin_settings() {
        // register plugin settings value in rest api
        register_setting(
            'theme_wing_admin_option_group',
            'theme_wing_admin_option',
            array(
                'type'         => 'string',
                'default'      => json_encode( apply_filters( 'theme_wing_post_types_array_filter', $this->get_admin_setting() ) ),
                'show_in_rest' => true
            )
        );
      }

      /**
       * Get plugin admin option
       * 
       * @package Theme Wing
       * @since 1.0.0
       */ 
      function get_admin_setting() {
        $theme_wing_admin_option = get_option( 'theme_wing_admin_option' );
        if( ! $theme_wing_admin_option ) true;
        return json_decode( $theme_wing_admin_option, true );
      }

      /**
       * Callback for plugin admin page
       * 
       * @package Theme Wing
       * @since 1.0.0
       */
       function admin_html() {
        ?>
            <div id="theme-wing-admin-main"></div>
        <?php
       }
  }
  new Theme_Wing_Admin() ;
endif;