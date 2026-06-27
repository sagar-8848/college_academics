<?php
// Start session
session_start();

require 'db.php';

// --- Session check ---
if (!isset($_SESSION['user'])) {
  header("Location: user/auth.php");
  exit;
}

// --- Fetch all orders for logged in user ---
// Get delivery_unix from MySQL directly to avoid PHP timezone issues
$stmt = $pdo->prepare("
    SELECT 
      o.order_id,
      o.order_date,
      UNIX_TIMESTAMP(DATE_ADD(o.order_date, INTERVAL 3 DAY)) AS delivery_unix,
      p.name        AS product_name,
      p.price       AS product_price,
      p.category    AS product_category,
      p.image       AS product_image,
      oi.quantity
    FROM orders o
    JOIN order_items oi ON o.order_id    = oi.order_id
    JOIN products    p  ON oi.product_id = p.product_id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
  ");
$stmt->execute([$_SESSION['user']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Get MySQL current time ONCE — same timezone as delivery_unix ---
$nowStmt = $pdo->query("SELECT UNIX_TIMESTAMP() AS now_unix");
$nowRow = $nowStmt->fetch(PDO::FETCH_ASSOC);
$mysqlNow = $nowRow['now_unix'];

// --- Group rows by order_id ---
$orders = [];
foreach ($rows as $row) {
  $id = $row['order_id'];
  if (!isset($orders[$id])) {
    $orders[$id] = [
      'order_id' => $id,
      'order_date' => $row['order_date'],
      'delivery_unix' => $row['delivery_unix'],
      'items' => []
    ];
  }
  $orders[$id]['items'][] = [
    'name' => $row['product_name'],
    'price' => $row['product_price'],
    'category' => $row['product_category'],
    'image' => $row['product_image'],
    'quantity' => $row['quantity']
  ];
}

// Include header
require 'header.php';
?>

<main class="container py-5">

  <div class="d-flex align-items-center justify-content-between mb-4">
    <h2 class="fw-bold mb-0">
      <i class="bi bi-clock-history me-2 text-warning"></i>My Orders
      <span class="badge bg-secondary ms-2 fs-6"><?= count($orders) ?></span>
    </h2>
    <a href="home.php" class="btn btn-outline-warning">
      <i class="bi bi-shop me-1"></i>Continue Shopping
    </a>
  </div>

  <?php if (!empty($orders)): ?>

    <?php foreach ($orders as $order):
      // --- Calculate order total ---
      $orderTotal = 0;
      foreach ($order['items'] as $item) {
        $orderTotal += $item['price'] * $item['quantity'];
      }

      // --- Delivery calculation using MySQL unix timestamps only ---
      $deliveryTime = (int) $order['delivery_unix'];
      $now = (int) $mysqlNow;
      $isDelivered = $now >= $deliveryTime;
      ?>

      <!-- ===== ORDER CARD ===== -->
      <div class="card border-0 shadow-sm mb-4 order-card">

        <!-- Order Header -->
        <div class="card-header bg-dark text-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
          <div>
            <span class="text-warning fw-bold me-2">
              <i class="bi bi-receipt me-1"></i><?= htmlspecialchars($order['order_id']) ?>
            </span>
            <span class="text-secondary small">
              <i class="bi bi-calendar3 me-1"></i>
              <?= date('d M Y, h:i A', strtotime($order['order_date'])) ?>
            </span>
          </div>

          <!-- Delivery Status Badge -->
          <?php if ($isDelivered): ?>
            <span class="badge bg-success px-3 py-2 fs-6">
              <i class="bi bi-check-circle-fill me-1"></i>Delivered
            </span>
          <?php else: ?>
            <span class="badge bg-warning text-dark px-3 py-2 fs-6">
              <i class="bi bi-truck me-1"></i>On The Way
            </span>
          <?php endif; ?>
        </div>

        <div class="card-body">
          <div class="row g-4">

            <!-- ===== ORDER ITEMS ===== -->
            <div class="col-lg-8">
              <div class="order-items-scroll"
                style="max-height:260px; overflow-y:auto; overflow-x:hidden; scroll-behavior:smooth;">
                <?php foreach ($order['items'] as $i => $item): ?>
                  <div class="d-flex align-items-center gap-3 <?= $i !== 0 ? 'border-top pt-3 mt-3' : '' ?>">

                    <!-- Product Icon -->
                    <div
                      class="order-item-icon bg-light rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                      <i class="bi bi-bag fs-3 text-warning"></i>
                    </div>

                    <!-- Product Details -->
                    <div class="flex-grow-1">
                      <h6 class="fw-bold mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                      <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge bg-light text-dark border">
                          <?= htmlspecialchars($item['category']) ?>
                        </span>
                        <span class="text-muted small">Qty: <?= $item['quantity'] ?></span>
                      </div>
                    </div>

                    <!-- Item Price -->
                    <div class="text-end flex-shrink-0">
                      <p class="fw-bold text-warning mb-0">
                        $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                      </p>
                      <p class="text-muted small mb-0">
                        $<?= number_format($item['price'], 2) ?> each
                      </p>
                    </div>

                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- ===== ORDER SUMMARY + COUNTDOWN ===== -->
            <div class="col-lg-4">
              <div class="bg-light rounded-3 p-3 h-100">

                <!-- Order Total -->
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Subtotal</span>
                  <span class="small">$<?= number_format($orderTotal, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Shipping</span>
                  <span class="small text-success">FREE</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between fw-bold">
                  <span>Total</span>
                  <span class="text-warning">$<?= number_format($orderTotal, 2) ?></span>
                </div>

                <hr class="my-3">

                <!-- ===== COUNTDOWN TIMER ===== -->
                <?php if ($isDelivered): ?>
                  <div class="text-center py-2">
                    <i class="bi bi-check-circle-fill text-success fs-2 mb-2 d-block"></i>
                    <p class="fw-bold text-success mb-0">Delivered!</p>
                    <p class="text-muted small mb-0">Thank you for shopping 🎉</p>
                  </div>
                <?php else: ?>
                  <div class="text-center">
                    <p class="fw-semibold mb-2 small">
                      <i class="bi bi-truck text-warning me-1"></i>Estimated Delivery In:
                    </p>
                    <!-- delivery_unix from MySQL — JS counts down from this -->
                    <div class="countdown-timer" data-delivery="<?= $deliveryTime ?>" data-now="<?= $now ?>">
                      <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <div class="timer-box">
                          <span class="timer-days fw-bold fs-5 text-warning d-block">00</span>
                          <span class="text-muted" style="font-size:0.65rem;">DAYS</span>
                        </div>
                        <div class="timer-sep fw-bold fs-5 text-warning">:</div>
                        <div class="timer-box">
                          <span class="timer-hours fw-bold fs-5 text-warning d-block">00</span>
                          <span class="text-muted" style="font-size:0.65rem;">HRS</span>
                        </div>
                        <div class="timer-sep fw-bold fs-5 text-warning">:</div>
                        <div class="timer-box">
                          <span class="timer-minutes fw-bold fs-5 text-warning d-block">00</span>
                          <span class="text-muted" style="font-size:0.65rem;">MINS</span>
                        </div>
                        <div class="timer-sep fw-bold fs-5 text-warning">:</div>
                        <div class="timer-box">
                          <span class="timer-seconds fw-bold fs-5 text-warning d-block">00</span>
                          <span class="text-muted" style="font-size:0.65rem;">SECS</span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

              </div>
            </div>

          </div>
        </div>

      </div>

    <?php endforeach; ?>

  <?php else: ?>

    <!-- ===== NO ORDERS STATE ===== -->
    <div class="text-center py-5">
      <i class="bi bi-bag-x display-1 text-muted"></i>
      <h4 class="mt-4 fw-bold">No orders yet!</h4>
      <p class="text-muted">Looks like you haven't placed any orders.</p>
      <a href="home.php" class="btn btn-warning px-5 mt-2 fw-semibold">
        <i class="bi bi-shop me-2"></i>Start Shopping
      </a>
    </div>

  <?php endif; ?>

</main>

<?php require 'footer.php'; ?>