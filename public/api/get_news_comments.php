<?php
// get_news_comments.php - Web Service to get comments for a news article

header('Content-Type: application/json');
require '../functions.php';

try {
    $newsId = intval($_GET['news_id'] ?? 0);
    
    if (!$newsId) {
        echo json_encode([]);
        exit;
    }
    
    // Read all comments
    $allComments = read_json('../../data/news_comments.json');
    
    // Filter comments by news_id
    $newsComments = array_filter($allComments, function($comment) use ($newsId) {
        return $comment['news_id'] === $newsId;
    });
    
    // Sort by date (newest first)
    usort($newsComments, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    
    echo json_encode(array_values($newsComments));
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to fetch comments',
        'message' => $e->getMessage()
    ]);
}
?>