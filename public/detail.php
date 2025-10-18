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
<div class="movie-detail">
    <img src="../<?php echo $movie['poster']; ?>" alt="<?php echo $movie['title']; ?>">
    <div>
        <h2><?php echo $movie['title']; ?></h2>
        <p><strong>Year:</strong> <?php echo $movie['year']; ?></p>
        <p><strong>Country:</strong> <?php echo $movie['country']; ?></p>
        <p><strong>Genres:</strong> <?php echo implode(', ', $movie['genre']); ?></p>
        <p><strong>Rating:</strong> ⭐ <?php echo $movie['rating']; ?></p>
        <p><?php echo $movie['description']; ?></p>
    </div>
</div>

<hr>
<h3>Reviews</h3>
<?php foreach ($movieReviews as $r): ?>
    <div class="review">
        <p><strong><?php echo htmlspecialchars($r['author']); ?></strong> (⭐ <?php echo $r['rating']; ?>)</p>
        <p><?php echo htmlspecialchars($r['text']); ?></p>
    </div>
<?php endforeach; ?>

<h3>Leave a Review</h3>
<form method="post" action="review_form.php">
    <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
    <input type="text" name="author" placeholder="Your name" required>
    <select name="rating" required>
        <option value="">Rate...</option>
        <?php for ($i=1;$i<=5;$i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
    <textarea name="text" placeholder="Your review" required></textarea>
    <button type="submit">Submit</button>
</form>
<?php else: ?>
<p>Movie not found.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
