<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'EcoSwap Dashboard') ?></title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
      --eco-green: #0f766e;
      --eco-light: #e8f5e9;
      --eco-dark: #065f46;
      --eco-accent: #34d399;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f7fdf9;
    }

    /* Sidebar */
    .sidebar {
    position: fixed;
    width: 250px;
    height: 100vh;
    background: #9fd89f;
    color: #85ad68ff;
}
    .sidebar .brand {
      font-size: 22px;
      font-weight: 700;
      padding: 20px;
      text-align: center;
      background: var(--eco-dark);
    }
    .sidebar .brand img {
      height: 35px;
      margin-right: 8px;
    }
    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: #000c06ff;
      text-decoration: none;
      transition: 0.3s;
      font-size: 15px;
    }
    .sidebar a:hover, .sidebar a.active {
      background: var(--eco-accent);
      color: #92ca79ff;
    }

    .main-content {
      margin-left: 250px;
      min-height: 100vh;
    }

    .topbar {
      background: #fff;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .eco-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(209, 240, 160, 0.05);
    background: #9ec4a1;
}
  </style>
</head>
<body>

<div class="sidebar">
  <div class="brand d-flex align-items-center justify-content-center">
   <img src="https://miro.medium.com/1*k2TyAS6wYfMkoCwbVJHpQg.jpeg" alt="EcoSwap Logo" style="height:35px; border-radius:50%;">

    EcoSwap
  </div>
  <a href="<?= base_url('dashboard') ?>" class="<?= url_is('admin/dashboard') ? 'active' : '' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a href="<?= base_url('clothes') ?>"><i class="bi bi-bag"></i> Clothes</a>
  <a href="<?= base_url('clothes/add') ?>"><i class="bi bi-plus-circle"></i> Add Clothes</a>
  <a href="<?= base_url('coins') ?>"><i class="bi bi-coin"></i> My Coins</a>
  <a href="<?= base_url('chatbot') ?>"><i class="bi bi-chat-dots"></i> Chat Assistant</a>
  <a href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main-content">
  <div class="topbar">
    <h5 class="fw-bold text-success"><?= esc($title ?? 'Dashboard') ?></h5>
    <div>
      <i class="bi bi-person-circle text-success me-2"></i>
      <?= session()->get('name') ?> | <small><?= session()->get('email') ?></small>
    </div>
  </div>

  <div class="container-fluid py-4">
    <?= $this->renderSection('content') ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
<?php if(session()->getFlashdata('success')): ?>
Swal.fire({ icon: 'success', title: 'Success', text: '<?= session()->getFlashdata('success') ?>' });
<?php endif; ?>
</script>

</body>
</html>
