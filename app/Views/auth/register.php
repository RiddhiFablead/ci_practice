<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

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
              <img src="https://img.freepik.com/free-vector/sign-page-abstract-concept-illustration-enter-application-mobile-screen-user-login-form-website-page-interface-ui-new-profile-registration-email-account_335657-936.jpg"
                alt="register form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>

            <!-- Form -->
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST" action="<?= base_url('store') ?>">
                  <?= csrf_field() ?>

                  <h1 class="fw-bold mb-4">Register</h1>

                  <!-- Name -->
                  <div class="form-outline mb-4">
                    <input type="text" name="name" value="<?= old('name') ?>"
                      class="form-control form-control-lg <?= session()->getFlashdata('errors')['name'] ?? '' ? 'is-invalid' : '' ?>"
                      placeholder="Full Name" />
                    <label class="form-label">Full Name</label>
                    <?php if(session()->getFlashdata('errors')['name'] ?? false): ?>
                      <div class="text-danger mt-1"><?= session()->getFlashdata('errors')['name'] ?></div>
                    <?php endif; ?>
                  </div>

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
                    <input class="btn btn-dark btn-lg btn-block" type="submit" value="Register">
                  </div>
                  <p>Don't have an account? <a href="<?= base_url('/login') ?>" class="link-info">Login</a></p>
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
    title: 'Validation Error!',
    text: '<?= session()->getFlashdata('error') ?>',
    confirmButtonText: 'Fix it'
});
<?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
