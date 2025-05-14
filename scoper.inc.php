<?php

declare(strict_types=1);

/**
 * Configuration for PHP-Scoper
 *
 * This configuration file is used by PHP-Scoper to prefix namespaces
 * and prevent conflicts with other plugins.
 */

// Uncomment to set a custom prefix
// $prefix = 'WPBoilerplate';

// Auto-generate prefix based on plugin slug if not set
if (!isset($prefix)) {
    // Default fallback prefix
    $prefix = 'WPBoilerplate';
    
    // Try to extract plugin slug from composer.json
    $composer_json = json_decode(file_get_contents(__DIR__ . '/composer.json'), true);
    if (isset($composer_json['name'])) {
        $parts = explode('/', $composer_json['name']);
        if (count($parts) > 1) {
            // Convert slug-name to SlugName
            $slug = $parts[1];
            $prefix = implode('', array_map('ucfirst', explode('-', $slug)));
        }
    }
}

// You can manually adjust which symbols to exclude from prefixing
$excluded_symbols = [
    // WordPress native symbols
    'WP_*',
    'wp_*',
    'get_*',
    'the_*',
    'is_*',
    'add_*',
    'remove_*',
    'do_*',
    'did_*',
    'apply_*',
    '__*',
    
    // PHP native symbols
    'array_*',
    'str_*',
    'date_*',
    
    // Add any other symbols that should not be prefixed
];

return [
    // By default, the prefix is set to the value of $prefix.
    'prefix' => $prefix,
    
    // By default, when scoping PHP files, PHP-Scoper only prefixes symbols that belong to the global namespace.
    // 'scope-global-constants' => false,
    // 'scope-global-functions' => false,
    
    // Exclude files from scoping by path
    'exclude-files' => [
        // Files that should not be scoped (e.g., WordPress API integration points)
        'includes/core/functions.php',
    ],
    
    // Configure additional excluded namespaces & classes
    'exclude-namespaces' => [
        // Exclude WordPress namespaces
        'WP',
    ],
    
    // List of symbols to exclude from the prefixing
    'exclude-symbols' => $excluded_symbols,
    
    // Configure patchers to modify code on the fly
    'patchers' => [
        // You can add custom patchers here if needed for special cases
    ],
]; 