<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'TESDA Dashboard')</title>
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
        <h1 id="page-title">@yield('title', 'Dashboard')</h1>
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
        @yield('content')
      </section>
    </main>
  </div>

  <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
