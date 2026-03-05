<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "rsk56_rsk56_3";
$pass = "654321#";
$db = "rsk56_rsk56_3";

try {
    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
    // Self-healing: Ensure news table has modern schema
    $check_news = mysqli_query($conn, "SHOW TABLES LIKE 'news'");
    if (mysqli_num_rows($check_news) > 0) {
        // Fix missing views
        $check_v = mysqli_query($conn, "SHOW COLUMNS FROM news LIKE 'views'");
        if (mysqli_num_rows($check_v) == 0) mysqli_query($conn, "ALTER TABLE news ADD COLUMN views INT DEFAULT 0");
        
        // Upgrade lengths to TEXT for long URLs/headlines
        mysqli_query($conn, "ALTER TABLE news MODIFY COLUMN image_url TEXT");
        mysqli_query($conn, "ALTER TABLE news MODIFY COLUMN title TEXT");
        mysqli_query($conn, "ALTER TABLE news MODIFY COLUMN short_description TEXT");
    }

} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

