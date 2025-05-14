<?php
/**
 * WP Boilerplate CLI Tool
 *
 * This class defines all code necessary to run the CLI interface for the plugin.
 *
 * @package    WP_Boilerplate_ARS
 * @subpackage WP_Boilerplate_ARS/cli
 */

/**
 * The CLI-specific functionality of the plugin.
 *
 * Defines all commands and their corresponding methods, and provides utilities
 * for initialization, file manipulation, and validation.
 *
 * @package    WP_Boilerplate_ARS
 * @subpackage WP_Boilerplate_ARS/cli
 * @author     ARS
 */
class WP_Boilerplate_CLI {

    /**
     * The path to the plugin directory
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_path    Path to the plugin directory.
     */
    private $plugin_path;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_path    Path to the plugin directory.
     */
    public function __construct( $plugin_path ) {
        $this->plugin_path = $plugin_path;
    }

    /**
     * Run the requested command
     *
     * @since    1.0.0
     * @param    array    $args    The command arguments.
     * @return   int               Exit code (0 for success, non-zero for failure)
     */
    public function run( $args ) {
        // Remove script name
        array_shift( $args );

        if ( empty( $args ) ) {
            $this->show_help();
            return 0;
        }

        $command = array_shift( $args );

        switch ( $command ) {
            case 'init':
                return $this->command_init( $args );
            case 'add-menu':
                return $this->command_add_menu( $args );
            case 'add-class':
                return $this->command_add_class( $args );
            case 'help':
                $this->show_help();
                return 0;
            default:
                echo "Error: Unknown command '$command'\n";
                $this->show_help();
                return 1;
        }
    }

    /**
     * Show help information
     *
     * @since    1.0.0
     */
    private function show_help() {
        echo "WordPress Plugin Boilerplate CLI Tool\n";
        echo "Usage: wp-boilerplate [command] [arguments]\n\n";
        echo "Available commands:\n";
        echo "  init           Initialize a new plugin\n";
        echo "                 --name=<plugin-name> (required) The name of the plugin\n";
        echo "                 --author=<author-name> (required) The author of the plugin\n";
        echo "                 --slug=<plugin-slug> (required) The slug of the plugin\n";
        echo "                 --blocks (optional) Include block support (default: false)\n";
        echo "                 --php=<php-version> (optional) Minimum PHP version (default: 7.4)\n";
        echo "                 --uri=<plugin-uri> (optional) Plugin URI\n";
        echo "                 --author-uri=<author-uri> (optional) Author URI\n";
        echo "                 --prefix=<prefix> (optional) Function prefix (default: derived from slug)\n";
        echo "                 --namespace=<namespace> (optional) PHP namespace (default: derived from slug)\n";
        echo "                 --description=<description> (optional) Plugin description\n";
        echo "                 --dev-deps (optional) Include dev dependencies (default: false)\n";
        echo "\n";
        echo "  add-menu       Add an admin menu page\n";
        echo "                 --title=<menu-title> (required) The title of the menu\n";
        echo "                 --slug=<menu-slug> (required) The slug of the menu\n";
        echo "                 --capability=<capability> (optional) Required capability (default: manage_options)\n";
        echo "                 --parent=<parent-slug> (optional) Parent menu slug (for sub-menus)\n";
        echo "                 --position=<position> (optional) Menu position\n";
        echo "\n";
        echo "  add-class      Add a new class file\n";
        echo "                 --name=<class-name> (required) The name of the class\n";
        echo "                 --dir=<directory> (required) The directory where to create the class (core, admin, etc.)\n";
        echo "                 --description=<description> (optional) Class description\n";
        echo "\n";
        echo "  help           Show this help information\n";
    }

