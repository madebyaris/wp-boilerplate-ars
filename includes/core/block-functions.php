<?php
/**
 * Block-related functions
 *
 * @link       ${PLUGIN_URI}
 * @since      1.0.0
 *
 * @package    ${PLUGIN_NAMESPACE}
 * @subpackage ${PLUGIN_NAMESPACE}/includes/core
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @since    1.0.0
 */
function block_init() {
    // Bail early if blocks are not supported
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }
    
    // Get all block directories
    $block_directories = glob( ${PLUGIN_PREFIX}_PLUGIN_DIR . 'blocks/*', GLOB_ONLYDIR );
    
    if ( ! empty( $block_directories ) ) {
        foreach ( $block_directories as $block_dir ) {
            // Get block name from directory name
            $block_name = basename( $block_dir );
            
            // Check if block.json exists
            $block_json_file = $block_dir . '/block.json';
            
            if ( file_exists( $block_json_file ) ) {
                // Register block type from metadata
                register_block_type( $block_json_file );
            } else {
                // Log warning about missing block.json
                ${PLUGIN_PREFIX}_log( "Block {$block_name} is missing block.json file", 'warning' );
            }
        }
    }
    
    /**
     * Action that fires after all blocks are registered
     *
     * @since 1.0.0
     * @param array $block_directories The block directories
     */
    do_action( '${PLUGIN_PREFIX}_blocks_registered', $block_directories );
}

/**
 * Register a custom block category for the plugin blocks
 *
 * @since    1.0.0
 * @param    array     $categories    List of existing block categories.
 * @return   array                    Modified block categories.
 */
function ${PLUGIN_PREFIX}_block_category( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => '${PLUGIN_SLUG}',
                'title' => __( '${PLUGIN_NAME}', '${PLUGIN_TEXT_DOMAIN}' ),
                'icon'  => 'admin-plugins',
            ),
        )
    );
}

// Add filter for block categories (WP 5.8+)
add_filter( 'block_categories_all', '${PLUGIN_PREFIX}_block_category' );

/**
 * Helper function to register a custom block
 *
 * @since    1.0.0
 * @param    string    $block_name    The block name/slug.
 * @param    array     $args          The block arguments.
 * @return   boolean                  Whether the block was registered successfully.
 */
function ${PLUGIN_PREFIX}_register_custom_block( $block_name, $args = array() ) {
    // Bail early if blocks are not supported
    if ( ! function_exists( 'register_block_type' ) ) {
        return false;
    }
    
    // Ensure block name starts with the plugin namespace
    if ( strpos( $block_name, '${PLUGIN_SLUG}/' ) !== 0 ) {
        $block_name = '${PLUGIN_SLUG}/' . $block_name;
    }
    
    try {
        // Merge with default args
        $default_args = array(
            'editor_script' => '${PLUGIN_SLUG}-editor-script',
            'editor_style'  => '${PLUGIN_SLUG}-editor-style',
            'style'         => '${PLUGIN_SLUG}-style',
            'category'      => '${PLUGIN_SLUG}',
        );
        
        $args = wp_parse_args( $args, $default_args );
        
        // Register the block
        register_block_type( $block_name, $args );
        
        return true;
    } catch ( Exception $e ) {
        // Log any errors
        ${PLUGIN_PREFIX}_log( "Error registering block {$block_name}: " . $e->getMessage(), 'error' );
        
        return false;
    }
} 