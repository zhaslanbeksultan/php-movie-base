<?php include '../includes/header.php'; ?>
<?php include 'functions.php'; ?>

<?php
$movies = read_json('../data/movies.json');
$topMovies = array_slice($movies, 0, 5);
?>

<section class="banner">
    <h2>Welcome to MovieBase</h2>
    <p>Discover and review your favorite movies!</p>
</section>

<section class="catalog">
    <h3>Top Movies</h3>
    <div class="movie-grid">
        <?php foreach ($topMovies as $movie): ?>
            <div class="movie-card">
                <img src="<?php echo $movie['poster']; ?>" alt="<?php echo $movie['title']; ?>" width="200">
                <h4><?php echo $movie['title']; ?></h4>
                <p><?php echo $movie['year']; ?> | ⭐ <?php echo $movie['rating']; ?></p>
                <a href="detail.php?id=<?php echo $movie['id']; ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
