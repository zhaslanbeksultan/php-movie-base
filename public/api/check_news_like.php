<?php
// check_news_like.php - Check if user has liked a news article
header('Content-Type: application/json');
require '../functions.php';

try {
    $newsId = intval($_GET['news_id'] ?? 0);
    
    if (!$newsId) {
        echo json_encode(['is_liked' => false]);
        exit;
    }
    
    // Read from news.json directly to get is_liked status
    $newsData = read_json('../../data/news.json');
    $isLiked = false;
    
    foreach ($newsData as $news) {
        if ($news['id'] === $newsId) {
            $isLiked = isset($news['is_liked']) ? $news['is_liked'] : false;
            break;
        }
    }
    
    // Fallback to favorites.json if is_liked not found in news.json
    if (!$isLiked) {
        $favorites = read_json('../../data/favorites.json');
        $newsIdStr = (string)$newsId;
        $isLiked = isset($favorites['news_likes'][$newsIdStr]) && $favorites['news_likes'][$newsIdStr];
    }
    
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