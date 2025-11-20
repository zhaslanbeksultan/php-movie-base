// news-detail.js - News detail page controller

(async () => {
  // Get news ID from URL
  const urlParams = new URLSearchParams(window.location.search);
  const newsId = parseInt(urlParams.get('id'));

  if (!newsId) {
    document.getElementById('news-content').innerHTML = '<p class="no-news">News not found.</p>';
    return;
  }

  try {
    // Fetch all news
    const allNews = await DataModule.fetchNews();

    // Find specific news by ID
    const news = DataModule.getNewsById(allNews, newsId);

    if (!news) {
      document.getElementById('news-content').innerHTML = '<p class="no-news">News not found.</p>';
      return;
    }

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
    likeSection.innerHTML = `
            <button class="like-btn" data-news-id="${news.id}">
                ❤️ ${news.likes}
            </button>
            <p class="like-text">Like this article</p>
        `;

    content.appendChild(likeSection);
    contentDiv.appendChild(content);

    // Add back button
    const backBtn = document.createElement('a');
    backBtn.href = 'news.php';
    backBtn.className = 'back-btn';
    backBtn.textContent = '← Back to News';
    contentDiv.appendChild(backBtn);

    // Setup like button event
    EventsModule.setupLikeButtons();

  } catch (error) {
    console.error('Error loading news detail:', error);
    document.getElementById('news-content').innerHTML = '<p class="no-news">Error loading news.</p>';
  }
})();