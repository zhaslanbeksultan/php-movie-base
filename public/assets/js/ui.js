// ui.js - UI manipulation module

const UIModule = (() => {
  // Create news card element dynamically (DOM creation)
  const createNewsCard = (news) => {
    const card = document.createElement('div');
    card.className = 'news-card';
    card.setAttribute('data-news-id', news.id);

    card.innerHTML = `
            <div class="news-image" style="background-image: url('${news.image}');">
                <div class="news-overlay">
                    <h3 class="news-title">${news.title}</h3>
                    <div class="news-meta">
                        <span class="news-date">${formatDate(news.date)}</span>
                        <span class="news-likes">❤️ ${news.likes}</span>
                    </div>
                </div>
            </div>
        `;

    return card;
  };

  // Format date helper function
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric',
      year: 'numeric'
    });
  };

  // Render news list (DOM manipulation)
  const renderNewsList = (newsArray, containerId) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    // Clear existing content
    container.innerHTML = '';

    // Create and append news cards
    newsArray.forEach(news => {
      const card = createNewsCard(news);
      container.appendChild(card);
    });
  };

  // Show loading spinner (DOM creation & manipulation)
  const showLoading = (containerId) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    const spinner = document.createElement('div');
    spinner.className = 'loading-spinner';
    spinner.innerHTML = '<div class="spinner"></div><p>Loading news...</p>';
    container.appendChild(spinner);
  };

  // Remove loading spinner (DOM manipulation)
  const hideLoading = (containerId) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    const spinner = container.querySelector('.loading-spinner');
    if (spinner) {
      spinner.remove();
    }
  };

  // Update like count dynamically (DOM manipulation)
  const updateLikeCount = (newsId, newCount) => {
    const likeBtn = document.querySelector(`[data-news-id="${newsId}"] .like-btn`);
    if (likeBtn) {
      likeBtn.textContent = `❤️ ${newCount}`;
    }
  };

  // Show notification (DOM creation)
  const showNotification = (message, type = 'success') => {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Auto remove after 3 seconds
    setTimeout(() => {
      notification.remove();
    }, 3000);
  };

  // Toggle element visibility (DOM manipulation)
  const toggleVisibility = (elementId) => {
    const element = document.getElementById(elementId);
    if (!element) return;

    element.style.display = element.style.display === 'none' ? 'block' : 'none';
  };

  // Public API
  return {
    createNewsCard,
    renderNewsList,
    showLoading,
    hideLoading,
    updateLikeCount,
    showNotification,
    toggleVisibility,
    formatDate
  };
})();

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = UIModule;
}