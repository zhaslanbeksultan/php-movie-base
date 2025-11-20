// news.js - Main controller for news page

(async () => {
  // Show loading state
  UIModule.showLoading('latest-news');
  UIModule.showLoading('popular-news');

  try {
    // Fetch all news data using DataModule
    const allNews = await DataModule.fetchNews();

    if (allNews.length === 0) {
      UIModule.showNotification('No news available', 'error');
      return;
    }

    // Filter news by categories using arrow functions and filter method
    const latestNews = DataModule.filterByCategory(allNews, 'latest');
    const popularNews = DataModule.filterByCategory(allNews, 'popular');

    // Sort popular news by likes
    const sortedPopular = DataModule.sortByLikes(popularNews);

    // Hide loading spinners
    UIModule.hideLoading('latest-news');
    UIModule.hideLoading('popular-news');

    // Render news lists
    UIModule.renderNewsList(latestNews, 'latest-news');
    UIModule.renderNewsList(sortedPopular, 'popular-news');

    // Log statistics using array methods
    console.log('Total news:', allNews.length);
    console.log('Latest news:', latestNews.length);
    console.log('Popular news:', popularNews.length);
    console.log('Total likes:', DataModule.getTotalLikes(allNews));

    // Add hover effects after rendering
    EventsModule.setupNewsHover();

  } catch (error) {
    console.error('Error loading news:', error);
    UIModule.hideLoading('latest-news');
    UIModule.hideLoading('popular-news');
    UIModule.showNotification('Failed to load news', 'error');
  }
})();

document.observe("dom:loaded", function () {

  /* === 1. Fade In All News Cards on Load === */
  $$(".news-card").each(function (card, index) {
    // small delay for a stagger animation
    new Effect.Appear(card, { duration: 0.8, delay: index * 0.1 });
  });

  /* === 2. Slide Down Category Title === */
  $$(".category-title").each(function (title) {
    new Effect.SlideDown(title, { duration: 0.6 });
  });

  /* === 3. Make Highlight Button Pulsate === */
  $$(".pimpin-btn").each(function (btn) {
    btn.observe("mouseover", function () {
      new Effect.Pulsate(btn, { pulses: 2, duration: 0.8 });
    });
  });
});

/* === 4. Fade Notification In and Out === */
window.showNewsNotification = function (msg, type = "success") {

  let note = new Element("div", {
    class: "notification " + (type === "error" ? "notification-error" : "notification-success")
  }).update(msg);

  document.body.insert(note);

  new Effect.Appear(note, { duration: 0.5 });

  // Remove after 3 sec
  setTimeout(function () {
    new Effect.Fade(note, { duration: 0.5, afterFinish: () => note.remove() });
  }, 3000);
};