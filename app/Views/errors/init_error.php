<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
            <h3 class="text-danger">Erro no aranque da aplicação</h3>
            <p><?= $error_message ?></p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>