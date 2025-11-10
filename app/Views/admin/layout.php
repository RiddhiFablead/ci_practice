<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'EcoSwap Admin Panel') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      display: flex;
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: #e8f5e9;
      color: #2e7d32;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      border-right: 1px solid #c8e6c9;
    }

    .sidebar .brand {
      font-size: 1.4rem;
      font-weight: bold;
      text-align: center;
      padding: 20px;
      color: #1b5e20;
      border-bottom: 1px solid #c8e6c9;
    }

    .sidebar .nav-link {
      color: #2e7d32;
      font-weight: 500;
      padding: 12px 20px;
      transition: all 0.2s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #d3f595;
      color: #1b5e20;
    }

    /* Content Area */
    .content {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    /* Navbar */
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      z-index: 10;
    }

    .navbar-brand {
      color: #2e7d32 !important;
      font-weight: bold;
    }

    main {
      padding: 25px;
      flex-grow: 1;
    }

    footer {
      text-align: center;
      padding: 10px;
      background: #fff;
      border-top: 1px solid #dee2e6;
      font-size: 0.9rem;
      color: #6c757d;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="brand">EcoSwap Admin</div>
    <nav class="nav flex-column mt-2">
      <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= url_is('admin/dashboard') ? 'active' : '' ?>">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
      <a href="<?= base_url('users') ?>" class="nav-link <?= url_is('users*') ? 'active' : '' ?>">
        <i class="bi bi-people me-2"></i> Users
      </a>
       <a href="<?= base_url('category') ?>" class="nav-link <?= url_is('category*') ? 'active' : '' ?>">
    <i class="bi bi-tags me-2"></i> Categories
  </a>

  <a href="<?= base_url('items') ?>" class="nav-link <?= url_is('items*') ? 'active' : '' ?>">
    <i class="bi bi-recycle me-2"></i> Recycled Items
      
      <a href="<?= base_url('products') ?>" class="nav-link <?= url_is('products*') ? 'active' : '' ?>">
        <i class="bi bi-bag-check me-2"></i> Products
      </a>
      <a href="<?= base_url('rewards') ?>" class="nav-link <?= url_is('rewards*') ? 'active' : '' ?>">
        <i class="bi bi-coin me-2"></i> Rewards
      </a>
      <a href="<?= base_url('payments') ?>" class="nav-link <?= url_is('payments*') ? 'active' : '' ?>">
        <i class="bi bi-credit-card me-2"></i> Payments
      </a>
      <a href="<?= base_url('deliveries') ?>" class="nav-link <?= url_is('deliveries*') ? 'active' : '' ?>">
        <i class="bi bi-truck me-2"></i> Deliveries
      </a>
      <a href="<?= base_url('chatbot') ?>" class="nav-link <?= url_is('chatbot*') ? 'active' : '' ?>">
        <i class="bi bi-robot me-2"></i> Chatbot
      </a>
      <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Welcome, <?= esc($user['name'] ?? 'Admin') ?></a>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-success" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-1"></i><?= esc($user['email'] ?? 'admin@example.com') ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="bi bi-person-lines-fill me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="<?= base_url('settings') ?>"><i class="bi bi-gear me-2"></i>Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Page Content -->
    <main>
      <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer>
      © <?= date('Y') ?> EcoSwap Admin Panel – All Rights Reserved.
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
