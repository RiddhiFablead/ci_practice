<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
.page-title {
    color: #2b6e2b;
    font-weight: 600;
    text-align: center;
    font-size: 26px;
    margin-bottom: 30px;
}
.btn-ecoswap {
    background-color: #2b6e2b;
    color: white;
    border-radius: 30px;
    padding: 8px 25px;
    font-weight: 600;
    border: none;
}
.btn-ecoswap:hover { background-color: #1e4b1e; }
.form-label { font-weight: 500; color: #333; }
</style>

<div class="container mt-5">
    <h2 class="page-title">✏️ Update Category</h2>
    <div class="card p-5 shadow-sm">
        <div id="responseMessage"></div>
        <form id="updateCategoryForm">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= esc($category['id']) ?>">

            <div class="mb-3">
                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= esc($category['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= esc($category['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="">-- Select Status --</option>
                    <option value="active" <?= $category['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $category['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-ecoswap" id="submitBtn">
                    <i class="bi bi-pencil-square"></i> Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#updateCategoryForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();
        $('#submitBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Updating...');

        $.ajax({
            url: "<?= base_url('category/update') ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                $('#submitBtn').prop('disabled', false).html('<i class="bi bi-pencil-square"></i> Update Category');

                if(response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message || 'Category updated successfully!',
                        confirmButtonColor: '#2b6e2b'
                    }).then(() => {
                        window.location.href = "<?= base_url('category') ?>";
                    });
                } else if(response.errors) {
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
            error: function() {
                $('#submitBtn').prop('disabled', false).html('<i class="bi bi-pencil-square"></i> Update Category');
                Swal.fire('Error', 'Could not connect to the server. Please try again.', 'error');
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
