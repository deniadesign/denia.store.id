<?php require_once __DIR__ . '/../config.php'; ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="DENIADESIGN adalah toko e-commerce premium untuk produk fashion dan desain berkualitas dengan checkout WhatsApp cepat.">
  <meta name="keywords" content="DENIADESIGN, e-commerce, fashion, desain, toko online">
  <meta name="author" content="DENIADESIGN">
  <meta property="og:title" content="<?= e($title ?? APP_NAME) ?>">
  <meta property="og:description" content="Belanja produk premium DENIADESIGN dengan pengiriman SPX dan J&T.">
  <meta property="og:type" content="website">
  <title><?= e($title ?? APP_NAME) ?></title>
  <link rel="canonical" href="<?= e(APP_URL . ($_SERVER['REQUEST_URI'] ?? '/')) ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top glass-nav">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">DENIA<span>DESIGN</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="index.php#produk">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        <li class="nav-item"><a class="btn btn-light ms-lg-3" href="cart.php">Keranjang (<?= cart_count() ?>)</a></li>
      </ul>
    </div>
  </div>
</nav>
