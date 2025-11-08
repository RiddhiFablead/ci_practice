<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    body {
        background-color: #f4f8f5;
        font-family: 'Poppins', sans-serif;
    }

    .page-wrapper {
        padding: 30px 0;
    }

    .page-title {
        color: #2b6e2b;
        font-weight: 600;
        text-align: center;
        font-size: 26px;
        margin-bottom: 30px;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .btn-ecoswap {
        background-color: #2b6e2b;
        color: white;
        border-radius: 30px;
        padding: 10px 40px;
        font-weight: 600;
        border: none;
    }

    .btn-ecoswap:hover {
        background-color: #1e4b1e;
    }

    .btn-secondary {
        border-radius: 30px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 20px;
        }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h2 class="page-title">🧥 Add Your Clothes</h2>
            </div>
            <div class="col-md-4 text-md-end text-center">
                <a href="<?= base_url('clothes') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>
        </div>

        <div class="card p-5 bg-white">
            <div id="responseMessage"></div>

            <form id="clothesForm" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">
                            Your Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <option value="men">Men</option>
                            <option value="women">Women</option>
                            <option value="kids">Kids</option>
                            <option value="winter">Winter</option>
                            <option value="summer">Summer</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="condition" class="form-label">
                            Condition <span class="text-danger">*</span>
                        </label>
                        <select name="condition" id="condition" class="form-select" required>
                            <option value="">-- Select Condition --</option>
                            <option value="new">New</option>
                            <option value="good">Good</option>
                            <option value="used">Used</option>
                            <option value="old">Old</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-12 mb-4">
                        <label for="status" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">-- Select Status --</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="col-12 mb-4">
                        <label for="image" class="form-label">
                            Upload Image <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png" required>
                        <small class="text-muted">Accepted: JPG, PNG (max 2MB)</small>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-ecoswap" id="submitBtn">
                            <i class="bi bi-cloud-upload"></i> Submit Clothes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap & SweetAlert -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $("#clothesForm").on("submit", function(e) {
            e.preventDefault();

            let form = $(this)[0];
            let formData = new FormData(form);
            $("#submitBtn").prop("disabled", true).html('<i class="bi bi-hourglass-split"></i> Submitting...');

            $.ajax({
                url: "<?= base_url('clothes/store') ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#submitBtn").prop("disabled", false).html('<i class="bi bi-cloud-upload"></i> Submit Clothes');

                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Clothes added successfully!',
                            confirmButtonColor: '#2b6e2b'
                        }).then(() => {
                            $("#clothesForm")[0].reset();
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops!',
                            text: response.message || 'Something went wrong, please try again.',
                            confirmButtonColor: '#2b6e2b'
                        });
                    }
                },
                error: function(xhr) {
                    $("#submitBtn").prop("disabled", false).html('<i class="bi bi-cloud-upload"></i> Submit Clothes');

                    let errorMessage = "An error occurred.";
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).join("\n");
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonColor: '#2b6e2b'
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>