/* ============================
       PAGE SWITCHING
    ============================ */
const menuLinks = document.querySelectorAll(".menu a");
const sections = document.querySelectorAll(".content-section");
const pageTitle = document.getElementById("page-title");

menuLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        menuLinks.forEach((l) => l.classList.remove("active"));
        link.classList.add("active");

        sections.forEach((sec) => sec.classList.remove("active"));
        document.getElementById(link.dataset.target).classList.add("active");

        pageTitle.textContent = link.textContent.trim();
    });
});
