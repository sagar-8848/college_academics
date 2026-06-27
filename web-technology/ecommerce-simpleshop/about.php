<?php
// Start session
session_start();

// --- Session check ---
if (!isset($_SESSION['user'])) {
  header("Location: user/auth.php");
  exit;
}

// Include header
require 'header.php';
?>

<main class="container py-5">

  <!-- ===== HERO SECTION ===== -->
  <section class="row align-items-center mb-5 pb-4 border-bottom">
    <div class="col-lg-6 mb-4 mb-lg-0">
      <span class="badge bg-warning text-dark mb-3 px-3 py-2">
        <i class="bi bi-info-circle me-1"></i>About Us
      </span>
      <h1 class="fw-bold display-5 mb-3">
        We Are <span class="text-warning">SimpleShop</span>
      </h1>
      <p class="text-muted lead">
        A modern fashion destination built for students, professionals, and everyday shoppers in Nepal.
        We bring quality clothing and accessories straight to your door — fast, simple, and affordable.
      </p>
      <div class="d-flex gap-3 mt-4">
        <a href="home.php" class="btn btn-warning fw-semibold px-4">
          <i class="bi bi-shop me-2"></i>Shop Now
        </a>
        <a href="orders.php" class="btn btn-outline-secondary px-4">
          <i class="bi bi-clock-history me-2"></i>My Orders
        </a>
      </div>
    </div>
    <div class="col-lg-6 text-center">
      <div class="about-hero-box rounded-4 p-5 bg-dark text-warning">
        <i class="bi bi-bag-heart-fill" style="font-size: 8rem;"></i>
        <h3 class="text-white mt-3 fw-bold">SimpleShop</h3>
        <p class="text-secondary mb-0">Fashion. Quality. Nepal.</p>
      </div>
    </div>
  </section>

  <!-- ===== STATS SECTION ===== -->
  <section class="row text-center mb-5 pb-4 border-bottom g-4">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 py-4">
        <div class="card-body">
          <i class="bi bi-box-seam-fill fs-1 text-warning mb-3"></i>
          <h2 class="fw-bold">16+</h2>
          <p class="text-muted mb-0">Products</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 py-4">
        <div class="card-body">
          <i class="bi bi-people-fill fs-1 text-warning mb-3"></i>
          <h2 class="fw-bold">500+</h2>
          <p class="text-muted mb-0">Happy Customers</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 py-4">
        <div class="card-body">
          <i class="bi bi-grid-fill fs-1 text-warning mb-3"></i>
          <h2 class="fw-bold">4</h2>
          <p class="text-muted mb-0">Categories</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 py-4">
        <div class="card-body">
          <i class="bi bi-truck fs-1 text-warning mb-3"></i>
          <h2 class="fw-bold">FREE</h2>
          <p class="text-muted mb-0">Delivery</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== OUR STORY ===== -->
  <section class="row align-items-center mb-5 pb-4 border-bottom">
    <div class="col-lg-6 mb-4 mb-lg-0">
      <div class="row g-3">
        <div class="col-6">
          <div class="rounded-4 bg-warning d-flex align-items-center justify-content-center" style="height:180px;">
            <i class="bi bi-stars text-dark" style="font-size:5rem;"></i>
          </div>
        </div>
        <div class="col-6">
          <div class="rounded-4 bg-dark d-flex align-items-center justify-content-center" style="height:180px;">
            <i class="bi bi-heart-fill text-warning" style="font-size:5rem;"></i>
          </div>
        </div>
        <div class="col-6">
          <div class="rounded-4 bg-dark d-flex align-items-center justify-content-center" style="height:180px;">
            <i class="bi bi-shield-check text-warning" style="font-size:5rem;"></i>
          </div>
        </div>
        <div class="col-6">
          <div class="rounded-4 bg-warning d-flex align-items-center justify-content-center" style="height:180px;">
            <i class="bi bi-geo-alt-fill text-dark" style="font-size:5rem;"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <span class="badge bg-dark text-warning mb-3 px-3 py-2">
        <i class="bi bi-book me-1"></i>Our Story
      </span>
      <h2 class="fw-bold mb-3">Built in Nepal, <br>For Nepal 🇳🇵</h2>
      <p class="text-muted mb-3">
        SimpleShop was founded with one mission — to make quality fashion accessible
        to everyone in Nepal without the hassle of long shipping times or overpriced imports.
      </p>
      <p class="text-muted mb-3">
        We started small with just a handful of products, but thanks to our loyal customers,
        we now offer over 16 curated items across Tops, Bottoms, Shoes, and Accessories.
      </p>
      <p class="text-muted">
        Every order is processed securely, stock is tracked in real-time, and our
        team is always available to help you find exactly what you're looking for.
      </p>
    </div>
  </section>

  <!-- ===== WHY CHOOSE US ===== -->
  <section class="mb-5 pb-4 border-bottom">
    <div class="text-center mb-5">
      <span class="badge bg-warning text-dark mb-3 px-3 py-2">
        <i class="bi bi-star-fill me-1"></i>Why Choose Us
      </span>
      <h2 class="fw-bold">What Makes Us Different</h2>
      <p class="text-muted">We put our customers first, always.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <article class="card border-0 shadow-sm h-100 text-center p-3">
          <div class="card-body">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
              style="width:64px;height:64px;">
              <i class="bi bi-shield-lock-fill fs-3 text-dark"></i>
            </div>
            <h5 class="fw-bold">Secure Shopping</h5>
            <p class="text-muted small mb-0">
              All transactions are protected with PDO prepared statements,
              password hashing, and session-based authentication.
            </p>
          </div>
        </article>
      </div>

      <div class="col-md-4">
        <article class="card border-0 shadow-sm h-100 text-center p-3">
          <div class="card-body">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
              style="width:64px;height:64px;">
              <i class="bi bi-lightning-charge-fill fs-3 text-dark"></i>
            </div>
            <h5 class="fw-bold">Real-Time Stock</h5>
            <p class="text-muted small mb-0">
              Stock levels update instantly after every order.
              Out-of-stock items are automatically blocked at checkout — no surprises.
            </p>
          </div>
        </article>
      </div>

      <div class="col-md-4">
        <article class="card border-0 shadow-sm h-100 text-center p-3">
          <div class="card-body">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
              style="width:64px;height:64px;">
              <i class="bi bi-truck fs-3 text-dark"></i>
            </div>
            <h5 class="fw-bold">Free Delivery</h5>
            <p class="text-muted small mb-0">
              Every order ships free to your doorstep across Kathmandu and
              surrounding areas. No hidden charges, ever.
            </p>
          </div>
        </article>
      </div>

      <div class="col-md-4">
        <article class="card border-0 shadow-sm h-100 text-center p-3">
          <div class="card-body">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
              style="width:64px;height:64px;">
              <i class="bi bi-grid-fill fs-3 text-dark"></i>
            </div>
            <h5 class="fw-bold">4 Categories</h5>
            <p class="text-muted small mb-0">
              Tops, Bottoms, Shoes, and Accessories — everything you need
              in one place, easily filtered and sorted by price.
            </p>
          </div>
        </article>
      </div>

      <div class="col-md-4">
        <article class="card border-0 shadow-sm h-100 text-center p-3">
          <div class="card-body">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
              style="width:64px;height:64px;">
              <i class="bi bi-person-check-fill fs-3 text-dark"></i>
            </div>
            <h5 class="fw-bold">Verified Accounts</h5>
            <p class="text-muted small mb-0">
              Email verification with a 6-digit code ensures
              only real users can shop. Your account is always safe.
            </p>
          </div>
        </article>
      </div>

      <div class="col-md-4">
        <article class="card border-0 shadow-sm h-100 text-center p-3">
          <div class="card-body">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
              style="width:64px;height:64px;">
              <i class="bi bi-headset fs-3 text-dark"></i>
            </div>
            <h5 class="fw-bold">24/7 Support</h5>
            <p class="text-muted small mb-0">
              Our support team is always ready to help you with
              orders, returns, or anything else you need.
            </p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== CONTACT SECTION ===== -->
  <section class="text-center py-5 rounded-4 bg-dark text-white">
    <i class="bi bi-envelope-heart-fill text-warning" style="font-size:3rem;"></i>
    <h2 class="fw-bold mt-3 mb-2">Get In Touch</h2>
    <p class="text-secondary mb-4">Have a question or feedback? We'd love to hear from you.</p>
    <div class="d-flex justify-content-center flex-wrap gap-4">
      <div>
        <i class="bi bi-envelope-fill text-warning me-2"></i>
        <span class="text-light">support@simpleshop.com</span>
      </div>
      <div>
        <i class="bi bi-telephone-fill text-warning me-2"></i>
        <span class="text-light">+977-9800000000</span>
      </div>
      <div>
        <i class="bi bi-geo-alt-fill text-warning me-2"></i>
        <span class="text-light">Kathmandu, Nepal</span>
      </div>
    </div>
    <a href="home.php" class="btn btn-warning fw-bold px-5 mt-4">
      <i class="bi bi-bag-heart me-2"></i>Start Shopping
    </a>
  </section>

</main>

<?php require 'footer.php'; ?>