<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center my-5">

            <?php if (count($orders) === 0) : ?>
                <div class="col-12 text-center">
                    <p class="display-6 opacity-25 my-5">Não existem pedidos pendentes</p>
                    <a href="<?= site_url('/') ?>" class="btn btn-outline-warning p-4">
                        <i class="fas fa-sync-alt fa-2xl"></i>
                    </a>
                </div>
            <?php else : ?>
                <div class="col-12">
                    <div class="row">
                        <?php foreach ($orders as $order) : ?>
                            <?= view('partials/order_card', ['order' => $order]) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>