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

    // Sort by date (latest → oldest)
    const latestNews = [...allNews].sort((a, b) => new Date(b.date) - new Date(a.date));

    // Sort by likes (most → least)
    const popularNews = [...allNews].sort((a, b) => b.likes - a.likes);

    // Hide loading spinners
    UIModule.hideLoading('latest-news');
    UIModule.hideLoading('popular-news');

    // Render news lists
    UIModule.renderNewsList(latestNews, 'latest-news');
    UIModule.renderNewsList(popularNews, 'popular-news');

    // Log statistics using array methods
    console.log('Total news:', allNews.length);
    console.log('Latest news:', latestNews.length);
    console.log('Popular news:', popularNews.length);
    console.log('Total likes:', DataModule.getTotalLikes(allNews));

    // Add hover effects after rendering
    EventsModule.setupNewsHover();

    // Enable horizontal scroll with vertical mouse wheel
    function enableHorizontalScroll(id) {
      const el = document.getElementById(id);

      /* === 1. Wheel Scroll (smooth for touchpad) === */
      el.addEventListener("wheel", (e) => {
        if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;
        e.preventDefault();
        el.scrollLeft += e.deltaY * 1.2;
      }, { passive: false });

      /* === 2. Drag to Scroll === */
      let isDown = false;
      let startX;
      let scrollLeft;
      let moved = false; // to prevent click after drag

      el.addEventListener("mousedown", (e) => {
        isDown = true;
        moved = false;
        el.classList.add("dragging");
        startX = e.pageX;
        scrollLeft = el.scrollLeft;
      });

      el.addEventListener("mouseleave", () => {
        isDown = false;
        el.classList.remove("dragging");
      });

      el.addEventListener("mouseup", () => {
        isDown = false;
        el.classList.remove("dragging");
      });

      el.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        moved = true;

        const walk = (e.pageX - startX) * 1.2; // smoother drag
        el.scrollLeft = scrollLeft - walk;
      });

      /* === 3. Disable clicking a news card after drag === */
      el.querySelectorAll('.news-card').forEach(card => {
        card.addEventListener("click", (e) => {
          if (moved) e.preventDefault();
        });
      });
    }


    enableHorizontalScroll('latest-news');
    enableHorizontalScroll('popular-news');


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