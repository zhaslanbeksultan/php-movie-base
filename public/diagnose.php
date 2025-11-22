<?php
/**
 * diagnose.php - Diagnostic script for file permissions and write access
 * Place in includes/ folder and access via browser
 */

require 'functions.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>System Diagnostics</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1a1a1a; color: #fff; }
        .success { color: #00ff00; }
        .error { color: #ff0000; }
        .warning { color: #ffcc00; }
        .section { margin: 20px 0; padding: 15px; background: #2a2a2a; border-radius: 8px; }
        h2 { color: #ffcc00; border-bottom: 2px solid #333; padding-bottom: 10px; }
        pre { background: #0f0f0f; padding: 10px; border-radius: 4px; overflow-x: auto; }
        .test-btn { background: #ffcc00; color: #000; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin: 10px 5px; }
    </style>
</head>
<body>
    <h1>🔍 System Diagnostics</h1>

<?php
// Test 1: Check if files exist
echo "<div class='section'>";
echo "<h2>📁 File Existence Check</h2>";

$files = [
    '../data/news.json',
    '../data/favorites.json',
    'like_news_service.php',
    'check_news_like.php'
];

foreach ($files as $file) {
    $exists = file_exists($file);
    $class = $exists ? 'success' : 'error';
    $status = $exists ? '✓ EXISTS' : '✗ NOT FOUND';
    echo "<div class='{$class}'>{$status}: {$file}</div>";
}
echo "</div>";

// Test 2: Check file permissions
echo "<div class='section'>";
echo "<h2>🔒 File Permissions</h2>";

foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = get_file_permissions($file);
        $writable = is_writable($file);
        $class = $writable ? 'success' : 'error';
        $status = $writable ? '✓ WRITABLE' : '✗ NOT WRITABLE';
        echo "<div class='{$class}'>{$status}: {$file} (Permissions: {$perms})</div>";
    }
}

// Check directory permissions
$dataDir = '../data';
if (is_dir($dataDir)) {
    $perms = get_file_permissions($dataDir);
    $writable = is_writable($dataDir);
    $class = $writable ? 'success' : 'error';
    $status = $writable ? '✓ WRITABLE' : '✗ NOT WRITABLE';
    echo "<div class='{$class}'>{$status}: {$dataDir}/ directory (Permissions: {$perms})</div>";
}
echo "</div>";

// Test 3: Read current data
echo "<div class='section'>";
echo "<h2>📄 Current Data</h2>";

try {
    $newsData = read_json('../data/news.json');
    echo "<div class='success'>✓ Successfully read news.json</div>";
    echo "<pre>" . json_encode($newsData, JSON_PRETTY_PRINT) . "</pre>";
} catch (Exception $e) {
    echo "<div class='error'>✗ Error reading news.json: " . $e->getMessage() . "</div>";
}

try {
    $favorites = read_json('../data/favorites.json');
    echo "<div class='success'>✓ Successfully read favorites.json</div>";
    echo "<pre>" . json_encode($favorites, JSON_PRETTY_PRINT) . "</pre>";
} catch (Exception $e) {
    echo "<div class='error'>✗ Error reading favorites.json: " . $e->getMessage() . "</div>";
}
echo "</div>";

// Test 4: Write test
echo "<div class='section'>";
echo "<h2>✍️ Write Test</h2>";

if (isset($_GET['test_write'])) {
    try {
        // Backup current data
        $newsData = read_json('../data/news.json');
        
        // Try to write
        $result = write_json('../data/news.json', $newsData);
        
        if ($result) {
            echo "<div class='success'>✓ Successfully wrote to news.json</div>";
        } else {
            echo "<div class='error'>✗ Write returned false</div>";
        }
    } catch (Exception $e) {
        echo "<div class='error'>✗ Write test failed: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<a href='?test_write=1'><button class='test-btn'>Run Write Test</button></a>";
    echo "<div class='warning'>⚠ This will test writing to news.json (safe - no data changes)</div>";
}
echo "</div>";

// Test 5: PHP Info
echo "<div class='section'>";
echo "<h2>ℹ️ PHP Information</h2>";
echo "<div>PHP Version: " . phpversion() . "</div>";
echo "<div>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</div>";
echo "<div>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</div>";
echo "<div>Current Script: " . __FILE__ . "</div>";
echo "<div>Current User: " . get_current_user() . "</div>";
echo "</div>";

// Recommendations
echo "<div class='section'>";
echo "<h2>💡 Recommendations</h2>";

$recommendations = [];

// Check if files are writable
if (!is_writable('../data/news.json')) {
    $recommendations[] = "Run: chmod 664 data/news.json";
}
if (!is_writable('../data/favorites.json')) {
    $recommendations[] = "Run: chmod 664 data/favorites.json";
}
if (!is_writable('../data')) {
    $recommendations[] = "Run: chmod 775 data/";
}

if (empty($recommendations)) {
    echo "<div class='success'>✓ All permissions look good!</div>";
} else {
    echo "<div class='warning'>⚠ Please run these commands via SSH:</div>";
    echo "<pre>";
    foreach ($recommendations as $rec) {
        echo $rec . "\n";
    }
    echo "</pre>";
}
echo "</div>";
?>

<div class='section'>
    <h2>🔄 Quick Actions</h2>
    <a href='init_is_liked.php' target='_blank'><button class='test-btn'>Initialize is_liked Field</button></a>
    <a href='?test_write=1'><button class='test-btn'>Test Write Access</button></a>
    <button class='test-btn' onclick='location.reload()'>Refresh Diagnostics</button>
</div>

<div class='section'>
    <p><strong>Note:</strong> After fixing any issues, delete this file for security.</p>
</div>

</body>
</html>