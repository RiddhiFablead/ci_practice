<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- SweetAlert -->
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
              <img src="https://img.freepik.com/free-vector/sign-page-abstract-concept-illustration-enter-application-mobile-screen-user-login-form-website-page-interface-ui-new-profile-registration-email-account_335657-936.jpg?semt=ais_hybrid&w=740&q=80"
                alt="register form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>

            <!-- Form -->
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST" action="<?= base_url('store') ?>">
                  <?= csrf_field() ?> <!-- CSRF token -->

                  <h1 class="fw-bold mb-4">Register</h1>

                  <!-- Username -->
                  <div class="form-outline mb-4">
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" />
                    <label class="form-label">Username</label>
                  </div>

                  <!-- Email -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email address" />
                    <label class="form-label">Email</label>
                  </div>

                  <!-- Password -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                    <label class="form-label">Password</label>
                  </div>

                  <!-- Submit -->
                  <div class="pt-1 mb-4">
                    <input class="btn btn-dark btn-lg btn-block" type="submit">
                  </div>

                  <!-- Already have account -->
                  <!-- <p class="mb-0">Already have an account? 
                    <a href="<?= site_url('login') ?>" class="text-dark">Login here</a>
                  </p> -->

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
    confirmButtonText: 'OK'
});
<?php endif; ?>
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
`