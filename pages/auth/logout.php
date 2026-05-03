<?php
session_start();

// destroy everything
$_SESSION = [];
session_destroy();

// prevent cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// redirect
header("Location: /mawzoon_frontend/");
exit();
?>