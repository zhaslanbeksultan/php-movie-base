// data.js - Data management module

const DataModule = (() => {
  // Fetch news data using modern fetch API
  const fetchNews = async () => {
    try {
      const response = await fetch('news_service.php');
      if (!response.ok) throw new Error('Failed to fetch news');
      return await response.json();
    } catch (error) {
      console.error('Error fetching news:', error);
      return [];
    }
  };

  // Filter news by category using array filter method
  const filterByCategory = (newsArray, category) => {
    return newsArray.filter(news => news.category === category);
  };

  // Sort news by likes using arrow function
  const sortByLikes = (newsArray) => {
    return [...newsArray].sort((a, b) => b.likes - a.likes);
  };

  // Get news by ID using array find method
  const getNewsById = (newsArray, id) => {
    return newsArray.find(news => news.id === parseInt(id));
  };

  // Calculate total likes using reduce method
  const getTotalLikes = (newsArray) => {
    return newsArray.reduce((total, news) => total + news.likes, 0);
  };

  // Map news to simplified objects using map method
  const mapToSimplified = (newsArray) => {
    return newsArray.map(news => ({
      id: news.id,
      title: news.title,
      likes: news.likes
    }));
  };

  // Like a news article (POST request)
  const likeNews = async (newsId) => {
    try {
      const response = await fetch('like_news_service.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ news_id: newsId })
      });

      if (!response.ok) throw new Error('Failed to like news');
      return await response.json();
    } catch (error) {
      console.error('Error liking news:', error);
      return { success: false };
    }
  };

  // Public API
  return {
    fetchNews,
    filterByCategory,
    sortByLikes,
    getNewsById,
    getTotalLikes,
    mapToSimplified,
    likeNews
  };
})();

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = DataModule;
}