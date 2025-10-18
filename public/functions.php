<?php
function read_json($path) {
    if (!file_exists($path)) return [];
    $data = file_get_contents($path);
    return json_decode($data, true) ?? [];
}

function write_json($path, $data) {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function get_movie_by_id($movies, $id) {
    foreach ($movies as $movie) {
        if ($movie['id'] == $id) return $movie;
    }
    return null;
}

function get_reviews_by_movie($reviews, $movie_id) {
    return array_filter($reviews, fn($r) => $r['movie_id'] == $movie_id);
}
?>
