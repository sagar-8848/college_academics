<?php
// Start session
session_start();

// Require database connection
require 'db.php';

// --- Session check ---
if (!isset($_SESSION['user'])) {
  header("Location: user/auth.php");
  exit;
}

// --- Initialize cart ---
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// --- Delete product from cart ---
if (isset($_POST['delete'])) {
  $index = (int) $_POST['index'];
  if (isset($_SESSION['cart'][$index])) {
    unset($_SESSION['cart'][$index]);
    // Re-index array so keys stay sequential 0,1,2...
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    $_SESSION['flash'] = "Item removed from cart.";
    $_SESSION['flashType'] = "warning";
  }
  header("Location: cart.php");
  exit;
}

// --- Checkout ---
if (isset($_POST['checkout'])) {

  // Empty cart check
  if (empty($_SESSION['cart'])) {
    $_SESSION['flash'] = "Your cart is empty. Add some products first!";
    $_SESSION['flashType'] = "danger";
    header("Location: cart.php");
    exit;
  }

  try {
    // Begin transaction — all or nothing
    $pdo->beginTransaction();

    // --- Step 1: Re-check stock for every item before proceeding ---
    foreach ($_SESSION['cart'] as $item) {
      $stmt = $pdo->prepare("SELECT stock, name FROM products WHERE product_id = ?");
      $stmt->execute([$item['product_id']]);
      $product = $stmt->fetch(PDO::FETCH_ASSOC);

      // If stock is 0 or less, abort the whole transaction
      if (!$product || $product['stock'] <= 0) {
        throw new Exception("'{$product['name']}' is out of stock. Please remove it from your cart.");
      }
    }

    // --- Step 2: Create a new order record ---
    $orderId = uniqid('ORD-');
    $stmt = $pdo->prepare("INSERT INTO orders (order_id, user_id) VALUES (?, ?)");
    $stmt->execute([$orderId, $_SESSION['user']]);

    // --- Step 3: Insert each cart item into order_items ---
    foreach ($_SESSION['cart'] as $item) {
      $quantity = $item['quantity'] ?? 1;

      $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
      $stmt->execute([$orderId, $item['product_id'], $quantity]);

      // --- Step 4: Deduct stock from products table ---
      $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
      $stmt->execute([$quantity, $item['product_id']]);
    }

    // Commit — everything went fine
    $pdo->commit();

    // Clear cart after successful checkout
    $_SESSION['cart'] = [];
    $_SESSION['flash'] = "🎉 Order placed successfully! Thank you for shopping with us.";
    $_SESSION['flashType'] = "success";

  } catch (Exception $e) {
    // Rollback — something went wrong, undo everything
    $pdo->rollBack();
    $_SESSION['flash'] = "Checkout failed: " . $e->getMessage();
    $_SESSION['flashType'] = "danger";
  }

  header("Location: cart.php");
  exit;
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
  $total += $item['price'] * ($item['quantity'] ?? 1);
}

// Include header
require 'header.php';
?>

<main class="container py-5">

  <h2 class="fw-bold mb-4">
    <i class="bi bi-cart-fill me-2 text-warning"></i>Your Cart
    <span class="badge bg-secondary ms-2 fs-6"><?= count($_SESSION['cart']) ?> items</span>
  </h2>

  <!-- ===== FLASH MESSAGE ===== -->
  <?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flashType'] ?? 'info' ?> alert-dismissible fade show" role="alert">
      <i
        class="bi bi-<?= $_SESSION['flashType'] === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?> me-2"></i>
      <?= htmlspecialchars($_SESSION['flash']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['flash'], $_SESSION['flashType']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['cart'])): ?>
    <div class="row g-4">

      <!-- ===== CART ITEMS (left side) ===== -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-0">

            <!-- Inline style guarantees Bootstrap can't override it -->
            <div class="cart-items-scroll"
              style="max-height:380px; overflow-y:scroll; overflow-x:hidden; scroll-behavior:smooth;">

              <?php foreach ($_SESSION['cart'] as $i => $item):
                $quantity = $item['quantity'] ?? 1;
                $subtotal = $item['price'] * $quantity;
                ?>
                <div class="cart-item d-flex align-items-center gap-3 p-3 <?= $i !== 0 ? 'border-top' : '' ?>">

                  <!-- Product Icon -->
                  <div
                    class="cart-item-icon bg-light rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                    <i class="bi bi-bag fs-3 text-warning"></i>
                  </div>

                  <!-- Item Details -->
                  <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($item['category'] ?? '') ?></span>
                    <p class="text-warning fw-bold mb-0 mt-1">
                      $<?= number_format($item['price'], 2) ?>
                      <span class="text-muted fw-normal small"> x <?= $quantity ?></span>
                    </p>
                  </div>

                  <!-- Subtotal + Remove -->
                  <div class="text-end flex-shrink-0">
                    <p class="fw-bold mb-1">$<?= number_format($subtotal, 2) ?></p>
                    <form method="POST" action="cart.php">
                      <input type="hidden" name="index" value="<?= $i ?>">
                      <button type="submit" name="delete" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash3-fill me-1"></i>Remove
                      </button>
                    </form>
                  </div>

                </div>
              <?php endforeach; ?>

            </div><!-- end scroll wrapper -->

          </div>
        </div>

        <!-- Continue Shopping -->
        <a href="home.php" class="btn btn-outline-warning mt-3">
          <i class="bi bi-arrow-left me-1"></i>Continue Shopping
        </a>
      </div>

      <!-- ===== ORDER SUMMARY (right side) ===== -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold mb-4">
              <i class="bi bi-receipt me-2 text-warning"></i>Order Summary
            </h5>

            <!-- Item breakdown -->
            <?php foreach ($_SESSION['cart'] as $item):
              $quantity = $item['quantity'] ?? 1;
              ?>
              <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted"><?= htmlspecialchars($item['name']) ?> x<?= $quantity ?></span>
                <span>$<?= number_format($item['price'] * $quantity, 2) ?></span>
              </div>
            <?php endforeach; ?>

            <hr>

            <!-- Shipping -->
            <div class="d-flex justify-content-between mb-2 small">
              <span class="text-muted">Shipping</span>
              <span class="text-success">FREE</span>
            </div>

            <!-- Total -->
            <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
              <span>Total</span>
              <span class="text-warning">$<?= number_format($total, 2) ?></span>
            </div>

            <!-- Checkout Button -->
            <form method="POST" action="cart.php" class="mt-4">
              <button type="submit" name="checkout" class="btn btn-warning w-100 fw-bold py-2">
                <i class="bi bi-bag-check-fill me-2"></i>Place Order
              </button>
            </form>

            <!-- Security note -->
            <p class="text-center text-muted small mt-3 mb-0">
              <i class="bi bi-shield-lock-fill me-1 text-success"></i>
              Secured checkout with transaction safety
            </p>
          </div>
        </div>
      </div>

    </div>

  <?php else: ?>

    <!-- ===== EMPTY CART ===== -->
    <div class="text-center py-5">
      <i class="bi bi-cart-x display-1 text-muted"></i>
      <h4 class="mt-4 fw-bold">Your cart is empty!</h4>
      <p class="text-muted">Looks like you haven't added anything yet.</p>
      <a href="home.php" class="btn btn-warning px-5 mt-2 fw-semibold">
        <i class="bi bi-shop me-2"></i>Start Shopping
      </a>
    </div>

  <?php endif; ?>

</main>

<?php require 'footer.php'; ?>