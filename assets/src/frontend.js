/**
 * Frontend-specific JavaScript
 *
 * Public-facing functionality for the plugin.
 *
 * @link       ${PLUGIN_URI}
 * @since      1.0.0
 *
 * @package    ${PLUGIN_NAMESPACE}
 */

// Any frontend CSS would be imported here if needed
// import './frontend.scss';

// DOM ready handler
document.addEventListener('DOMContentLoaded', () => {
  console.log('${PLUGIN_NAME} frontend scripts loaded');
  
  // Initialize frontend components
  initFrontendComponents();
});

/**
 * Initialize frontend components
 */
function initFrontendComponents() {
  // Example: Initialize any frontend-specific components
  const pluginElements = document.querySelectorAll('.${PLUGIN_SLUG}-element');
  
  if (pluginElements.length > 0) {
    pluginElements.forEach(element => {
      // Process each element
      element.addEventListener('click', handleElementClick);
    });
  }
}

/**
 * Example click handler
 * 
 * @param {Event} event - The click event
 */
function handleElementClick(event) {
  event.preventDefault();
  
  // Example functionality
  console.log('Plugin element clicked', event.currentTarget);
}

/**
 * Example of an exported function that can be used by other scripts
 * 
 * @param {string} selector - The selector to target
 * @param {string} content - The content to update
 * @returns {boolean} - Success status
 */
export function updateContent(selector, content) {
  if (!selector || !content) return false;
  
  const targetElement = document.querySelector(selector);
  if (targetElement) {
    targetElement.innerHTML = content;
    return true;
  }
  
  return false;
}

// Make functions available in the global scope if needed
window.${PLUGIN_PREFIX} = window.${PLUGIN_PREFIX} || {};
window.${PLUGIN_PREFIX}.updateContent = updateContent; 