<?php
// toggle_favorite.php - Web Service for toggling favorites

header('Content-Type: application/json');
require '../public/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['movie_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Movie ID is required']);
        exit;
    }
    
    $movieId = intval($input['movie_id']);
    
    // Read favorites data
    $favorites = read_json('../data/favorites.json');
    
    // Check if movie is already in favorites
    $index = array_search($movieId, $favorites['movies']);
    
    if ($index !== false) {
        // Remove from favorites
        array_splice($favorites['movies'], $index, 1);
        $isFavorite = false;
    } else {
        // Add to favorites
        $favorites['movies'][] = $movieId;
        $isFavorite = true;
    }
    
    // Save updated favorites
    write_json('../data/favorites.json', $favorites);
    
    echo json_encode([
        'success' => true,
        'is_favorite' => $isFavorite,
        'movie_id' => $movieId
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>