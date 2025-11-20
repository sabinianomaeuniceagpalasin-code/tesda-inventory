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

        <!-- ======================
    MAINTENANCE & MONITORING
======================= -->
        <div id="reports" class="content-section">
          <div class="form-header">
            <h2>Maintenance Summary</h2>

            <div class="reports-controls">
              <div class="right-buttons">
                <input type="text" id="MaintenanceSearchInput" placeholder="Search Item Name...">
              </div>
            </div>
          </div>

          <div class="form-summary">
            <div class="summary-card">
              <p>Items Under Repair</p>
              <h2>{{ $maintenanceCounts['total'] }}</h2>
            </div>
            <div class="summary-card">
              <p>Complete Repairs</p>
              <h2>{{ $maintenanceCounts['pending'] }}</h2>
            </div>
            <div class="summary-card">
              <p>Unserviceable</p>
              <h2>{{ $maintenanceCounts['completed'] }}</h2>
            </div>
            <div class="summary-card">
              <p>Total Repair Cost</p>
              <h2>{{ $maintenanceCounts['upcoming'] }}</h2>
            </div>
          </div>

          <!-- Maintenance Filter Input -->
          <div class="reports-controls">

            <!-- Input With Icon -->
            <div class="left-side">
              <div class="input-with-icon">
                <input type="text" id="MaintenanceFilterInput" placeholder="Filter Items">
                <svg class="filter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path
                    d="M21 4V6H20L15 13.5V22H9V13.5L4 6H3V4H21ZM6.4037 6L11 12.8944V20H13V12.8944L17.5963 6H6.4037Z">
                  </path>
                </svg>
              </div>

              <!-- Export Button -->
              <div class="btn-with-icon">
                <button class="export-btn" id="ExportMaintenanceBtn">
                  <svg class="export-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                      d="M21 3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3ZM12 16C10.3431 16 9 14.6569 9 13H4V5H20V13H15C15 14.6569 13.6569 16 12 16ZM16 11H13V14H11V11H8L12 6.5L16 11Z">
                    </path>
                  </svg>
                  Export to PDF
                </button>
              </div>

              <!-- Print Button -->
              <div class="btn-wth-icon">
                <button class="print-btn" id="PrintMaintenanceBtn">
                  <svg class="print-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                      d="M7 17H17V22H7V17ZM19 20V15H5V20H3C2.44772 20 2 19.5523 2 19V9C2 8.44772 2.44772 8 3 8H21C21.5523 8 22 8.44772 22 9V19C22 19.5523 21.5523 20 21 20H19ZM5 10V12H8V10H5ZM7 2H17C17.5523 2 18 2.44772 18 3V6H6V3C6 2.44772 6.44772 2 7 2Z">
                    </path>
                  </svg>
                  Print
              </div>
            </div>

            <!-- Right Buttons -->
            <div class="right-side">
              <div class="btn-with-icon">
                <button class="edit-btn" id="EditMaintenanceBtn">
                  <svg class="edit-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="rgba(100,205,138,1)">
                    <path
                      d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z">
                    </path>
                  </svg>
                  Edit
                </button>
              </div>

              <div class="btn-with-icon">
                <button class="delete-btn" id="DeleteMaintenanceBtn">
                  <svg class="delete-icon" mlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="rgba(222,49,49,1)">
                    <path
                      d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z">
                    </path>
                  </svg>
                  Delete
                </button>
              </div>

              <div class="btn-with-icon">
                <button class="add-btn" id="AddMaintenanceBtn">
                  <svg class="add-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                    fill="white">
                    <path d="M12 5v14m-7-7h14" stroke="white" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                  Add New Form
                </button>
              </div>
            </div>
          </div>


          <div class="form-table-container">
            <table class="form-table">
              <thead>
                <tr>
                  <th>Property #</th>
                  <th>Tool</th>
                  <th>Issue / Problem</th>
                  <th>Date Reported</th>
                  <th>Repair Cost</th>
                  <th>Expected Completion</th>
                  <th>Remarks</th>
                </tr>
              </thead>

              <tbody>
                @isset($maintenanceRecords)
                  @foreach($maintenanceRecords as $record)
                    <tr>
                      <td>{{ $record->property_no }}</td>
                      <td>{{ $record->item_name }}</td>
                      <td>{{ $record->issue_problem }}</td>
                      <td>{{ $record->date_reported }}</td>
                      <td>{{ $record->repair_cost ? '₱' . number_format($record->repair_cost, 2) : '-' }}</td>
                      <td>{{ $record->expected_completion ?? '-' }}</td>
                      <td>{{ $record->remarks }}</td>
                    </tr>
                  @endforeach
                @endisset
              </tbody>
            </table>
          </div>
        </div>

        <!-- ======================
            FORM RECORDS SECTION
        ======================= -->
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

  <!-- ===============================
     MAINTENANCE ADD MODAL
