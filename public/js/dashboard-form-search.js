/* ============================
       FORM RECORDS SEARCH
    ============================ */
document
    .getElementById("formSearchInput")
    .addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();

        document.querySelectorAll(".form-table tbody tr").forEach((row) => {
            const student = row.cells[3].textContent.toLowerCase();
            const reference = row.cells[1].textContent.toLowerCase();

            const match =
                student.includes(filter) || reference.includes(filter);

            row.style.display = match ? "" : "none";
        });
    });
