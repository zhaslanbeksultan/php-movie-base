<?php
// --- start session FIRST, before any HTML ---
session_start();

require 'functions.php';

$admin_password = "admin123"; // change if needed

// --- LOGIN LOGIC ---
if (isset($_POST['password'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin'] = true;
        header("Location: admin.php"); // redirect to avoid form resubmission
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
    <h2>Admin Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
        <input type="password" name="password" placeholder="Enter admin password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
<?php
exit;
endif;

// now safe to include header (after session logic)
include '../includes/header.php';

// --- LOAD MOVIES ---
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
        "poster" => "assets/images/" . trim($_POST['poster'])
    ];

    $movies[] = $newMovie;
    write_json('../data/movies.json', $movies);
    echo "<p style='color:green'>Movie added successfully!</p>";
}

// --- DELETE MOVIE ---
if (isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);

    // 1. Delete from movies.json
    $movies = array_filter($movies, fn($m) => $m['id'] != $deleteId);
    write_json('../data/movies.json', array_values($movies));

    // 2. Delete related reviews from reviews.json
    $reviewsFile = '../data/reviews.json';
    if (file_exists($reviewsFile)) {
        $reviews = read_json($reviewsFile);
        $filtered = array_filter($reviews, fn($r) => $r['movie_id'] != $deleteId);
        write_json($reviewsFile, array_values($filtered));
    }

    echo "<p style='color:red'>Movie and its reviews deleted (ID $deleteId)</p>";
}
?>

<h2>🎬 Admin Panel</h2>
<a href="?logout=1" style="float:right;">Logout</a>

<section class="admin-section">
    <h3>Add New Movie</h3>
    <form method="post">
        <input type="hidden" name="add_movie" value="1">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="text" name="genre" placeholder="Genres (comma-separated)" required>
        <input type="number" name="year" placeholder="Year" required>
        <input type="text" name="country" placeholder="Country" required>
        <input type="number" step="0.1" name="rating" placeholder="Rating (e.g. 8.5)" required>
        <input type="text" name="poster" placeholder="Poster file (e.g. Inception.jpg)" required>
        <button type="submit">Add Movie</button>
    </form>
</section>

<hr>

<section class="admin-section">
    <h3>Delete Movie</h3>
    <form method="post">
        <input type="number" name="delete_id" placeholder="Movie ID to delete" required>
        <button type="submit">Delete</button>
    </form>
</section>

<hr>

<section class="admin-section">
    <h3>Movie List</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr><th>ID</th><th>Title</th><th>Year</th><th>Rating</th><th>Country</th></tr>
        <?php foreach ($movies as $m): ?>
            <tr>
                <td><?= $m['id']; ?></td>
                <td><?= htmlspecialchars($m['title']); ?></td>
                <td><?= $m['year']; ?></td>
                <td><?= $m['rating']; ?></td>
                <td><?= htmlspecialchars($m['country']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<?php include '../includes/footer.php'; ?>
