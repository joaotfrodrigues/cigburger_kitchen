<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-11">
            <!-- general order information -->
            <div class="row">
                <div class="d-flex gap-4 flex-column flex-md-row justify-content-between border-1 mb-4">
                    <a href="<?= site_url('/') ?>" class="btn btn-outline-warning p-4">
                        <i class="fas fa-chevron-left fa-2xl"></i>
                    </a>
                    <div class="order-details-info" style="background-color: <?= order_color($order_details['order_number']) ?>">Pedido nº <?= lead_zeros($order_details['order_number'], 3) ?></div>
                    <div class="order-details-info" style="background-color: <?= order_color($order_details['order_number']) ?>">Total de produtos: <?= $order_details['total_items'] ?></div>
                    <div class="order-details-info" style="background-color: <?= order_color($order_details['order_number']) ?>">Data: <?= $order_details['order_date'] ?></div>
                    <div class="order-details-info" style="background-color: <?= order_color($order_details['order_number']) ?>">Preço total: <?= format_currency($order_details['total_price']) ?></div>
                </div>
            </div>

            <!-- order products -->
            <div class="row mt-5" id="products-wrapper">
                <h3>Produtos</h3>
                <hr>
                <?php foreach ($order_products as $product) : ?>
                    <div class="mb-3 order-product-item">
                        <input type="checkbox" name="check_product-<?= $product['id'] ?>" id="check_product-<?= $product['id'] ?>">
                        <label class="ms-2" for="check_product-<?= $product['id'] ?>">
                            <span class="text-warning"><strong><?= $product['quantity'] ?></strong></span>
                            <span class="mx-2">x</span>
                            <span><?= $product['product_name'] ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- order actions -->
            <div class="my-5 d-flex gap-4 flex-column flex-md-row flex-wrap">
                <!-- cancel -->
                <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary p-2 px-5 m-2">
                    <h3><i class="fas fa-chevron-left me-3"></i>Cancelar</h3>
                </a>

                <!-- check all -->
                <div class="btn btn-outline-secondary p-2 px-5 m-2" id="check_all">
                    <h3><i class="fas fa-check-double me-3"></i>Marcar todos</h3>
                </div>

                <!-- finalize -->
                <a id="finalize" href="<?= site_url('/handle_order_confirm/' . Encrypt($order_details['id'])) ?>" class="btn btn-outline-success p-2 px-5 m-2 disabled">
                    <h3><i class="fas fa-check me-3"></i>Finalizar</h3>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Get the element with the ID 'products-wrapper', which contains the checkboxes.
    const productsWrapper = document.getElementById('products-wrapper');

    // Find all input elements of type 'checkbox' within 'products-wrapper'.
    const productsCheckboxes = productsWrapper.querySelectorAll('input[type="checkbox"]');

    // Add an event listener to the element with the ID 'check_all'.
    // This listener will execute the provided function when the element is clicked.
    document.getElementById('check_all').addEventListener('click', () => {
        // Loop through each checkbox in the 'productsCheckboxes' NodeList.
        productsCheckboxes.forEach(checkbox => {
            // Check the current state of each checkbox.
            if (checkbox.checked) {
                // If the checkbox is checked, uncheck it.
                checkbox.checked = false;
            } else {
                // If the checkbox is not checked, check it.
                checkbox.checked = true;
            }
        });

        // Call the verifyCheckboxes function to update the state of the finalize button.
        verifyCheckboxes();
    });

    /**
     * Checks the state of all checkboxes and updates the 'finalize' button.
     * If all checkboxes are checked, the 'finalize' button is enabled.
     * If any checkbox is unchecked, the 'finalize' button is disabled.
     */
    function verifyCheckboxes() {
        var allChecked = true; // Flag to track if all checkboxes are checked.

        // Loop through each checkbox to check their state.
        productsCheckboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                // If any checkbox is not checked, set the flag to false.
                allChecked = false;
            }
        });

        // Update the 'finalize' button based on the state of the checkboxes.
        if (allChecked) {
            finalizeBtn.classList.remove('disabled'); // Enable the 'finalize' button.
        } else {
            if (!finalizeBtn.classList.contains('disabled')) {
                finalizeBtn.classList.add('disabled'); // Disable the 'finalize' button.
            }
        }
    }

    // Get the element with the ID 'finalize'.
    const finalizeBtn = document.getElementById('finalize');

    // Add a change event listener to each checkbox.
    productsCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            // Call the verifyCheckboxes function to update the state of the finalize button.
            verifyCheckboxes();
        });
    });
</script>

<?= $this->endSection() ?>