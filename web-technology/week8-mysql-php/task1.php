<?php
// -- This file handles student registration: insert + display
require 'db.php';

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name   = trim($_POST['name']);
    $email  = trim($_POST['email']);
    $course = trim($_POST['course']);

    // -- Insert student into DB using prepared statement (prevents SQL injection)
    $stmt = $pdo->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $course]);
    $message = "✅ Student registered successfully!";
}

// -- Fetch all students for display
$students = $pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task 1 - Student Registration</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background: #f4f4f4; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 400px; }
        input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #4CAF50; color: white; }
        .msg { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Student Registration</h2>

    <!-- Registration Form -->
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required placeholder="Enter full name">

        <label>Email:</label>
        <input type="email" name="email" required placeholder="Enter email">

        <label>Course:</label>
        <input type="text" name="course" required placeholder="e.g. BSc IT">

        <button type="submit">Register</button>
    </form>

    <!-- Success message -->
    <?php if ($message): ?>
        <p class="msg"><?= $message ?></p>
    <?php endif; ?>

    <!-- Display all students -->
    <h3>Registered Students</h3>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Course</th>
        </tr>
        <?php foreach ($students as $s): ?>
        <tr>
            <td><?= $s['id'] ?></td>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= htmlspecialchars($s['course']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>