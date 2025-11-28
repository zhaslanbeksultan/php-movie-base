<?php
// check_news_like.php - Check if user has liked a news article

header('Content-Type: application/json');
require '../public/functions.php';

try {
    $newsId = intval($_GET['news_id'] ?? 0);
    
    if (!$newsId) {
        echo json_encode(['is_liked' => false]);
        exit;
    }
    
    $favorites = read_json('../data/favorites.json');
    $newsIdStr = (string)$newsId;
    
    $isLiked = isset($favorites['news_likes'][$newsIdStr]) && $favorites['news_likes'][$newsIdStr];
    
    echo json_encode([
        'is_liked' => $isLiked,
        'news_id' => $newsId
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'is_liked' => false,
        'error' => $e->getMessage()
    ]);
}
?>