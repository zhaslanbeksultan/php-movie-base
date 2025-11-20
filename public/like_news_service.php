<?php
// like_news_service.php - Web Service v2 (POST - Accepts data and updates JSON)

header('Content-Type: application/json');
require 'functions.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get POST data sent via fetch
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['news_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'News ID is required']);
        exit;
    }
    
    $newsId = intval($input['news_id']);
    
    // Read current news data
    $newsData = read_json('../data/news.json');
    
    // Find and update the news item
    $found = false;
    foreach ($newsData as &$news) {
        if ($news['id'] === $newsId) {
            $news['likes']++;
            $found = true;
            $newLikes = $news['likes'];
            break;
        }
    }
    
    if (!$found) {
        http_response_code(404);
        echo json_encode(['error' => 'News not found']);
        exit;
    }
    
    // Save updated data back to JSON
    write_json('../data/news.json', $newsData);
    
    // Return success response with updated like count
    echo json_encode([
        'success' => true,
        'message' => 'News liked successfully',
        'news_id' => $newsId,
        'likes' => $newLikes
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to like news',
        'message' => $e->getMessage()
    ]);
}
?>