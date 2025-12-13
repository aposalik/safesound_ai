<?php
session_start();
echo "<h3>Debug Info:</h3>";
echo "Session Data:<br>";
print_r($_SESSION);
echo "<br><br>";
echo "GET Data:<br>";
print_r($_GET);
echo "<br><br>";
echo "Current Page: " . ($_GET['page'] ?? 'none');
echo "<br><br>";
echo "User logged in: " . (isset($_SESSION['user_id']) ? 'YES' : 'NO');
?>