/* ============================
       LOAD AVAILABLE SERIALS
    ============================ */
async function loadAvailableSerials(propertyNo = "") {
    const container = document.getElementById("serialList");
    const formType = document.getElementById("form_type_input").value; // ICS or PAR
    container.innerHTML =
        '<div class="placeholder">Loading available serials...</div>';

    if (!propertyNo) {
        container.innerHTML =
            '<div class="placeholder">Type a Property No. to see available items.</div>';
        return;
    }

    try {
        const res = await fetch(
            `/issued/available-serials?property_no=${encodeURIComponent(
                propertyNo
            )}&form_type=${encodeURIComponent(formType)}`
        );
        const list = await res.json();

        if (!list.length) {
            container.innerHTML =
                '<div class="placeholder">No available items for this property number.</div>';
            return;
        }

        container.innerHTML = list
            .map(
                (item) => `
            <div class="serial-item" onclick="this.querySelector('input').click()">
                <input type="checkbox" class="serial-checkbox" data-serial="${
                    item.serial_no
                }" data-property="${item.property_no}">
                <span>${item.tool_name} ${item.serial_no} (₱${Number(
                    item.unit_cost
                ).toLocaleString()})</span>
            </div>
        `
            )
            .join("");
    } catch (err) {
        console.error(err);
        container.innerHTML = `<div class="placeholder" style="color:red;">Failed to load serials: ${err.message}</div>`;
    }
}
