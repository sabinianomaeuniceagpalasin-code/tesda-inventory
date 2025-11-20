/* ============================
       REFERENCE QUICK CHECK
    ============================ */
const referenceNo = document.getElementById("referenceNo");
const refCheck = document.getElementById("refCheck");
let refTimer = null;
referenceNo.addEventListener("input", function () {
    if (refTimer) clearTimeout(refTimer);
    const ref = this.value.trim();
    refCheck.style.display = "none";
    if (!ref) return;

    refTimer = setTimeout(async () => {
        try {
            const res = await fetch(
                `/issued/check-ref/${encodeURIComponent(ref)}`
            );
            const data = await res.json();
            refCheck.style.display = data.exists ? "block" : "none";
        } catch (err) {
            console.error(err);
        }
    }, 300);
});
