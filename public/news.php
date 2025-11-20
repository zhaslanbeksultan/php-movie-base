<?php include '../includes/header.php'; ?>

<section class="news-page">
    <div class="news-header">
        <h2 class="section-title">🎬 Cinema News</h2>
        <p class="news-subtitle">Stay updated with the latest from the world of movies</p>
        
        <!-- Interactive UI Elements for ENDTERM -->
        <div class="interactive-controls">
            <button id="pimpin-btn" class="pimpin-btn">Make Me Bigger! 🚀</button>
            <label class="bling-control">
                <input type="checkbox" id="bling-checkbox">
                <span>✨ Snoopify (Bling Mode)</span>
            </label>
        </div>
        
        <!-- Search functionality -->
        <div class="search-bar">
            <input type="text" id="news-search" placeholder="🔍 Search news... (Press Enter)">
        </div>
    </div>

    <!-- Latest News Section -->
    <div class="news-section">
        <h3 class="category-title">⚡ Latest News</h3>
        <div id="latest-news" class="news-grid">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>

    <!-- Popular News Section -->
    <div class="news-section">
        <h3 class="category-title">🔥 Popular News</h3>
        <div id="popular-news" class="news-grid">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>
</section>

<!-- Load JavaScript modules -->
<script src="../assets/js/data.js"></script>
<script src="../assets/js/ui.js"></script>
<script src="../assets/js/events.js"></script>
<script src="../assets/js/news.js"></script>

<?php include '../includes/footer.php'; ?>