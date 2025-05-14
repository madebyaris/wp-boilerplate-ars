# WordPress Plugin Boilerplate

A modern WordPress plugin boilerplate with Vite integration, optional block support, and a CLI tool for common tasks.

## Features

- Clean, well-structured, and modular code
- Modern JavaScript development with Vite
- WordPress coding standards compliance
- Optional Gutenberg block support
- CLI tool for plugin generation and code scaffolding
- Security best practices
- Comprehensive inline documentation

## Requirements

- PHP 8.0 or higher
- WordPress 5.0 or higher
- Composer
- Node.js (for Vite)

## Installation

### Using Composer (Recommended)

The easiest way to get started is by using Composer:

```bash
composer create-project madebyaris/wp-boilerplate my-plugin
```

This will create a new plugin in the specified directory and guide you through an interactive setup process where you'll:
- Enter your plugin name and slug
- Provide author information
- Set a description
- Choose whether to include block support
- Specify other optional settings

The setup process will automatically handle file generation and configuration.

### Manual Installation

Clone or download this repository to your WordPress plugins directory:

```bash
git clone https://github.com/your-username/wp-boilerplate-ars.git
cd wp-boilerplate-ars
```

## Usage

### Creating a new plugin

```bash
# Initialize a new plugin (basic)
./wp-boilerplate init --name="My Plugin" --author="Your Name" --slug="my-plugin"

# Initialize with additional options
./wp-boilerplate init --name="My Plugin" --author="Your Name" --slug="my-plugin" --blocks --php=8.0 --description="A custom WordPress plugin" --uri="https://example.com" --author-uri="https://example.com" --prefix="my_plugin" --namespace="MyPlugin" --dev-deps
```

### Adding an admin menu

```bash
# Add a top-level menu
./wp-boilerplate add-menu --title="My Menu" --slug="my-menu"

# Add a submenu
./wp-boilerplate add-menu --title="My Submenu" --slug="my-submenu" --parent="my-menu" --capability="manage_options"
```

### Adding a class

```bash
# Add a new class
./wp-boilerplate add-class --name="My_Class" --dir="core" --description="Custom functionality"
```

## CLI Tool

The plugin comes with a powerful CLI tool that helps you manage and extend your plugin.

### Available Commands

```bash
# Interactive plugin setup
./wp-boilerplate --setup

# Create a new admin menu
./wp-boilerplate add-menu --title="Settings Page" --slug="settings" --capability="manage_options"

# Create a new class file
./wp-boilerplate add-class --name="API_Controller" --dir="core" --description="Handles external API connections"
```

For manual initialization without the interactive prompts, you can use:

```bash
./wp-boilerplate init --name="My Plugin" --author="Your Name" --slug="my-plugin" --blocks
```

See all available options with:

```bash
./wp-boilerplate help
```

## After initialization

After creating a new plugin, navigate to its directory and run:

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies and build assets
npm install
npm run build
```

## Directory Structure

```
my-plugin/
├── config/
│   └── default-settings.php
├── includes/
│   ├── admin/
│   │   ├── class-plugin-name-admin.php
│   │   └── partials/
│   │       ├── settings-page.php
│   │       └── settings-section.php
│   ├── core/
│   │   ├── class-plugin-name.php
│   │   ├── class-plugin-loader.php
│   │   ├── class-i18n.php
│   │   ├── functions.php
│   │   └── [OPTIONAL] block-functions.php
│   └── data/
│       └── install.php
├── languages/
├── assets/
│   ├── src/
│   │   ├── admin.js
│   │   ├── admin.scss
│   │   └── frontend.js
│   └── dist/
├── [OPTIONAL] blocks/
├── .gitignore
├── composer.json
├── eslintrc.js
├── phpcs.xml.dist
├── vite.config.js
└── my-plugin.php
```

## Block Support

The boilerplate includes optional support for Gutenberg blocks. You can:

1. Include block support with the `--blocks` flag during initialization
2. Remove block support by removing the blocks directory and block-functions.php file

## License

GPL-2.0-or-later 