<?php
// like_news_service.php - Web Service v2 (POST - Toggle like status)

header('Content-Type: application/json');
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['news_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'News ID is required']);
        exit;
    }
    
    $newsId = intval($input['news_id']);
    
    // Read current favorites data
    $favorites = read_json('../data/favorites.json');
    
    // Initialize news_likes array if not exists
    if (!isset($favorites['news_likes'])) {
        $favorites['news_likes'] = [];
    }
    
    // Convert newsId to string for array key
    $newsIdStr = (string)$newsId;
    
    // Toggle like status
    $isLiked = isset($favorites['news_likes'][$newsIdStr]) && $favorites['news_likes'][$newsIdStr];
    
    if ($isLiked) {
        // Unlike
        $favorites['news_likes'][$newsIdStr] = false;
    } else {
        // Like
        $favorites['news_likes'][$newsIdStr] = true;
    }
    
    // Save updated favorites
    write_json('../data/favorites.json', $favorites);
    
    // Read news data to get current like count
    $newsData = read_json('../data/news.json');
    $newLikes = 0;
    
    foreach ($newsData as &$news) {
        if ($news['id'] === $newsId) {
            if (!$isLiked) {
                $news['likes']++;
            } else {
                $news['likes'] = max(0, $news['likes'] - 1);
            }
            $newLikes = $news['likes'];
            break;
        }
    }
    
    write_json('../data/news.json', $newsData);
    
    echo json_encode([
        'success' => true,
        'is_liked' => !$isLiked,
        'likes' => $newLikes,
        'news_id' => $newsId
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>