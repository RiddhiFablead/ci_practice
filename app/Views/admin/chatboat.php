<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="container">
  <h4 class="mb-4"><i class="bi bi-robot text-success"></i> Chatbot</h4>

  <div class="card shadow-sm">
    <div class="card-body">
      <form action="<?= base_url('chatbot/send') ?>" method="post">
        <div class="input-group">
          <input type="text" name="message" class="form-control" placeholder="Ask something..." required>
          <button class="btn btn-success" type="submit">Send</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
