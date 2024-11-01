<?php
/**
 * Main Admin class responsible for handling admin section functions, hooks and files
 *
 * @package Theme Wing
 * @since 1.0.0
 */

if( !class_exists( 'Theme_Wing_Admin_Posttypes' ) ) :
  class Theme_Wing_Admin_Posttypes {
    /**
     * 
     */
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
        $this->custom_post_types = ( get_option( 'theme_wing_admin_option' ) ) ? json_decode( get_option( 'theme_wing_admin_option' ), true ) : false;
        $this->init();
     }

     /**
      * Initialization of the plugin class
      *
      * Theme_Wing_Admin
      *
      */
     public function init() {
        add_action( 'init', array( $this, 'register_post_type' ), 999999 );
        add_action( 'rest_api_init', array( $this, 'register_post_type' ), 999999 );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
     }

     /**
      * Enqueue required scripts and styles  
      * 
      */
     function admin_enqueue_scripts() {
        wp_enqueue_style( 'fontawesome', THEME_WING_URI . '/assets/lib/fontawesome/css/all.min.css', array(), '5.15.3', 'all' );
        wp_enqueue_style( 'theme-wing-metaboxes', THEME_WING_URI . '/admin/metaboxes/metaboxes.css', array(), THEME_WING_VERSION, 'all' );
        wp_enqueue_script( 'theme-wing-metaboxes', THEME_WING_URI . '/admin/metaboxes/metaboxes.js', array(), THEME_WING_VERSION, true );
    }
    
     /**
      * Register given postypes
      * 
      * @return
      * 
      */
      function register_post_type() {
        $postype_slugs = apply_filters( 'theme_wing_post_types_array_filter', $this->custom_post_types );
        foreach( $postype_slugs as $postype_slug ) :
            register_post_type( $postype_slug, $this->get_args( $postype_slug ) );
        endforeach;
      }

      /**
       *  Label of all the post types
       * 
       * @return array w.r.t parameter
       * 
       */ 
      function get_labels( $post_type = '' ) {
        if( empty( $post_type ) ) return;
        $labels = array(
            'tw-services'   => array(
                'name'              => esc_html__( 'Services', 'theme-wing' ),
                'singular_name'     => esc_html__( 'Service', 'theme-wing' ),
                'add_new'           => esc_html__( 'Add New Service', 'theme-wing' ),
                'edit_item'         => esc_html__( 'Edit Services', 'theme-wing' ),
                'all_items'         => esc_html__( 'All Services', 'theme-wing' ),
                'view_item'         => esc_html__( 'View Services', 'theme-wing' ),
                'search_item'       => esc_html__( 'Search Service', 'theme-wing' ),
                'not_found'         => esc_html__( 'No Service Found', 'theme-wing' ),
                'not_found_in_trash'    => esc_html__( 'No Service Found in Trash', 'theme-wing' )
            ),
            'tw-team'   => array(
                'name'          => esc_html__( 'Team', 'theme-wing' ),
                'singular_name' => esc_html__( 'Team', 'theme-wing' ),
                'add_new'       => esc_html__( 'Add new team', 'theme-wing' ),
                'edit_item'     => esc_html__( 'Edit teams', 'theme-wing' ),
                'all_items'     => esc_html__( 'All Teams', 'theme-wing' ),
                'view_item'     => esc_html__( 'View Teams', 'theme-wing' ),
                'search_item'   => esc_html__( 'Search Teams', 'theme-wing' ),
                'not_found'     => esc_html__( 'Team not Found', 'theme-wing' ),
            ),
            'tw-pricing'   => array(
                'name'          => esc_html__( 'Pricing', 'theme-wing' ),
                'singular_name' => esc_html__( 'Pricing', 'theme-wing' ),
                'add_new'       => esc_html__( 'Add new pricing', 'theme-wing' ),
                'edit_item'     => esc_html__( 'Edit pricings', 'theme-wing' ),
                'all_items'     => esc_html__( 'All pricings', 'theme-wing' ),
                'view_item'     => esc_html__( 'View pricings', 'theme-wing' ),
                'search_item'   => esc_html__( 'Search pricings', 'theme-wing' ),
                'not_found'     => esc_html__( 'Pricing not Found', 'theme-wing' ),
            ),
            'tw-projects'   => array(
                'name'          => esc_html__( 'Projects', 'theme-wing' ),
                'singular_name' => esc_html__( 'Project', 'theme-wing' ),
                'add_new'       => esc_html__( 'Add new project', 'theme-wing' ),
                'edit_item'     => esc_html__( 'Edit projects', 'theme-wing' ),
                'all_items'     => esc_html__( 'All projects', 'theme-wing' ),
                'view_item'     => esc_html__( 'View projects', 'theme-wing' ),
                'search_item'   => esc_html__( 'Search projects', 'theme-wing' ),
                'not_found'     => esc_html__( 'Project not found.', 'theme-wing' ),
            )
        );
        return apply_filters( 'theme_wing_' .esc_html( $post_type ). '_labels', $labels[$post_type] );
      }

      /**
       *  Supports arguments of all the post types
       * 
       * @return array w.r.t parameter
       * 
       */ 
      function get_supports( $post_type = '' ) {
        if( empty( $post_type ) ) return;
        $supports = array(
            'tw-services'   => array( 'title', 'editor', 'thumbnail' ),
            'tw-team'       => array( 'title', 'editor', 'thumbnail' ),
            'tw-pricing'    => array( 'title', 'editor', 'thumbnail' ),
            'tw-projects'   => array( 'title', 'editor', 'thumbnail' )
        );
        return apply_filters( 'theme_wing_' .esc_html( $post_type ). '_supports', $supports[$post_type] );
      }

      /**
       *  Arguments of all the post types
       * 
       * @return array w.r.t parameter
       * 
       */ 
      function get_args( $post_type = '' ) {
        if( empty( $post_type ) ) return;
        $args = array(
            'tw-services'   => array(
                'labels'        => $this->get_labels( $post_type ),
                'description'   => esc_html__( 'Services custom type lets user to add services in their websites.', 'theme-wing' ), 
                'public'        => true,
                'publicly_queryable'    => true,
                'menu_position' => 30,
                'menu_icon'     => 'dashicons-share',
                'show_in_rest'  => true,
                'supports'      => $this->get_supports( $post_type ),
                'has_archive'   => true,
                'rewrite'       => true,
                'register_meta_box_cb'  => 'theme_wing_services_meta_box'
            ),
            'tw-team'   => array(
                'labels'        => $this->get_labels( $post_type ),
                'description'   => esc_html__( 'Team custom type lets user to add teams in their websites.', 'theme-wing' ),
                'public'        => true,
                'publicly_queryable'    => true,
                'menu_position' => 35,
                'menu_icon'     => 'dashicons-groups',
                'rewrite'       => true,
                'show_in_rest'  => true,
                'supports'      => $this->get_supports( $post_type ),
                'has_archive'   => true,
                'register_meta_box_cb'  => 'theme_wing_team_meta_box'
            ),
            'tw-pricing'   => array(
                'labels'        => $this->get_labels( $post_type ),
                'description'   => esc_html__( 'Pricing custom type lets user to add pricings in their websites.', 'theme-wing' ),
                'public'        => true,
                'publicly_queryable'    => true,
                'menu_position' => 35,
                'menu_icon'     => 'dashicons-welcome-widgets-menus',
                'rewrite'       => true,
                'show_in_rest'  => true,
                'supports'      => $this->get_supports( $post_type ),
                'has_archive'   => true,
                'register_meta_box_cb'  => 'theme_wing_pricing_meta_box'
            ),
            'tw-projects'   => array(
                'labels'        => $this->get_labels( $post_type ),
                'description'   => esc_html__( 'Projects custom type lets user to add pricings in their websites.', 'theme-wing' ),
                'public'        => true,
                'publicly_queryable'    => true,
                'menu_position' => 35,
                'menu_icon'     => 'dashicons-products',
                'rewrite'       => true,
                'show_in_rest'  => true,
                'supports'      => $this->get_supports( $post_type ),
                'has_archive'   => true,
                'register_meta_box_cb'  => 'theme_wing_projects_meta_box'
            )
        );
        return apply_filters( 'theme_wing_' .esc_html( $post_type ). '_args', $args[$post_type] );
      }
  }
  new Theme_Wing_Admin_Posttypes() ;
endif;
