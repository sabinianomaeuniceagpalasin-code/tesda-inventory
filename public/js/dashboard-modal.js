/* ============================
       MODALS (Add Item & Forms)
    ============================ */
const modals = {
    addItem: document.getElementById("addItemModal"),
    formType: document.getElementById("formTypeModal"),
    addForm: document.getElementById("addFormModal"),
};

document
    .getElementById("addItemBtn")
    .addEventListener("click", () => (modals.addItem.style.display = "flex"));
document
    .getElementById("closeModal")
    .addEventListener("click", () => (modals.addItem.style.display = "none"));

function openFormTypeModal() {
    modals.formType.style.display = "flex";
}
function closeFormTypeModal() {
    modals.formType.style.display = "none";
}
function openAddFormModal(type) {
    document.getElementById("form_type_input").value = type;
    document.getElementById("addFormTitle").textContent = `${type} - New Form`;
    closeFormTypeModal();
    loadAvailableSerials();
    modals.addForm.style.display = "flex";
}
function closeAddFormModal() {
    modals.addForm.style.display = "none";
    document.getElementById("addForm").reset();
    document.getElementById("studentSuggestion").innerHTML = "";
    document.getElementById("serialList").innerHTML = "";
    document.getElementById("refCheck").style.display = "none";
}

// Add Form buttons
document
    .getElementById("chooseIcs")
    .addEventListener("click", () => openAddFormModal("ICS"));
document
    .getElementById("choosePar")
    .addEventListener("click", () => openAddFormModal("PAR"));
document.querySelectorAll(".add-btn").forEach((el) =>
    el.addEventListener("click", (e) => {
        e.preventDefault();
        openFormTypeModal();
    })
);

// Close modals if clicked outside
window.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal-overlay"))
        e.target.style.display = "none";
});

// Open View Modal
function closeViewFormModal() {
    document.getElementById("viewFormModal").style.display = "none";
    document
        .getElementById("viewFormModal")
        .querySelector(".modal-body").innerHTML = "";
}

// Attach click event to all "View" links in the form table
document.querySelectorAll(".form-table tbody tr td a").forEach((link) => {
    if (link.textContent.trim() === "View") {
        link.addEventListener("click", async function (e) {
            e.preventDefault();
            const row = this.closest("tr");
            const referenceNo = row.cells[1].textContent.trim();
            const formType = row.cells[0].textContent.trim();

            try {
                const res = await fetch(
                    `/issued/view/${encodeURIComponent(referenceNo)}`
                );
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const data = await res.json();
                if (data.error) return alert(data.error);

                const grouped = {};
                data.details.forEach((d) => {
                    if (!grouped[d.property_no]) {
                        grouped[d.property_no] = {
                            property_no: d.property_no,
                            tool_name: d.tool_name,
                            quantity: 0,
                            unit_cost: 0,
                            total_cost: 0,
                            serials: [],
                        };
                    }
                    grouped[d.property_no].quantity += 1;
                    grouped[d.property_no].unit_cost = Number(d.unit_cost) || 0;
                    grouped[d.property_no].total_cost +=
                        Number(d.unit_cost) || 0;
                    grouped[d.property_no].serials.push(d.serial_no);
                });

                let html = `
                    <br>
                    <p><strong>Issued To:</strong> <u>${data.issued_to}</u></p>
                    <p><strong>Reference No.:</strong> <u>${data.reference_no}</u></p>
                    <table border="1" cellpadding="5" style="width:100%; margin-top:10px;">
                        <thead>
                            <tr>
                                <th>Property Number</th>
                                <th>Article/Property Name</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                Object.values(grouped).forEach((item) => {
                    html += `<tr>
                        <td>${item.property_no}</td>
                        <td>${item.tool_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit_cost.toFixed(2)}</td>
                        <td>${item.total_cost.toFixed(2)}</td>
                    </tr>`;
                });
                html += `</tbody></table>`;

                html += `
                    <h4 style="margin-top:15px;">Serial Numbers Issued</h4>
                    <table border="1" cellpadding="5" style="width:100%; margin-top:5px;">
                        <thead>
                            <tr>
                                <th>Property Number</th>
                                <th>Serial Number</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                data.details.forEach((d) => {
                    html += `<tr>
                        <td>${d.property_no}</td>
                        <td>${d.serial_no}</td>
                    </tr>`;
                });
                html += `</tbody></table>`;

                html += `
                    <div style="margin-top:30px; font-size:14px; line-height:1.5;">
                        I hereby acknowledge receipt of the above-listed item(s) and accept full responsibility for their proper use, custody, and maintenance.
                        I understand that any loss, damage, or misuse of said property will be my liability and may be subject to appropriate administrative or financial action as per government property regulations.
                    </div>
                `;

                document.getElementById("viewFormModal").dataset.formType =
                    formType;

                document
                    .getElementById("viewFormModal")
                    .querySelector(".modal-body").innerHTML = html;
                document.getElementById("viewFormModal").style.display = "flex";
            } catch (err) {
                console.error(err);
                alert("Failed to load form details: " + err.message);
            }
        });
    }
});

// Close modal if clicked outside
window.addEventListener("click", (e) => {
    if (e.target.id === "viewFormModal") closeViewFormModal();
});
