<?php
require_once __DIR__ . '/../../config/config.php'; 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "public/login.php");
    exit();
}
?>
