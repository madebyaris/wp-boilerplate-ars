# Product Requirements Document (PRD) - WordPress Plugin Boilerplate

## 1. Introduction

**1.1. Purpose:** To define the requirements for a minimalistic WordPress plugin boilerplate that is easy to maintain, works well with AI-assisted IDEs, integrates with Vite for modern JavaScript development, and includes a CLI tool for common tasks. The block functionality is optional and easily removable. The boilerplate prioritizes modularity, extensibility, security, and testability.

**1.2. Goals:**

*   Provide a clean and well-structured codebase.
*   Minimize dependencies.
*   Follow WordPress coding standards.
*   Implement PSR-4 autoloading for better organization and performance.
*   Be easily extensible.
*   Facilitate AI-assisted development.
*   Enable the use of modern JavaScript tools and libraries via Vite.
*   Provide a streamlined way to create custom Gutenberg blocks (optional).
*   Allow developers to easily remove block-related code if not needed.
*   Provide a CLI tool to automate common plugin development tasks.
*   Prioritize modularity and extensibility through the strategic use of WordPress actions and filters.
*   Ensure the plugin is secure and follows WordPress security best practices.
*   Provide a testing framework for ensuring code quality and reliability.
*   Create comprehensive documentation for developers.
*   Provide production-ready build tools for dependency isolation, internationalization, and distribution.

## 2. Overall Description

**2.1. Product Perspective:** A standalone WordPress plugin that serves as a starting point for new plugin development.

**2.2. Product Functions:**

*   Plugin activation/deactivation hook.
*   Settings page in the WordPress admin.
*   Example custom function.
*   Basic documentation.
*   Vite integration for asset bundling.
*   Block registration functionality (optional).
*   CLI tool for:
    *   Initializing a new plugin (name, author, slug, block support).
    *   Creating an admin menu.
    *   Creating a core class file.
*   Production build tools for:
    *   Dependency isolation with PHP-Scoper to prevent conflicts.
    *   Translation file generation.
    *   Distribution package creation.

**2.3. User Classes and Characteristics:** WordPress developers with basic to advanced knowledge.

**2.4. Operating Environment:** WordPress 5.0 or higher, PHP 8.0 or higher.

**2.5. Design and Implementation Constraints:**

*   Adhere to WordPress coding standards (see section 3.9).
*   Minimize external dependencies.
*   Use clear and descriptive code.
*   Provide a clear way to remove block functionality if not needed.
*   Employ WordPress actions and filters to allow for easy modification and extension of plugin functionality.

**2.6. User Documentation:** A `README.md` file and a developer guide with instructions on how to use the boilerplate, including how to remove block functionality and extend the plugin.

**2.7. Assumptions and Dependencies:** Assumes the user has a working WordPress installation and basic knowledge of PHP and JavaScript.

## 3. Specific Requirements

**3.1. Functional Requirements:**

*   FR1: Plugin should activate without errors.
*   FR2: Plugin should deactivate without errors.
*   FR3: Plugin should create a settings page under the "Settings" menu.
*   FR4: Settings page should have a text input field for a custom option.
*   FR5: Plugin should save the custom option to the WordPress database.
*   FR6: Plugin should display the custom option on the settings page.
*   FR7: Plugin should include an example custom function that can be called from other plugins or themes.
*   FR8: Plugin should use Vite to bundle JavaScript and CSS assets.
*   FR9: Plugin should provide a function to easily register new Gutenberg blocks (optional).
*   FR10: Plugin should function correctly even if block-related files and directories are removed.
*   FR11: The CLI tool should be accessible via a command (e.g., `wp plugin-name`).
*   FR12: The CLI tool should provide an `init` command to initialize a new plugin.
    *   FR12.1: The `init` command should accept the following arguments:
        *   `--name=<plugin-name>` (required): The name of the plugin.
        *   `--author=<author-name>` (required): The author of the plugin.
        *   `--slug=<plugin-slug>` (required): The slug of the plugin (must be a valid WordPress slug).
        *   `--blocks[=<true|false>]`: Whether to include block support (default: false).
    *   FR12.2: The `init` command should validate the input arguments.
    *   FR12.3: The `init` command should generate the necessary plugin files with the provided information.
*   FR13: The CLI tool should provide an `add-menu` command to create an admin menu.
    *   FR13.1: The `add-menu` command should accept arguments for menu title, menu slug, capability, and function.
