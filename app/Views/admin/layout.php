<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'Admin Panel') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
    }
    .sidebar {
      width: 250px;
      background-color: #0a3d62;
      color: #fff;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
    }
    .sidebar .nav-link {
      color: #cfd8dc;
      padding: 12px 20px;
    }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #1e90ff;
      color: #fff;
    }
    .content {
      flex-grow: 1;
      background-color: #f8f9fa;
      padding: 25px;
    }
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      z-index: 10;
    }
    .navbar-brand {
      color: #0a3d62 !important;
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="p-4 fs-4 fw-bold text-center border-bottom">Admin Panel</div>
  <nav class="nav flex-column mt-3">
    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="<?= base_url('users') ?>" class="nav-link"><i class="bi bi-people me-2"></i>Users</a>
    <a href="<?= base_url('clothes') ?>" class="nav-link"><i class="bi bi-bag-check me-2"></i>Clothes</a>
    <a href="<?= base_url('logout') ?>" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
  </nav>
</div>

<!-- Main Content -->
<div class="content">
  <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Welcome, <?= esc($user['name']) ?></a>
      <div class="d-flex align-items-center">
        <span class="text-muted me-3"><?= esc($user['email']) ?></span>
      </div>
    </div>
  </nav>

  <main>
    <?= $this->renderSection('content') ?>
  </main>
</div>

</body>
</html>
