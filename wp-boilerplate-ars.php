<?php
/**
 * Plugin Name: ${PLUGIN_NAME}
 * Plugin URI: ${PLUGIN_URI}
 * Description: ${PLUGIN_DESCRIPTION}
 * Version: 1.0.0
 * Author: ${AUTHOR_NAME}
 * Author URI: ${AUTHOR_URI}
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: ${PLUGIN_TEXT_DOMAIN}
 * Domain Path: /languages
 *
 * @package ${PLUGIN_NAMESPACE}
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
define( '${PLUGIN_PREFIX}_VERSION', '1.0.0' );
define( '${PLUGIN_PREFIX}_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( '${PLUGIN_PREFIX}_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( '${PLUGIN_PREFIX}_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( '${PLUGIN_PREFIX}_PLUGIN_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 */
function ${PLUGIN_PREFIX}_activate() {
    // Activation logic will be handled by the Install class
    ${PLUGIN_NAMESPACE}\Data\Install::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function ${PLUGIN_PREFIX}_deactivate() {
    // Deactivation logic will be handled by the Install class
    ${PLUGIN_NAMESPACE}\Data\Install::deactivate();
}

register_activation_hook( __FILE__, '${PLUGIN_PREFIX}_activate' );
register_deactivation_hook( __FILE__, '${PLUGIN_PREFIX}_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once ${PLUGIN_PREFIX}_PLUGIN_DIR . 'includes/core/class-plugin-name.php';

/**
 * Load helper functions
 * Note: Functions are not classes and need to be loaded directly
 */
require_once ${PLUGIN_PREFIX}_PLUGIN_DIR . 'includes/core/functions.php';

/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function ${PLUGIN_PREFIX}_run() {
    $plugin = new ${PLUGIN_NAMESPACE}\Core\Plugin_Name();
    $plugin->run();
}

${PLUGIN_PREFIX}_run(); 