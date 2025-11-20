/* ============================
       MAINTENANCE MODAL
============================ */

// Modal elements
const maintenanceModal = document.getElementById("maintenanceAddModal");
const addBtn = document.getElementById("AddMaintenanceBtn");
const closeBtn = document.getElementById("closeMaintenanceModal");

// Open modal
addBtn.addEventListener("click", () => {
    maintenanceModal.style.display = "flex";
});

// Close modal
closeBtn.addEventListener("click", () => {
    maintenanceModal.style.display = "none";
});

// Close when clicking outside
window.addEventListener("click", (e) => {
    if (e.target === maintenanceModal) {
        maintenanceModal.style.display = "none";
    }
});
