<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card eco-card p-4 text-center">
      <i class="bi bi-recycle fs-1 text-success"></i>
      <h5 class="mt-2">Total Clothes Donated</h5>
      <h3><?= esc($totalClothes) ?></h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card eco-card p-4 text-center">
      <i class="bi bi-clock-history fs-1 text-warning"></i>
      <h5 class="mt-2">Pending Approval</h5>
      <h3><?= esc($pendingClothes) ?></h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card eco-card p-4 text-center">
      <i class="bi bi-check-circle fs-1 text-success"></i>
      <h5 class="mt-2">Approved Donations</h5>
      <h3><?= esc($approvedClothes) ?></h3>
    </div>
  </div>
</div>

<div class="card mt-5 p-4 text-center">
  <h4 class="fw-bold text-success">Welcome to EcoSwap 🌿</h4>
  <p class="text-muted mb-3">Turn your old clothes into new opportunities. Reuse. Earn. Save the planet.</p>
  <a href="<?= base_url('clothes/add') ?>" class="btn btn-success me-2"><i class="bi bi-plus-circle"></i> Donate Clothes</a>
  <a href="<?= base_url('coins') ?>" class="btn btn-outline-success"><i class="bi bi-coin"></i> View Coins</a>
  <a href="<?= base_url('chatbot') ?>" class="btn btn-outline-success"><i class="bi bi-chat-dots"></i> Chat with EcoBot</a>
</div>

<?= $this->endSection() ?>
