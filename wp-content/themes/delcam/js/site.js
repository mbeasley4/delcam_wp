document.addEventListener("DOMContentLoaded", function () {
  AOS.init({
    duration: 800,
    once: true,
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".team-card").forEach((card) => {
    card.addEventListener("click", () => {
      const modalId = card.getAttribute("data-modal-id");
      document.getElementById(modalId).classList.add("active");
    });
  });

  document.querySelectorAll("[data-close]").forEach((closeBtn) => {
    closeBtn.addEventListener("click", () => {
      closeBtn.closest(".team-modal").classList.remove("active");
    });
  });

  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      document.querySelectorAll(".team-modal.active").forEach((modal) => {
        modal.classList.remove("active");
      });
    }
  });
});
document.addEventListener("DOMContentLoaded", function() {
    const toggle = document.querySelector(".mobile-menu-toggle");
    const mobileMenu = document.querySelector("#mobile-menu");

    toggle.addEventListener("click", function () {
        const expanded = toggle.getAttribute("aria-expanded") === "true";
        toggle.setAttribute("aria-expanded", !expanded);
        mobileMenu.hidden = expanded;
        document.body.classList.toggle("mobile-menu-open");
    });
});