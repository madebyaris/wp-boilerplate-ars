<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @since      1.0.0
 * @package    ${PLUGIN_NAMESPACE}
 * @subpackage ${PLUGIN_NAMESPACE}/includes/core
 */

namespace ${PLUGIN_NAMESPACE}\Core;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @since      1.0.0
 * @package    ${PLUGIN_NAMESPACE}
 * @subpackage ${PLUGIN_NAMESPACE}/includes/core
 * @author     ${AUTHOR_NAME}
 */
class Plugin_Name {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( '${PLUGIN_PREFIX}_VERSION' ) ) {
            $this->version = ${PLUGIN_PREFIX}_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = '${PLUGIN_SLUG}';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        
        // Load optional block functionality if needed
        if ( $this->is_block_support_enabled() ) {
            $this->define_block_hooks();
        }
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        // The class responsible for orchestrating the actions and filters of the core plugin.
        // The loader is created here since it's used immediately in this class
        $this->loader = new Plugin_Loader();
        
        // Load optional block functionality if needed
        if ( $this->is_block_support_enabled() ) {
            require_once ${PLUGIN_PREFIX}_PLUGIN_DIR . 'includes/core/block-functions.php';
        }
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new I18n();
        $plugin_i18n->set_domain( $this->plugin_name );

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new \${PLUGIN_NAMESPACE}\Admin\Plugin_Name_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        
        // Add settings page
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_settings_page' );
        
        // Register settings
        $this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        // Optional: Add public-facing hooks if needed
    }
    
    /**
     * Register all of the hooks related to blocks functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_block_hooks() {
        // Add block registration hooks only if block support is enabled
        $this->loader->add_action( 'init', '${PLUGIN_NAMESPACE}\Core\block_init' );
    }
    
    /**
     * Check if block support is enabled for this plugin
     * 
     * @since    1.0.0
     * @access   private
     * @return   boolean    Whether block support is enabled
     */
    private function is_block_support_enabled() {
        // This can be modified to check a setting or constant
        // For now, we just check if the block directory exists
        return file_exists( ${PLUGIN_PREFIX}_PLUGIN_DIR . 'blocks' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
        
        /**
         * Action that fires after the plugin is fully loaded
         *
         * @since 1.0.0
         * @param object $this Main plugin object
         */
        do_action( '${PLUGIN_PREFIX}_loaded', $this );
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Plugin_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
} 