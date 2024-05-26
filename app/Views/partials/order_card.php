<div class="col-xxl-4 col-lg-6 col-12">
    <div class="order-wrapper">
        <div class="order-top-bar"></div>

        <div class="d-flex order-content justify-content-between" style="background-color: <?= order_color($order['order_number']) ?>">
            <!-- order number -->
            <div class="order-content-item order-content-number text-center">
                <?= lead_zeros(define_order_number_from_last_order_number($order['order_number']), 3) ?>
            </div>
            <!-- order total items -->
            <div class="order-content-item ms-2 order-content-total-items d-flex align-items-center justify-content-center">
                <?= $order['total_items'] ?> items
            </div>
            <!-- date time order -->
            <div class="order-content-item ms-2 order-content-date-time d-flex align-items-center justify-content-center">
                <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?>
            </div>
            <!-- delete order -->
            <a href="<?= site_url('/delete_order/' . Encrypt($order['id'])) ?>" class="ms-2 btn btn-danger p-3 px-4 d-flex align-items-center justify-content-center">
                <i class="fa-regular fa-trash-can fa-2x"></i>
            </a>
            <!-- handle the order -->
            <a href="#" class="ms-2 btn btn-success p-3 px-4 d-flex align-items-center justify-content-center">
                <i class="fa-regular fa-hand-point-right fa-2x"></i>
            </a>
        </div>
    </div>
</div>