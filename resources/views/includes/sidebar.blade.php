<aside class="sidebar">
  <div class="logo">
    <img src="{{ asset('images/Tesda logo 1.png') }}" alt="TESDA Logo">
  </div>

  <nav class="menu">
    <!-- default active is dashboard; the JS will handle switching -->
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