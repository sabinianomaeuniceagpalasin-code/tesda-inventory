/* ============================
       INVENTORY SEARCH
    ============================ */
document
    .getElementById("inventorySearchInput")
    .addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();

        document.querySelectorAll("#inventoryTable tbody tr").forEach((row) => {
            const col0 = row.cells[0].textContent.toLowerCase(); 
            const col1 = row.cells[1].textContent.toLowerCase(); 

            const match = col0.includes(filter) || col1.includes(filter);

            row.style.display = match ? "" : "none";
        });
    });
