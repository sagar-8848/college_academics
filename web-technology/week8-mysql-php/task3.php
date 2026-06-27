<?php
// -- Product inventory: Add products, display them, update stock
require 'db.php';

$message = "";

// -- Handle adding a new product
if (isset($_POST['add'])) {
  $name = trim($_POST['name']);
  $price = $_POST['price'];
  $stock = $_POST['stock'];

  $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
  $stmt->execute([$name, $price, $stock]);
  $message = "✅ Product added!";
}

// -- Handle updating stock quantity
if (isset($_POST['update'])) {
  $id = $_POST['product_id'];
  $newStock = $_POST['new_stock'];

  $stmt = $pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
  $stmt->execute([$newStock, $id]);
  $message = "✅ Stock updated!";
}

// -- Fetch all products
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Task 3 - Product Inventory</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background: #f9f9f9;
    }

    form {
      background: white;
      padding: 20px;
      border-radius: 8px;
      max-width: 420px;
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 8px;
      margin: 6px 0;
      box-sizing: border-box;
    }

    button {
      background: #673AB7;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    th {
      background: #673AB7;
      color: white;
    }

    .low {
      color: red;
      font-weight: bold;
    }

    .msg {
      color: green;
      font-weight: bold;
      margin: 10px 0;
    }
  </style>
</head>

<body>
  <h2>📦 Product Inventory Manager</h2>

  <?php if ($message): ?>
    <p class="msg"><?= $message ?></p>
  <?php endif; ?>

  <!-- Add Product Form -->
  <h3>Add New Product</h3>
  <form method="POST">
    <input type="text" name="name" placeholder="Product name" required>
    <input type="number" step="0.01" name="price" placeholder="Price (e.g. 99.99)" required>
    <input type="number" name="stock" placeholder="Stock quantity" required>
    <button type="submit" name="add">Add Product</button>
  </form>

  <!-- Products Table -->
  <h3>All Products</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Price</th>
      <th>Stock</th>
      <th>Update Stock</th>
    </tr>
    <?php foreach ($products as $p): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td>$<?= number_format($p['price'], 2) ?></td>
        <!-- Show "LOW" warning if stock is below 5 -->
        <td class="<?= $p['stock'] < 5 ? 'low' : '' ?>">
          <?= $p['stock'] ?>   <?= $p['stock'] < 5 ? '⚠️ LOW' : '' ?>
        </td>
        <td>
          <!-- Inline update form for each product -->
          <form method="POST" style="display:flex; gap:8px;">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <input type="number" name="new_stock" placeholder="New qty" style="width:80px;" required>
            <button type="submit" name="update" style="padding: 5px 10px;">Update</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>