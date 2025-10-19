<?php include '../includes/header.php'; ?>
<?php include 'functions.php'; ?>

<?php
$movies = read_json('../data/movies.json');

$q = strtolower(trim($_GET['q'] ?? ''));
$genre = strtolower(trim($_GET['genre'] ?? ''));

$filtered = array_filter($movies, function($m) use ($q, $genre) {
    $matchQ = $q ? str_contains(strtolower($m['title']), $q) : true;
    $matchG = $genre ? in_array($genre, array_map('strtolower', $m['genre'])) : true;
    return $matchQ && $matchG;
});
?>

<section class="catalog-section">
    <h2 class="section-title">Movie Catalog</h2>

    <form method="get" class="search-form">
        <input type="text" name="q" placeholder="🔍 Search by title..." value="<?php echo htmlspecialchars($q); ?>">
        <input type="text" name="genre" placeholder="🎭 Filter by genre..." value="<?php echo htmlspecialchars($genre); ?>">
        <button type="submit">Search</button>
    </form>

    <div class="movie-grid">
        <?php if (empty($filtered)): ?>
            <p class="no-results">No movies found matching your search.</p>
        <?php else: ?>
            <?php foreach ($filtered as $movie): ?>
                <div class="movie-card">
                <div class="poster">
                    <img src="<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    <div class="overlay">
                    <div class="overlay-content">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p class="rating">⭐ <?php echo $movie['rating']; ?></p>
                        <a href="detail.php?id=<?php echo $movie['id']; ?>" class="btn-overlay">View Details</a>
                    </div>
                    </div>
                </div>
                <div class="movie-info">
                    <p class="meta"><?php echo $movie['year']; ?> • <?php echo strtoupper($movie['country']); ?></p>
                    <div class="genres">
                        <?php foreach ($movie['genre'] as $g): ?>
                            <span class="genre-tag"><?php echo ucfirst($g); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