*   FR14: The CLI tool should provide an `add-class` command to create a core class file.
*   FR15: Key plugin functionalities should be exposed through actions and filters, allowing other developers to modify or extend the plugin's behavior.
*   FR16: All functions should include error handling to catch potential exceptions or failures.
*   FR17: The plugin should provide tools for namespace isolation to prevent conflicts with other plugins.
*   FR18: The plugin should provide internationalization (i18n) support with translation file generation.
*   FR19: The plugin should provide a build system for creating distribution packages.

**3.2. Non-Functional Requirements:**

*   NFR1: Code should be well-commented and easy to understand.
*   NFR2: The plugin should have a minimal footprint (file size < 2MB, memory usage < 10MB).
*   NFR3: Plugin should be compatible with popular WordPress plugins.
*   NFR4: Plugin should be secure and follow WordPress security best practices (see section 3.5).
*   NFR5: Vite configuration should be easy to customize.
*   NFR6: Block registration process should be simple and efficient (if used).
*   NFR7: Plugin should provide clear instructions on how to remove block functionality.
*   NFR8: The CLI tool should be easy to use and provide clear instructions.
*   NFR9: The CLI tool should handle errors gracefully.
*   NFR10: The plugin's code should be modular and extensible, making it easy for other developers to integrate with and customize the plugin.
*   NFR11: The plugin should be accessible to users with disabilities, following WCAG guidelines.

**3.3. Interface Requirements:**

*   Settings page should have a clean and intuitive design.
*   Settings page should be responsive and work on different screen sizes.

**3.4. Performance Requirements:**

*   Plugin should have minimal impact on website performance.
*   Plugin should load quickly.

**3.5. Security Requirements:**

*   SR1: All user input should be sanitized using appropriate WordPress functions (e.g., `esc_attr()`, `esc_html()`, `esc_sql()`) before being displayed or stored in the database.
*   SR2: Nonces should be used to protect against cross-site request forgery (CSRF) attacks on all admin forms.
*   SR3: Prepared statements should be used for all database queries to prevent SQL injection attacks.
*   SR4: All external libraries should be regularly updated to address security vulnerabilities.
*   SR5: The plugin should follow WordPress security coding standards.

**3.6. Error Handling:**

*   EH1: All functions should include error handling to catch potential exceptions or failures.
*   EH2: Errors should be logged using the `error_log()` function or a dedicated logging library (e.g., Monolog).
*   EH3: User-friendly error messages should be displayed to the user when appropriate.

**3.7. Testing:**

*   T1: Unit tests should be implemented to verify the functionality of individual classes and functions using PHPUnit.
*   T2: Integration tests should be implemented to verify the interaction between different components of the plugin.
*   T3: End-to-end tests should be implemented to verify the plugin's functionality in a real WordPress environment.

**3.8. Coding Standards:**

*   CS1: The plugin should adhere to the WordPress Coding Standards for PHP, HTML, CSS, and JavaScript.
*   CS2: Code quality should be enforced using a code sniffer (e.g., PHP_CodeSniffer) and a linter (e.g., ESLint).
*   CS3: The plugin should implement PSR-4 autoloading for all PHP classes, with a clean namespace structure that reflects the directory organization.

**3.9. Version Control:**

*   VC1: The plugin's code should be managed using Git.
*   VC2: A branching strategy (e.g., Gitflow) should be used to manage development, staging, and production releases.

**3.10. Documentation:**

*   D1: A developer guide should be created to provide detailed information about the plugin's architecture, API, and extension points.
*   D2: Inline code documentation should be used to explain the purpose and usage of classes, functions, and variables.

**3.11. Accessibility:**

*   A1: The plugin should be accessible to users with disabilities, following WCAG guidelines.
*   A2: All user interface elements should have appropriate ARIA attributes.

## 4. File Structure

plugin-name/
├── config/
│   └── default-settings.php
├── data/
│   └── install.php
├── includes/
│   ├── admin/
│   │   ├── class-plugin-name-admin.php
│   │   ├── settings.php
│   │   └── partials/
│   │       └── settings-section.php
│   ├── core/
│   │   ├── class-plugin-name.php
│   │   ├── functions.php
│   │   └── [OPTIONAL] block-functions.php
│   ├── widgets/
│   ├── shortcodes/
│   ├── templates/
│   └── lib/
├── [OPTIONAL] blocks/
│   └── example-block/
│       ├── src/
│       │   ├── index.js
│       │   └── editor.scss
│       ├── block.json
│       └── index.php
├── languages/
│   └── plugin-name.pot
├── assets/
│   ├── src/
│   │   ├── admin.js
│   │   ├── admin.scss
│   │   └── frontend.js
│   ├── dist/
│   │   ├── admin.js
│   │   ├── admin.css
│   │   └── frontend.js
├── cli/
│   ├── class-plugin-cli.php
│   └── cli.php
├── tests/
│   ├── unit/
│   ├── integration/
│   └── end-to-end/
├── vendor/
├── dist/
│   ├── scoped/
│   └── plugin-name.zip
├── .gitignore
├── phpcs.xml.dist
├── eslintrc.js
├── vite.config.js
├── scoper.inc.php
├── README.md
├── LICENSE
└── composer.json

