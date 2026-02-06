<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home', 'about', 'contact', 'dashboard', 'test'];

// Validate page
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

include "views/layout.php";
?>