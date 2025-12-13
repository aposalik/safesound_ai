<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

$page = $_GET['page'] ?? 'home';
$public_pages = ['home', 'about', 'contact', 'login', 'signup'];
$auth_pages = ['dashboard', 'logout'];

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);

// Handle logout
if ($page === 'logout') {
    session_destroy();
    header('Location: ?page=home');
    exit;
}

// Redirect to login if accessing protected page without authentication
if (in_array($page, $auth_pages) && !$is_logged_in) {
    header('Location: ?page=login');
    exit;
}

// Redirect to dashboard if logged in user tries to access login/signup
if (in_array($page, ['login', 'signup']) && $is_logged_in) {
    header('Location: ?page=dashboard');
    exit;
}

// Validate page
if (!in_array($page, array_merge($public_pages, $auth_pages))) {
    $page = 'home';
}

include "views/layout.php";
?>