<?php
require 'functions.php';

$movie_id = intval($_POST['movie_id'] ?? 0);
$author = trim($_POST['author'] ?? '');
$rating = intval($_POST['rating'] ?? 0);
$text = trim($_POST['text'] ?? '');

if ($movie_id && $author && $rating && $text) {
    $reviews = read_json('../data/reviews.json');
    $newId = empty($reviews) ? 1 : max(array_column($reviews, 'id')) + 1;

    $reviews[] = [
        'id' => $newId,
        'movie_id' => $movie_id,
        'author' => htmlspecialchars($author),
        'rating' => $rating,
        'text' => htmlspecialchars($text),
        'date' => date('Y-m-d')
    ];

    write_json('../data/reviews.json', $reviews);
    header("Location: detail.php?id=$movie_id");
    exit;
} else {
    echo "Please fill all fields!";
}
?>
