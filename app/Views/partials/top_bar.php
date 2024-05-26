<div class="container-fluid top-bar-background text-white p-2">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col d-flex align-items-center">
            <a href="<?= site_url('/') ?>">
                <img src="<?= base_url('assets/images/logo.png') ?>" class="img-fluid" alt="Logo" width="60">
            </a>
            <h3 class="ms-3 text-warning mb-0"><?= session()->get('restaurant_details')['name'] ?></h3>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <div class="d-none d-sm-block top-bar-watch me-3" id="top_watch">00:00:00</div>
            <a href="<?= site_url('/') ?>" class="btn btn-warning p-3">
                <i class="fa-solid fa-rotate fa-2xl"></i>
            </a>
        </div>
    </div>
</div>