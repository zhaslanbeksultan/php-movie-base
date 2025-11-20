// events.js - Event handling module

const EventsModule = (() => {
  // Initialize all event listeners
  const init = () => {
    setupNewsCardClicks();
    setupBiggerPimpinButton();
    setupBlingCheckbox();
    setupNewsFilter();
    setupLikeButtons();
  };

  // Event 1: Click - News card navigation
  const setupNewsCardClicks = () => {
    document.addEventListener('click', (e) => {
      const newsCard = e.target.closest('.news-card');
      if (newsCard) {
        const newsId = newsCard.getAttribute('data-news-id');
        window.location.href = `news_detail.php?id=${newsId}`;
      }
    });
  };

  // Event 2: Click - Bigger Pimpin' Button (grows by 5% on each click)
  const setupBiggerPimpinButton = () => {
    const btn = document.getElementById('pimpin-btn');
    if (!btn) return;

    let scale = 1;

    btn.addEventListener('click', () => {
      scale += 0.05;
      btn.style.transform = `scale(${scale})`;
      btn.textContent = `Bigger! (${Math.round(scale * 100)}%)`;
    });
  };

  // Event 3: Click - Bling Checkbox (Snoopify - toggles special styling)
  const setupBlingCheckbox = () => {
    const checkbox = document.getElementById('bling-checkbox');
    if (!checkbox) return;

    checkbox.addEventListener('change', (e) => {
      if (e.target.checked) {
        document.body.classList.add('snoopified');
        UIModule.showNotification('✨ Bling mode activated!', 'success');
      } else {
        document.body.classList.remove('snoopified');
        UIModule.showNotification('Bling mode deactivated', 'info');
      }
    });
  };

  // Event 4: Mouseover - News card hover effect
  const setupNewsHover = () => {
    document.addEventListener('mouseover', (e) => {
      const newsCard = e.target.closest('.news-card');
      if (newsCard) {
        newsCard.style.transform = 'translateY(-10px)';
        newsCard.style.boxShadow = '0 10px 30px rgba(255, 204, 0, 0.3)';
      }
    });

    document.addEventListener('mouseout', (e) => {
      const newsCard = e.target.closest('.news-card');
      if (newsCard) {
        newsCard.style.transform = 'translateY(0)';
        newsCard.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.5)';
      }
    });
  };

  // Event 5: Keydown - Search functionality
  const setupNewsFilter = () => {
    const searchInput = document.getElementById('news-search');
    if (!searchInput) return;

    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const searchTerm = searchInput.value.toLowerCase();
        filterNewsCards(searchTerm);
        showNewsNotification("News found!", "success");
      }
    });
  };

  // Filter news cards based on search
  const filterNewsCards = (searchTerm) => {
    const newsCards = document.querySelectorAll('.news-card');

    newsCards.forEach(card => {
      const title = card.querySelector('.news-title').textContent.toLowerCase();

      if (title.includes(searchTerm)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  };

  // Like button click handler
  const setupLikeButtons = () => {
    document.addEventListener('click', async (e) => {
      if (e.target.classList.contains('like-btn')) {
        e.preventDefault();
        const newsId = e.target.getAttribute('data-news-id');

        // Show loading state
        e.target.disabled = true;
        e.target.classList.add('liking');

        // Call API
        const result = await DataModule.likeNews(newsId);

        if (result.success) {
          UIModule.updateLikeCount(newsId, result.likes);
          UIModule.showNotification('❤️ Liked!', 'success');
        } else {
          UIModule.showNotification('Failed to like', 'error');
        }

        // Remove loading state
        e.target.disabled = false;
        e.target.classList.remove('liking');
      }
    });
  };

  // Public API
  return {
    init,
    setupNewsCardClicks,
    setupBiggerPimpinButton,
    setupBlingCheckbox,
    setupNewsHover,
    setupNewsFilter,
    setupLikeButtons
  };
})();

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', EventsModule.init);
} else {
  EventsModule.init();
}