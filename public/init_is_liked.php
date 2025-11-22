<?php
/**
 * init_is_liked.php
 * Run this script ONCE to add is_liked field to all news items
 * Access: http://yourdomain.com/includes/init_is_liked.php
 */

require 'functions.php';

try {
    // Read current news data
    $newsData = read_json('../data/news.json');
    
    // Read favorites to check which news are liked
    $favorites = read_json('../data/favorites.json');
    
    if (!isset($favorites['news_likes'])) {
        $favorites['news_likes'] = [];
    }
    
    // Add is_liked field to each news item
    $updated = 0;
    foreach ($newsData as &$news) {
        $newsIdStr = (string)$news['id'];
        
        // Set is_liked based on favorites.json
        $news['is_liked'] = isset($favorites['news_likes'][$newsIdStr]) && $favorites['news_likes'][$newsIdStr];
        
        $updated++;
    }
    
    // Save updated news data
    write_json('../data/news.json', $newsData);
    
    echo json_encode([
        'success' => true,
        'message' => "Successfully added is_liked field to {$updated} news items",
        'updated_count' => $updated
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>