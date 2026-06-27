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

// --- Add product to cart ---
if (isset($_POST['add'])) {
  $id = (int) $_POST['product_id'];

  // Fetch product from DB
  $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->execute([$id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row && $row['stock'] > 0) {
    $_SESSION['cart'][] = [
      "product_id" => $row['product_id'],
      "name" => $row['name'],
      "price" => $row['price'],
      "stock" => $row['stock'],
      "category" => $row['category']
    ];
    $_SESSION['flash'] = "Product added to cart successfully!";
    $_SESSION['flashType'] = "success";
  } else {
    $_SESSION['flash'] = "Sorry, this product is out of stock!";
    $_SESSION['flashType'] = "danger";
  }

  header("Location: home.php");
  exit;
}

// --- Category Filter ---
// Get selected category from dropdown (default: empty = all)
$category = $_GET['category'] ?? '';

// --- Price Sort ---
// Get selected sort from dropdown (default: empty = none)
$sort = $_GET['sort'] ?? '';

// --- Build dynamic SQL query ---
$sql = "SELECT * FROM products";
$params = [];

// Add WHERE clause if category is selected
if (!empty($category)) {
  $sql .= " WHERE category = ?";
  $params[] = $category;
}

// Add ORDER BY clause if sort is selected
if ($sort === 'asc') {
  $sql .= " ORDER BY price ASC";
} elseif ($sort === 'desc') {
  $sql .= " ORDER BY price DESC";
}

// Execute the query
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include header (opens <html>, <head>, <body>, <nav>)
require 'header.php';
?>

<main class="container-fluid px-4 py-4">

  <!-- ===== BANNER SLIDER ===== -->
  <!-- ===== BANNER SLIDER ===== -->
  <div class="swiper-container mb-5">
    <div class="swiper rounded-3 overflow-hidden shadow">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="images/banner1.jpg" alt="Banner 1">
        </div>
        <div class="swiper-slide">
          <img src="images/banner2.jpg" alt="Banner 2">
        </div>
        <div class="swiper-slide">
          <img src="images/banner3.jpg" alt="Banner 3">
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>

  <!-- ===== FLASH MESSAGE ===== -->
  <?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flashType'] ?? 'info' ?> alert-dismissible fade show" role="alert">
      <i
        class="bi bi-<?= ($_SESSION['flashType'] === 'success') ? 'check-circle-fill' : 'exclamation-triangle-fill' ?> me-2"></i>
      <?= htmlspecialchars($_SESSION['flash']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['flash'], $_SESSION['flashType']); ?>
  <?php endif; ?>

  <!-- ===== FILTER + SORT BAR ===== -->
  <div class="card shadow-sm mb-4 border-0 bg-light">
    <div class="card-body">
      <form method="GET" action="home.php" class="row g-3 align-items-end">

        <!-- Category Filter -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">
            <i class="bi bi-funnel-fill me-1 text-warning"></i>Filter by Category
          </label>
          <select name="category" class="form-select">
            <option value="">All Categories</option>
            <option value="Top" <?= $category === 'Top' ? 'selected' : '' ?>>👕 Tops</option>
            <option value="Bottom" <?= $category === 'Bottom' ? 'selected' : '' ?>>👖 Bottoms</option>
            <option value="Shoe" <?= $category === 'Shoe' ? 'selected' : '' ?>>👟 Shoes</option>
            <option value="Accessories" <?= $category === 'Accessories' ? 'selected' : '' ?>>👜 Accessories</option>
          </select>
        </div>

        <!-- Price Sort -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">
            <i class="bi bi-sort-numeric-down me-1 text-warning"></i>Sort by Price
          </label>
          <select name="sort" class="form-select">
            <option value="">Default</option>
            <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>💲 Price: Low to High</option>
            <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>💲 Price: High to Low</option>
          </select>
        </div>

        <!-- Buttons -->
        <div class="col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-warning fw-semibold w-100">
            <i class="bi bi-search me-1"></i>Apply
          </button>
          <a href="home.php" class="btn btn-outline-secondary w-100">
            <i class="bi bi-x-circle me-1"></i>Reset
          </a>
        </div>

      </form>
    </div>
  </div>

  <!-- ===== SECTION HEADING ===== -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
      <i class="bi bi-grid-fill me-2 text-warning"></i>
      <?= empty($category) ? 'All Products' : htmlspecialchars($category) . 's' ?>
      <span class="badge bg-secondary ms-2"><?= count($products) ?> items</span>
    </h5>
  </div>

  <!-- ===== PRODUCT GRID ===== -->
  <?php if (!empty($products)): ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

      <?php foreach ($products as $p): ?>
        <div class="col">
          <div class="card h-100 shadow-sm border-0 product-card">

            <!-- Stock Badge -->
            <?php if ($p['stock'] <= 0): ?>
              <span class="badge bg-danger position-absolute top-0 end-0 m-2">Out of Stock</span>
            <?php elseif ($p['stock'] <= 5): ?>
              <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">Only <?= $p['stock'] ?> left!</span>
            <?php else: ?>
              <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
            <?php endif; ?>

            <!-- Product Image -->
            <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>"
              class="card-img-top product-img">

            <!-- Product Details -->
            <div class="card-body d-flex flex-column">
              <span class="badge bg-light text-dark border mb-2 align-self-start">
                <?= htmlspecialchars($p['category']) ?>
              </span>
              <h6 class="card-title fw-bold"><?= htmlspecialchars($p['name']) ?></h6>
              <p class="text-warning fw-bold fs-5 mb-3">$<?= number_format($p['price'], 2) ?></p>

              <!-- Add to Cart -->
              <form method="POST" action="home.php" class="mt-auto">
                <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                <?php if ($p['stock'] <= 0): ?>
                  <!-- Disabled button for out of stock -->
                  <button type="button" class="btn btn-secondary w-100" disabled>
                    <i class="bi bi-x-circle me-1"></i>Out of Stock
                  </button>
                <?php else: ?>
                  <button type="submit" name="add" class="btn btn-warning w-100 fw-semibold">
                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                  </button>
                <?php endif; ?>
              </form>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

    </div>

  <?php else: ?>
    <!-- No products found -->
    <div class="text-center py-5">
      <i class="bi bi-search display-1 text-muted"></i>
      <h4 class="mt-3 text-muted">No products found</h4>
      <p class="text-secondary">Try resetting the filter</p>
      <a href="home.php" class="btn btn-warning mt-2">
        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Filters
      </a>
    </div>
  <?php endif; ?>

</main>

<?php require 'footer.php'; ?>