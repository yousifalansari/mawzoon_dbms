<?php
session_start();

// 🔒 Prevent caching (VERY IMPORTANT)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// 🚫 If not logged in → redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: /mawzoon_frontend/");
    exit();
}
?>

<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>