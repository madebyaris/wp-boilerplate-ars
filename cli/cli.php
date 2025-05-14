#!/usr/bin/env php
<?php
/**
 * WP Boilerplate CLI Command Runner
 *
 * @package    WP_Boilerplate_ARS
 * @subpackage WP_Boilerplate_ARS/cli
 */

// Get the plugin path (one directory up from this file)
$plugin_path = dirname( __DIR__ );

// Load the CLI class
require_once $plugin_path . '/cli/class-plugin-cli.php';

// Create a new CLI instance and run the command
$cli = new WP_Boilerplate_CLI( $plugin_path );
$exit_code = $cli->run( $argv );

// Exit with the appropriate code
exit( $exit_code ); 