================================ -->
  <div id="maintenanceAddModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">

      <button id="closeMaintenanceModal" class="modal-close">&times;</button>

      <h2 class="modal-title">Add new record</h2>

      <form id="maintenanceForm">

        <!-- TOP 2-COLUMN FIELDS -->
        <div class="two-columns">
          <div class="form-group">
            <label>Property No.*</label>
            <input type="text" id="m_property_no" name="property_no" required readonly>
          </div>

          <div class="form-group">
            <label>Item Name*</label>
            <input type="text" id="m_item_name" name="item_name" required readonly>
          </div>
        </div>

        <div class="form-group full">
          <label>Issue / Problem*</label>
          <input type="text" id="m_issue" name="issue" required>
        </div>

        <div class="form-group full">
          <label>Date Reported*</label>
          <input type="date" id="m_date" name="date_reported" required>
        </div>

        <div class="form-group full">
          <label>Repair Cost*</label>
          <input type="number" id="m_cost" name="repair_cost" required>
        </div>

        <div class="form-group full">
          <label>Expected Completion*</label>
          <input type="date" id="m_completion" name="expected_completion" required>
        </div>

        <div class="modal-buttons">
          <button type="button" class="cancel-btn">Cancel</button>
          <button type="submit" class="add-btn">Add</button>
        </div>

      </form>
    </div>
  </div>

  <script>

    // I DIDN'T SEPERATE THIS FUNCTION INTO A DIFFERENT JS FILE BECAUSE IT'S ONLY USED HERE
    // Print the content of the View Form Modal
    function printFormModal() {
      const modal = document.getElementById('viewFormModal');
      const modalContent = modal.querySelector('.modal-body').cloneNode(true);

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

      const printWindow = window.open('TESDA', 'TESDA', 'width=900, height = 700');
      printWindow.document.write(printHTML);
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
      printWindow.close();
    }
  </script>

  <script>
    window.usageLabels = @json($usageData->pluck('tool_name'));
    window.usageValues = @json($usageData->pluck('total_usage'));
    window.issuedLabels = @json($issuedFrequency->pluck('tool_name'));
    window.issuedValues = @json($issuedFrequency->pluck('total')).map(Number);
  </script>

  <script src="{{ asset('js/dashboard-charts.js') }}"></script>
  <script src=" {{ asset('js/dashboard-page-switch.js') }}"></script>
  <script src="{{ asset('js/dashboard-inv-search.js') }}"></script>
  <script src="{{ asset('js/dashboard-modal.js') }}"></script>
  <script src="{{ asset('js/dashboard-form-search.js') }}"></script>
  <script src="{{ asset('js/dashboard-calc-total.js') }}"></script>
  <script src="{{ asset('js/dashboard-fill-prop-num.js') }}"></script>
  <script src="{{ asset('js/dashboard-form-search.js') }}"></script>
  <script src="{{ asset('js/dashboard-load-avail-serials.js') }}"></script>
  <script src="{{ asset('js/dashboard-prop-filter.js') }}"></script>
  <script src="{{ asset('js/dashboard-reference-quick.js') }}"></script>
  <script src="{{ asset('js/dashboard-student-search.js') }}"></script>
  <script src="{{ asset('js/dashboard-submit-form.js') }}"></script>
  <script src="{{ asset('js/dashboard-maintenance-modal.js') }}"></script>

</body>

</html>