// movie-detail.js - Movie detail page controller with favorite functionality

(async () => {
  let clickCount = 0;
  let currentScale = 1;
  const poster = document.getElementById('movie-poster');
  const favoriteIcon = document.getElementById('favorite-icon');
  const movieId = poster ? poster.getAttribute('data-movie-id') : null;

  // Check if movie is already in favorites
  const checkFavoriteStatus = async () => {
    try {
      const response = await fetch('check_favorite.php?movie_id=' + movieId);
      const data = await response.json();

      if (data.is_favorite) {
        favoriteIcon.style.display = 'block';
        clickCount = 2;
        currentScale = 1.1;
        poster.style.transform = `scale(${currentScale})`;
        document.body.classList.add('snoopified');
      }
    } catch (error) {
      console.error('Error checking favorite status:', error);
    }
  };

  if (movieId) {
    await checkFavoriteStatus();
  }

  // Event: Double-click on movie poster
  if (poster) {
    poster.addEventListener('click', async () => {
      clickCount++;

      if (clickCount === 1) {
        // First click - make bigger
        currentScale = 1.1;
        poster.style.transform = `scale(${currentScale})`;
        poster.style.transition = 'transform 0.3s ease';
        UIModule.showNotification('Click again to add to favorites! ⭐', 'info');

      } else if (clickCount === 2) {
        // Second click - add to favorites and show icon
        try {
          const response = await fetch('toggle_favorite.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ movie_id: movieId })
          });

          const data = await response.json();

          if (data.success) {
            if (data.is_favorite) {
              favoriteIcon.style.display = 'block';
              document.body.classList.add('snoopified');

              // Apply Scriptaculous effect
              new Effect.Appear(favoriteIcon, { duration: 0.5 });
              new Effect.Pulsate(favoriteIcon, { pulses: 3, duration: 1.5 });

              UIModule.showNotification('✨ Added to favorites!', 'success');
            } else {
              // Removed from favorites
              new Effect.Fade(favoriteIcon, { duration: 0.5 });
              document.body.classList.remove('snoopified');
              clickCount = 0;
              currentScale = 1;
              poster.style.transform = 'scale(1)';
              UIModule.showNotification('Removed from favorites', 'info');
            }
          }
        } catch (error) {
          console.error('Error toggling favorite:', error);
          UIModule.showNotification('Failed to update favorites', 'error');
        }
      }
    });
  }

  // Event: Bigger Pimpin' Button
  const pimpinBtn = document.getElementById('pimpin-btn');
  if (pimpinBtn) {
    let btnScale = 1;

    pimpinBtn.addEventListener('click', () => {
      btnScale += 0.05;
      pimpinBtn.style.transform = `scale(${btnScale})`;
      pimpinBtn.textContent = `Bigger! (${Math.round(btnScale * 100)}%)`;

      // Apply Scriptaculous pulsate effect
      new Effect.Pulsate(pimpinBtn, { pulses: 1, duration: 0.5 });
    });
  }

  // Event: Bling Checkbox (Snoopify)
  const blingCheckbox = document.getElementById('bling-checkbox');
  if (blingCheckbox) {
    blingCheckbox.addEventListener('change', (e) => {
      if (e.target.checked) {
        document.body.classList.add('snoopified');

        // Apply Scriptaculous slide effect to all genre tags
        const genreTags = document.querySelectorAll('.genre-tag');
        genreTags.forEach((tag, index) => {
          new Effect.SlideDown(tag, { duration: 0.5, delay: index * 0.1 });
        });

        UIModule.showNotification('✨ Bling mode activated!', 'success');
      } else {
        document.body.classList.remove('snoopified');
        UIModule.showNotification('Bling mode deactivated', 'info');
      }
    });
  }

})();