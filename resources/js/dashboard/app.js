// const sidebar = document.getElementById("sidebar");
// const content = document.getElementById("content");
// const toggleBtn = document.getElementById("toggleSidebar");
//
// toggleBtn.addEventListener("click", () => {
//     sidebar.classList.toggle("collapsed");
//     content.classList.toggle("expanded");
// });

const sidebar = document.getElementById("sidebar");
const content = document.getElementById("content");
const toggleBtn = document.getElementById("toggleSidebar");
const overlay = document.getElementById("sidebarOverlay");

toggleBtn.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
        // MOBILE
        sidebar.classList.toggle("show");
        overlay.classList.toggle("show");
    } else {
        // DESKTOP
        sidebar.classList.toggle("collapsed");
        content.classList.toggle("expanded");
    }
});

overlay.addEventListener("click", () => {
    sidebar.classList.remove("show");
    overlay.classList.remove("show");
});
