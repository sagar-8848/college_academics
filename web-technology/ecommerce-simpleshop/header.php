<?php
// header.php - Modern Bootstrap Navbar
// session_start() must be called BEFORE including this file
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SimpleShop</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Our custom CSS (loads after Bootstrap so it can override) -->
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
    <div class="container">

      <!-- Brand Logo -->
      <a class="navbar-brand fw-bold fs-4" href="home.php">
        <i class="bi bi-bag-heart-fill text-warning me-2"></i>SimpleShop
      </a>

      <!-- Mobile Hamburger Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav Links -->
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

          <li class="nav-item">
            <a class="nav-link" href="home.php">
              <i class="bi bi-house-fill me-1"></i>Home
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="about.php">
              <i class="bi bi-info-circle-fill me-1"></i>About Us
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="orders.php">
              <i class="bi bi-clock-history me-1"></i>Orders
            </a>
          </li>

          <!-- Cart with badge -->
          <li class="nav-item">
            <a class="nav-link position-relative" href="cart.php">
              <i class="bi bi-cart-fill me-1"></i>Cart
              <?php $cartCount = count($_SESSION['cart'] ?? []); ?>
              <?php if ($cartCount > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                  <?= $cartCount ?>
                </span>
              <?php endif; ?>
            </a>
          </li>

          <!-- User greeting -->
          <li class="nav-item d-flex align-items-center">
            <span class="text-secondary me-2 small">
              <i class="bi bi-person-circle me-1"></i>
              <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>
            </span>
          </li>

          <!-- Logout Button -->
          <li class="nav-item">
            <form method="POST" action="user/logout.php">
              <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
              </button>
            </form>
          </li>

        </ul>
      </div>
    </div>
  </nav>