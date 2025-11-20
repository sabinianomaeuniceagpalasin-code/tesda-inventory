/* ============================
       AUTO CALCULATE TOTAL
    ============================ */
const qtyInput = document.getElementById("quantity");
const unitInput = document.getElementById("unit_cost");
const totalInput = document.getElementById("total_cost");

function updateTotal() {
    totalInput.value = (
        (parseFloat(qtyInput.value) || 0) * (parseFloat(unitInput.value) || 0)
    ).toFixed(2);
}
qtyInput.addEventListener("input", updateTotal);
unitInput.addEventListener("input", updateTotal);
