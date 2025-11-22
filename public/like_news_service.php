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
    
    // Read news data FIRST to get current state
    $newsData = read_json('../data/news.json');
    $currentIsLiked = false;
    $newLikes = 0;
    $found = false;
    
    // Find the news item and get current like status
    foreach ($newsData as $index => &$news) {
        if ($news['id'] === $newsId) {
            $currentIsLiked = isset($news['is_liked']) ? $news['is_liked'] : false;
            $found = true;
            
            // Toggle the like status
            $news['is_liked'] = !$currentIsLiked;
            
            // Update like count
            if ($news['is_liked']) {
                $news['likes']++;
            } else {
                $news['likes'] = max(0, $news['likes'] - 1);
            }
            
            $newLikes = $news['likes'];
            break;
        }
    }
    unset($news); // Break reference
    
    if (!$found) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'News item not found'
        ]);
        exit;
    }
    
    // Save updated news data
    $newsWriteResult = write_json('../data/news.json', $newsData);
    
    if ($newsWriteResult === false) {
        throw new Exception('Failed to write news.json - check file permissions');
    }
    
    // Update favorites.json for consistency
    $favorites = read_json('../data/favorites.json');
    
    if (!isset($favorites['news_likes'])) {
        $favorites['news_likes'] = [];
    }
    
    $newsIdStr = (string)$newsId;
    
    if (!$currentIsLiked) {
        // Was unliked, now liked
        $favorites['news_likes'][$newsIdStr] = true;
    } else {
        // Was liked, now unliked
        unset($favorites['news_likes'][$newsIdStr]);
    }
    
    // Save updated favorites
    $favoritesWriteResult = write_json('../data/favorites.json', $favorites);
    
    if ($favoritesWriteResult === false) {
        throw new Exception('Failed to write favorites.json - check file permissions');
    }
    
    echo json_encode([
        'success' => true,
        'is_liked' => !$currentIsLiked,
        'likes' => $newLikes,
        'news_id' => $newsId,
        'debug' => [
            'previous_state' => $currentIsLiked,
            'new_state' => !$currentIsLiked,
            'files_written' => true
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
?>