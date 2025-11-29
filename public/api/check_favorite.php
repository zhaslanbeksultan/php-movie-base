<?php
// check_favorite.php - Check if movie is in favorites

header('Content-Type: application/json');
require '../functions.php';

try {
    $movieId = intval($_GET['movie_id'] ?? 0);
    
    if (!$movieId) {
        echo json_encode(['is_favorite' => false]);
        exit;
    }
    
    $favorites = read_json('../../data/favorites.json');
    $isFavorite = in_array($movieId, $favorites['movies']);
    
    echo json_encode([
        'is_favorite' => $isFavorite,
        'movie_id' => $movieId
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'is_favorite' => false,
        'error' => $e->getMessage()
    ]);
}
?>