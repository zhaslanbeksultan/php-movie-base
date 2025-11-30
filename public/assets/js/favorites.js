// favorites.js - Favorites page controller

const FavoritesModule = (() => {

  const init = () => {
    setupRemoveButtons();
    applyInitialAnimations();
  };

  // Remove movie from favorites with confirmation
  const setupRemoveButtons = () => {
    document.addEventListener('click', async (e) => {
      if (e.target.classList.contains('btn-remove')) {
        const movieId = parseInt(e.target.getAttribute('data-movie-id'));
        const movieCard = e.target.closest('.movie-card');


        try {
          const response = await fetch('api/toggle_favorite.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ movie_id: movieId })
          });

          const result = await response.json();

          if (result.success && !result.is_favorite) {
            // Apply fade out effect before removing
            new Effect.Fade(movieCard, {
              duration: 0.5,
              afterFinish: () => {
                movieCard.remove();
                checkIfEmpty();
                UIModule.showNotification('Removed from favorites', 'info');
              }
            });
          }
        } catch (error) {
          console.error('Error removing favorite:', error);
          UIModule.showNotification('Failed to remove favorite', 'error');
        }
      }
    });
  };

  // Check if favorites is empty and show message
  const checkIfEmpty = () => {
    const container = document.getElementById('favorites-container');
    const cards = container.querySelectorAll('.movie-card');

    if (cards.length === 0) {
      container.innerHTML = `
        <div class="empty-favorites">
          <div class="empty-icon">💔</div>
          <h3>No favorites yet</h3>
          <p>Start adding movies to your collection!</p>
          <a href="catalog.php" class="btn-main">Browse Catalog</a>
        </div>
      `;
      new Effect.Appear(container.firstElementChild, { duration: 0.6 });
    }
  };


  // Initial page load animations
  const applyInitialAnimations = () => {
    const cards = document.querySelectorAll('.movie-card');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      new Effect.Appear(card, {
        duration: 0.6,
        delay: index * 0.1
      });
    });
  };

  return { init };
})();

// Initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', FavoritesModule.init);
} else {
  FavoritesModule.init();
}