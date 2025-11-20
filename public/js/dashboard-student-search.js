/* ============================
       STUDENT SEARCH LIVE
    ============================ */
const studentSearch = document.getElementById("studentSearch");
const studentSuggestion = document.getElementById("studentSuggestion");
let studentTimer = null;

studentSearch.addEventListener("keyup", function () {
    const q = this.value.trim();
    studentSuggestion.innerHTML = "";
    if (studentTimer) clearTimeout(studentTimer);
    if (q.length < 1) return;

    studentTimer = setTimeout(async () => {
        try {
            const res = await fetch(
                `/issued/search-students?query=${encodeURIComponent(q)}`
            );
            const data = await res.json();
            if (!data || data.length === 0)
                studentSuggestion.innerHTML = `<div class="no-result">No students found</div>`;
            else {
                studentSuggestion.innerHTML = data
                    .map(
                        (s) =>
                            `<div class="suggest-item" onclick="selectStudent('${s.student_name}')">${s.student_name}</div>`
                    )
                    .join("");
            }
        } catch (err) {
            studentSuggestion.innerHTML = `<div class="no-result">Error loading</div>`;
            console.error(err);
        }
    }, 250);
});

function selectStudent(name) {
    studentSearch.value = name;
    studentSuggestion.innerHTML = "";
}
