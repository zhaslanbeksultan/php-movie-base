// news-detail.js - News detail page controller with comments

(async () => {
  const urlParams = new URLSearchParams(window.location.search);
  const newsId = parseInt(urlParams.get('id'));

  if (!newsId) {
    document.getElementById('news-content').innerHTML = '<p class="no-news">News not found.</p>';
    return;
  }

  try {
    // Fetch all news
    const allNews = await DataModule.fetchNews();
    const news = DataModule.getNewsById(allNews, newsId);

    if (!news) {
      document.getElementById('news-content').innerHTML = '<p class="no-news">News not found.</p>';
      return;
    }

    // Check if user has liked this news
    const likeStatus = await fetch(`check_news_like.php?news_id=${newsId}`);
    const likeData = await likeStatus.json();

    // Create detail page DOM elements
    const contentDiv = document.getElementById('news-content');
    contentDiv.innerHTML = '';

    // Create header section
    const header = document.createElement('div');
    header.className = 'news-detail-header';
    header.style.backgroundImage = `url('${news.image}')`;

    const headerOverlay = document.createElement('div');
    headerOverlay.className = 'news-detail-overlay';
    headerOverlay.innerHTML = `
      <h1 class="news-detail-title">${news.title}</h1>
      <div class="news-detail-meta">
        <span class="news-date">📅 ${UIModule.formatDate(news.date)}</span>
        <span class="news-category">📂 ${news.category.toUpperCase()}</span>
      </div>
    `;

    header.appendChild(headerOverlay);
    contentDiv.appendChild(header);

    // Create content section
    const content = document.createElement('div');
    content.className = 'news-detail-content';

    const description = document.createElement('p');
    description.className = 'news-description';
    description.textContent = news.description;
    content.appendChild(description);

    // Create like section
    const likeSection = document.createElement('div');
    likeSection.className = 'news-like-section';

    const likeBtn = document.createElement('button');
    likeBtn.className = 'like-btn' + (likeData.is_liked ? ' liked' : '');
    likeBtn.setAttribute('data-news-id', news.id);
    likeBtn.innerHTML = `${likeData.is_liked ? '❤️' : '🤍'} ${news.likes}`;

    const likeText = document.createElement('p');
    likeText.className = 'like-text';
    likeText.textContent = likeData.is_liked ? 'You liked this' : 'Like this article';

    likeSection.appendChild(likeBtn);
    likeSection.appendChild(likeText);
    content.appendChild(likeSection);
    contentDiv.appendChild(content);

    // Add back button
    const backBtn = document.createElement('a');
    backBtn.href = 'news.php';
    backBtn.className = 'back-btn';
    backBtn.textContent = '← Back to News';
    contentDiv.appendChild(backBtn);

    // Show comments section
    document.getElementById('comments-section').style.display = 'block';
    document.getElementById('news-id-input').value = newsId;

    // Load comments
    await loadComments(newsId);

    // Setup like button event with toggle functionality
    likeBtn.addEventListener('click', async (e) => {
      e.preventDefault();

      likeBtn.disabled = true;
      likeBtn.classList.add('liking');

      const result = await DataModule.likeNews(newsId);

      if (result.success) {
        // Update button appearance
        likeBtn.classList.toggle('liked');
        likeBtn.innerHTML = `${result.is_liked ? '❤️' : '🤍'} ${result.likes}`;
        likeText.textContent = result.is_liked ? 'You liked this' : 'Like this article';

        // Apply Scriptaculous effect
        if (result.is_liked) {
          new Effect.Pulsate(likeBtn, { pulses: 2, duration: 0.8 });
          UIModule.showNotification('❤️ Liked!', 'success');
        } else {
          UIModule.showNotification('Like removed', 'info');
        }
      } else {
        UIModule.showNotification('Failed to update like', 'error');
      }

      likeBtn.disabled = false;
      likeBtn.classList.remove('liking');
    });

    // Apply fade-in effect to content
    new Effect.Appear(content, { duration: 0.8 });

  } catch (error) {
    console.error('Error loading news detail:', error);
    document.getElementById('news-content').innerHTML = '<p class="no-news">Error loading news.</p>';
  }
})();

// Load comments function
async function loadComments(newsId) {
  try {
    const response = await fetch(`get_news_comments.php?news_id=${newsId}`);
    const comments = await response.json();

    const commentsList = document.getElementById('comments-list');
    commentsList.innerHTML = '';

    if (comments.length === 0) {
      commentsList.innerHTML = '<p class="no-comments">No comments yet. Be the first to comment!</p>';
      return;
    }

    comments.forEach((comment, index) => {
      const commentCard = document.createElement('div');
      commentCard.className = 'comment-card';
      commentCard.innerHTML = `
        <div class="comment-header">
          <strong>${comment.author}</strong>
          <span class="comment-date">${UIModule.formatDate(comment.date)}</span>
        </div>
        <p class="comment-text">${comment.text}</p>
      `;
      commentsList.appendChild(commentCard);

      // Apply slide-in effect
      new Effect.SlideDown(commentCard, { duration: 0.5, delay: index * 0.1 });
    });

  } catch (error) {
    console.error('Error loading comments:', error);
  }
}

// Comment form submission
document.getElementById('comment-form').addEventListener('submit', async (e) => {
  e.preventDefault();

  const formData = {
    news_id: parseInt(document.getElementById('news-id-input').value),
    author: document.getElementById('comment-author').value.trim(),
    text: document.getElementById('comment-text').value.trim()
  };

  if (!formData.author || !formData.text) {
    UIModule.showNotification('Please fill in all fields', 'error');
    return;
  }

  try {
    const response = await fetch('add_news_comment.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formData)
    });

    const result = await response.json();

    if (result.success) {
      UIModule.showNotification('✅ Comment posted!', 'success');

      // Clear form
      document.getElementById('comment-author').value = '';
      document.getElementById('comment-text').value = '';

      // Reload comments
      await loadComments(formData.news_id);
    } else {
      UIModule.showNotification('Failed to post comment', 'error');
    }

  } catch (error) {
    console.error('Error posting comment:', error);
    UIModule.showNotification('Error posting comment', 'error');
  }
});