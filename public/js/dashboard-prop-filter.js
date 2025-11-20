/* ============================
       PROPERTY FILTER SERIALS
    ============================ */
document
    .getElementById("propertyFilter")
    .addEventListener("input", function () {
        loadAvailableSerials(this.value.trim());
    });
