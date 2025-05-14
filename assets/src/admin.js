/**
 * Admin-specific JavaScript
 *
 * Admin-facing JavaScript functionality for the plugin.
 *
 * @link       ${PLUGIN_URI}
 * @since      1.0.0
 *
 * @package    ${PLUGIN_NAMESPACE}
 */

// Import admin styles
import './admin.scss';

// Example: DOM ready handler
document.addEventListener('DOMContentLoaded', () => {
  console.log('${PLUGIN_NAME} admin scripts loaded');
  
  // Initialize the admin UI components
  initAdminComponents();
});

/**
 * Initialize admin components
 */
function initAdminComponents() {
  // Example: Settings form handling
  const settingsForm = document.querySelector('.${PLUGIN_SLUG}-settings-form');
  
  if (settingsForm) {
    settingsForm.addEventListener('submit', (e) => {
      // You can add form validation or other functionality here
      console.log('Settings form submitted');
    });
  }
}

/**
 * Example of an exported function that can be used by other scripts
 * 
 * @param {string} message - The message to display
 * @returns {void}
 */
export function showAdminNotice(message) {
  if (!message) return;
  
  const noticeContainer = document.createElement('div');
  noticeContainer.className = 'notice notice-success is-dismissible';
  
  const paragraph = document.createElement('p');
  paragraph.textContent = message;
  
  noticeContainer.appendChild(paragraph);
  
  // Insert notice at the top of the admin content
  const adminContent = document.querySelector('.wrap');
  if (adminContent) {
    adminContent.insertBefore(noticeContainer, adminContent.firstChild);
  }
}

// Make functions available in the global scope if needed
window.${PLUGIN_PREFIX} = window.${PLUGIN_PREFIX} || {};
window.${PLUGIN_PREFIX}.showAdminNotice = showAdminNotice; 