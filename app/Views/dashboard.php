<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f7f7f7;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <div class="card p-5 text-center">
      <h1 class="mb-4">Welcome, <?= session()->get('name'); ?> 👋</h1>
      <p class="lead">You have successfully logged in to your dashboard!</p>

      <a href="<?= base_url('logout') ?>" class="btn btn-danger mt-3">Logout</a>
    </div>
  </div>

  <!-- SweetAlert for success message -->
  <script>
    <?php if(session()->getFlashdata('success')): ?>
      Swal.fire({
        icon: 'success',
        title: 'Welcome!',
        text: '<?= session()->getFlashdata('success') ?>',
        confirmButtonText: 'OK'
      });
    <?php endif; ?>
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
