<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.img-fluid {
  max-width: 100%;
  height: 630px !important;
}
</style>
</head>
<body>

<section class="vh-100" style="background-color: #9A616D;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">

            <!-- Left image -->
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://img.freepik.com/free-vector/login-concept-illustration_114360-739.jpg"
                   alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>

            <!-- Form -->
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST" action="<?= base_url('checkLogin') ?>">
                  <?= csrf_field() ?>

                  <h1 class="fw-bold mb-4">Login</h1>

                  <!-- Email -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" value="<?= old('email') ?>"
                      class="form-control form-control-lg <?= session()->getFlashdata('errors')['email'] ?? '' ? 'is-invalid' : '' ?>"
                      placeholder="Email address" />
                    <label class="form-label">Email</label>
                    <?php if(session()->getFlashdata('errors')['email'] ?? false): ?>
                      <div class="text-danger mt-1"><?= session()->getFlashdata('errors')['email'] ?></div>
                    <?php endif; ?>
                  </div>

                  <!-- Password -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password"
                      class="form-control form-control-lg <?= session()->getFlashdata('errors')['password'] ?? '' ? 'is-invalid' : '' ?>"
                      placeholder="Password" />
                    <label class="form-label">Password</label>
                    <?php if(session()->getFlashdata('errors')['password'] ?? false): ?>
                      <div class="text-danger mt-1"><?= session()->getFlashdata('errors')['password'] ?></div>
                    <?php endif; ?>
                  </div>

                  <!-- Submit -->
                  <div class="pt-1 mb-4">
                    <input class="btn btn-dark btn-lg btn-block" type="submit" value="Login">
                  </div>

                  <p>Don't have an account? <a href="<?= base_url('/') ?>" class="link-info">Register here</a></p>

                </form>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SweetAlert for flash messages -->
<script>
<?php if(session()->getFlashdata('success')): ?>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '<?= session()->getFlashdata('success') ?>',
    confirmButtonText: 'OK'
});
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: '<?= session()->getFlashdata('error') ?>',
    confirmButtonText: 'Try Again'
});
<?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
