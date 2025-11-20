/* ============================
       AUTO-FILL PROPERTY NUMBER
    ============================ */
document
    .getElementById("property_no")
    .addEventListener("blur", async function () {
        const propertyNo = this.value.trim();
        if (!propertyNo) return;

        try {
            const res = await fetch(
                `/check-property-no/${encodeURIComponent(propertyNo)}`
            );
            const data = await res.json();

            if (data.exists) {
                document.getElementById("tool_name").value =
                    data.data.tool_name;
                document.getElementById("classification").value =
                    data.data.classification;
                document.getElementById("source_of_fund").value =
                    data.data.source_of_fund;
                document.getElementById("date_acquired").value =
                    data.data.date_acquired;
            } else {
                document.getElementById("tool_name").value = "";
                document.getElementById("classification").value = "";
                document.getElementById("source_of_fund").value = "";
                document.getElementById("date_acquired").value = "";
            }
        } catch (err) {
            console.error(err);
        }
    });
