<?php // footer.php - Modern Bootstrap Footer ?>

<!-- ===== FOOTER ===== -->
<footer class="bg-dark text-light pt-5 pb-3 mt-auto">
  <div class="container">
    <div class="row gy-4">

      <!-- Brand Column -->
      <div class="col-md-4">
        <h5 class="fw-bold text-warning mb-3">
          <i class="bi bi-bag-heart-fill me-2"></i>SimpleShop
        </h5>
        <p class="text-secondary small">
          Your one-stop fashion destination for tops, bottoms, shoes, and accessories. Quality products at great prices.
        </p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-secondary fs-5"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-secondary fs-5"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-secondary fs-5"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="text-secondary fs-5"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>

      <!-- Quick Links Column -->
      <div class="col-md-2 offset-md-1">
        <h6 class="fw-bold text-uppercase text-warning mb-3">Quick Links</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="home.php" class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>Home</a></li>
          <li class="mb-2"><a href="about.php" class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>About Us</a></li>
          <li class="mb-2"><a href="orders.php" class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>My Orders</a></li>
          <li class="mb-2"><a href="cart.php" class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>Cart</a></li>
        </ul>
      </div>

      <!-- Categories Column -->
      <div class="col-md-2">
        <h6 class="fw-bold text-uppercase text-warning mb-3">Categories</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="home.php?category=Top" class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>Tops</a></li>
          <li class="mb-2"><a href="home.php?category=Bottom" class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>Bottoms</a></li>
          <li class="mb-2"><a href="home.php?category=Shoe" class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>Shoes</a></li>
          <li class="mb-2"><a href="home.php?category=Accessories"
              class="text-secondary text-decoration-none footer-link"><i
                class="bi bi-chevron-right me-1"></i>Accessories</a></li>
        </ul>
      </div>

      <!-- Contact Column -->
      <div class="col-md-3">
        <h6 class="fw-bold text-uppercase text-warning mb-3">Contact Us</h6>
        <ul class="list-unstyled small text-secondary">
          <li class="mb-2"><i class="bi bi-envelope-fill me-2 text-warning"></i>support@simpleshop.com</li>
          <li class="mb-2"><i class="bi bi-telephone-fill me-2 text-warning"></i>+977-9800000000</li>
          <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-warning"></i>Kathmandu, Nepal</li>
          <li class="mb-2"><i class="bi bi-clock-fill me-2 text-warning"></i>Mon–Sat: 9AM – 6PM</li>
        </ul>
      </div>

    </div>

    <!-- Divider -->
    <hr class="border-secondary mt-4">

    <!-- Bottom Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <p class="text-secondary small mb-0">
        &copy; <?= date('Y') ?> SimpleShop. All rights reserved.
      </p>
      <p class="text-secondary small mb-0">
        Built with <i class="bi bi-heart-fill text-danger"></i> using PHP + MySQL
      </p>
    </div>

  </div>
</footer>

<!-- Bootstrap 5 JS — MUST be first -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Swiper JS — MUST come before script.js -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Custom JS — ALWAYS last -->
<script src="script.js"></script>

</body>

</html>