/* ============================
   DASHBOARD CHARTS
============================ */

// ======== GENERATE UNIQUE TOOL NAMES ========
const toolNames = [...new Set([...usageLabels, ...issuedLabels])];

// ======== ASSIGN COLORS CONSISTENTLY ========
const colorMap = {};
toolNames.forEach((tool) => {
    const r = Math.floor(Math.random() * 156) + 100;
    const g = Math.floor(Math.random() * 156) + 100;
    const b = Math.floor(Math.random() * 156) + 100;
    colorMap[tool] = `rgb(${r}, ${g}, ${b})`;
});

// ======== USAGE TRENDS BAR CHART ========
const usageColors = usageLabels.map((tool) => colorMap[tool]);

new Chart(document.getElementById("usageChart"), {
    type: "bar",
    data: {
        labels: usageLabels,
        datasets: [
            {
                label: "Total Usage Count",
                data: usageValues,
                backgroundColor: usageColors,
                borderWidth: 1,
            },
        ],
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                suggestedMin: 0,
                suggestedMax: 100,
                ticks: { stepSize: 10 },
            },
        },
    },
});

// ======== ISSUED FREQUENCY PIE CHART ========
const issuedColors = issuedLabels.map((tool) => colorMap[tool]);

new Chart(document.getElementById("issuedChart"), {
    type: "pie",
    data: {
        labels: issuedLabels,
        datasets: [
            {
                data: issuedValues,
                backgroundColor: issuedColors,
                borderColor: "#fff",
                borderWidth: 2,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: "right" },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const total = context.dataset.data.reduce(
                            (a, b) => a + b,
                            0
                        );
                        const value = context.parsed;
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${context.label}: ${value} (${percentage}%)`;
                    },
                },
            },
        },
    },
});
