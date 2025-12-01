# 🎬 MovieBase

**GitHub Repository:** [php-movie-base](https://github.com/zhaslanbeksultan/php-movie-base)

MovieBase is a feature-rich **PHP-based web application** that provides users with an immersive movie browsing experience, complete with news updates, favorites management, and interactive reviews. Built without a traditional database, it leverages **JSON files** for data storage, making it lightweight, portable, and perfect for learning full-stack web development.

---

## 👥 Team Members

| Name                  | Role               | Responsibilities                                                                                                                      |
| --------------------- | ------------------ | ------------------------------------------------------------------------------------------------------------------------------------- |
| **Beksultan Zhaslan** | Backend Developer  | Implemented backend logic in PHP: CRUD operations, JSON file handling, admin authentication, review linking, and final project report |
| **Alikhan Murat**     | Frontend Developer | Designed all pages using HTML + CSS with a modern, responsive layout and consistent theme; prepared the presentation                  |

---

## 🧩 Project Overview

### 🎯 Core Functionality

MovieBase is a comprehensive movie catalog and entertainment news platform with **two user roles**:

#### **Visitors / Users**
- Browse and search movies by title or genre
- View detailed movie pages with ratings and descriptions
- Read and write reviews
- Add movies to favorites with instant visual feedback
- Explore cinema news with interactive engagement
- Like and comment on news articles
- Toggle between light/dark themes

#### **Admin**
- Secure session-based authentication
- Add, update, and delete movie records
- Real-time JSON data management
- Automatic review cleanup when movies are deleted

---

## 🆕 What's New in Final Phase

### ✨ Enhanced Features

#### **1. News System** 📰
- **Dynamic News Feed**: Browse latest cinema news with smooth horizontal scrolling
- **News Categories**: 
  - Latest News (sorted by date)
  - Popular News (sorted by likes)
- **Interactive Engagement**:
  - Like/unlike news articles with real-time updates
  - Toggle functionality prevents double-clicking issues
  - Persistent like status across sessions
- **Comment System**:
  - Add comments to news articles
  - Real-time comment posting with validation
  - Chronological comment display
- **Search Functionality**: Filter news by title (press Enter or click Search)

#### **2. Favorites Management** ⭐
- **Visual Favorites**:
  - Double-click movie posters to add to favorites
  - Animated star badge appears on favorite movies
  - Dedicated Favorites page with all your saved movies
- **Web Service Integration**:
  - RESTful API endpoints for favorites management
  - Persistent storage in `favorites.json`
  - Real-time favorite status checking

#### **3. Modern JavaScript Architecture** 🚀
- **Modular Design**:
  - `data.js`: Data fetching and management
  - `ui.js`: UI manipulation and rendering
  - `events.js`: Event handling and user interactions
  - `theme.js`: Theme switching functionality
  - Page-specific controllers (news.js, favorites.js, etc.)
- **ES6+ Features**:
  - Arrow functions
  - Async/await for API calls
  - Array methods (map, filter, reduce, sort)
  - Template literals
  - Destructuring

#### **4. Scriptaculous Effects** ✨
- **Smooth Animations**:
  - Fade in/out effects for cards and notifications
  - Slide effects for category titles
  - Pulsate animations for like buttons
  - Highlight effects for new comments
  - Appear/disappear transitions
- **Interactive Feedback**:
  - Button hover effects
  - Card stagger animations
  - Loading state animations

#### **5. Enhanced UI/UX** 🎨
- **Theme System**:
  - Light/Dark mode toggle
  - Persistent theme preference (localStorage)
  - Smooth theme transitions
  - Custom color schemes for each mode
- **Responsive Design**:
  - Mobile-friendly layouts
  - Touch-optimized interactions
  - Flexible grid systems
- **Visual Effects**:
  - Hover animations on cards
  - Gradient overlays
  - Box shadows and glows
  - Genre tags with hover effects

#### **6. Web Services (RESTful APIs)** 🌐

All web services return JSON responses and follow REST principles:

| Endpoint | Method | Description |
|----------|--------|-------------|
| `api/news_service.php` | GET | Fetch all news articles |
| `api/like_news_service.php` | POST | Toggle like status on news |
| `api/get_news_comments.php` | GET | Fetch comments for a news article |
| `api/add_news_comment.php` | POST | Add a new comment |
| `api/toggle_favorite.php` | POST | Add/remove movie from favorites |
| `api/check_favorite.php` | GET | Check if movie is favorited |
| `api/check_news_like.php` | GET | Check if news is liked |

---

## 📁 Project Structure

```
php-movie-base/
│
├── includes/
│   ├── header.php              # Common header with navigation
│   ├── footer.php              # Common footer
│   └── menu.php                # Navigation menu with theme toggle
│
├── public/
│   ├── index.php               # Homepage with featured movies
│   ├── catalog.php             # Full movie catalog with search
│   ├── detail.php              # Movie detail page with reviews
│   ├── favorites.php           # User's favorite movies
│   ├── news.php                # News feed page
│   ├── news_detail.php         # Individual news article
│   ├── admin.php               # Admin panel for CRUD operations
│   ├── review_form.php         # Review submission handler
│   ├── functions.php           # Core PHP helper functions
│   │
│   └── api/                    # Web Services (RESTful APIs)
│       ├── news_service.php          # Fetch news (GET)
│       ├── like_news_service.php     # Toggle like (POST)
│       ├── get_news_comments.php     # Fetch comments (GET)
│       ├── add_news_comment.php      # Add comment (POST)
│       ├── toggle_favorite.php       # Toggle favorite (POST)
│       ├── check_favorite.php        # Check favorite (GET)
│       └── check_news_like.php       # Check like status (GET)
│
├── data/
│   ├── movies.json             # Movie database
│   ├── reviews.json            # User reviews
│   ├── favorites.json          # User favorites & likes
│   ├── news.json               # News articles
│   └── news_comments.json      # News comments
│
├── assets/
│   ├── css/
│   │   ├── style.css           # Main stylesheet (imports all modules)
│   │   ├── base.css            # Global styles & animations
│   │   ├── layout.css          # Header, footer, navigation
│   │   ├── components.css      # Reusable components
│   │   ├── pages.css           # Page-specific styles
│   │   └── themes.css          # Light/dark theme styles
│   │
│   ├── js/
│   │   ├── data.js             # Data management module
│   │   ├── ui.js               # UI manipulation module
│   │   ├── events.js           # Event handling module
│   │   ├── theme.js            # Theme toggle functionality
│   │   ├── news.js             # News page controller
│   │   ├── news-detail.js      # News detail controller
│   │   ├── favorites.js        # Favorites page controller
│   │   └── movie-detail.js     # Movie detail controller
│   │
│   └── images/
│       ├── logo.jpg            # Site logo
│       └── banner-bg.jpg       # Homepage banner
│
└── README.md                   # This file
```

---

## ⚙️ JSON Data Management

MovieBase uses five JSON files for persistent storage:

### **1️⃣ movies.json**
Contains movie data including:
```json
{
  "id": 1,
  "title": "Inception",
  "year": 2010,
  "rating": 8.8,
  "country": "USA",
  "genre": ["sci-fi", "thriller"],
  "description": "A thief who steals corporate secrets...",
  "poster": "assets/images/inception.jpg"
}
```

### **2️⃣ reviews.json**
Stores user reviews linked by `movie_id`:
```json
{
  "id": 1,
  "movie_id": 1,
  "author": "John",
  "rating": 5,
  "text": "Amazing visuals and storytelling!",
  "date": "2025-10-18"
}
```

### **3️⃣ favorites.json**
Manages user favorites and news likes:
```json
{
  "movies": [1, 3, 5],
  "news_likes": {
    "1": true,
    "5": true
  }
}
```

### **4️⃣ news.json**
Cinema news articles with engagement metrics:
```json
{
  "id": 1,
  "title": "Christopher Nolan's Next Film Announced",
  "description": "Oscar-winning director...",
  "image": "https://example.com/image.jpg",
  "date": "2025-11-18",
  "likes": 358,
  "is_liked": false
}
```

### **5️⃣ news_comments.json**
Comments on news articles:
```json
{
  "id": 1,
  "news_id": 1,
  "author": "MovieFan",
  "text": "Can't wait for this!",
  "date": "2025-11-23 16:01:35"
}
```

### **How JSON is Managed**
- `read_json()` loads and decodes data into PHP arrays
- `write_json()` safely writes changes with pretty formatting
- Automatic cleanup: when a movie is deleted, all linked reviews are removed
- Unique IDs ensure data integrity
- Error handling for file operations

---

## 🧠 Admin Panel Overview

The admin panel provides comprehensive movie management:

- **Add Movie**: Create new entries with all movie details
- **Update Movie**: Modify existing movies by ID
- **Delete Movie**: Remove movies and automatically clean up related reviews
- **Movie List**: View all movies in a sortable table
- **Session-based Security**: Password-protected access

**Default Admin Password**: `admin123`

---

## 🎨 Design Highlights

### **Color Scheme**

#### Dark Mode (Default)
- Background: `#0f0f0f`
- Cards: `#1b1b1b`
- Accent: `#ffcc00` (Gold)
- Text: `#f5f5f5`

#### Light Mode
- Background: `#faedb9` (Warm cream)
- Cards: `#fff8dc` (Cornsilk)
- Accent: `#ffd700` (Vibrant gold)
- Text: `#1a1a1a`

### **Key Animations**
- Fade in effects on page load
- Hover transformations on cards
- Smooth scrolling for news sections
- Pulsating effects on interactions
- Loading spinners for async operations

### **Typography**
- Font Family: 'Segoe UI', Roboto, Arial
- Headers: Bold, shadow effects
- Body: Clean, high contrast
- Responsive sizing

---

## 🚀 Technical Implementation

### **JavaScript Architecture**

#### Module Pattern
All JavaScript code follows the **Module Pattern** for encapsulation:

```javascript
const DataModule = (() => {
  // Private functions and variables
  
  // Public API
  return {
    fetchNews,
    likeNews,
    // ...
  };
})();
```

#### Key Features
- **Async/Await**: Modern promise handling
- **Fetch API**: RESTful web service calls
- **DOM Manipulation**: Dynamic content rendering
- **Event Delegation**: Efficient event handling
- **Array Methods**: Functional programming approach

### **PHP Backend**

#### Security Features
- Session-based authentication
- Input sanitization with `htmlspecialchars()`
- File existence validation
- JSON encoding/decoding with error handling

#### Helper Functions
- `read_json()`: Safe JSON file reading
- `write_json()`: Pretty-printed JSON writing
- `get_movie_by_id()`: Movie lookup
- `get_reviews_by_movie()`: Review filtering

---

## 📊 Data Flow

### Adding a Favorite
```
1. User double-clicks movie poster
2. JavaScript captures event
3. POST request to api/toggle_favorite.php
4. PHP reads favorites.json
5. Adds/removes movie ID
6. Writes updated favorites.json
7. Returns success response
8. JavaScript updates UI with animation
```

### Liking News
```
1. User clicks like button
2. Button enters loading state
3. POST request to api/like_news_service.php
4. PHP updates news.json and favorites.json
5. Returns new like count and status
6. JavaScript updates button appearance
7. Scriptaculous animation plays
```

---

## 🖼️ Screenshots

### **🏠 Home Page**
*Discover featured movies with an engaging banner*
<img width="1919" height="869" alt="image" src="https://github.com/user-attachments/assets/f085e33c-84e2-46b4-95c1-491d47cb0aca" />
<img width="1917" height="874" alt="image" src="https://github.com/user-attachments/assets/90d44e85-e480-4cfd-8432-eb6b05a1538c" />

### **🎞️ Catalog Page**
*Search and filter movies by title or genre*
<img width="1912" height="883" alt="image" src="https://github.com/user-attachments/assets/27f5f29f-f9fa-4b99-a3db-6970e715f885" />
<img width="1914" height="872" alt="image" src="https://github.com/user-attachments/assets/6e76e005-b9e4-4140-978c-f405dbeb09e3" />

### **📖 Movie Detail Page**
*View ratings, reviews, and add to favorites*
<img width="1919" height="858" alt="image" src="https://github.com/user-attachments/assets/4a05de46-f126-473a-9b29-a44e2cfe69e4" />
<img width="1862" height="877" alt="image" src="https://github.com/user-attachments/assets/ba746a33-878c-4dcc-9ec4-79d63b5ce8ab" />

### **⭐ Favorites Page**
*Manage your collection of saved movies*
<img width="1908" height="793" alt="image" src="https://github.com/user-attachments/assets/d3bd8daa-75e8-4684-bf8c-8accc3ace942" />
<img width="1903" height="887" alt="image" src="https://github.com/user-attachments/assets/c8c36784-474a-493c-a2a4-8edaa6779c8a" />

### **📰 News Page**
*Browse latest cinema news with horizontal scrolling*
<img width="1907" height="880" alt="image" src="https://github.com/user-attachments/assets/bdf3bc3f-518d-4723-984f-6bc9e1521825" />

### **💬 News Detail Page**
*Read articles, like, and leave comments*
<img width="1917" height="876" alt="image" src="https://github.com/user-attachments/assets/f5bb3d2b-eee7-4af7-8a83-d9a6406e534e" />
<img width="1919" height="864" alt="image" src="https://github.com/user-attachments/assets/daba14b7-adbe-4c42-8bce-1898cc64d97a" />

### **🛠️ Admin Panel**
*Manage movies with live JSON updates*
<img width="1919" height="882" alt="image" src="https://github.com/user-attachments/assets/3bda7729-32da-4459-bc5d-e5f7e5cfd5a5" />
<img width="1916" height="828" alt="image" src="https://github.com/user-attachments/assets/aa5596ea-3096-434a-a41d-356a73afce00" />

### **Light Theme**
<img width="1919" height="878" alt="image" src="https://github.com/user-attachments/assets/3c6fdc1a-ae3a-448d-a558-c9440b943429" />

---

## 🎓 Learning Outcomes

This project demonstrates:

### **Frontend Development**
- ✅ Semantic HTML5 structure
- ✅ Modern CSS3 (Grid, Flexbox, Animations)
- ✅ Modular CSS architecture
- ✅ Responsive design principles
- ✅ JavaScript ES6+ features
- ✅ Async programming
- ✅ DOM manipulation
- ✅ Event handling
- ✅ Module pattern

### **Backend Development**
- ✅ PHP session management
- ✅ File-based data storage
- ✅ JSON encoding/decoding
- ✅ RESTful API design
- ✅ CRUD operations
- ✅ Input validation
- ✅ Error handling

### **Full-Stack Integration**
- ✅ Client-server communication
- ✅ RESTful web services
- ✅ Data persistence
- ✅ State management
- ✅ User authentication

### **Best Practices**
- ✅ Code organization
- ✅ Separation of concerns
- ✅ DRY principle
- ✅ Security considerations
- ✅ User experience design

---

## 🚀 Getting Started

### Prerequisites
- PHP 7.4 or higher
- Web server (Apache/Nginx) or PHP built-in server
- Modern web browser

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/zhaslanbeksultan/php-movie-base.git
   cd php-movie-base
   ```

2. **Start PHP server**
   ```bash
   cd public
   php -S localhost:8000
   ```

3. **Access the application**
   ```
   http://localhost:8000
   ```

4. **Admin access**
   ```
   Navigate to: http://localhost:8000/admin.php
   Password: admin123
   ```

---

## 🔧 Configuration

### Changing Admin Password
Edit `public/admin.php`:
```php
$admin_password = "your_new_password";
```

### Adding New Movies
Use the Admin Panel or manually edit `data/movies.json`

### Theme Customization
Modify colors in `assets/css/themes.css`

---

## 📝 Future Enhancements

Potential features for future versions:

- [ ] User registration and authentication
- [ ] Advanced search with filters
- [ ] Movie trailers integration
- [ ] Social sharing functionality
- [ ] Watchlist feature
- [ ] User profiles
- [ ] Movie recommendations
- [ ] Rating system improvements
- [ ] Multi-language support
- [ ] Database migration (MySQL/PostgreSQL)

---

## 🐛 Known Issues

- Large movie posters may affect load times
- No pagination for large catalogs
- Single-user favorites (no multi-user support)
- Admin password stored in plain text

---

## 📚 Resources

- [PHP Documentation](https://www.php.net/docs.php)
- [MDN Web Docs](https://developer.mozilla.org/)
- [Scriptaculous Effects](https://script.aculo.us/)
- [JSON Specification](https://www.json.org/)

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues.

---

## 📄 License

This project is open source and available for educational purposes.

---

## 🙏 Acknowledgments

- Movie data and descriptions sourced from public film databases
- Design inspiration from modern streaming platforms
- Icons and emoji from Unicode standard
- Scriptaculous library by Thomas Fuchs

---

## 📞 Contact

For questions or feedback:
- **GitHub**: [@zhaslanbeksultan](https://github.com/zhaslanbeksultan)
- **Project**: [php-movie-base](https://github.com/zhaslanbeksultan/php-movie-base)

---

## 🚀 Conclusion

MovieBase demonstrates a complete full-stack web application built with PHP, JavaScript, and modern web technologies. It showcases:

- **Core CRUD logic in PHP** without database complexity
- **RESTful web services** for client-server communication
- **Modern JavaScript architecture** with modular design
- **Interactive UI/UX** with animations and effects
- **Responsive design** for all devices
- **Practical file-based data persistence** ideal for learning

Perfect for students, developers learning full-stack development, or anyone interested in building dynamic web applications with a clean, maintainable architecture.

**🎬 Happy Coding! 🎬**
