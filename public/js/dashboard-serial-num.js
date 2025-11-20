/* ============================
       SERIAL NUMBER CHECK
    ============================ */
const serialInput = document.getElementById("serial_no");
if (serialInput) {
    serialInput.addEventListener("blur", async function () {
        const serialNo = this.value.trim();
        if (!serialNo) return;
        try {
            const res = await fetch(
                `/check-serial-no/${encodeURIComponent(serialNo)}`
            );
            const data = await res.json();
            if (data.exists) {
                alert("Serial already exists");
                this.value = "";
                this.focus();
            }
        } catch (err) {
            console.error(err);
        }
    });
}
