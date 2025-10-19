<?php include '../includes/header.php'; ?>
<?php include 'functions.php'; ?>

<?php
$movies = read_json('../data/movies.json');
$topMovies = array_slice($movies, 0, 5);
?>

<section class="banner">
  <div class="banner-overlay">
    <div class="banner-content">
      <div class="logo">
        <img src="assets/images/logo.jpg" alt="MovieBase Logo">
        <h1>MovieBase</h1>
      </div>
      <p class="tagline">Your gateway to the world of cinema.</p>
      <p class="subtext">Dive into stories that inspire, thrill, and move you — from timeless classics to the latest blockbusters.</p>
      <a href="catalog.php" class="btn-main">Explore Movies</a>
    </div>
  </div>
</section>


    <section class="catalog-section">
    <h2 class="section-title">🔥 Top Movies</h2>
    <div class="movie-grid">
        <?php foreach ($topMovies as $movie): ?>
        <div class="movie-card">
            <div class="poster">
            <img src="<?php echo $movie['poster']?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
            </div>
            <div class="movie-info">
            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
            <p class="meta"><?php echo $movie['year']; ?> • <?php echo strtoupper($movie['country']); ?></p>
            <p class="rating">⭐ <?php echo $movie['rating']; ?></p>
            <a href="detail.php?id=<?php echo $movie['id']; ?>" class="btn-details">View Details</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
