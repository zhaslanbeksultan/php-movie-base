<?php include '../includes/header.php'; ?>
<?php include 'functions.php'; ?>

<?php
$favorites = read_json('../data/favorites.json');
$movies = read_json('../data/movies.json');

// Filter movies that are in favorites
$favoriteMovies = array_filter($movies, function($movie) use ($favorites) {
    return in_array($movie['id'], $favorites['movies']);
});
?>

<section class="favorites-page">
    <div class="favorites-header">
        <h2 class="section-title">⭐ My Favorite Movies</h2>
    </div>

    <div id="favorites-container" class="movie-grid">
        <?php if (empty($favoriteMovies)): ?>
            <div class="empty-favorites">
                <div class="empty-icon">💔</div>
                <h3>No favorites yet</h3>
                <p>Start adding movies to your collection!</p>
                <a href="catalog.php" class="btn-main">Browse Catalog</a>
            </div>
        <?php else: ?>
            <?php foreach ($favoriteMovies as $movie): ?>
                <div class="movie-card" data-movie-id="<?php echo $movie['id']; ?>">
                    <div class="poster">
                        <img src="<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        <div class="favorite-badge">⭐</div>
                        <div class="overlay">
                            <div class="overlay-content">
                                <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                                <p class="rating">⭐ <?php echo $movie['rating']; ?></p>
                                <a href="detail.php?id=<?php echo $movie['id']; ?>" class="btn-overlay">View Details</a>
                                <button class="btn-remove" data-movie-id="<?php echo $movie['id']; ?>">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="movie-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p class="meta"><?php echo $movie['year']; ?> • <?php echo strtoupper($movie['country']); ?></p>
                        <div class="genres">
                            <?php foreach ($movie['genre'] as $g): ?>
                                <span class="genre-tag"><?php echo ucfirst($g); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <p class="rating">⭐ <?php echo $movie['rating']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Load JavaScript modules -->
<script src="../assets/js/data.js"></script>
<script src="../assets/js/ui.js"></script>
<script src="../assets/js/events.js"></script>
<script src="../assets/js/favorites.js"></script>

<?php include '../includes/footer.php'; ?>