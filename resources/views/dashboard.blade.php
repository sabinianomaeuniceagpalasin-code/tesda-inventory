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
        <a href="#" data-target="reports">
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
                      <tr>
                        <td>Hammer</td>
                        <td>Damaged</td>
                        <td>Ongoing</td>
                        <td>Aug 1, 2025</td>
                        <td>Sep 7, 2025</td>
                      </tr>
                      <tr>
                        <td>Crimping</td>
                        <td>Damaged</td>
                        <td>Ongoing</td>
                        <td>Aug 10, 2025</td>
                        <td>Sep 10, 2025</td>
                      </tr>
                      <tr>
                        <td>Saw</td>
                        <td>Damaged</td>
                        <td>Pending</td>
                        <td>Aug 20, 2025</td>
                        <td>Sep 20, 2025</td>
                      </tr>
                      <tr>
                        <td>Wrench</td>
                        <td>For Repair</td>
                        <td>Ongoing</td>
                        <td>Aug 22, 2025</td>
                        <td>Sep 22, 2025</td>
                      </tr>
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
                      <tr>
                        <td>Luffy</td>
                        <td>Hammer</td>
                        <td>001</td>
                        <td>ICS</td>
                        <td>Missing</td>
                      </tr>
                      <tr>
                        <td>Zoro</td>
                        <td>Crimping</td>
                        <td>002</td>
                        <td>PPR</td>
                        <td>For Repair</td>
                      </tr>
                      <tr>
                        <td>Sanji</td>
                        <td>Saw</td>
                        <td>003</td>
                        <td>ICS</td>
                        <td>For Repair</td>
                      </tr>
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
            <div class="summary-box">
              <p>Total Tools & Equipment</p>
              <h2>{{ $totalTools }}</h2>
            </div>
            <div class="summary-box">
              <p>Available Items</p>
              <h2>{{ $availableItems }}</h2>
            </div>
            <div class="summary-box">
              <p>Issued Items</p>
              <h2>{{ $issuedItems }}</h2>
            </div>
            <div class="summary-box">
              <p>Unserviceable/For Repair</p>
              <h2>{{ $forRepair }}</h2>
            </div>
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
                <th>Serial No.</th>
                <th>Item Name</th>
                <th>Sources of Fund</th>
                <th>Classification</th>
                <th>Date Acquired</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($inventory as $item)
                <tr>
                  <td>{{ $item->serial_no }}</td>
                  <td>{{ $item->tool_name }}</td>
                  <td>{{ $item->source_of_fund }}</td>
                  <td>{{ $item->classification }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->date_acquired)->format('F d, Y') }}</td>
                  <td>{{ $item->status }}</td>
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
                <div id="successAlert"
                  style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:10px;text-align:center;">
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
                  <div><label>Particular Article / Item Name</label><input type="text" id="tool_name" name="tool_name"
                      required></div>
                  <div><label>Classification</label><input type="text" id="classification" name="classification"
                      required></div>
                  <div><label>Source of Fund</label><input type="text" id="source_of_fund" name="source_of_fund"
                      required></div>
                  <div><label>Date Acquired</label><input type="date" id="date_acquired" name="date_acquired" required>
                  </div>
                  <div><label>Quantity</label><input type="number" id="quantity" name="quantity" value="1" min="1"
                      required></div>
                  <div><label>Unit Cost</label><input type="number" id="unit_cost" name="unit_cost" step="0.01"
                      value="0" required></div>
                  <div><label>Total Cost</label><input type="number" id="total_cost" name="total_cost" step="0.01"
                      value="0" readonly></div>
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
                <div class="analytic-card">
                  <h4>Total issued items</h4>
                  <p>309</p>
                </div>
                <div class="analytic-card">
                  <h4>Active issuances</h4>
                  <p>{{ $issuedItems }}</p>
                </div>
                <div class="analytic-card">
                  <h4>Returned items</h4>
                  <p>25</p>
                </div>
                <div class="analytic-card">
                  <h4>Overdue items</h4>
                  <p>10</p>
                </div>
                <div class="analytic-card">
                  <h4>Permanent issuances</h4>
                  <p>25</p>
                </div>
                <div class="analytic-card">
                  <h4>Pending issuances</h4>
                  <p>15</p>
                </div>
              </div>

              <!-- Issued Table -->
              <div class="issued-table-section">
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
                    <tr>
                      <td><input type="checkbox" /></td>
                      <td>00001</td>
                      <td>Luffy</td>
                      <td>Doflamingo</td>
                      <td>July 1, 2025</td>
                      <td>Helmet</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" /></td>
                      <td>00002</td>
                      <td>Zoro</td>
                      <td>Kaido</td>
                      <td>July 2, 2025</td>
                      <td>Safety Shoes</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" /></td>
                      <td>00003</td>
                      <td>Nami</td>
                      <td>Linlin</td>
                      <td>July 3, 2025</td>
                      <td>Uniform</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" /></td>
                      <td>00004</td>
                      <td>Usopp</td>
                      <td>Garp</td>
                      <td>July 4, 2025</td>
                      <td>Goggles</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" /></td>
                      <td>00005</td>
                      <td>Sanji</td>
                      <td>Dragon</td>
                      <td>July 5, 2025</td>
                      <td>Mask</td>
                    </tr>
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
                <div class="summary-item"><span>Total issued items</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 60%"></div>
                  </div>
                </div>
                <div class="summary-item"><span>Active issuances</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 5%"></div>
                  </div>
                </div>
                <div class="summary-item"><span>Returned items</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 4%"></div>
                  </div>
                </div>
                <div class="summary-item"><span>Overdue items</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 2%"></div>
                  </div>
                </div>
                <div class="summary-item"><span>Permanent issuances</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 5%"></div>
                  </div>
                </div>
                <div class="summary-item"><span>Pending issuances</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 2%"></div>
                  </div>
                </div>
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
              <h2>{{ $formSummaryCounts->total_forms }}</h2>
            </div>
            <div class="summary-card">
              <p>ICS Form</p>
              <h2>{{ $formSummaryCounts->ics_forms }}</h2>
            </div>
            <div class="summary-card">
              <p>PAR Form</p>
              <h2>{{ $formSummaryCounts->par_forms }}</h2>
            </div>
            <div class="summary-card">
              <p>Active</p>
              <h2>{{ $formSummaryCounts->active_forms }}</h2>
            </div>
            <div class="summary-card">
              <p>Archive</p>
              <h2>{{ $formSummaryCounts->archived_forms }}</h2>
            </div>
          </div>

          <!-- FORM SECTION -->
          <div class="form-controls">

            <button class="sort-btn"><i class="fas fa-filter"></i> Sort by field</button>
            <input type="text" id="formSearchInput" placeholder="Search student or reference number..."
              style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; width:300px; margin-left: 350px;">
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
                    <td>
                      <span class="status {{ strtolower($form->status) }}">
                        {{ $form->status }}
                      </span>
                    </td>
                    <td><a href="#">View</a></td>
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

          <!-- ===== View Form Modal ===== -->
          <div id="viewFormModal" class="modal-overlay" style="display:none;">
            <div class="modal-content" style="width: 800px;">
              <span class="close-btn" onclick="closeViewFormModal()">&times;</span>
              <h2 style="text-align:center;color:#004aad;">Form Details</h2>
              <div class="modal-body" style="margin-top:20px;"></div>
              <div style="text-align:center; margin:20px 0;">
                <button class="save-btn" onclick="printFormModal()">🖨️ Print</button>
              </div>
            </div>
          </div>

          <!-- ====== Add Form Modal (ISSUE FORM) ====== -->
          <div id="addFormModal" class="modal-overlay">
            <div class="modal-content">
              <span class="close-btn" onclick="closeAddFormModal()">&times;</span>
              <h2 id="addFormTitle" style="text-align:center;color:#004aad;">Add New Form</h2>

              <form id="addForm" onsubmit="submitForm(event)">
                <input type="hidden" id="form_type_input" name="form_type" value="ICS">

                <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 12px;">
                  <div class="full-width" style="position:relative;">
                    <label>Student Name</label>
                    <input type="text" id="studentSearch" name="student_name" autocomplete="off"
                      placeholder="Type student name..." required>
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
            #addFormModal .suggestion-box {
              position: absolute;
              left: 0;
              right: 0;
              top: 66px;
              z-index: 1100;
            }
          </style>


        </div>
  </div>
  </div>
  </div>
  <!-- ======================
            MAINTENANCE SECTION
        ======================= -->
  <div id="reports" class="content-section">
    <h2>Maintenance Section</h2>

    <div class="summary-cards">
      <div class="summary-card">Total: {{ $maintenanceCounts['total'] }}</div>
      <div class="summary-card">Pending: {{ $maintenanceCounts['pending'] }}</div>
      <div class="summary-card">Completed: {{ $maintenanceCounts['completed'] }}</div>
      <div class="summary-card">Upcoming: {{ $maintenanceCounts['upcoming'] }}</div>
    </div>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Tool</th>
            <th>Maintenance Type</th>
            <th>Performed By</th>
            <th>Date</th>
            <th>Next Schedule</th>
            <th>Remarks</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @isset($maintenanceRecords)
            @foreach($maintenanceRecords as $record)
              <tr>
                <td>{{ $record->tool_name }}</td>
                <td>{{ $record->maintenance_type }}</td>
                <td>{{ $record->performed_by }}</td>
                <td>{{ $record->maintenance_date }}</td>
                <td>{{ $record->next_schedule ?? '-' }}</td>
                <td>{{ $record->remarks }}</td>
                <td>{{ $record->status }}</td>
              </tr>
            @endforeach
          @endisset
        </tbody>
      </table>
    </div>

    <script>
      /* ============================
         DASHBOARD CHARTS
      ============================ */
      // ======== GET DATA FROM CONTROLLER ========
      const usageLabels = @json($usageData->pluck('tool_name'));
      const usageValues = @json($usageData->pluck('total_usage'));
      const issuedLabels = @json($issuedFrequency->pluck('tool_name'));
      const issuedValues = @json($issuedFrequency->pluck('total')).map(Number);

      // ======== GENERATE UNIQUE TOOL NAMES ========
      const toolNames = [...new Set([...usageLabels, ...issuedLabels])];

      // ======== ASSIGN COLORS CONSISTENTLY ========
      const colorMap = {};
      toolNames.forEach(tool => {
        const r = Math.floor(Math.random() * 156) + 100;
        const g = Math.floor(Math.random() * 156) + 100;
        const b = Math.floor(Math.random() * 156) + 100;
        colorMap[tool] = `rgb(${r}, ${g}, ${b})`;
      });

      // ======== USAGE TRENDS BAR CHART ========
      const usageColors = usageLabels.map(tool => colorMap[tool]);

      new Chart(document.getElementById("usageChart"), {
        type: "bar",
        data: {
          labels: usageLabels,
          datasets: [{
            label: "Total Usage Count",
            data: usageValues,
            backgroundColor: usageColors,
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: {
            y: {
              beginAtZero: true,
              suggestedMin: 0,
              suggestedMax: 100,
              ticks: { stepSize: 10 }
            }
          }
        }
      });

      // ======== ISSUED FREQUENCY PIE CHART ========
      const issuedColors = issuedLabels.map(tool => colorMap[tool]);

      new Chart(document.getElementById("issuedChart"), {
        type: "pie",
        data: {
          labels: issuedLabels,
          datasets: [{
            data: issuedValues,
            backgroundColor: issuedColors,
            borderColor: "#fff",
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: "right" },
            tooltip: {
              callbacks: {
                label: function (context) {
                  const total = context.dataset.data.reduce((a, b) => a + b, 0);
                  const value = context.parsed;
                  const percentage = ((value / total) * 100).toFixed(1);
                  return `${context.label}: ${value} (${percentage}%)`;
                }
              }
            }
          }
        }
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
      document.getElementById("inventorySearchInput").addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();

        document.querySelectorAll("#inventoryTable tbody tr").forEach(row => {
          const col0 = row.cells[0].textContent.toLowerCase(); // Column 0
          const col1 = row.cells[1].textContent.toLowerCase(); // Column 1

          const match =
            col0.includes(filter) ||
            col1.includes(filter);

          row.style.display = match ? "" : "none";
        });
      });

      /* ============================
         FORM RECORDS SEARCH
      ============================ */
      document.getElementById("formSearchInput").addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();

        document.querySelectorAll(".form-table tbody tr").forEach(row => {
          const student = row.cells[3].textContent.toLowerCase();  // Issued To
          const reference = row.cells[1].textContent.toLowerCase(); // Reference No.

          const match =
            student.includes(filter) ||
            reference.includes(filter);

          row.style.display = match ? "" : "none";
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
      document.getElementById('property_no').addEventListener('blur', async function () {
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
        } catch (err) { console.error(err); }
      });

      /* ============================
         SERIAL NUMBER CHECK
      ============================ */
      const serialInput = document.getElementById('serial_no');
      if (serialInput) {
        serialInput.addEventListener('blur', async function () {
          const serialNo = this.value.trim();
          if (!serialNo) return;
          try {
            const res = await fetch(`/check-serial-no/${encodeURIComponent(serialNo)}`);
            const data = await res.json();
            if (data.exists) { alert('Serial already exists'); this.value = ''; this.focus(); }
          } catch (err) { console.error(err); }
        });
      }

      /* ============================
         REFERENCE QUICK CHECK
      ============================ */
      const referenceNo = document.getElementById('referenceNo');
      const refCheck = document.getElementById('refCheck');
      let refTimer = null;
      referenceNo.addEventListener('input', function () {
        if (refTimer) clearTimeout(refTimer);
        const ref = this.value.trim();
        refCheck.style.display = 'none';
        if (!ref) return;

        refTimer = setTimeout(async () => {
          try {
            const res = await fetch(`/issued/check-ref/${encodeURIComponent(ref)}`);
            const data = await res.json();
            refCheck.style.display = data.exists ? 'block' : 'none';
          } catch (err) { console.error(err); }
        }, 300);
      });

      /* ============================
         STUDENT SEARCH LIVE
      ============================ */
      const studentSearch = document.getElementById('studentSearch');
      const studentSuggestion = document.getElementById('studentSuggestion');
      let studentTimer = null;

      studentSearch.addEventListener('keyup', function () {
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
          } catch (err) { studentSuggestion.innerHTML = `<div class="no-result">Error loading</div>`; console.error(err); }
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
        const formType = document.getElementById('form_type_input').value; // ICS or PAR
        container.innerHTML = '<div class="placeholder">Loading available serials...</div>';

        if (!propertyNo) {
          container.innerHTML = '<div class="placeholder">Type a Property No. to see available items.</div>';
          return;
        }

        try {
          const res = await fetch(`/issued/available-serials?property_no=${encodeURIComponent(propertyNo)}&form_type=${encodeURIComponent(formType)}`);
          const list = await res.json();

          if (!list.length) {
            container.innerHTML = '<div class="placeholder">No available items for this property number.</div>';
            return;
          }

          container.innerHTML = list.map(item => `
            <div class="serial-item" onclick="this.querySelector('input').click()">
                <input type="checkbox" class="serial-checkbox" data-serial="${item.serial_no}" data-property="${item.property_no}">
                <span>${item.tool_name} ${item.serial_no} (₱${Number(item.unit_cost).toLocaleString()})</span>
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

        const studentName = document.getElementById('studentSearch').value.trim();
        const referenceNo = document.getElementById('referenceNo').value.trim();
        const issuedDate = document.getElementById('issuedDate').value;
        const returnDate = document.getElementById('returnDate').value;
        const formType = document.getElementById('form_type_input').value;

        const checkedSerials = Array.from(document.querySelectorAll('.serial-checkbox:checked'))
          .map(cb => cb.dataset.serial);

        if (!studentName || !referenceNo || !issuedDate || !checkedSerials.length) {
          return alert('Please fill all required fields and select at least one serial.');
        }

        const refCheck = document.getElementById('refCheck');
        if (refCheck.style.display !== 'none') return alert('Reference number already exists.');

        const payload = {
          student_name: studentName,
          selected_serials: checkedSerials,
          form_type: formType,
          issued_date: issuedDate,
          return_date: returnDate,
          reference_no: referenceNo
        };

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

          const json = await res.json();

          if (!json.success) {
            return alert(json.message || 'Failed to save form');
          }

          alert('Form saved successfully!');
          closeAddFormModal();
          window.location.reload();

        } catch (err) {
          console.error(err);
          alert('Unexpected error saving form: ' + err.message);
        }
      }

      /* ============================
         PROPERTY FILTER SERIALS
      ============================ */
      document.getElementById('propertyFilter').addEventListener('input', function () {
        loadAvailableSerials(this.value.trim());
      });

      // Open View Modal
      function closeViewFormModal() {
        document.getElementById('viewFormModal').style.display = 'none';
        document.getElementById('viewFormModal').querySelector('.modal-body').innerHTML = '';
      }

      // Attach click event to all "View" links in the form table
      document.querySelectorAll('.form-table tbody tr td a').forEach(link => {
        if (link.textContent.trim() === 'View') {
          link.addEventListener('click', async function (e) {
            e.preventDefault();
            const row = this.closest('tr');
            const referenceNo = row.cells[1].textContent.trim();
            const formType = row.cells[0].textContent.trim(); // <-- GET FORM TYPE HERE

            try {
              const res = await fetch(`/issued/view/${encodeURIComponent(referenceNo)}`);
              if (!res.ok) throw new Error(`HTTP ${res.status}`);
              const data = await res.json();
              if (data.error) return alert(data.error);

              // Group items by property number
              const grouped = {};
              data.details.forEach(d => {
                if (!grouped[d.property_no]) {
                  grouped[d.property_no] = {
                    property_no: d.property_no,
                    tool_name: d.tool_name,
                    quantity: 0,
                    unit_cost: 0,
                    total_cost: 0,
                    serials: []
                  };
                }
                grouped[d.property_no].quantity += 1;
                grouped[d.property_no].unit_cost = Number(d.unit_cost) || 0;
                grouped[d.property_no].total_cost += Number(d.unit_cost) || 0;
                grouped[d.property_no].serials.push(d.serial_no);
              });

              // Build modal content WITHOUT signature block
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
              Object.values(grouped).forEach(item => {
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
              data.details.forEach(d => {
                html += `<tr>
                        <td>${d.property_no}</td>
                        <td>${d.serial_no}</td>
                    </tr>`;
              });
              html += `</tbody></table>`;

              // Add acknowledgement text
              html += `
                    <div style="margin-top:30px; font-size:14px; line-height:1.5;">
                        I hereby acknowledge receipt of the above-listed item(s) and accept full responsibility for their proper use, custody, and maintenance.
                        I understand that any loss, damage, or misuse of said property will be my liability and may be subject to appropriate administrative or financial action as per government property regulations.
                    </div>
                `;

              document.getElementById('viewFormModal').dataset.formType = formType;

              document.getElementById('viewFormModal').querySelector('.modal-body').innerHTML = html;
              document.getElementById('viewFormModal').style.display = 'flex';

            } catch (err) {
              console.error(err);
              alert('Failed to load form details: ' + err.message);
            }
          });
        }
      });

      // Print function with proper header and only 2 signatures
      // Print function with proper header and friendly form type names
      function printFormModal() {
        const modal = document.getElementById('viewFormModal');
        const modalContent = modal.querySelector('.modal-body').cloneNode(true);

        // Get the form type from the data attribute
        let formType = modal.dataset.formType || '';
        if (formType === 'ICS') formType = 'Inventory Custodian Slip (ICS)';
        if (formType === 'PAR') formType = 'Property Acknowledgement Receipt (PAR)';

        const headerUrl = "{{ url('images/header.png') }}";
        const referenceNoElem = modalContent.querySelector('p strong');
        const referenceNo = referenceNoElem ? referenceNoElem.parentElement.textContent.trim() : '';

        const printHTML = `
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
                table, th, td { border: 1px solid #000; }
                th, td { padding: 6px; text-align: center; }
                .signature { text-align:center; width:45%; }
                .signature div { border-bottom:1px solid #000; margin:20px auto 10px auto; width:100%; }
                .flex { display:flex; justify-content:space-between; margin-top:50px; }
                
            </style>
        </head>
        <body>
            <div style="text-align:center;">
                
                <div style="font-weight:bold; margin:20px 0; line-height:1.4;">
                    TESDA<br>
                    Property and Supply Management Section
                    ${formType ? `<p style="font-weight:bold; font-size:16px;" margin-top: -20px;>${formType}</p>` : ''}
                </div>
    
            </div>

            <div>${modalContent.innerHTML}</div>

            <div class="flex">
                <div class="signature">
                    Issued By:<br>
                    <div></div>
                    Signature over printed name<br>
                    Date: __________
                </div>
                <div class="signature">
                    Issued To:<br>
                    <div></div>
                    Signature over printed name<br>
                    Date: __________
                </div>
            </div>
        </body>
        </html>
    `;

        const printWindow = window.open('TESDA', 'TESDA', 'width=900,height=700');
        printWindow.document.write(printHTML);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
      }


      // Close modal if clicked outside
      window.addEventListener('click', e => {
        if (e.target.id === 'viewFormModal') closeViewFormModal();
      });
    </script>
</body>

</html>