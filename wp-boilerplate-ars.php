<?php
/**
 * Plugin Name: WP Boilerplate
 * Plugin URI: https://github.com/madebyaris/wp-boilerplate
 * Description: A modern WordPress plugin boilerplate with PSR-4 autoloading, Vite integration, and CLI tools
 * Version: 1.0.0
 * Author: Aris
 * Author URI: https://github.com/madebyaris
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-boilerplate
 * Domain Path: /languages
 *
 * @package MadeByAris\WPBoilerplate
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Composer autoloader
if ( file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
}

// Define plugin constants
define( 'WP_BOILERPLATE_VERSION', '1.0.0' );
define( 'WP_BOILERPLATE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_BOILERPLATE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_BOILERPLATE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WP_BOILERPLATE_PLUGIN_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 */
function wp_boilerplate_activate() {
    // Activation logic will be handled by the Install class
    if (class_exists('MadeByAris\WPBoilerplate\Data\Install')) {
        MadeByAris\WPBoilerplate\Data\Install::activate();
    }
}

/**
 * The code that runs during plugin deactivation.
 */
function wp_boilerplate_deactivate() {
    // Deactivation logic will be handled by the Install class
    if (class_exists('MadeByAris\WPBoilerplate\Data\Install')) {
        MadeByAris\WPBoilerplate\Data\Install::deactivate();
    }
}

register_activation_hook( __FILE__, 'wp_boilerplate_activate' );
register_deactivation_hook( __FILE__, 'wp_boilerplate_deactivate' );

/**
 * Load helper functions
 * Note: Functions are not classes and need to be loaded directly
 */
require_once WP_BOILERPLATE_PLUGIN_DIR . 'includes/core/functions.php';

/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function wp_boilerplate_run() {
    if (class_exists('MadeByAris\WPBoilerplate\Core\Plugin_Name')) {
        $plugin = new MadeByAris\WPBoilerplate\Core\Plugin_Name();
        $plugin->run();
    }
}

wp_boilerplate_run(); 