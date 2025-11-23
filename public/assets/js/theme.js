// theme.js - Theme toggle functionality

const ThemeModule = (() => {
  const THEME_KEY = 'moviebase-theme';

  // Initialize theme on page load
  const init = () => {
    const savedTheme = localStorage.getItem(THEME_KEY);

    if (savedTheme === 'light') {
      document.body.classList.add('light-mode');
    }

    setupToggleButton();
  };

  // Setup toggle button event listener
  const setupToggleButton = () => {
    const toggleBtn = document.getElementById('theme-toggle');
    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', toggleTheme);
  };

  // Toggle between light and dark mode
  const toggleTheme = () => {
    const body = document.body;
    const isLight = body.classList.contains('light-mode');

    if (isLight) {
      // Switch to dark mode
      body.classList.remove('light-mode');
      localStorage.setItem(THEME_KEY, 'dark');
      showNotification('🌙 Dark mode activated', 'info');
    } else {
      // Switch to light mode
      body.classList.add('light-mode');
      localStorage.setItem(THEME_KEY, 'light');
      showNotification('☀️ Light mode activated', 'success');
    }

    // Animate the transition
    animateThemeChange();
  };

  // Animate theme change
  const animateThemeChange = () => {
    const toggleBtn = document.getElementById('theme-toggle');
    if (toggleBtn) {
      // Add rotation animation
      toggleBtn.style.transform = 'rotate(360deg)';
      setTimeout(() => {
        toggleBtn.style.transform = 'scale(1.05)';
      }, 300);
    }
  };

  // Show notification (uses UIModule if available)
  const showNotification = (message, type) => {
    if (typeof UIModule !== 'undefined' && UIModule.showNotification) {
      UIModule.showNotification(message, type);
    }
  };

  return {
    init,
    toggleTheme
  };
})();

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', ThemeModule.init);
} else {
  ThemeModule.init();
}