    /**
     * Initialize a new plugin
     *
     * @since    1.0.0
     * @param    array    $args    The command arguments.
     * @return   int               Exit code (0 for success, non-zero for failure)
     */
    private function command_init( $args ) {
        $options = array(
            'name'        => '',
            'author'      => '',
            'slug'        => '',
            'blocks'      => false,
            'php'         => '7.4',
            'uri'         => '',
            'author_uri'  => '',
            'prefix'      => '',
            'namespace'   => '',
            'description' => '',
            'dev_deps'    => false,
        );

        // Parse command line arguments
        foreach ( $args as $arg ) {
            if ( preg_match( '/^--([^=]+)=?(.*)$/', $arg, $matches ) ) {
                $key = $matches[1];
                $value = $matches[2];

                switch ( $key ) {
                    case 'name':
                    case 'author':
                    case 'slug':
                    case 'uri':
                    case 'author-uri':
                    case 'prefix':
                    case 'namespace':
                    case 'description':
                    case 'php':
                        $options[ str_replace( '-', '_', $key ) ] = $value;
                        break;
                    case 'blocks':
                    case 'dev-deps':
                        $options[ str_replace( '-', '_', $key ) ] = true;
                        break;
                }
            }
        }

        // Validate required arguments
        if ( empty( $options['name'] ) ) {
            echo "Error: Plugin name is required. Use --name=<plugin-name>\n";
            return 1;
        }

        if ( empty( $options['author'] ) ) {
            echo "Error: Author name is required. Use --author=<author-name>\n";
            return 1;
        }

        if ( empty( $options['slug'] ) ) {
            echo "Error: Plugin slug is required. Use --slug=<plugin-slug>\n";
            return 1;
        }

        // Validate slug format
        if ( ! preg_match( '/^[a-z0-9-]+$/', $options['slug'] ) ) {
            echo "Error: Plugin slug must contain only lowercase letters, numbers, and hyphens.\n";
            return 1;
        }

        // Set default prefix if not provided
        if ( empty( $options['prefix'] ) ) {
            $options['prefix'] = strtolower( str_replace( '-', '_', $options['slug'] ) );
        }

        // Set default namespace if not provided
        if ( empty( $options['namespace'] ) ) {
            $namespace = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $options['slug'] ) ) );
            $options['namespace'] = $namespace;
        }

        // Set default description if not provided
        if ( empty( $options['description'] ) ) {
            $options['description'] = 'A custom WordPress plugin based on WP Boilerplate.';
        }

        // Prepare template variables for replacement
        $replacements = array(
            '${PLUGIN_NAME}'        => $options['name'],
            '${PLUGIN_SLUG}'        => $options['slug'],
            '${PLUGIN_PREFIX}'      => $options['prefix'],
            '${PLUGIN_NAMESPACE}'   => $options['namespace'],
            '${PLUGIN_TEXT_DOMAIN}' => $options['slug'],
            '${PLUGIN_URI}'         => $options['uri'],
            '${PLUGIN_DESCRIPTION}' => $options['description'],
            '${AUTHOR_NAME}'        => $options['author'],
            '${AUTHOR_URI}'         => $options['author_uri'],
            '${AUTHOR_EMAIL}'       => '',
        );

        try {
            // Create the new plugin directory
            $target_dir = dirname( $this->plugin_path ) . '/' . $options['slug'];

            if ( file_exists( $target_dir ) ) {
                echo "Error: Directory $target_dir already exists.\n";
                return 1;
            }

            echo "Initializing new plugin in $target_dir\n";
            mkdir( $target_dir, 0755, true );

            // Copy template files
            $this->copy_plugin_files( $this->plugin_path, $target_dir, $replacements, $options );

            // Update composer.json if dev dependencies are not needed
            if ( ! $options['dev_deps'] ) {
                $composer_file = $target_dir . '/composer.json';
                if ( file_exists( $composer_file ) ) {
                    $composer_json = json_decode( file_get_contents( $composer_file ), true );
                    unset( $composer_json['require-dev'] );
                    unset( $composer_json['scripts']['test'] );
                    unset( $composer_json['scripts']['phpcs-setup'] );
                    unset( $composer_json['scripts']['post-install-cmd'] );
                    unset( $composer_json['scripts']['post-update-cmd'] );
                    file_put_contents( $composer_file, json_encode( $composer_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );
                }
            }

            // Remove block-related files if block support is not needed
            if ( ! $options['blocks'] ) {
                $this->remove_block_files( $target_dir );
            } else {
                // Create blocks directory if needed
                mkdir( $target_dir . '/blocks', 0755, true );
                file_put_contents( $target_dir . '/blocks/.gitkeep', '# This directory contains block files.' );
            }

            // Update PHP version in composer.json and phpcs.xml.dist
            $this->update_php_version( $target_dir, $options['php'] );

            // Rename main plugin file
            rename( 
                $target_dir . '/wp-boilerplate-ars.php', 
                $target_dir . '/' . $options['slug'] . '.php' 
            );

            echo "Plugin initialized successfully.\n";
            echo "Next steps:\n";
            echo "1. cd $target_dir\n";
            echo "2. composer install\n";
            echo "3. npm install (or yarn)\n";

            return 0;
        } catch ( Exception $e ) {
            echo "Error: " . $e->getMessage() . "\n";
            return 1;
        }
    }

    /**
     * Add an admin menu page
     *
     * @since    1.0.0
     * @param    array    $args    The command arguments.
     * @return   int               Exit code (0 for success, non-zero for failure)
     */
    private function command_add_menu( $args ) {
        $options = array(
            'title'      => '',
            'slug'       => '',
            'capability' => 'manage_options',
            'parent'     => '',
            'position'   => '',
        );

        // Parse command line arguments
        foreach ( $args as $arg ) {
            if ( preg_match( '/^--([^=]+)=(.*)$/', $arg, $matches ) ) {
                $key = $matches[1];
                $value = $matches[2];

                switch ( $key ) {
                    case 'title':
                    case 'slug':
                    case 'capability':
                    case 'parent':
                    case 'position':
                        $options[ $key ] = $value;
                        break;
                }
            }
        }

        // Validate required arguments
        if ( empty( $options['title'] ) ) {
            echo "Error: Menu title is required. Use --title=<menu-title>\n";
            return 1;
        }

        if ( empty( $options['slug'] ) ) {
            echo "Error: Menu slug is required. Use --slug=<menu-slug>\n";
            return 1;
        }

        try {
            // Get plugin information
            $plugin_info = $this->get_plugin_info();
            if ( ! $plugin_info ) {
                echo "Error: Could not determine plugin information. Make sure you're running this command from a plugin directory.\n";
                return 1;
            }

            // Create the menu file
            $target_dir = $this->plugin_path . '/includes/admin';
            $menu_filename = 'menu-' . $options['slug'] . '.php';
            $menu_file = $target_dir . '/' . $menu_filename;

            if ( file_exists( $menu_file ) ) {
                echo "Error: Menu file $menu_filename already exists.\n";
                return 1;
            }

            // Create menu content
            $content = $this->generate_menu_content( $options, $plugin_info );

            // Create the file
            file_put_contents( $menu_file, $content );

            // Create the partial view file
            $partial_dir = $target_dir . '/partials';
            if ( ! file_exists( $partial_dir ) ) {
                mkdir( $partial_dir, 0755, true );
            }

            $partial_file = $partial_dir . '/page-' . $options['slug'] . '.php';
            $partial_content = $this->generate_menu_partial_content( $options, $plugin_info );
            file_put_contents( $partial_file, $partial_content );

            // Update admin class to include the menu
            $this->update_admin_class_for_menu( $options, $plugin_info );

            echo "Admin menu created successfully:\n";
            echo "- Menu file: $menu_file\n";
            echo "- View file: $partial_file\n";
            echo "The admin class has been updated to include the new menu.\n";

            return 0;
        } catch ( Exception $e ) {
            echo "Error: " . $e->getMessage() . "\n";
            return 1;
        }
    }

    /**
     * Add a new class file
     *
     * @since    1.0.0
     * @param    array    $args    The command arguments.
     * @return   int               Exit code (0 for success, non-zero for failure)
     */
    private function command_add_class( $args ) {
        $options = array(
            'name'        => '',
            'dir'         => '',
            'description' => '',
        );

        // Parse command line arguments
        foreach ( $args as $arg ) {
            if ( preg_match( '/^--([^=]+)=(.*)$/', $arg, $matches ) ) {
                $key = $matches[1];
                $value = $matches[2];

                switch ( $key ) {
                    case 'name':
                    case 'dir':
                    case 'description':
                        $options[ $key ] = $value;
                        break;
                }
            }
        }

        // Validate required arguments
        if ( empty( $options['name'] ) ) {
            echo "Error: Class name is required. Use --name=<class-name>\n";
            return 1;
        }

        if ( empty( $options['dir'] ) ) {
            echo "Error: Directory is required. Use --dir=<directory>\n";
            return 1;
        }

        try {
            // Get plugin information
            $plugin_info = $this->get_plugin_info();
            if ( ! $plugin_info ) {
                echo "Error: Could not determine plugin information. Make sure you're running this command from a plugin directory.\n";
                return 1;
            }

            // Set default description if not provided
            if ( empty( $options['description'] ) ) {
                $options['description'] = 'The ' . $options['name'] . ' class.';
            }

            // Normalize class name
            $class_name = $this->normalize_class_name( $options['name'] );
            $file_name = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';

            // Create the target directory if it doesn't exist
            $target_dir = $this->plugin_path . '/includes/' . $options['dir'];
            if ( ! file_exists( $target_dir ) ) {
                mkdir( $target_dir, 0755, true );
            }

            $class_file = $target_dir . '/' . $file_name;

            if ( file_exists( $class_file ) ) {
                echo "Error: Class file $file_name already exists in $target_dir.\n";
                return 1;
            }

            // Create class content
            $content = $this->generate_class_content( $class_name, $options, $plugin_info );

            // Create the file
            file_put_contents( $class_file, $content );

            echo "Class created successfully: $class_file\n";
            return 0;
        } catch ( Exception $e ) {
            echo "Error: " . $e->getMessage() . "\n";
            return 1;
        }
    }

    /**
     * Copy plugin files with replacements
     *
     * @since    1.0.0
     * @param    string    $source_dir      Source directory.
     * @param    string    $target_dir      Target directory.
     * @param    array     $replacements    Template replacements.
     * @param    array     $options         Command options.
     */
    private function copy_plugin_files( $source_dir, $target_dir, $replacements, $options ) {
        $exclude_dirs = array( '.git', '.github', 'vendor', 'node_modules' );
        $dir = new DirectoryIterator( $source_dir );

        foreach ( $dir as $file ) {
            if ( $file->isDot() ) {
                continue;
            }

            $source_path = $file->getPathname();
            $filename = $file->getFilename();

            if ( in_array( $filename, $exclude_dirs ) ) {
                continue;
            }

            if ( $filename === 'cli' ) {
                continue; // Skip the CLI directory
            }

            $target_path = $target_dir . '/' . $filename;

            if ( $file->isDir() ) {
                // Create the target directory
                mkdir( $target_path, 0755, true );
                // Recursively copy files
                $this->copy_plugin_files( $source_path, $target_path, $replacements, $options );
            } else {
                // Skip files that shouldn't be copied
                if ( $filename === 'README.md' || $filename === '.DS_Store' ) {
                    continue;
                }

                // Read the file content
                $content = file_get_contents( $source_path );

                // Replace template variables
                foreach ( $replacements as $search => $replace ) {
                    $content = str_replace( $search, $replace, $content );
                }

                // Write the content to the target file
                file_put_contents( $target_path, $content );
            }
        }
    }

    /**
     * Remove block-related files
     *
     * @since    1.0.0
     * @param    string    $plugin_dir    Plugin directory.
     */
    private function remove_block_files( $plugin_dir ) {
        $block_functions_file = $plugin_dir . '/includes/core/block-functions.php';
        if ( file_exists( $block_functions_file ) ) {
            unlink( $block_functions_file );
        }

        // Remove block registration from core class
        $core_class_file = $plugin_dir . '/includes/core/class-plugin-name.php';
        if ( file_exists( $core_class_file ) ) {
            $content = file_get_contents( $core_class_file );
            // Remove block-related code
            $content = preg_replace( '/        \/\/ Load optional block functionality.*?\}\n/s', '', $content );
            $content = preg_replace( '/    \/\*\*\n     \* Register all of the hooks related to blocks functionality.*?\}\n/s', '', $content );
            $content = preg_replace( '/    \/\*\*\n     \* Check if block support is enabled for this plugin.*?\}\n/s', '', $content );
            file_put_contents( $core_class_file, $content );
        }
    }

    /**
     * Update PHP version in files
     *
     * @since    1.0.0
     * @param    string    $plugin_dir    Plugin directory.
     * @param    string    $php_version   PHP version.
     */
    private function update_php_version( $plugin_dir, $php_version ) {
        // Update composer.json
        $composer_file = $plugin_dir . '/composer.json';
        if ( file_exists( $composer_file ) ) {
            $content = file_get_contents( $composer_file );
            $content = preg_replace( '/"php": ">=7.4"/', '"php": ">=' . $php_version . '"', $content );
            file_put_contents( $composer_file, $content );
        }

        // Update phpcs.xml.dist
        $phpcs_file = $plugin_dir . '/phpcs.xml.dist';
        if ( file_exists( $phpcs_file ) ) {
            $content = file_get_contents( $phpcs_file );
            $content = preg_replace( '/testVersion" value="7.4-"/', 'testVersion" value="' . $php_version . '-"', $content );
            file_put_contents( $phpcs_file, $content );
        }
    }

    /**
     * Get plugin information from main plugin file
     *
     * @since    1.0.0
     * @return   array|false    Plugin information or false on failure.
     */
    private function get_plugin_info() {
        $main_files = glob( $this->plugin_path . '/*.php' );
        $plugin_info = array();

        foreach ( $main_files as $file ) {
            $content = file_get_contents( $file );
            $plugin_data = array();

            // Check if this is the main plugin file
            if ( preg_match( '/Plugin Name:\s*(.+)$/m', $content, $matches ) ) {
                $plugin_data['name'] = trim( $matches[1] );

                // Get plugin slug from file name
                $plugin_data['slug'] = basename( $file, '.php' );

                // Get prefix from define statements
                if ( preg_match( '/define\(\s*\'([A-Z0-9_]+)_VERSION/', $content, $matches ) ) {
                    $plugin_data['prefix'] = $matches[1];
                }

                // Get namespace from namespace declaration
                if ( preg_match( '/namespace\s+([^;]+)/', $content, $matches ) ) {
                    $parts = explode( '\\', $matches[1] );
                    $plugin_data['namespace'] = $parts[0];
                }

                // Get text domain from text domain declaration
                if ( preg_match( '/Text Domain:\s*(.+)$/m', $content, $matches ) ) {
                    $plugin_data['text_domain'] = trim( $matches[1] );
                }

                $plugin_info = $plugin_data;
                break;
            }
        }

        return ! empty( $plugin_info ) ? $plugin_info : false;
    }

    /**
     * Generate menu file content
     *
     * @since    1.0.0
     * @param    array    $options       Menu options.
     * @param    array    $plugin_info   Plugin information.
     * @return   string                  File content.
     */
    private function generate_menu_content( $options, $plugin_info ) {
        $namespace = $plugin_info['namespace'];
        $prefix = $plugin_info['prefix'];
        $text_domain = $plugin_info['text_domain'];
        $slug = $options['slug'];
        $title = $options['title'];
        $capability = $options['capability'];
        $parent = $options['parent'];
        $position = $options['position'];

        $function_name = strtolower( str_replace( '-', '_', $slug ) );
        $class_name = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $slug ) ) );

        $content = "<?php\n";
        $content .= "/**\n";
        $content .= " * Admin menu page for $title\n";
        $content .= " *\n";
        $content .= " * @link       https://example.com\n";
        $content .= " * @since      1.0.0\n";
        $content .= " *\n";
        $content .= " * @package    $namespace\n";
        $content .= " * @subpackage $namespace/includes/admin\n";
        $content .= " */\n\n";

        $content .= "// If this file is called directly, abort.\n";
        $content .= "if ( ! defined( 'WPINC' ) ) {\n";
        $content .= "    die;\n";
        $content .= "}\n\n";

        // Add menu function
        $content .= "/**\n";
        $content .= " * Register the admin menu page for $title\n";
        $content .= " *\n";
        $content .= " * @since    1.0.0\n";
        $content .= " */\n";
        $content .= "function {$prefix}_register_{$function_name}_menu() {\n";

        if ( ! empty( $parent ) ) {
            // Submenu page
            $content .= "    \$page = add_submenu_page(\n";
            $content .= "        '$parent',\n";
            $content .= "        __( '$title', '$text_domain' ),\n";
            $content .= "        __( '$title', '$text_domain' ),\n";
            $content .= "        '$capability',\n";
            $content .= "        '$slug',\n";
            $content .= "        '{$prefix}_render_{$function_name}_page'\n";
            $content .= "    );\n";
        } else {
            // Top-level menu
            $content .= "    \$page = add_menu_page(\n";
            $content .= "        __( '$title', '$text_domain' ),\n";
            $content .= "        __( '$title', '$text_domain' ),\n";
            $content .= "        '$capability',\n";
            $content .= "        '$slug',\n";
            $content .= "        '{$prefix}_render_{$function_name}_page',\n";
            $content .= "        'dashicons-admin-generic'";
            if ( ! empty( $position ) ) {
                $content .= ",\n        $position";
            } else {
                $content .= ",\n        null";
            }
            $content .= "\n    );\n";
        }

        $content .= "\n    // Enqueue assets specifically for this page\n";
        $content .= "    add_action( 'admin_print_styles-' . \$page, '{$prefix}_enqueue_{$function_name}_assets' );\n";
        $content .= "}\n";
        $content .= "add_action( 'admin_menu', '{$prefix}_register_{$function_name}_menu' );\n\n";

        // Add render function
        $content .= "/**\n";
        $content .= " * Render the admin page for $title\n";
        $content .= " *\n";
        $content .= " * @since    1.0.0\n";
        $content .= " */\n";
        $content .= "function {$prefix}_render_{$function_name}_page() {\n";
        $content .= "    // Check user capabilities\n";
        $content .= "    if ( ! current_user_can( '$capability' ) ) {\n";
        $content .= "        return;\n";
        $content .= "    }\n\n";
        $content .= "    // Include the partial\n";
        $content .= "    require_once {$prefix}_PLUGIN_DIR . 'includes/admin/partials/page-$slug.php';\n";
        $content .= "}\n\n";

        // Add assets function
        $content .= "/**\n";
        $content .= " * Enqueue assets for the $title page\n";
        $content .= " *\n";
        $content .= " * @since    1.0.0\n";
        $content .= " */\n";
        $content .= "function {$prefix}_enqueue_{$function_name}_assets() {\n";
        $content .= "    // CSS and JavaScript would be enqueued here\n";
        $content .= "}\n";

        return $content;
    }

    /**
     * Generate menu partial content
     *
     * @since    1.0.0
     * @param    array    $options       Menu options.
     * @param    array    $plugin_info   Plugin information.
     * @return   string                  File content.
     */
    private function generate_menu_partial_content( $options, $plugin_info ) {
        $namespace = $plugin_info['namespace'];
        $text_domain = $plugin_info['text_domain'];
        $title = $options['title'];

        $content = "<?php\n";
        $content .= "/**\n";
        $content .= " * Provides the view for the $title admin page\n";
        $content .= " *\n";
        $content .= " * @link       https://example.com\n";
        $content .= " * @since      1.0.0\n";
        $content .= " *\n";
        $content .= " * @package    $namespace\n";
        $content .= " * @subpackage $namespace/includes/admin/partials\n";
        $content .= " */\n\n";

        $content .= "// If this file is called directly, abort.\n";
        $content .= "if ( ! defined( 'WPINC' ) ) {\n";
        $content .= "    die;\n";
        $content .= "}\n";
        $content .= "?>\n\n";

        $content .= "<div class=\"wrap\">\n";
        $content .= "    <h1><?php echo esc_html( __( '$title', '$text_domain' ) ); ?></h1>\n\n";
        $content .= "    <div class=\"card\">\n";
        $content .= "        <h2><?php echo esc_html( __( 'Overview', '$text_domain' ) ); ?></h2>\n";
        $content .= "        <p><?php echo esc_html( __( 'This is the $title page content.', '$text_domain' ) ); ?></p>\n";
        $content .= "    </div>\n\n";
        $content .= "    <div class=\"card\">\n";
        $content .= "        <h2><?php echo esc_html( __( 'Settings', '$text_domain' ) ); ?></h2>\n";
        $content .= "        <form method=\"post\" action=\"options.php\">\n";
        $content .= "            <?php\n";
        $content .= "            // Add your settings fields here\n";
        $content .= "            settings_fields( '$text_domain-settings' );\n";
        $content .= "            do_settings_sections( '$text_domain-$options[slug]' );\n";
        $content .= "            submit_button();\n";
        $content .= "            ?>\n";
        $content .= "        </form>\n";
        $content .= "    </div>\n";
        $content .= "</div>\n";

        return $content;
    }

    /**
     * Update admin class to include the menu
     *
     * @since    1.0.0
     * @param    array    $options       Menu options.
     * @param    array    $plugin_info   Plugin information.
     */
    private function update_admin_class_for_menu( $options, $plugin_info ) {
        $admin_class_file = $this->plugin_path . '/includes/core/class-plugin-name.php';
        if ( ! file_exists( $admin_class_file ) ) {
            return;
        }

        $content = file_get_contents( $admin_class_file );
        $function_name = strtolower( str_replace( '-', '_', $options['slug'] ) );
        $menu_file = "includes/admin/menu-{$options['slug']}.php";
        $require_line = "        require_once {$plugin_info['prefix']}_PLUGIN_DIR . '$menu_file';";

        // Add the include statement for the menu file
        $pattern = '/(private function load_dependencies\(\) \{.*?)(\/\/ The class responsible for orchestrating)/s';
        if ( preg_match( $pattern, $content, $matches ) ) {
            $replacement = $matches[1] . "// Load admin menu: {$options['title']}\n$require_line\n\n        $matches[2]";
            $content = preg_replace( $pattern, $replacement, $content );
            file_put_contents( $admin_class_file, $content );
        }
    }

    /**
     * Generate class content
     *
     * @since    1.0.0
     * @param    string    $class_name    Class name.
     * @param    array     $options       Class options.
     * @param    array     $plugin_info   Plugin information.
     * @return   string                   File content.
     */
    private function generate_class_content( $class_name, $options, $plugin_info ) {
        $namespace = $plugin_info['namespace'];
        $dir = $options['dir'];
        $description = $options['description'];

        // Convert directory to namespace part
        $namespace_part = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $dir ) ) );

        $content = "<?php\n";
        $content .= "/**\n";
        $content .= " * $description\n";
        $content .= " *\n";
        $content .= " * @link       https://example.com\n";
        $content .= " * @since      1.0.0\n";
        $content .= " *\n";
        $content .= " * @package    $namespace\n";
        $content .= " * @subpackage $namespace/includes/$dir\n";
        $content .= " */\n\n";

        $content .= "namespace $namespace\\$namespace_part;\n\n";

        $content .= "/**\n";
        $content .= " * $description\n";
        $content .= " *\n";
        $content .= " * @since      1.0.0\n";
        $content .= " * @package    $namespace\n";
        $content .= " * @subpackage $namespace/includes/$dir\n";
        $content .= " * @author     {$plugin_info['name']}\n";
        $content .= " */\n";
        $content .= "class $class_name {\n\n";

        // Add constructor
        $content .= "    /**\n";
        $content .= "     * Initialize the class and set its properties.\n";
        $content .= "     *\n";
        $content .= "     * @since    1.0.0\n";
        $content .= "     */\n";
        $content .= "    public function __construct() {\n";
        $content .= "        // Constructor code here\n";
        $content .= "    }\n\n";

        // Add example method
        $content .= "    /**\n";
        $content .= "     * Example method.\n";
        $content .= "     *\n";
        $content .= "     * @since    1.0.0\n";
        $content .= "     * @param    string    \$param    Example parameter.\n";
        $content .= "     * @return   string               Example return value.\n";
        $content .= "     */\n";
        $content .= "    public function example_method( \$param ) {\n";
        $content .= "        return 'Example output: ' . \$param;\n";
        $content .= "    }\n";
        $content .= "}\n";

        return $content;
    }

    /**
     * Normalize class name
     *
     * @since    1.0.0
     * @param    string    $name    Class name.
     * @return   string             Normalized class name.
     */
    private function normalize_class_name( $name ) {
        // Replace hyphens and spaces with underscores
        $name = str_replace( array( '-', ' ' ), '_', $name );
        
        // Make first letter uppercase
        $name = ucfirst( $name );
        
        // Convert each word to uppercase after underscores
        $name = implode( '_', array_map( 'ucfirst', explode( '_', $name ) ) );
        
        return $name;
    }
} 