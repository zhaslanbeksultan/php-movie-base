<?php
// add_news_comment.php - Web Service to add a comment to news article

header('Content-Type: application/json');
require '../public/functions.php;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['news_id']) || !isset($input['author']) || !isset($input['text'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }
    
    $newsId = intval($input['news_id']);
    $author = trim($input['author']);
    $text = trim($input['text']);
    
    if (empty($author) || empty($text)) {
        http_response_code(400);
        echo json_encode(['error' => 'Author and text cannot be empty']);
        exit;
    }
    
    // Read existing comments
    $comments = read_json('../data/news_comments.json');
    
    // Create new comment
    $newComment = [
        'id' => empty($comments) ? 1 : max(array_column($comments, 'id')) + 1,
        'news_id' => $newsId,
        'author' => htmlspecialchars($author),
        'text' => htmlspecialchars($text),
        'date' => date('Y-m-d H:i:s')
    ];
    
    // Add to comments array
    $comments[] = $newComment;
    
    // Save to file
    write_json('../data/news_comments.json', $comments);
    
    echo json_encode([
        'success' => true,
        'message' => 'Comment added successfully',
        'comment' => $newComment
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to add comment',
        'message' => $e->getMessage()
    ]);
}
?>