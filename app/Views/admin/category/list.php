<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.page-title { color: #2b6e2b; font-weight: 600; text-align: center; font-size: 26px; margin-bottom: 30px; }
.btn-ecoswap { background-color: #2b6e2b; color: white; border-radius: 30px; padding: 8px 25px; font-weight: 600; border: none; }
.btn-ecoswap:hover { background-color: #1e4b1e; }
.table thead { background-color: #e8f5e9; color: #2b6e2b; }
.table tbody tr:hover { background-color: #f4f8f4; }
.actions button { border: none; background: none; cursor: pointer; margin: 0 4px; }
.actions i { font-size: 18px; }
.actions .edit { color: #2e7d32; }
.actions .delete { color: #c62828; }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">📦 Category List</h3>
        <a href="<?= base_url('category/create') ?>" class="btn btn-ecoswap">
            <i class="bi bi-plus-circle"></i> Add Category
        </a>
    </div>

    <div class="card p-3 shadow-sm">
        <table class="table table-striped table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>Category_id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $i => $cat): ?>
                        <tr data-id="<?= $cat['id'] ?>">
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($cat['name']) ?></td>
                            <td><?= esc($cat['description']) ?: '-' ?></td>
                            <td>
                                <?php if ($cat['status'] === 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($cat['created_at'] ?? '-') ?></td>
                            <td class="actions">
                                <a href="<?= base_url('category/edit/' . $cat['id']) ?>" class="edit" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-muted">No categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).on('click', '.delete', function(){
    const row = $(this).closest('tr');
    const id = row.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This category will be deleted permanently!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2b6e2b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: "<?= base_url('category/delete/') ?>" + id,
                type: 'POST', // ✅ matches route
                dataType: 'json',
                success: function(res){
                    if(res.status === 'success'){
                        Swal.fire('Deleted!', res.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function(){
                    Swal.fire('Error', 'Could not delete the category.', 'error');
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>
