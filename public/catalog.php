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

<form method="get" class="search-form">
    <input type="text" name="q" placeholder="Search by title..." value="<?php echo htmlspecialchars($q); ?>">
    <input type="text" name="genre" placeholder="Filter by genre..." value="<?php echo htmlspecialchars($genre); ?>">
    <button type="submit">Search</button>
</form>

<div class="movie-grid">
    <?php foreach ($filtered as $movie): ?>
        <div class="movie-card">
            <img src="../<?php echo $movie['poster']; ?>" alt="<?php echo $movie['title']; ?>">
            <h4><?php echo $movie['title']; ?></h4>
            <p><?php echo $movie['year']; ?> | ⭐ <?php echo $movie['rating']; ?></p>
            <a href="detail.php?id=<?php echo $movie['id']; ?>">View Details</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>
