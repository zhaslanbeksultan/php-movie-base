<?php
session_start();
require 'functions.php';

$admin_password = "admin123";

// --- LOGIN ---
if (isset($_POST['password'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid password!";
    }
}

// --- LOGOUT ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// --- AUTH CHECK ---
if (!isset($_SESSION['admin'])):
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="admin-login-container">
    <h2>🔐 Admin Login</h2>
    <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>

    <form method="post" class="admin-login-form">
      <input type="password" name="password" placeholder="Enter admin password" required>
      <button type="submit">Login</button>
    </form>

    <a href="index.php" class="go-back-btn">⬅ Go Back</a>
  </div>
</body>
</html>
<?php
exit;
endif;

// --- MAIN ADMIN PANEL ---
include '../includes/header.php';
$movies = read_json('../data/movies.json');

// --- ADD MOVIE ---
if (isset($_POST['add_movie'])) {
    $newMovie = [
        "id" => empty($movies) ? 1 : max(array_column($movies, 'id')) + 1,
        "title" => trim($_POST['title']),
        "description" => trim($_POST['description']),
        "genre" => array_map('trim', explode(',', $_POST['genre'])),
        "year" => intval($_POST['year']),
        "rating" => floatval($_POST['rating']),
        "country" => trim($_POST['country']),
        "poster" => "" . trim($_POST['poster'])
    ];

    $movies[] = $newMovie;
    write_json('../data/movies.json', $movies);
    echo "<p class='success-message'>🎉 Movie added successfully!</p>";
}

// --- UPDATE MOVIE ---
if (isset($_POST['update_movie'])) {
    $updateId = intval($_POST['update_id']);
    $updated = false;

    foreach ($movies as &$m) {
        if ($m['id'] == $updateId) {
            if (!empty($_POST['title'])) $m['title'] = trim($_POST['title']);
            if (!empty($_POST['description'])) $m['description'] = trim($_POST['description']);
            if (!empty($_POST['genre'])) $m['genre'] = array_map('trim', explode(',', $_POST['genre']));
            if (!empty($_POST['year'])) $m['year'] = intval($_POST['year']);
            if (!empty($_POST['country'])) $m['country'] = trim($_POST['country']);
            if (!empty($_POST['rating'])) $m['rating'] = floatval($_POST['rating']);
            if (!empty($_POST['poster'])) $m['poster'] = "" . trim($_POST['poster']);
            $updated = true;
            break;
        }
    }

    if ($updated) {
        write_json('../data/movies.json', $movies);
        echo "<p class='success-message'>✏️ Movie ID $updateId updated successfully!</p>";
    } else {
        echo "<p class='error-message'>⚠️ Movie with ID $updateId not found!</p>";
    }
}


// --- DELETE MOVIE ---
if (isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    $movies = array_filter($movies, fn($m) => $m['id'] != $deleteId);
    write_json('../data/movies.json', array_values($movies));

    $reviewsFile = '../data/reviews.json';
    if (file_exists($reviewsFile)) {
        $reviews = read_json($reviewsFile);
        $filtered = array_filter($reviews, fn($r) => $r['movie_id'] != $deleteId);
        write_json($reviewsFile, array_values($filtered));
    }

    echo "<p class='delete-message'>🗑️ Movie and its reviews deleted (ID $deleteId)</p>";
}
?>

<section class="admin-panel">
  <div class="admin-header">
    <h2>🎬 MovieBase Admin Dashboard</h2>
    <a href="?logout=1" class="logout-btn">Logout</a>
  </div>

  <!-- Top Section: Add / Update / Delete -->
  <div class="admin-top">
    <!-- Add Movie -->
    <div class="admin-card">
      <h3>➕ Add New Movie</h3>
      <form method="post" class="admin-form">
        <input type="hidden" name="add_movie" value="1">
        <input type="text" name="title" placeholder="Movie Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="text" name="genre" placeholder="Genres (comma-separated)" required>
        <input type="number" name="year" placeholder="Year" required>
        <input type="text" name="country" placeholder="Country" required>
        <input type="number" step="0.1" name="rating" placeholder="Rating (e.g. 8.5)" required>
        <input type="text" name="poster" placeholder="Poster file (e.g. Inception.jpg)" required>
        <button type="submit">Add Movie</button>
      </form>
    </div>

    <!-- Update Movie -->
    <div class="admin-card">
      <h3>✏️ Update Movie</h3>
      <form method="post" class="admin-form">
        <input type="hidden" name="update_movie" value="1">
        <input type="number" name="update_id" placeholder="Movie ID" required>
        <input type="text" name="title" placeholder="New Title (optional)">
        <textarea name="description" placeholder="New Description (optional)"></textarea>
        <input type="text" name="genre" placeholder="New Genres (comma-separated)">
        <input type="number" name="year" placeholder="New Year">
        <input type="text" name="country" placeholder="New Country">
        <input type="number" step="0.1" name="rating" placeholder="New Rating">
        <input type="text" name="poster" placeholder="New Poster filename">
        <button type="submit" class="update-btn">Update Movie</button>
      </form>
    </div>

    <!-- Delete Movie -->
    <div class="admin-card">
      <h3>🗑️ Delete Movie</h3>
      <form method="post" class="admin-form">
        <input type="number" name="delete_id" placeholder="Enter Movie ID" required>
        <button type="submit" class="delete-btn">Delete</button>
      </form>
    </div>
  </div>

  <!-- Bottom Section: Movie List -->
  <div class="admin-bottom">
    <div class="admin-card">
      <h3>📜 Movie List</h3>
      <div class="movie-table-container">
        <table class="movie-table">
          <tr>
            <th>ID</th><th>Title</th><th>Year</th><th>Rating</th><th>Country</th>
          </tr>
          <?php foreach ($movies as $m): ?>
          <tr>
            <td><?= $m['id']; ?></td>
            <td><?= htmlspecialchars($m['title']); ?></td>
            <td><?= $m['year']; ?></td>
            <td>⭐ <?= $m['rating']; ?></td>
            <td><?= htmlspecialchars($m['country']); ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>


<?php include '../includes/footer.php'; ?>
