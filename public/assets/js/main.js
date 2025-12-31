// Toggle mobile menu
document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".nav-menu");

  if (hamburger) {
    hamburger.addEventListener("click", function () {
      navMenu.style.display =
        navMenu.style.display === "flex" ? "none" : "flex";
    });
  }

  // Close menu when a link is clicked (except dropdown links)
  const navLinks = document.querySelectorAll(".nav-link");
  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      // Jangan tutup menu jika ini adalah dropdown toggle
      if (this.closest(".dropdown")) {
        return;
      }
      if (navMenu.style.display === "flex") {
        navMenu.style.display = "none";
      }
    });
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const href = this.getAttribute("href");
      if (href !== "#") {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          target.scrollIntoView({ behavior: "smooth" });
        }
      }
    });
  });

  // Dropdown toggle dengan click
  const dropdown = document.querySelector(".dropdown");
  if (dropdown) {
    const dropdownToggle = dropdown.querySelector(".nav-link");

    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation(); // Mencegah event bubbling
      dropdown.classList.toggle("active");
    });

    // Tutup dropdown saat klik di luar area
    document.addEventListener("click", function (e) {
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove("active");
      }
    });

    // Jangan tutup dropdown saat klik di dalam dropdown menu
    const dropdownMenu = dropdown.querySelector(".dropdown-menu");
    if (dropdownMenu) {
      dropdownMenu.addEventListener("click", function (e) {
        // Tutup dropdown hanya setelah link diklik (bukan pada menu itu sendiri)
        if (e.target.tagName === "A") {
          dropdown.classList.remove("active");
        }
      });
    }
  }
});
