<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/bootstrap.min.css') ?>">

    <!-- fontawesome -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/all.min.css') ?>">

    <!-- custom css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">

    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/png">
</head>

<body class="main-wrapper">
    <!-- top bar -->
    <?= $this->include('partials/top_bar') ?>

    <!-- content -->
    <?= $this->renderSection('content') ?>

    <!-- bootstrap -->
    <script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>

    <!-- js -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>