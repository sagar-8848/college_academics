document.addEventListener("DOMContentLoaded", () => {
  // ===== SWIPER BANNER =====
  const swiperEl = document.querySelector(".swiper");
  if (swiperEl) {
    new Swiper(".swiper", {
      loop: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }

  // ===== AUTO DISMISS FLASH ALERTS =====
  setTimeout(() => {
    document.querySelectorAll(".alert").forEach((el) => {
      el.classList.remove("show");
      setTimeout(() => el.remove(), 300);
    });
  }, 4000);

  // ===== COUNTDOWN TIMERS =====
  const timers = document.querySelectorAll(".countdown-timer");

  if (timers.length > 0) {
    // Track elapsed seconds since page loaded
    let elapsed = 0;

    runTimers();
    setInterval(() => {
      elapsed++;
      runTimers();
    }, 1000);

    function runTimers() {
      timers.forEach(function (timer) {
        // Use MySQL now from data-now attribute + elapsed seconds
        const mysqlNow = parseInt(timer.getAttribute("data-now"), 10);
        const deliverAt = parseInt(timer.getAttribute("data-delivery"), 10);

        // Current time = MySQL time when page loaded + seconds elapsed since
        const currentNow = mysqlNow + elapsed;
        const left = deliverAt - currentNow;

        if (!deliverAt || isNaN(left) || left <= 0) {
          timer.innerHTML =
            '<div class="text-center py-1"><i class="bi bi-check-circle-fill text-success fs-2 d-block mb-1"></i><p class="fw-bold text-success mb-0 small">Delivered!</p></div>';
          return;
        }

        const d = Math.floor(left / 86400);
        const h = Math.floor((left % 86400) / 3600);
        const m = Math.floor((left % 3600) / 60);
        const s = left % 60;
        const pad = (n) => String(n).padStart(2, "0");

        timer.querySelector(".timer-days").textContent = pad(d);
        timer.querySelector(".timer-hours").textContent = pad(h);
        timer.querySelector(".timer-minutes").textContent = pad(m);
        timer.querySelector(".timer-seconds").textContent = pad(s);
      });
    }
  }
});
