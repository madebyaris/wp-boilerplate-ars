<?php
/**
 * Provide a admin area view for the plugin settings fields
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

<input type="text" 
       name="<?php echo esc_attr( '${PLUGIN_PREFIX}_example_option' ); ?>" 
       id="<?php echo esc_attr( '${PLUGIN_PREFIX}_example_option' ); ?>" 
       value="<?php echo esc_attr( $option ); ?>" 
       class="regular-text" />

<p class="description">
    <?php esc_html_e( 'This is an example setting field. Replace with your own content.', '${PLUGIN_TEXT_DOMAIN}' ); ?>
</p>

<?php
/**
 * Action to add content after this field
 *
 * @since 1.0.0
 * @param string $option The current option value
 */
do_action( '${PLUGIN_PREFIX}_after_example_field', $option );
?> 