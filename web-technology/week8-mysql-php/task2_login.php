<?php
// -- Login form: checks credentials and starts session
session_start();
require 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // -- Find user by username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // -- Verify hashed password
    if ($user && password_verify($password, $user['password'])) {
        // Store username in session to keep user logged in
        $_SESSION['user'] = $user['username'];
        header("Location: task2_home.php");
        exit;
    } else {
        $error = "❌ Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task 2 - Login</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; padding-top: 80px; background: #f0f0f0; }
        form { background: white; padding: 30px; border-radius: 10px; width: 300px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; background: #2196F3; color: white; padding: 10px; border: none; cursor: pointer; border-radius: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>🔐 Login</h2>
        <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>