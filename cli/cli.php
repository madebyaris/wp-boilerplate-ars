#!/usr/bin/env php
<?php
/**
 * WP Boilerplate CLI Command Runner
 *
 * This script provides CLI functionality for WordPress plugin development.
 */

// Get the plugin path
$plugin_path = dirname(__FILE__);

// Load the CLI class
require_once $plugin_path . '/class-plugin-cli.php';

// Create a new CLI instance
$cli = new WP_Boilerplate_CLI($plugin_path);

// Check if this is a setup command
if (isset($argv[1]) && $argv[1] === '--setup') {
    // Convert --setup to the correct format for the CLI
    $argv[1] = 'init';
    
    // Gather plugin information interactively
    echo "\n🚀 Setting up your new WordPress plugin boilerplate\n";
    echo "==============================================\n\n";
    
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
    
    // Create a new argument array
    $argv = ['wp-boilerplate', 'init'];
    $argv[] = '--name=' . $name;
    $argv[] = '--author=' . $author;
    $argv[] = '--slug=' . $slug;
    $argv[] = '--description=' . $description;
    $argv[] = '--php=' . $php;
    
    if (!empty($uri)) {
        $argv[] = '--uri=' . $uri;
    }
    
    if (!empty($author_uri)) {
        $argv[] = '--author-uri=' . $author_uri;
    }
    
    if ($blocks) {
        $argv[] = '--blocks';
    }
}

// Run the CLI with the provided arguments
$exit_code = $cli->run($argv);

// If this was a successful init command, show success message
if ($exit_code === 0 && isset($argv[1]) && $argv[1] === 'init' && isset($slug)) {
    echo "\n✅ Plugin initialization complete!\n\n";
    echo "🎉 Your new WordPress plugin has been created successfully.\n";
    echo "📁 Plugin location: " . dirname($plugin_path) . "/" . $slug . "\n\n";
    echo "Next steps:\n";
    echo "1. cd " . $slug . "\n";
    echo "2. composer install\n";
    echo "3. npm install && npm run build\n\n";
}

// Exit with the appropriate code
exit($exit_code); 