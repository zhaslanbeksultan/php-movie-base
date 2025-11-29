<?php include '../includes/header.php'; ?>
<?php include 'functions.php'; ?>

<?php
$id = intval($_GET['id'] ?? 0);
$movies = read_json('../data/movies.json');
$reviews = read_json('../data/reviews.json');
$movie = get_movie_by_id($movies, $id);
$movieReviews = get_reviews_by_movie($reviews, $id);
?>

<?php if ($movie): ?>
<section class="movie-detail-section">
  <div class="movie-detail-container">
    <div class="movie-poster" id="movie-poster-container">
      <img id="movie-poster" src="<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" data-movie-id="<?php echo $movie['id']; ?>">
      <div class="favorite-badge" id="favorite-icon" style="display: none;">⭐</div>
    </div>
    <div class="movie-content">
      <h2 class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></h2>
      <p class="movie-meta">
        <span><?php echo $movie['year']; ?></span> • 
        <span><?php echo strtoupper($movie['country']); ?></span>
      </p>
      <div class="movie-genres">
        <?php foreach ($movie['genre'] as $g): ?>
          <span class="genre-tag"><?php echo ucfirst($g); ?></span>
        <?php endforeach; ?>
      </div>
      <p class="movie-rating">⭐ <?php echo $movie['rating']; ?></p>
      <p class="movie-description"><?php echo htmlspecialchars($movie['description']); ?></p>
    </div>
  </div>
</section>

<section class="reviews-section">
  <h3>Audience Reviews</h3>

  <?php if (empty($movieReviews)): ?>
    <p class="no-reviews">No reviews yet. Be the first to share your thoughts!</p>
  <?php else: ?>
    <?php foreach ($movieReviews as $r): ?>
      <div class="review-card">
        <div class="review-header">
          <strong><?php echo htmlspecialchars($r['author']); ?></strong>
          <span class="stars">⭐ <?php echo $r['rating']; ?></span>
        </div>
        <p class="review-text"><?php echo htmlspecialchars($r['text']); ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</section>

<section class="review-form-section">
  <h3>Leave a Review</h3>
  <form method="post" action="review_form.php" class="review-form">
      <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
      <input type="text" name="author" placeholder="Your name" required>
      <select name="rating" required>
          <option value="">Rate...</option>
          <?php for ($i=1;$i<=5;$i++): ?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
          <?php endfor; ?>
      </select>
      <textarea name="text" placeholder="Write your review..." required></textarea>
      <button type="submit">Submit Review</button>
  </form>
</section>

<!-- Load JavaScript modules -->
<script src="../assets/js/data.js"></script>
<script src="../assets/js/ui.js"></script>
<script src="../assets/js/events.js"></script>
<script src="../assets/js/movie-detail.js"></script>

<?php else: ?>
<p class="no-movie">Movie not found.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>