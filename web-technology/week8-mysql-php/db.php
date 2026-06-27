<?php
// db.php - Reusable DB connection file

$host = "localhost";
$dbname = "week8_assignment";
$user = "root";
$pass = ""; // Leave empty for XAMPP default

// Connect using PDO for security
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
  // Set error mode to exception so we catch DB errors easily
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>