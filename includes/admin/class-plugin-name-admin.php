<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       ${PLUGIN_URI}
 * @since      1.0.0
 *
 * @package    ${PLUGIN_NAMESPACE}
 * @subpackage ${PLUGIN_NAMESPACE}/includes/admin
 */

namespace ${PLUGIN_NAMESPACE}\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks for
 * enqueuing the admin-specific stylesheet and JavaScript.
 *
 * @package    ${PLUGIN_NAMESPACE}
 * @subpackage ${PLUGIN_NAMESPACE}/includes/admin
 * @author     ${AUTHOR_NAME}
 */
class Plugin_Name_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of this plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            ${PLUGIN_PREFIX}_PLUGIN_URL . 'assets/dist/admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            ${PLUGIN_PREFIX}_PLUGIN_URL . 'assets/dist/admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );
        
        // Localize the script with new data
        $localize_data = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( '${PLUGIN_PREFIX}_nonce' ),
        );
        wp_localize_script( $this->plugin_name, '${PLUGIN_PREFIX}_data', $localize_data );
    }
    
    /**
     * Add settings page to the admin menu
     *
     * @since    1.0.0
     */
    public function add_settings_page() {
        add_options_page(
            __( '${PLUGIN_NAME} Settings', '${PLUGIN_TEXT_DOMAIN}' ),
            __( '${PLUGIN_NAME}', '${PLUGIN_TEXT_DOMAIN}' ),
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_settings_page' )
        );
    }
    
    /**
     * Display the settings page content
     *
     * @since    1.0.0
     */
    public function display_settings_page() {
        // Include settings page view
        require_once ${PLUGIN_PREFIX}_PLUGIN_DIR . 'includes/admin/partials/settings-page.php';
    }
    
    /**
     * Register settings and fields
     *
     * @since    1.0.0
     */
    public function register_settings() {
        // Register a setting
        register_setting(
            $this->plugin_name . '-settings',         // Option group
            '${PLUGIN_PREFIX}_example_option',        // Option name
            array( $this, 'sanitize_example_option' ) // Sanitize callback
        );
        
        // Add a section
        add_settings_section(
            $this->plugin_name . '-general',                                 // ID
            __( 'General Settings', '${PLUGIN_TEXT_DOMAIN}' ),               // Title
            array( $this, 'display_general_section_description' ),           // Callback
            $this->plugin_name                                               // Page
        );
        
        // Add a field
        add_settings_field(
            '${PLUGIN_PREFIX}_example_option',                              // ID
            __( 'Example Setting', '${PLUGIN_TEXT_DOMAIN}' ),               // Title
            array( $this, 'display_example_option_field' ),                 // Callback
            $this->plugin_name,                                             // Page
            $this->plugin_name . '-general'                                 // Section
        );
        
        /**
         * Action that fires after settings are registered
         *
         * @since 1.0.0
         * @param string $plugin_name The name of the plugin
         */
        do_action( '${PLUGIN_PREFIX}_settings_registered', $this->plugin_name );
    }
    
    /**
     * Display the general section description
     *
     * @since    1.0.0
     */
    public function display_general_section_description() {
        echo '<p>' . esc_html__( 'Configure general settings for the plugin.', '${PLUGIN_TEXT_DOMAIN}' ) . '</p>';
    }
    
    /**
     * Display the example option field
     *
     * @since    1.0.0
     */
    public function display_example_option_field() {
        $option = get_option( '${PLUGIN_PREFIX}_example_option' );
        
        // Get the field HTML from a partial
        require ${PLUGIN_PREFIX}_PLUGIN_DIR . 'includes/admin/partials/settings-section.php';
    }
    
    /**
     * Sanitize the example option value
     *
     * @since    1.0.0
     * @param    string    $input    The value to sanitize.
     * @return   string              The sanitized value.
     */
    public function sanitize_example_option( $input ) {
        // Sanitize the input
        $sanitized = sanitize_text_field( $input );
        
        /**
         * Filter the sanitized option value
         *
         * @since 1.0.0
         * @param string $sanitized Sanitized value
         * @param string $input Original input
         */
        return apply_filters( '${PLUGIN_PREFIX}_sanitize_example_option', $sanitized, $input );
    }
} 