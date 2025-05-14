<?php
/**
 * Provide a admin area view for the plugin settings page
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       ${PLUGIN_URI}
 * @since      1.0.0
 *
 * @package    ${PLUGIN_NAMESPACE}
 * @subpackage ${PLUGIN_NAMESPACE}/includes/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    
    <?php settings_errors(); ?>
    
    <form method="post" action="options.php">
        <?php
        // Output security fields
        settings_fields( $this->plugin_name . '-settings' );
        
        // Output setting sections and their fields
        do_settings_sections( $this->plugin_name );
        
        // Output save settings button
        submit_button( __( 'Save Settings', '${PLUGIN_TEXT_DOMAIN}' ) );
        ?>
    </form>
    
    <?php
    /**
     * Action to add content after the settings form
     *
     * @since 1.0.0
     */
    do_action( '${PLUGIN_PREFIX}_after_settings_form' );
    ?>
</div> 