Key:

[OPTIONAL]: These directories and files are only included if the plugin uses Gutenberg blocks. If not, the blocks/ directory and block-functions.php file should be removed.


## To-Do List  

**Core Functionality:**  

*   [ ] Implement plugin activation and deactivation hooks (FR1, FR2).  
*   [ ] Create settings page in the WordPress admin (FR3).  
*   [ ] Implement saving and displaying custom options on the settings page (FR4, FR5, FR6).  
*   [ ] Implement an example custom function (FR7).  
*   [ ] Integrate Vite for asset bundling (FR8).  
*   [ ] Implement block registration functionality (optional) (FR9).  
*   [ ] Ensure the plugin functions correctly even if block-related code is removed (FR10).  

**CLI Tool:**  

*   [ ] Implement the CLI tool accessible via a command (FR11).  
*   [ ] Implement the `init` command (FR12):  
    *   [ ] Accept arguments for plugin name, author, slug, and block support (FR12.1).  
    *   [ ] Validate input arguments (FR12.2).  
    *   [ ] Generate the necessary plugin files (FR12.3).  
*   [ ] Implement the `add-menu` command (FR13):  
    *   [ ] Accept arguments for menu title, menu slug, capability, and function (FR13.1).  
    *   [ ] Generate the necessary code for the admin menu.  
*   [ ] Implement the `add-class` command (FR14).  

**Code Quality and Extensibility:**  

*   [ ] Expose key plugin functionalities through actions and filters (FR15).  
*   [ ] Implement error handling in all functions (FR16, EH1, EH2, EH3).  
*   [ ] Write well-commented and easy-to-understand code (NFR1).  
*   [ ] Minimize the plugin's footprint (NFR2).  
*   [ ] Ensure compatibility with popular WordPress plugins (NFR3).  
*   [ ] Follow WordPress coding standards (NFR4, CS1).  
*   [ ] Implement PSR-4 autoloading for class files (CS3).
*   [ ] Make the Vite configuration easy to customize (NFR5).  
*   [ ] Make the block registration process simple and efficient (NFR6).  
*   [ ] Provide clear instructions on how to remove block functionality (NFR7).  
*   [ ] Make the CLI tool easy to use and provide clear instructions (NFR8).  
*   [ ] Ensure the CLI tool handles errors gracefully (NFR9).  
*   [ ] Make the plugin's code modular and extensible (NFR10).  
*   [ ] Ensure the plugin is accessible (NFR11, A1, A2).  

**Security:**  

*   [ ] Sanitize all user input (SR1).  
*   [ ] Use nonces to protect against CSRF attacks (SR2).  
*   [ ] Use prepared statements for database queries (SR3).  
*   [ ] Regularly update external libraries (SR4).  
*   [ ] Follow WordPress security coding standards (SR5).  

**Testing:**  

*   [ ] Implement unit tests (T1).  
*   [ ] Implement integration tests (T2).  
*   [ ] Implement end-to-end tests (T3).  

**Documentation and Version Control:**  

*   [ ] Create a developer guide (D1).  
*   [ ] Use inline code documentation (D2).  
*   [ ] Manage the plugin's code using Git (VC1).  
*   [ ] Use a branching strategy (VC2).  

**Configuration and Build Tools:**  

*   [ ] Configure `.gitignore` file.  
*   [ ] Configure `phpcs.xml.dist` file.  
*   [ ] Configure `eslintrc.js` file.  
*   [ ] Configure `vite.config.js` file.  
*   [ ] Configure `composer.json` file.
*   [ ] Configure `scoper.inc.php` for dependency isolation.

**Production & Distribution:**

*   [ ] Implement dependency scoping with PHP-Scoper (FR17).
*   [ ] Configure internationalization and translation file generation (FR18).
*   [ ] Create build process for distribution packages (FR19).
*   [ ] Document build and distribution workflows.

This comprehensive PRD, file structure, and to-do list provide a solid foundation for developing a high-quality, AI-assisted WordPress plugin boilerplate. Remember to adapt and refine these documents as needed throughout the development process. Good luck!