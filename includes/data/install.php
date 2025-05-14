<?php
/**
 * Fired during plugin activation/deactivation
 *
 * @link       https://github.com/madebyaris/wp-boilerplate
 * @since      1.0.0
 *
 * @package    MadeByAris\WPBoilerplate
 * @subpackage MadeByAris\WPBoilerplate\Data
 */

namespace MadeByAris\WPBoilerplate\Data;

/**
 * Fired during plugin activation/deactivation.
 *
 * This class defines all code necessary to run during the plugin's activation and deactivation.
 *
 * @since      1.0.0
 * @package    MadeByAris\WPBoilerplate
 * @subpackage MadeByAris\WPBoilerplate\Data
 * @author     Aris
 */
class Install {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        // Create custom database tables if needed
        self::create_tables();
        
        // Add default options
        self::add_default_options();
        
        // Set version
        update_option( 'wp_boilerplate_version', WP_BOILERPLATE_VERSION );
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        /**
         * Fires after plugin activation
         *
         * @since 1.0.0
         */
        do_action( 'wp_boilerplate_activated' );
    }

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        // Clean up if necessary
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        /**
         * Fires after plugin deactivation
         *
         * @since 1.0.0
         */
        do_action( 'wp_boilerplate_deactivated' );
    }
    
    /**
     * Create any database tables needed for the plugin
     *
     * @since    1.0.0
     */
    private static function create_tables() {
        global $wpdb;
        
        // Example of creating a table - uncomment if needed
        /*
        $table_name = $wpdb->prefix . 'wp_boilerplate_example';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name tinytext NOT NULL,
            text text NOT NULL,
            url varchar(55) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
        */
    }
    
    /**
     * Add default options to the database
     *
     * @since    1.0.0
     */
    private static function add_default_options() {
        // Load default options from config file
        if (defined('WP_BOILERPLATE_PLUGIN_DIR') && file_exists(WP_BOILERPLATE_PLUGIN_DIR . 'config/default-settings.php')) {
            $default_options = include WP_BOILERPLATE_PLUGIN_DIR . 'config/default-settings.php';
            
            // Add each option if it doesn't already exist
            foreach ( $default_options as $option_name => $option_value ) {
                if ( false === get_option( $option_name ) ) {
                    add_option( $option_name, $option_value );
                }
            }
        }
    }
} 