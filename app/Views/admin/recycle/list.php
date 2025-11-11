<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">♻️ Recycle Items</h3>
        <div>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-success">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
            <a href="<?= base_url('recycle/create') ?>" class="btn btn-success">
                <i class="fa-solid fa-plus me-2"></i>Add Item
            </a>
        </div>
    </div>

    <div class="card p-3 shadow-sm">
        <table id="recycleTable" class="table table-bordered table-hover text-center align-middle">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>User name</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Weight</th>
                    <th>Status</th>
                    <th>Reward</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $i => $item): ?>
                        <tr data-id="<?= $item['id'] ?>">
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($item['user_name']) ?></td>
                            <td><?= esc($item['item_name']) ?></td>
                            <td><?= esc($item['category']) ?></td>
                            <td><?= esc($item['weight']) ?> kg</td>
                            <td>
                                <span class="badge 
                                    <?= $item['status'] == 'approved' ? 'bg-success' : 
                                        ($item['status'] == 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                                    <?= ucfirst($item['status']) ?>
                                </span>
                            </td>
                            <td><i class="fa-solid fa-coins text-warning me-1"></i><?= esc($item['reward_coins']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-info viewBtn"><i class="fa-solid fa-eye"></i></button>
                                    <button class="btn btn-sm btn-success editBtn"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-sm btn-danger deleteBtn"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-muted">No recycle items found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Edit Recycle Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editId">
        <div class="mb-2"><label>User ID</label><input type="number" class="form-control" name="user_id" id="editUserId"></div>
        <div class="mb-2"><label>Item Name</label><input type="text" class="form-control" name="item_name" id="editItemName"></div>
        <div class="mb-2"><label>Category</label><input type="text" class="form-control" name="category" id="editCategory"></div>
        <div class="mb-2"><label>Weight (kg)</label><input type="number" step="0.01" class="form-control" name="weight" id="editWeight"></div>
        <div class="mb-2"><label>Status</label>
            <select name="status" id="editStatus" class="form-select">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="mb-2"><label>Reward Coins</label><input type="number" class="form-control" name="reward_coins" id="editReward"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function() {
    $('#recycleTable').DataTable();

    // Edit
    $(document).on('click', '.editBtn', function() {
        const id = $(this).closest('tr').data('id');
        $.get("<?= base_url('recycle/edit') ?>/" + id, function(data) {
            $('#editId').val(data.id);
            $('#editUserId').val(data.user_id);
            $('#editItemName').val(data.item_name);
            $('#editCategory').val(data.category);
            $('#editWeight').val(data.weight);
            $('#editStatus').val(data.status);
            $('#editReward').val(data.reward_coins);
            $('#editModal').modal('show');
        }, 'json');
    });

    // Update
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('recycle/update') ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                Swal.fire({
                    icon: res.status,
                    title: res.status === 'success' ? 'Updated!' : 'Error',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            }
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function() {
        const id = $(this).closest('tr').data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This recycle item will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('recycle/delete') ?>/" + id,
                    method: "POST",
                    success: function(res) {
                        Swal.fire({
                            icon: res.status,
                            title: res.status === 'success' ? 'Deleted!' : 'Error',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    }
                });
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
