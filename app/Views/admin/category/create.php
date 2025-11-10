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
                <h2 class="page-title">📂 Add New Category</h2>
            </div>
            <div class="col-md-4 text-md-end text-center">
                <a href="<?= base_url('category') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>
        </div>

        <div class="card p-5 bg-white">
            <div id="responseMessage"></div>

            <form id="categoryForm">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Category Name -->
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Enter category name" required>
                    </div>

                    <!-- Description -->
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3" class="form-control"
                            placeholder="Enter short description (optional)"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-12 mb-3">
                        <label for="status" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">-- Select Status --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-ecoswap" id="submitBtn">
                            <i class="bi bi-cloud-upload"></i> Save Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons & SweetAlert -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $("#categoryForm").on("submit", function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = form.serialize();
            $("#submitBtn").prop("disabled", true).html('<i class="bi bi-hourglass-split"></i> Saving...');

            $.ajax({
                url: "<?= site_url('category/store') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    $("#submitBtn").prop("disabled", false).html('<i class="bi bi-cloud-upload"></i> Save Category');

                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Category created successfully!',
                            confirmButtonColor: '#2b6e2b'
                        }).then(() => {
                            $("#categoryForm")[0].reset();
                        });
                    } else if (response.errors) {
                        let errors = Object.values(response.errors).join("\n");
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: errors,
                            confirmButtonColor: '#2b6e2b'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Something went wrong.',
                            confirmButtonColor: '#2b6e2b'
                        });
                    }
                },
                error: function(xhr) {
                    $("#submitBtn").prop("disabled", false).html('<i class="bi bi-cloud-upload"></i> Save Category');
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Could not connect to the server. Please try again.',
                        confirmButtonColor: '#2b6e2b'
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
