/* ============================
       SUBMIT FORM (AJAX)
    ============================ */
async function submitForm(e) {
    e.preventDefault();

    const studentName = document.getElementById("studentSearch").value.trim();
    const referenceNo = document.getElementById("referenceNo").value.trim();
    const issuedDate = document.getElementById("issuedDate").value;
    const returnDate = document.getElementById("returnDate").value;
    const formType = document.getElementById("form_type_input").value;

    const checkedSerials = Array.from(
        document.querySelectorAll(".serial-checkbox:checked")
    ).map((cb) => cb.dataset.serial);

    if (!studentName || !referenceNo || !issuedDate || !checkedSerials.length) {
        return alert(
            "Please fill all required fields and select at least one serial."
        );
    }

    const refCheck = document.getElementById("refCheck");
    if (refCheck.style.display !== "none")
        return alert("Reference number already exists.");

    const payload = {
        student_name: studentName,
        selected_serials: checkedSerials,
        form_type: formType,
        issued_date: issuedDate,
        return_date: returnDate,
        reference_no: referenceNo,
    };

    try {
        const res = await fetch("/issued/store", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
            },
            body: JSON.stringify(payload),
        });

        const json = await res.json();

        if (!json.success) {
            return alert(json.message || "Failed to save form");
        }

        alert("Form saved successfully!");
        closeAddFormModal();
        window.location.reload();
    } catch (err) {
        console.error(err);
        alert("Unexpected error saving form: " + err.message);
    }
}
