<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- ✅ CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

<style>
    body { background-color: #f3f9f4; font-family: 'Poppins', sans-serif; }
    .navbar { background-color: #1b7c3f !important; }
    .navbar-brand { color: white !important; font-weight: bold; }
    .btn-ecoswap { background-color: #1b7c3f; color: white; border-radius: 25px; }
    .btn-ecoswap:hover { background-color: #155d30; }
    .card { border: none; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .table thead { background-color: #1b7c3f; color: white; }
    .status-badge { padding: 6px 12px; border-radius: 15px; color: white; }
    .status-pending { background-color: #ffc107; }
    .status-approved { background-color: #28a745; }
    .status-rejected { background-color: #dc3545; }
    .action-btn i { cursor: pointer; margin: 0 6px; font-size: 1.1rem; transition: .3s; }
    .action-btn i:hover { transform: scale(1.2); }
    .modal-header { background-color: #1b7c3f; color: white; }
    .filter-row select { border-radius: 25px; }
    .filter-row .btn { border-radius: 25px; }
</style>

<!-- ✅ Page Content -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">♻️ My Clothes</h3>
        <a href="<?= base_url('clothes/add') ?>" class="btn btn-ecoswap"><i class="fa-solid fa-plus me-2"></i>Add Clothes</a>
    </div>

    <!-- ✅ Filter -->
    <div class="row filter-row mb-4 p-3 bg-light rounded">
        <div class="col-md-3 mb-2">
            <select id="filterCategory" class="form-select select2">
                <option value="">All Categories</option>
                <option value="men">Men</option>
                <option value="women">Women</option>
                <option value="kids">Kids</option>
                <option value="winter">Winter</option>
                <option value="summer">Summer</option>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select id="filterCondition" class="form-select select2">
                <option value="">All Conditions</option>
                <option value="new">New</option>
                <option value="good">Good</option>
                <option value="used">Used</option>
                <option value="old">Old</option>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select id="filterStatus" class="form-select select2">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="col-md-3 mb-2 text-end">
            <button id="resetFilters" class="btn btn-outline-secondary"><i class="fa-solid fa-rotate-right me-1"></i>Reset</button>
        </div>
    </div>

    <!-- ✅ Data Table -->
    <div class="card">
        <div class="card-body">
            <table id="clothesTable" class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>Image</th>
                         <th>Name</th>
                        <th>Category</th>
                        <th>Condition</th>
                        <th>Status</th>
                        <th>Added On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="clothesBody">
                    <?php if (!empty($clothes)): ?>
                        <?php foreach ($clothes as $item): ?>
                            <tr data-id="<?= $item['id'] ?>">
                                <td><img src="<?= base_url('uploads/clothes/' . $item['image']) ?>" width="60" height="60" class="rounded-circle"></td>
                                 <td><?= esc($item['user_name']) ?></td>
                                <td><?= ucfirst($item['category']) ?></td>
                                <td><?= ucfirst($item['condition']) ?></td>
                                <td><span class="status-badge status-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span></td>
                                <td><?= date('d M Y', strtotime($item['created_at'])) ?></td>
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
                        <button class="btn btn-sm btn-secondary downloadBtn" title="Download">
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>
                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-muted">No clothes found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ✅ View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fa-solid fa-eye me-2"></i>Clothes Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
            <img id="viewImage" src="" class="rounded mb-3" width="150">
            <h5 id="viewCategory" class="text-success"></h5>
            <p><strong>Condition:</strong> <span id="viewCondition"></span></p>
            <p><strong>Status:</strong> <span id="viewStatus" class="badge bg-success"></span></p>
            <p><strong>Added On:</strong> <span id="viewDate"></span></p>
        </div>
    </div>
  </div>
</div>

<!-- ✅ Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-pen me-2"></i>Edit Clothes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editId">

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" id="editCategory" class="form-select" required>
                <option value="men">Men</option>
                <option value="women">Women</option>
                <option value="kids">Kids</option>
                <option value="winter">Winter</option>
                <option value="summer">Summer</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Condition</label>
            <select name="condition" id="editCondition" class="form-select" required>
                <option value="new">New</option>
                <option value="good">Good</option>
                <option value="used">Used</option>
                <option value="old">Old</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="editStatus" class="form-select" required>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload New Image (optional)</label>
            <input type="file" name="image" class="form-control">
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(function () {
    $('.select2').select2();
    const table = $('#clothesTable').DataTable();

    // ✅ View
    $(document).on('click', '.viewBtn', function() {
        const row = $(this).closest('tr');
        $('#viewImage').attr('src', row.find('img').attr('src'));
        $('#viewCategory').text(row.find('td:eq(1)').text());
        $('#viewCondition').text(row.find('td:eq(2)').text());
        $('#viewStatus').text(row.find('td:eq(3)').text());
        $('#viewDate').text(row.find('td:eq(4)').text());
        $('#viewModal').modal('show');
    });

    // ✅ Edit
    $(document).on('click', '.editBtn', function() {
        const id = $(this).closest('tr').data('id');
        $.get("<?= base_url('clothes/edit') ?>/" + id, function(data) {
            $('#editId').val(data.id);
            $('#editCategory').val(data.category);
            $('#editCondition').val(data.condition);
            $('#editModal').modal('show');
        }, 'json');
    });

    // ✅ Update AJAX
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: "<?= base_url('clothes/update') ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
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
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('clothes/delete') ?>/" + id,
                    method: "DELETE",
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
                        Swal.fire('Error', 'Failed to delete item.', 'error');
                    }
                });
            }
        });
    });

    // ✅ Status update (Approve / Reject / Pending)
    $(document).on('click', '.statusBtn', function() {
        const id = $(this).closest('tr').data('id');
        const newStatus = $(this).data('status');

        Swal.fire({
            title: 'Change Status?',
            text: `You are about to set status to "${newStatus}"`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('clothes/updateStatus') ?>/" + id, { status: newStatus }, function(res) {
                    Swal.fire({
                        icon: res.status === 'success' ? 'success' : 'error',
                        title: res.status === 'success' ? 'Updated!' : 'Error',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                }, 'json').fail(function() {
                    Swal.fire('Error', 'Failed to update status.', 'error');
                });
            }
        });
    });

    // ✅ Download
    $(document).on('click', '.downloadBtn', function() {
        const id = $(this).closest('tr').data('id');
        window.location.href = "<?= base_url('clothes/download') ?>/" + id;
    });

    // ✅ Filters
    $('.select2').on('change', function() {
        const category = $('#filterCategory').val();
        const condition = $('#filterCondition').val();
        const status = $('#filterStatus').val();
        $.get("<?= base_url('clothes/filter') ?>", { category, condition, status }, function(res) {
            $('#clothesBody').html(res);
        });
    });

    // ✅ Reset filters
    $('#resetFilters').on('click', function() {
        $('.select2').val('').trigger('change');
        location.reload();
    });
});

</script>

<?= $this->endSection() ?>
