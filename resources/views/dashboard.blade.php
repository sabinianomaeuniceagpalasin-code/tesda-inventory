<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>TESDA Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="{{ asset('images/Tesda logo 1.png') }}" alt="TESDA Logo">
      </div>

      <!-- NAVIGATION MENU -->
      <nav class="menu">
        <a href="#" class="active" data-target="dashboard">
          <img src="{{ asset('images/reports.png') }}" alt="Dashboard Icon" class="menu-icon">
          Dashboard
        </a>
        <a href="#" data-target="inventory">
          <img src="{{ asset('images/inventory.png') }}" alt="Inventory Icon" class="menu-icon">
          Inventory
        </a>
        <a href="#" data-target="issued">
          <img src="{{ asset('images/issued.png') }}" alt="Issued Icon" class="menu-icon">
          Issued Item
        </a>
        <a href="#" data-target="form">
          <img src="{{ asset('images/form.png') }}" alt="Form Icon" class="menu-icon">
          Form Records
        </a>
        <a href="#" data-target="maintenance">
          <img src="{{ asset('images/maintenance.png') }}" alt="Reports Icon" class="menu-icon">
          Maintenance
        </a>
      </nav>

      <form method="POST" action="{{ route('logout') }}" class="bottom-menu"> 
        @csrf 
        <button type="submit">Logout</button> 
      </form>
    </aside>

    <!-- Main -->
    <main class="main">
      <header class="topbar">
        <h1 id="page-title">Dashboard</h1>
        <div class="right-section">
          <div class="search-bar">
            <input type="text" placeholder="Search">
            <button>🔍</button>
          </div>
          <div class="icons">
            <span>🔔</span>
            <span>👤</span>
          </div>
        </div>
      </header>

      <section id="content-area">
        <!-- ======================
             DASHBOARD SECTION
        ======================= -->
        <div id="dashboard" class="content-section active">
          <section class="quick-status">
            <div class="status-card">
              <h2>{{ $totalTools }}</h2>
              <p>Total Tools & Equipment</p>
            </div>
            <div class="status-card">
              <h2>{{ $availableItems }}</h2>
              <p>Available Items</p>
            </div>
            <div class="status-card">
              <h2>{{ $issuedItems }}</h2>
              <p>Issued Items</p>
            </div>
            <div class="status-card">
              <h2>{{ $forRepair }}</h2>
              <p>For Repair</p>
            </div>

            <div class="summary-column">
              <div class="summary-item">
                <p>| Low Stock</p><span>{{ $lowStock }}</span>
              </div>
              <div class="summary-item">
                <p>| Missing Items</p><span>{{ $missingItems }}</span>
              </div>
            </div>
          </section>

          <section class="dashboard-layout">
            <div class="top-row">
              <div class="chart-box equal-box">
                <h3>Usage Trends</h3>
                <div class="chart-wrapper">
                  <canvas id="usageChart"></canvas>
                </div>
              </div>

              <div class="table-box equal-box">
                <h3>Tools Schedule for Repair</h3>
                <div class="table-wrapper">
                  <table>
                    <thead>
                      <tr>
                        <th>Tool</th>
                        <th>Issue</th>
                        <th>Status</th>
                        <th>Date Schedule</th>
                        <th>Expected Completion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr><td>Hammer</td><td>Damaged</td><td>Ongoing</td><td>Aug 1, 2025</td><td>Sep 7, 2025</td></tr>
                      <tr><td>Crimping</td><td>Damaged</td><td>Ongoing</td><td>Aug 10, 2025</td><td>Sep 10, 2025</td></tr>
                      <tr><td>Saw</td><td>Damaged</td><td>Pending</td><td>Aug 20, 2025</td><td>Sep 20, 2025</td></tr>
                      <tr><td>Wrench</td><td>For Repair</td><td>Ongoing</td><td>Aug 22, 2025</td><td>Sep 22, 2025</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="bottom-row">
              <div class="table-box equal-box">
                <h3>For Repair, Unserviceable, & Missing Items</h3>
                <div class="table-wrapper">
                  <table>
                    <thead>
                      <tr>
                        <th>Issued To</th>
                        <th>Tool</th>
                        <th>Property No.</th>
                        <th>Item Type</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr><td>Luffy</td><td>Hammer</td><td>001</td><td>ICS</td><td>Missing</td></tr>
                      <tr><td>Zoro</td><td>Crimping</td><td>002</td><td>PPR</td><td>For Repair</td></tr>
                      <tr><td>Sanji</td><td>Saw</td><td>003</td><td>ICS</td><td>For Repair</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="chart-box equal-box">
                <h3>Issued Items Frequency</h3>
                <div class="chart-wrapper">
                  <canvas id="issuedChart"></canvas>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- ======================
            INVENTORY SECTION
        ======================= -->
        <div id="inventory" class="content-section">
          <div class="inventory-summary">
            <div class="summary-box"><p>Total Tools & Equipment</p><h2>{{ $totalTools }}</h2></div>
            <div class="summary-box"><p>Available Items</p><h2>{{ $availableItems }}</h2></div>
            <div class="summary-box"><p>Issued Items</p><h2>{{ $issuedItems }}</h2></div>
            <div class="summary-box"><p>Unserviceable/For Repair</p><h2>{{ $forRepair }}</h2></div>
          </div>

          <div class="inventory-controls">
            <div class="left-buttons">
              <button>Sort by fields</button>
              <button>+ Export</button>
              <button>Clear filters</button>
            </div>
            <div class="right-buttons">
              <input type="text" id="inventorySearchInput" placeholder="Search Item Name...">
              <button id="addItemBtn">+ Add new item</button>
            </div>
          </div>

          <table id="inventoryTable">
            <thead>
              <tr>
                <th>Sources of Fund</th>
                <th>Classification</th>
                <th>Date Acquired</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($inventory as $item)
              <tr>
                <td>{{ $item->source_of_fund }}</td>
                <td>{{ $item->classification }}</td>
                <td>{{ \Carbon\Carbon::parse($item->date_acquired)->format('F d, Y') }}</td>
                <td>{{ $item->tool_name }}</td>
                <td>{{ $item->quantity ?? 0 }}</td>
                <td class="action-buttons">
                  <button class="edit-btn">✏️</button>
                  <button class="delete-btn">🗑️</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <!-- MODAL -->
          <div id="addItemModal" class="modal-overlay">
            <div class="modal-content">
              <span class="close-btn" id="closeModal">&times;</span>
              <h2>Add new item</h2>

              @if(session('success'))
            <div id="successAlert" style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:10px;text-align:center;">
              {{ session('success') }}
            </div>

            <script>
              // Fade out the message after 3 seconds
              setTimeout(() => {
                const alert = document.getElementById('successAlert');
                if (alert) alert.style.display = 'none';
              }, 3000);
            </script>
          @endif

              <form id="addItemForm" method="POST" action="{{ route('inventory.store') }}">
                @csrf
                <div class="form-grid">
                  <div><label>Property No.</label><input type="text" id="property_no" name="property_no" required></div>
                  <div><label>Particular Article / Item Name</label><input type="text" id="tool_name" name="tool_name" required></div>
                  <div><label>Classification</label><input type="text" id="classification" name="classification" required></div>
                  <div><label>Source of Fund</label><input type="text" id="source_of_fund" name="source_of_fund" required></div>
                  <div><label>Date Acquired</label><input type="date" id="date_acquired" name="date_acquired" required></div>
                  <div><label>Quantity</label><input type="number" id="quantity" name="quantity" value="1" min="1" required></div>
                  <div><label>Unit Cost</label><input type="number" id="unit_cost" name="unit_cost" step="0.01" value="0" required></div>
                  <div><label>Total Cost</label><input type="number" id="total_cost" name="total_cost" step="0.01" value="0" readonly></div>
                  <div class="full-width"><label>Remarks / Location</label><input type="text" name="remarks"></div>
                </div>
                <div class="form-buttons">
                  <button type="submit" class="save-btn">Save Item</button>
                  <button type="reset" class="reset-btn">Reset Form</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div id="issued" class="content-section">
  <div class="issued-header">
    <h2>Analytics Overview</h2>
  </div>

  <div class="issued-layout">
    <!-- ===== LEFT SECTION ===== -->
    <div class="issued-left">
      <!-- Analytics Overview -->
      <div class="analytics-overview">
        <div class="analytic-card"><h4>Total issued items</h4><p>309</p></div>
        <div class="analytic-card"><h4>Active issuances</h4><p>60</p></div>
        <div class="analytic-card"><h4>Returned items</h4><p>25</p></div>
        <div class="analytic-card"><h4>Overdue items</h4><p>10</p></div>
        <div class="analytic-card"><h4>Permanent issuances</h4><p>25</p></div>
        <div class="analytic-card"><h4>Pending issuances</h4><p>15</p></div>
      </div>

      <!-- Issued Table -->
      <div class="issued-table-section">`
        <div class="table-header">
          <h4>Issued item list</h4>
          <a href="#">View all</a>
        </div>
        <table class="issued-table">
          <thead>
            <tr>
              <th><input type="checkbox" /></th>
              <th>Property #</th>
              <th>Issued to</th>
              <th>Issued by</th>
              <th>Date issued</th>
              <th>Item</th>
            </tr>
          </thead>
          <tbody>
            <tr><td><input type="checkbox" /></td><td>00001</td><td>Luffy</td><td>Doflamingo</td><td>July 1, 2025</td><td>Helmet</td></tr>
            <tr><td><input type="checkbox" /></td><td>00002</td><td>Zoro</td><td>Kaido</td><td>July 2, 2025</td><td>Safety Shoes</td></tr>
            <tr><td><input type="checkbox" /></td><td>00003</td><td>Nami</td><td>Linlin</td><td>July 3, 2025</td><td>Uniform</td></tr>
            <tr><td><input type="checkbox" /></td><td>00004</td><td>Usopp</td><td>Garp</td><td>July 4, 2025</td><td>Goggles</td></tr>
            <tr><td><input type="checkbox" /></td><td>00005</td><td>Sanji</td><td>Dragon</td><td>July 5, 2025</td><td>Mask</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ===== RIGHT SECTION ===== -->
    <div class="issued-right">
      <div class="chart-card">
        <canvas id="issuedItemsChart"></canvas>
      </div>
      <div class="summary-card">
        <h4>Issuance Summary</h4>
        <div class="summary-item"><span>Total issued items</span><div class="progress"><div class="progress-bar" style="width: 60%"></div></div></div>
        <div class="summary-item"><span>Active issuances</span><div class="progress"><div class="progress-bar" style="width: 5%"></div></div></div>
        <div class="summary-item"><span>Returned items</span><div class="progress"><div class="progress-bar" style="width: 4%"></div></div></div>
        <div class="summary-item"><span>Overdue items</span><div class="progress"><div class="progress-bar" style="width: 2%"></div></div></div>
        <div class="summary-item"><span>Permanent issuances</span><div class="progress"><div class="progress-bar" style="width: 5%"></div></div></div>
        <div class="summary-item"><span>Pending issuances</span><div class="progress"><div class="progress-bar" style="width: 2%"></div></div></div>
      </div>
    </div>
  </div>
</div>
        <div id="form" class="content-section">
  <div class="form-header">
    <h2>Form Summary</h2>
  </div>

  <!-- Summary Section -->
  <div class="form-summary">
    <div class="summary-card">
      <p>Total Forms</p>
      <h2>124</h2>
    </div>
    <div class="summary-card">
      <p>ICS Form</p>
      <h2>88</h2>
    </div>
    <div class="summary-card">
      <p>PAR Form</p>
      <h2>36</h2>
    </div>
    <div class="summary-card">
      <p>Active</p>
      <h2>22</h2>
    </div>
    <div class="summary-card">
      <p>Archive</p>
      <h2>102</h2>
    </div>
  </div>

  <!-- FORM SECTION --> 
  <div class="form-controls">
    <button class="sort-btn"><i class="fas fa-filter"></i> Sort by field</button>
    <button class="add-btn"><i class="fas fa-plus"></i> Add New Form</button>
  </div>

  <!-- Table -->
  <div class="form-table-container">
    <table class="form-table">
      <thead>
        <tr>
          <th>Form Type</th>
          <th>Reference No.</th>
          <th>Date Created</th>
          <th>Issued To</th>
          <th>Item Count</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($issuedForms as $form)
        <tr>
          <td>{{ $form->form_type }}</td>
          <td>{{ $form->reference_no }}</td>
          <td>{{ \Carbon\Carbon::parse($form->created_at)->format('F d, Y') }}</td>
          <td>{{ $form->student_name }}</td>
          <td>{{ $form->item_count }}</td>
          <td>{{ $form->status }}</td>
          <td><a href="#">View</a> | <a href="#">Print</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- ====== Form Type Chooser Modal ====== -->
<div id="formTypeModal" class="modal-overlay">
  <div class="modal-content" style="width: 420px;">
    <span class="close-btn" onclick="closeFormTypeModal()">&times;</span>
    <h2 style="color:#004aad;text-align:center;">Choose Form Type</h2>
    <div style="display:flex;gap:20px;justify-content:center;margin-top:20px;">
      <button class="save-btn" id="chooseIcs">ICS</button>
      <button class="save-btn" id="choosePar">PAR</button>
    </div>
  </div>
</div>

<!-- ====== Add Form Modal (ISSUE FORM) ====== -->
<div id="addFormModal" class="modal-overlay">
  <div class="modal-content" style="width: 720px;">
    <span class="close-btn" onclick="closeAddFormModal()">&times;</span>
    <h2 id="addFormTitle" style="text-align:center;color:#004aad;">Add New Form</h2>

    <form id="addForm" onsubmit="submitForm(event)">
      <input type="hidden" id="form_type_input" name="form_type" value="ICS">

      <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 12px;">
        <div class="full-width" style="position:relative;">
          <label>Student Name</label>
          <input type="text" id="studentSearch" name="student_name" autocomplete="off" placeholder="Type student name..." required>
          <div id="studentSuggestion" class="suggestion-box"></div>
        </div>

        <div class="full-width">
          <label>Property Number</label>
          <input type="text" id="propertyFilter" placeholder="Enter property number..." autocomplete="off">
        </div>

        <div class="full-width">
          <label>Available Serial Numbers</label>
            <div id="serialList" class="serial-container">
              <div class="placeholder">Type a Property No. to see available items.</div>
            </div>
          </div>


        <div class="full-width">
          <label>Reference No.</label>
          <input type="text" id="referenceNo" name="reference_no" required>
          <div id="refCheck" style="color:red;margin-top:6px;display:none;">Reference already exists.</div>
        </div>

        <div class="full-width">
          <label>Issued Date</label>
          <input type="date" id="issuedDate" name="issued_date" required>
        </div>

        <div class="full-width">
          <label>Return Date</label>
          <input type="date" id="returnDate" name="return_date">
        </div>

      <div class="form-buttons" style="margin-top:18px;">
        <button type="submit" class="save-btn">Save Form</button>
        <button type="button" class="reset-btn" onclick="closeAddFormModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Small styles to ensure suggestion-box inside modal positions correctly -->
<style>
  #addFormModal .suggestion-box { position: absolute; left: 0; right: 0; top: 66px; z-index: 1100; }
</style>


    </div>
  </div>
</div>
</div>

        <div id="maintenance" class="content-section">
        <h1>HELLO2</h1>
        </div>
      </section>
    </main>
  </div>

  <script>
/* ============================
   DASHBOARD CHARTS
============================ */
new Chart(document.getElementById("usageChart"), {
  type: "bar",
  data: {
    labels: ["Hammer", "Drill", "Saw", "Wrench"],
    datasets: [
      { label: "Category A", data: [35, 20, 40, 10], backgroundColor: "#004aad" },
      { label: "Category B", data: [15, 30, 20, 25], backgroundColor: "#2ca02c" },
      { label: "Category C", data: [5, 10, 15, 20], backgroundColor: "#7c3aed" }
    ]
  },
  options: { responsive: true, plugins: { legend: { position: "bottom" } } }
});

new Chart(document.getElementById("issuedChart"), {
  type: "pie",
  data: {
    labels: ["Category A", "Category B", "Category C"],
    datasets: [{
      data: [50, 30, 20],
      backgroundColor: ["#004aad", "#2ca02c", "#7c3aed"],
      borderColor: "#fff",
      borderWidth: 3
    }]
  },
  options: { plugins: { legend: { position: "right" } }, responsive: true, maintainAspectRatio: false }
});

new Chart(document.getElementById("issuedItemsChart"), {
  type: "pie",
  data: {
    labels: ["Active", "Returned", "Overdue", "Pending", "Permanent"],
    datasets: [{
      data: [60, 25, 10, 15, 25],
      backgroundColor: ["#123596", "#ff6b6b", "#ffc107", "#20c997", "#6f42c1"]
    }]
  },
  options: { plugins: { legend: { position: "bottom" } } }
});

/* ============================
   PAGE SWITCHING
============================ */
const menuLinks = document.querySelectorAll(".menu a");
const sections = document.querySelectorAll(".content-section");
const pageTitle = document.getElementById("page-title");

menuLinks.forEach(link => {
  link.addEventListener("click", e => {
    e.preventDefault();
    menuLinks.forEach(l => l.classList.remove("active"));
    link.classList.add("active");

    sections.forEach(sec => sec.classList.remove("active"));
    document.getElementById(link.dataset.target).classList.add("active");

    pageTitle.textContent = link.textContent.trim();
  });
});

/* ============================
   INVENTORY SEARCH
============================ */
document.getElementById("inventorySearchInput").addEventListener("keyup", function() {
  const filter = this.value.toLowerCase();
  document.querySelectorAll("#inventoryTable tbody tr").forEach(row => {
    row.style.display = row.cells[3].textContent.toLowerCase().includes(filter) ? "" : "none";
  });
});

/* ============================
   MODALS (Add Item & Forms)
============================ */
const modals = {
  addItem: document.getElementById('addItemModal'),
  formType: document.getElementById('formTypeModal'),
  addForm: document.getElementById('addFormModal')
};

document.getElementById('addItemBtn').addEventListener('click', () => modals.addItem.style.display = 'flex');
document.getElementById('closeModal').addEventListener('click', () => modals.addItem.style.display = 'none');

function openFormTypeModal() { modals.formType.style.display = 'flex'; }
function closeFormTypeModal() { modals.formType.style.display = 'none'; }
function openAddFormModal(type) {
  document.getElementById('form_type_input').value = type;
  document.getElementById('addFormTitle').textContent = `${type} - New Form`;
  closeFormTypeModal();
  loadAvailableSerials();
  modals.addForm.style.display = 'flex';
}
function closeAddFormModal() {
  modals.addForm.style.display = 'none';
  document.getElementById('addForm').reset();
  document.getElementById('studentSuggestion').innerHTML = '';
  document.getElementById('serialList').innerHTML = '';
  document.getElementById('refCheck').style.display = 'none';
}

// Add Form buttons
document.getElementById('chooseIcs').addEventListener('click', () => openAddFormModal('ICS'));
document.getElementById('choosePar').addEventListener('click', () => openAddFormModal('PAR'));
document.querySelectorAll('.add-btn').forEach(el => el.addEventListener('click', e => { e.preventDefault(); openFormTypeModal(); }));

// Close modals if clicked outside
window.addEventListener('click', e => {
  if (e.target.classList.contains('modal-overlay')) e.target.style.display = 'none';
});

/* ============================
   AUTO CALCULATE TOTAL
============================ */
const qtyInput = document.getElementById('quantity');
const unitInput = document.getElementById('unit_cost');
const totalInput = document.getElementById('total_cost');

function updateTotal() {
  totalInput.value = ((parseFloat(qtyInput.value) || 0) * (parseFloat(unitInput.value) || 0)).toFixed(2);
}
qtyInput.addEventListener('input', updateTotal);
unitInput.addEventListener('input', updateTotal);

/* ============================
   AUTO-FILL PROPERTY NUMBER
============================ */
document.getElementById('property_no').addEventListener('blur', async function() {
  const propertyNo = this.value.trim();
  if (!propertyNo) return;

  try {
    const res = await fetch(`/check-property-no/${encodeURIComponent(propertyNo)}`);
    const data = await res.json();

    if (data.exists) {
      document.getElementById('tool_name').value = data.data.tool_name;
      document.getElementById('classification').value = data.data.classification;
      document.getElementById('source_of_fund').value = data.data.source_of_fund;
      document.getElementById('date_acquired').value = data.data.date_acquired;
    } else {
      document.getElementById('tool_name').value = '';
      document.getElementById('classification').value = '';
      document.getElementById('source_of_fund').value = '';
      document.getElementById('date_acquired').value = '';
    }
  } catch(err) { console.error(err); }
});

/* ============================
   SERIAL NUMBER CHECK
============================ */
const serialInput = document.getElementById('serial_no');
if (serialInput) {
  serialInput.addEventListener('blur', async function() {
    const serialNo = this.value.trim();
    if (!serialNo) return;
    try {
      const res = await fetch(`/check-serial-no/${encodeURIComponent(serialNo)}`);
      const data = await res.json();
      if (data.exists) { alert('Serial already exists'); this.value=''; this.focus(); }
    } catch(err) { console.error(err); }
  });
}

/* ============================
   REFERENCE QUICK CHECK
============================ */
const referenceNo = document.getElementById('referenceNo');
const refCheck = document.getElementById('refCheck');
let refTimer = null;
referenceNo.addEventListener('input', function() {
  if (refTimer) clearTimeout(refTimer);
  const ref = this.value.trim();
  refCheck.style.display = 'none';
  if (!ref) return;

  refTimer = setTimeout(async () => {
    try {
      const res = await fetch(`/issued/check-ref/${encodeURIComponent(ref)}`);
      const data = await res.json();
      refCheck.style.display = data.exists ? 'block' : 'none';
    } catch(err){ console.error(err); }
  }, 300);
});

/* ============================
   STUDENT SEARCH LIVE
============================ */
const studentSearch = document.getElementById('studentSearch');
const studentSuggestion = document.getElementById('studentSuggestion');
let studentTimer = null;

studentSearch.addEventListener('keyup', function() {
  const q = this.value.trim();
  studentSuggestion.innerHTML = '';
  if (studentTimer) clearTimeout(studentTimer);
  if (q.length < 1) return;

  studentTimer = setTimeout(async () => {
    try {
      const res = await fetch(`/issued/search-students?query=${encodeURIComponent(q)}`);
      const data = await res.json();
      if (!data || data.length === 0) studentSuggestion.innerHTML = `<div class="no-result">No students found</div>`;
      else {
        studentSuggestion.innerHTML = data.map(s => `<div class="suggest-item" onclick="selectStudent('${s.student_name}')">${s.student_name}</div>`).join('');
      }
    } catch(err){ studentSuggestion.innerHTML = `<div class="no-result">Error loading</div>`; console.error(err); }
  }, 250);
});

function selectStudent(name) {
  studentSearch.value = name;
  studentSuggestion.innerHTML = '';
}

/* ============================
   LOAD AVAILABLE SERIALS
============================ */
async function loadAvailableSerials(propertyNo = '') {
  const container = document.getElementById('serialList');
  container.innerHTML = '<div class="placeholder">Loading available serials...</div>';

  try {
    let url = '/issued/available-serials';
    if (propertyNo) url += `?property_no=${encodeURIComponent(propertyNo)}`;

    const res = await fetch(url);
    if (!res.ok) throw new Error(`HTTP ${res.status}`);

    const list = await res.json();

    if (!list.length) {
      container.innerHTML = '<div class="placeholder">No available items for this property number.</div>';
      return;
    }

    container.innerHTML = list.map(item => `
      <div class="serial-item" onclick="this.querySelector('input').click()">
        <input type="checkbox" class="serial-checkbox" data-serial="${item.serial_no}" data-property="${item.property_no}">
        <span>${item.tool_name} ${item.serial_no}</span>
      </div>
    `).join('');

  } catch (err) {
    console.error(err);
    container.innerHTML = `<div class="placeholder" style="color:red;">Failed to load serials: ${err.message}</div>`;
  }
}


/* ============================
   SUBMIT FORM (AJAX)
============================ */
async function submitForm(e) {
  e.preventDefault();

  const studentName = studentSearch.value.trim();
  if (!studentName) return alert('Please select a student');

  const checked = Array.from(document.querySelectorAll('.serial-checkbox:checked'))
                       .map(cb => cb.dataset.serial);
  if (!checked.length) return alert('Please choose at least one serial');

  const payload = {
    student_name: studentName,
    selected_serials: checked,
    form_type: document.getElementById('form_type_input').value,
    issued_date: document.getElementById('issuedDate').value,
    return_date: document.getElementById('returnDate').value,
    reference_no: referenceNo.value.trim()
  };

  if (!payload.issued_date || !payload.reference_no)
      return alert('Fill required fields');

  if (refCheck.style.display !== 'none')
      return alert('Reference exists');

  try {
    const res = await fetch('/issued/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
      },
      body: JSON.stringify(payload)
    });

    // If Laravel returns validation errors (422)
    if (res.status === 422) {
      const err = await res.json();
      let msg = "Validation failed:\n";
      for (const key in err.errors) {
        msg += "- " + err.errors[key][0] + "\n";
      }
      return alert(msg);
    }

    const json = await res.json();

    // Backend returned but not successful
    if (!json.success) {
      return alert(json.message || "Failed to save");
    }

    // ---- SUCCESS ----
    loadAvailableSerials();
    appendFormRecordToTable(json.data);
    alert('Form saved successfully!');
    closeAddFormModal();

  } catch (err) {
    console.error(err);
    alert('Unexpected error saving form');
  }
}


function appendFormRecordToTable(data) {
  const tbody = document.querySelector('.form-table tbody');
  if (!tbody) return;

  data.selected_serials.forEach(serial => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${data.form_type}</td>
      <td>${data.reference_no}</td>
      <td>${data.issued_date}</td>
      <td>${data.student_name}</td>
      <td>1</td>
      <td class="status active">Active</td>
      <td><a href="#">View</a> | <a href="#">Print</a></td>
    `;
    tbody.prepend(tr);
  });
}

/* ============================
   PROPERTY FILTER SERIALS
============================ */
document.getElementById('propertyFilter').addEventListener('input', function() {
  loadAvailableSerials(this.value.trim());
});
</script>
</body>
</html>