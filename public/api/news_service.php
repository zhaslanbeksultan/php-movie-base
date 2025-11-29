<?php
// news_service.php - Web Service v1 (GET - Returns JSON data)

header('Content-Type: application/json');
require '../functions.php';

try {
    // Read news data from JSON file
    $news = read_json('../../data/news.json');
    
    // Return news data as JSON
    echo json_encode($news);
    
} catch (Exception $e) {
    // Return error if something goes wrong
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to fetch news',
        'message' => $e->getMessage()
    ]);
}
?>