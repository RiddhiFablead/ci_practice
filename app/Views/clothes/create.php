<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Clothes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Add Clothes</h3>
        <a href="<?= base_url('clothes') ?>" class="btn btn-secondary">Back</a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('clothes/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="category" class="form-label">Category *</label>
            <select name="category" id="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <option value="men">Men</option>
                <option value="women">Women</option>
                <option value="kids">Kids</option>
                <option value="winter">Winter</option>
                <option value="summer">Summer</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="condition" class="form-label">Condition *</label>
            <select name="condition" id="condition" class="form-control" required>
                <option value="">-- Select Condition --</option>
                <option value="new">New</option>
                <option value="good">Good</option>
                <option value="used">Used</option>
                <option value="old">Old</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Upload Image *</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
