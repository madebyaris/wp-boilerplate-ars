<?php
/**
 * Default settings for the plugin
 *
 * @package    ${PLUGIN_NAMESPACE}
 * @subpackage ${PLUGIN_NAMESPACE}/config
 * @since      1.0.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * This file should return an array of default settings
 * Each setting should use the plugin prefix to avoid conflicts
 */
return array(
    // Example settings
    '${PLUGIN_PREFIX}_example_option'      => 'default value',
    '${PLUGIN_PREFIX}_another_setting'     => true,
    '${PLUGIN_PREFIX}_advanced_setting'    => array(
        'key1' => 'value1',
        'key2' => 'value2',
    ),
); 