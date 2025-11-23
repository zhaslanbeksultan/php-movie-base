<?php include '../includes/header.php'; ?>

<section class="news-page">
    <div class="news-header">
        <h2 class="section-title">🎬 Cinema News</h2>
        
        <!-- Search functionality -->
        <div class="search-form">
            <input type="text" id="news-search" placeholder="🔍 Search news... (Press Enter)">
            <button type="submit" id="news-search-btn">Search</button>
        </div>
    </div>

    <!-- Latest News Section -->
    <div class="news-section">
        <h3 class="category-title">⚡ Latest News</h3>
        <div class="fade-wrapper">
            <div id="latest-news" class="news-grid scroll-section">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Popular News Section -->
    <div class="news-section">
        <h3 class="category-title">🔥 Popular News</h3>
        <div class="fade-wrapper">
            <div id="popular-news" class="news-grid scroll-section">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>
</section>

<!-- Load JavaScript modules -->
<script src="../assets/js/data.js"></script>
<script src="../assets/js/ui.js"></script>
<script src="../assets/js/events.js"></script>
<script src="../assets/js/news.js"></script>

<?php include '../includes/footer.php'; ?>