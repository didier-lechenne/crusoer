// Initialize basicLightbox
document.addEventListener("DOMContentLoaded", function () {
  // Select all links with data-lightbox attribute
  const lightboxLinks = document.querySelectorAll(
    '[data-lightbox="imagenote"]'
  );

  lightboxLinks.forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      // Get the image
      const img = this.querySelector("img");
      const imgSrc = this.href;
      const imgAlt = img ? img.alt : "";

      // Get the figcaption - <figure> standard ou conteneur .imagenote
      const container =
        this.closest("figure, .imagenote") || this.parentElement;
      const figcaption = container
        ? container.querySelector("figcaption, .figcaption")
        : null;
      const caption = figcaption ? figcaption.innerHTML : "";

      // Create lightbox content
      let content = `<figure><img src="${imgSrc}" alt="${imgAlt}">`;
      if (caption) {
        content += `<figcaption>${caption}</figcaption>`;
      }
      content += `</figure>`;

      // Create and show lightbox
      const instance = basicLightbox.create(content);
      instance.show();
    });
  });

  // PDF lightbox - ouvre le PDF natif du navigateur dans une iframe
  document.querySelectorAll('[data-lightbox="pdf"]').forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const pdfSrc = this.href;
      const container = this.closest(".pdfnote") || this.parentElement;
      const figcaption = container
        ? container.querySelector(".figcaption")
        : null;
      const caption = figcaption ? figcaption.innerHTML : "";
      let content = `<figure class="lightbox-pdf"><iframe src="${pdfSrc}"></iframe>`;
      if (caption) content += `<figcaption>${caption}</figcaption>`;
      content += `</figure>`;
      basicLightbox
        .create(content, { className: "basicLightbox--iframe" })
        .show();
    });
  });
});

// Tabs : ouvre l'onglet correspondant au hash de l'URL au chargement
document.addEventListener("DOMContentLoaded", function () {
  var hash = window.location.hash;
  if (hash === "#tab-secondaire") {
    var input = document.getElementById("tab-secondaire");
    if (input) input.checked = true;
  } else if (hash === "#tab-principal") {
    var input = document.getElementById("tab-principal");
    if (input) input.checked = true;
  }
});

// Tabs : scroll vers #tab-panels au clic sur un label
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll("label.tabset-contenu").forEach(function (label) {
    label.addEventListener("click", function () {
      var panels = document.querySelector("#tab-panels");
      var allTab = document.querySelector(".all-tab");
      var header = document.querySelector(".header");
      if (panels) {
        var headerHeight = header ? header.offsetHeight : 0;
        var allTabHeight = allTab ? allTab.offsetHeight : 0;
        var allTabMargin = allTab ? parseFloat(getComputedStyle(allTab).marginBottom) || 0 : 0;
        var offset = headerHeight + allTabHeight + allTabMargin;
        var top = panels.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top: top, behavior: "smooth" });
      }
    });
  });
});

// Video lazy load facade
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".video-facade").forEach(function (facade) {
    facade.addEventListener("click", function () {
      const type = this.dataset.type;
      const figure = this.closest("figure");

      if (type === "external") {
        const src = this.dataset.src;
        const iframe = document.createElement("iframe");
        iframe.src = src;
        iframe.allow = "autoplay; fullscreen";
        iframe.allowFullscreen = true;
        this.replaceWith(iframe);
      } else {
        const player = figure.querySelector(".video-player");
        const video = player ? player.querySelector("video") : null;
        this.remove();
        if (player) player.removeAttribute("hidden");
        if (video) video.play();
      }
    });
  });
});

// Theme toggle : dark ↔ light
(function () {
  var html = document.documentElement;

  var icons = { dark: "☽", light: "☀" };
  var labels = { dark: "Mode sombre", light: "Mode clair" };
  var cycle = { dark: "light", light: "dark" };

  function getState() {
    var saved = localStorage.getItem("theme");
    if (saved === "dark" || saved === "light") return saved;
    return "light";
  }

  function applyState(state) {
    html.setAttribute("data-theme", state);
    localStorage.setItem("theme", state);
    var btn = document.querySelector(".theme-toggle");
    if (btn) {
      btn.textContent = icons[state];
      btn.setAttribute("aria-label", labels[state]);
      btn.setAttribute("title", labels[state]);
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    var btn = document.querySelector(".theme-toggle");
    if (!btn) return;
    applyState(getState());
    btn.addEventListener("click", function () {
      applyState(cycle[getState()]);
    });
  });
})();

document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector(".header");
  if (!header) return;

  let lastY = window.scrollY;
  let ticking = false;

  function updateHeaderVisibility() {
    const currentY = window.scrollY;
    const delta = currentY - lastY;

    if (currentY <= 10) {
      header.classList.remove("is-hidden");
    } else if (delta > 5) {
      header.classList.add("is-hidden");
    } else if (delta < -5) {
      header.classList.remove("is-hidden");
    }

    lastY = currentY;
    ticking = false;
  }

  window.addEventListener(
    "scroll",
    function () {
      if (!ticking) {
        window.requestAnimationFrame(updateHeaderVisibility);
        ticking = true;
      }
    },
    { passive: true }
  );
});
