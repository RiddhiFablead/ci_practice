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
                <h2 class="page-title">♻️ Add Recycle Item</h2>
            </div>
            <div class="col-md-4 text-md-end text-center">
                <a href="<?= base_url('recycle') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>
        </div>

        <div class="card p-5 bg-white">
            <div id="responseMessage"></div>

            <form id="recycleForm" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- User name -->
                    <div class="col-md-6 mb-3">
                        <label for="user_name" class="form-label">
                            User Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" required>
                    </div>

                    <!-- Item Name -->
                    <div class="col-md-6 mb-3">
                        <label for="item_name" class="form-label">
                            Item Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter item name" required>
                    </div>

                    <!-- Dynamic Category Dropdown -->
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="">-- Loading Categories... --</option>
                        </select>
                    </div>

                    <!-- Weight -->
                    <div class="col-md-6 mb-3">
                        <label for="weight" class="form-label">
                            Weight (in kg) <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" name="weight" id="weight" class="form-control" placeholder="Enter weight" required>
                    </div>

                    <!-- Reward Coins -->
                    <div class="col-md-6 mb-3">
                        <label for="reward_coins" class="form-label">
                            Reward Coins <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="reward_coins" id="reward_coins" class="form-control" placeholder="Enter reward coins" required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
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

                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-ecoswap" id="submitBtn">
                            <i class="bi bi-recycle"></i> Add Recycle Item
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

        // 🔄 Load categories dynamically from backend
        $.ajax({
            url: "<?= base_url('categories/active') ?>", // Route defined in Routes.php
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success' && response.categories.length > 0) {
                    let options = '<option value="">-- Select Category --</option>';
                    response.categories.forEach(cat => {
                        options += `<option value="${cat.name}">${cat.name.charAt(0).toUpperCase() + cat.name.slice(1)}</option>`;
                    });
                    $("#category").html(options);
                } else {
                    $("#category").html('<option value="">No active categories found</option>');
                }
            },
            error: function() {
                $("#category").html('<option value="">Failed to load categories</option>');
            }
        });

        // ♻️ Submit recycle form via AJAX
        $("#recycleForm").on("submit", function(e) {
            e.preventDefault();

            let form = $(this)[0];
            let formData = new FormData(form);
            $("#submitBtn").prop("disabled", true).html('<i class="bi bi-hourglass-split"></i> Submitting...');

            $.ajax({
                url: "<?= base_url('recycle/store') ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#submitBtn").prop("disabled", false).html('<i class="bi bi-recycle"></i> Add Recycle Item');

                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Recycle item added successfully!',
                            confirmButtonColor: '#2b6e2b'
                        }).then(() => {
                            $("#recycleForm")[0].reset();
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops!',
                            text: response.message || 'Something went wrong. Please try again.',
                            confirmButtonColor: '#2b6e2b'
                        });
                    }
                },
                error: function(xhr) {
                    $("#submitBtn").prop("disabled", false).html('<i class="bi bi-recycle"></i> Add Recycle Item');

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
