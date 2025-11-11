<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- ✅ CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body { background-color: #f3f9f4; font-family: 'Poppins', sans-serif; }
.page-title { color: #1b7c3f; font-weight: 700; }
.btn-ecoswap { background-color: #1b7c3f; color: white; border-radius: 25px; }
.btn-ecoswap:hover { background-color: #155d30; }
.card { border: none; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
.table thead { background-color: #1b7c3f; color: white; }
.modal-header { background-color: #1b7c3f; color: white; }
.dataTables_wrapper .dataTables_filter input {
    border-radius: 25px;
    border: 1px solid #ccc;
    padding: 5px 10px;
}
</style>

<!-- ✅ PAGE CONTENT -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">📦 Category List</h3>
        <div class="d-flex gap-2">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-success rounded-pill">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
            <a href="<?= base_url('category/create') ?>" class="btn btn-ecoswap">
                <i class="fa-solid fa-plus me-2"></i>Add Category
            </a>
        </div>
    </div>

    <div class="card p-3">
        <table id="categoryTable" class="table table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>Category id</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $i => $cat): ?>
                        <tr data-id="<?= $cat['id'] ?>">
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($cat['name']) ?></td>
                            <td><?= esc($cat['description'] ?: '-') ?></td>
                            <td>
                                <span class="badge <?= $cat['status'] == 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($cat['status']) ?>
                                </span>
                            </td>
                            <td class="action-btn">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-info viewBtn" title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success editBtn" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger deleteBtn" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-muted">No categories found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ✅ View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fa-solid fa-eye me-2"></i>Category Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
            <h5 id="viewName" class="text-success"></h5>
            <p><strong>Description:</strong> <span id="viewDescription"></span></p>
            <p><strong>Status:</strong> <span id="viewStatus" class="badge bg-success"></span></p>
        </div>
    </div>
  </div>
</div>

<!-- ✅ Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-pen me-2"></i>Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editId">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" id="editName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" id="editDescription" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="editStatus" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- ✅ JS -->
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function() {
    // ✅ Initialize DataTable
    const table = $('#categoryTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 20, 50],
        language: {
            searchPlaceholder: "Search categories...",
            search: "",
        }
    });

    // ✅ View
    $(document).on('click', '.viewBtn', function() {
        const row = $(this).closest('tr');
        $('#viewName').text(row.find('td:eq(1)').text());
        $('#viewDescription').text(row.find('td:eq(2)').text());
        $('#viewStatus').text(row.find('td:eq(3)').text());
        $('#viewModal').modal('show');
    });

    // ✅ Edit
    $(document).on('click', '.editBtn', function() {
        const id = $(this).closest('tr').data('id');
        $.get("<?= base_url('category/edit') ?>/" + id, function(data) {
            $('#editId').val(data.id);
            $('#editName').val(data.name);
            $('#editDescription').val(data.description);
            $('#editStatus').val(data.status);
            $('#editModal').modal('show');
        }, 'json');
    });

    // ✅ Update AJAX
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('category/update') ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                Swal.fire({
                    icon: res.status === 'success' ? 'success' : 'error',
                    title: res.status === 'success' ? 'Updated!' : 'Error',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            },
            error: function() {
                Swal.fire('Error', 'Update failed. Try again.', 'error');
            }
        });
    });

    // ✅ Delete
    $(document).on('click', '.deleteBtn', function() {
        const id = $(this).closest('tr').data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This category will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b7c3f',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('category/delete') ?>/" + id,
                    method: "POST",
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            icon: res.status === 'success' ? 'success' : 'error',
                            title: res.status === 'success' ? 'Deleted!' : 'Error',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to delete category.', 'error');
                    }
                });
            }
        });
    });

    // ✅ Download
    $(document).on('click', '.downloadBtn', function() {
        const id = $(this).closest('tr').data('id');
        window.location.href = "<?= base_url('category/download') ?>/" + id;
    });
});
</script>

<?= $this->endSection() ?>
