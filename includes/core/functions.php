<?php
/**
 * Core plugin functions
 *
 * @link       https://github.com/madebyaris/wp-boilerplate
 * @since      1.0.0
 *
 * @package    MadeByAris\WPBoilerplate
 * @subpackage MadeByAris\WPBoilerplate\Core
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Get a plugin option with default value fallback
 *
 * @since    1.0.0
 * @param    string    $option_name    The option name to retrieve.
 * @param    mixed     $default        Default value to return if option is not set.
 * @return   mixed                     The option value.
 */
function wp_boilerplate_get_option( $option_name, $default = false ) {
    $option = get_option( $option_name, $default );
    
    /**
     * Filter the option value
     *
     * @since 1.0.0
     * @param mixed $option The option value
     * @param string $option_name The option name
     * @param mixed $default Default value
     */
    return apply_filters( 'wp_boilerplate_get_option', $option, $option_name, $default );
}

/**
 * Example custom function that can be called from other plugins or themes
 *
 * @since    1.0.0
 * @param    string    $input    Some input string.
 * @return   string              Modified output.
 */
function wp_boilerplate_example_function( $input = '' ) {
    // Add your custom logic here
    $output = 'Modified: ' . $input;
    
    /**
     * Filter the example function output
     *
     * @since 1.0.0
     * @param string $output The function output
     * @param string $input The function input
     */
    return apply_filters( 'wp_boilerplate_example_function', $output, $input );
}

/**
 * Get the URL for a plugin asset
 *
 * @since    1.0.0
 * @param    string    $path    The relative path to the asset.
 * @return   string             The full URL to the asset.
 */
function wp_boilerplate_asset_url( $path ) {
    $url = defined('WP_BOILERPLATE_PLUGIN_URL') ? WP_BOILERPLATE_PLUGIN_URL . trim( $path, '/' ) : '/' . trim( $path, '/' );
    
    /**
     * Filter the asset URL
     *
     * @since 1.0.0
     * @param string $url The full URL to the asset
     * @param string $path The relative path to the asset
     */
    return apply_filters( 'wp_boilerplate_asset_url', $url, $path );
}

/**
 * Check if debug mode is enabled
 *
 * @since    1.0.0
 * @return   boolean    Whether debug mode is enabled.
 */
function wp_boilerplate_is_debug() {
    $debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG );
    
    /**
     * Filter the debug mode
     *
     * @since 1.0.0
     * @param boolean $debug Whether debug mode is enabled
     */
    return apply_filters( 'wp_boilerplate_is_debug', $debug );
}

/**
 * Log a message to the debug.log file
 *
 * @since    1.0.0
 * @param    mixed     $message    The message to log.
 * @param    string    $level      The log level.
 */
function wp_boilerplate_log( $message, $level = 'info' ) {
    if ( wp_boilerplate_is_debug() ) {
        if ( is_array( $message ) || is_object( $message ) ) {
            $message = print_r( $message, true );
        }
        
        $log_message = '[' . strtoupper( $level ) . '] ' . $message;
        
        // Log the message
        error_log( $log_message );
        
        /**
         * Action that fires after a message is logged
         *
         * @since 1.0.0
         * @param string $log_message The logged message
         * @param string $level The log level
         */
        do_action( 'wp_boilerplate_logged_message', $log_message, $level );
    }
} 