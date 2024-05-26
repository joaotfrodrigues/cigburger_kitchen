<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10 col-md-6 card border-danger bg-dark py-5">
            <div class="mb-5 text-center">
                <h1><i class="fa-solid fa-times-circle text-danger"></i></h1>
            </div>

            <h4 class="text-center text-danger mb-3">Aconteceu um erro no pedido.</h4>
            <p class="text-center text-warning mb-5"><?= $error ?></p>
            
            <div class="text-center">
                <a href="<?= site_url('/') ?>" class="btn btn-outline-danger px-5 mx-3"><h3>Voltar</h3></a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>