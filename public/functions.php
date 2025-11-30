<?php
function read_json($filepath) {
    if (!file_exists($filepath)) {
        throw new Exception("File not found: {$filepath}");
    }
    
    $content = file_get_contents($filepath);
    
    if ($content === false) {
        throw new Exception("Failed to read file: {$filepath}");
    }
    
    $data = json_decode($content, true);
    
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON decode error in {$filepath}: " . json_last_error_msg());
    }
    
    return $data;
}

function write_json($filepath, $data) {
    // Encode with pretty print for readability
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    
    if ($json === false) {
        throw new Exception("JSON encode error: " . json_last_error_msg());
    }
    
    // Write to file
    $result = file_put_contents($filepath, $json);
    
    if ($result === false) {
        throw new Exception("Failed to write to file: {$filepath}. Check permissions!");
    }
    
    // Verify the write was successful
    if (!file_exists($filepath)) {
        throw new Exception("File was not created: {$filepath}");
    }
    
    return true;
}

function get_movie_by_id($movies, $id) {
    foreach ($movies as $movie) {
        if ($movie['id'] == $id) return $movie;
    }
    return null;
}

function get_reviews_by_movie($reviews, $movie_id) {
    return array_filter($reviews, fn($r) => $r['movie_id'] == $movie_id);
}
?>
