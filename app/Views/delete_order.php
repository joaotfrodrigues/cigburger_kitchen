<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-6 card border-warning bg-dark py-5">
            <div class="mb-5 text-center">
                <h1><i class="fa-solid fa-triangle-exclamation text-warning"></i></h1>
            </div>

            <div class="text-center display-6 text-white mb-5">Deseja remover o pedido?</div>

            <div class="d-flex justify-content-center flex-column flex-lg-row text-white display-6 mb-5 p-3">
                <div class="my-2 w-100 bg-warning text-black text-center rounded-3 px-3 me-5"><?= lead_zeros($order['order_number'], 3) ?></div>
                <div class="my-2 w-50 mx-auto text-center"><?= format_currency($order['total_price']) ?></div>
                <div class="my-2 w-100 text-center"><small><?= $order['order_date'] ?></small></div>
            </div>

            <div class="text-center">
                <a href="<?= site_url('/') ?>" class="btn btn-outline-danger px-5 mx-3 my-3"><h3>NÃO</h3></a>
                <a href="<?= site_url('/delete_order_confirm/' . Encrypt($order['id'])) ?>" class="btn btn-outline-danger px-5 mx-3"><h3>SIM</h3></a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>