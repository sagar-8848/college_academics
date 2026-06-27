<?php
// -- Protected page: only accessible if logged in
session_start();

// -- If not logged in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: task2_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body style="font-family: Arial; padding: 40px;">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>! 👋</h2>
    <p>You are successfully logged in.</p>
    <!-- Logout button -->
    <a href="task2_logout.php">
        <button style="background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">
            Logout
        </button>
    </a>
</body>
</html>