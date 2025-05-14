#!/usr/bin/env php
<?php
/**
 * WP Boilerplate CLI Command Runner
 *
 * @package    WP_Boilerplate_ARS
 * @subpackage WP_Boilerplate_ARS/cli
 */

// Get the plugin path (one directory up from this file)
$plugin_path = dirname( __FILE__ );

// Load the CLI class
require_once $plugin_path . '/cli/class-plugin-cli.php';

// Create a new CLI instance
$cli = new WP_Boilerplate_CLI( $plugin_path );

// Detect if this is a fresh Composer installation or a regular CLI command
$is_first_run = false;

// Check for Composer's post-create-project-cmd hook or detect if this is being run directly after installation
if ((isset($argv[1]) && $argv[1] === '--setup') || 
    (isset($_SERVER['COMPOSER_BINARY']) && basename($_SERVER['COMPOSER_BINARY']) === 'composer')) {
    $is_first_run = true;
}

// If this is the first run or explicit setup, do interactive setup
if ($is_first_run) {
    echo "\n🚀 Setting up your new WordPress plugin boilerplate\n";
    echo "==============================================\n\n";
    
    // Gather plugin information
    $name = readline("📝 Plugin Name: ");
    $author = readline("👤 Author Name: ");
    $slug = readline("🔗 Plugin Slug (lowercase with hyphens): ");
    $description = readline("📄 Plugin Description: ");
    $blocks = strtolower(readline("📦 Include Block Support? (yes/no): ")) === 'yes';
    $uri = readline("🌐 Plugin URI (optional): ");
    $author_uri = readline("🔗 Author URI (optional): ");
    $php = readline("🐘 Minimum PHP Version (default: 8.0): ");
    
    if (empty($php)) {
        $php = '8.0';
    }
    
    // Build the init command arguments
    $args = array(
        'init',
        '--name=' . $name,
        '--author=' . $author,
        '--slug=' . $slug,
        '--description=' . $description,
        '--php=' . $php
    );
    
    if (!empty($uri)) {
        $args[] = '--uri=' . $uri;
    }
    
    if (!empty($author_uri)) {
        $args[] = '--author-uri=' . $author_uri;
    }
    
    if ($blocks) {
        $args[] = '--blocks';
    }
    
    // Execute the init command
    $exit_code = $cli->run($args);
    
    // Display success message if initialization succeeded
    if ($exit_code === 0) {
        echo "\n✅ Plugin initialization complete!\n\n";
        echo "🎉 Your new WordPress plugin has been created successfully.\n";
        echo "📁 Plugin location: " . realpath($plugin_path . '/../' . $slug) . "\n\n";
        echo "Next steps:\n";
        echo "1. cd " . $slug . "\n";
        echo "2. composer install\n";
        echo "3. npm install && npm run build\n\n";
    }
} else {
    // Normal CLI operation - pass through all arguments
    $exit_code = $cli->run($argv);
}

// Exit with the appropriate code
exit($exit_code); 