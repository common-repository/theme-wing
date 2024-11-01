<?php
/**
 * Plugin Name: Theme Wing
 * Description: Adds up functionali ty like custom post types and custom post meta for blazethemes themes.
 * Author:      Blaze Themes
 * Author URI:  https://blazethemes.com/
 * Version: 1.0.0
 * Text Domain: theme-wing
 * Domain Path: languages
 */
 define( 'THEME_WING_VERSION', '1.0.0' );
 define( 'THEME_WING_PATH', plugin_dir_path( __FILE__ ) );
 define( 'THEME_WING_URI', plugin_dir_url( __FILE__ ) );
 include THEME_WING_PATH . '/admin/class-theme-wing-admin.php';

if( ! function_exists( 'theme_wing_activate' ) ) :
  /**
   * Removes rewrite rules and then recreate rewrite rules.
   * 
   * @package Theme Wing
   * @since 1.0.0
   */ 
   register_activation_hook(__FILE__, 'theme_wing_activate');
   register_deactivation_hook(__FILE__, 'theme_wing_activate');
    function theme_wing_activate() {
      global $wp_rewrite;
      $wp_rewrite->flush_rules();
    }
endif;