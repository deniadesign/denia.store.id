<?php
require_once __DIR__ . '/config.php';
$title = 'DENIADESIGN - Premium Store';
try {
    $banners = db()->query("SELECT * FROM banners WHERE is_active=1 ORDER BY sort_order, id DESC")->fetchAll();
    $categories = db()->query("SELECT * FROM categories ORDER BY name")->fetchAll();
    $products = db()->query("SELECT p.*, c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.is_active=1 ORDER BY p.id DESC LIMIT 12")->fetchAll();
} catch (Throwable $e) { $banners = $categories = $products = []; }
include __DIR__ . '/includes/header.php';
?>
<header class="hero d-flex align-items-center">
  <div class="container py-5">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="badge rounded-pill text-bg-light mb-3">Premium Indonesian Design Store</span>
        <h1 class="display-3 fw-black">DENIADESIGN untuk gaya yang berkelas.</h1>
        <p class="lead text-light-emphasis">Temukan koleksi pilihan, checkout cepat via WhatsApp, dan pengiriman SPX atau J&T ke seluruh Indonesia.</p>
        <a href="#produk" class="btn btn-light btn-lg me-2">Belanja Sekarang</a>
        <a href="about.php" class="btn btn-outline-light btn-lg">Tentang Kami</a>
      </div>
      <div class="col-lg-5">
        <div id="heroCarousel" class="carousel slide premium-card" data-bs-ride="carousel">
          <div class="carousel-inner rounded-4">
            <?php if ($banners): foreach ($banners as $i => $banner): ?>
              <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>"><img src="<?= e($banner['image']) ?>" class="d-block w-100" alt="<?= e($banner['title']) ?>"><div class="carousel-caption"><h5><?= e($banner['title']) ?></h5><p><?= e($banner['subtitle']) ?></p></div></div>
            <?php endforeach; else: ?>
              <div class="carousel-item active"><img src="product-placeholder.jpg" class="d-block w-100" alt="DENIADESIGN"><div class="carousel-caption"><h5>Koleksi Premium</h5><p>Produk terbaik untuk pelanggan terbaik.</p></div></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<section class="container py-5" id="kategori"><div class="d-flex flex-wrap gap-2"><?php foreach ($categories as $cat): ?><span class="badge category-pill"><?= e($cat['name']) ?></span><?php endforeach; ?></div></section>
<section class="container py-5" id="produk">
  <div class="d-flex justify-content-between align-items-end mb-4"><div><p class="text-warning fw-semibold">Koleksi Terbaru</p><h2 class="display-6 fw-bold">Produk Pilihan</h2></div></div>
  <div class="row g-4">
    <?php if ($products): foreach ($products as $product): ?>
      <div class="col-md-6 col-lg-4"><div class="product-card h-100"><img src="<?= e($product['image'] ?: 'product-placeholder.jpg') ?>" alt="<?= e($product['name']) ?>"><div class="p-4"><small class="text-warning"><?= e($product['category_name']) ?></small><h3 class="h5 mt-2"><?= e($product['name']) ?></h3><p class="text-secondary"><?= e(substr($product['description'],0,95)) ?></p><div class="d-flex justify-content-between align-items-center"><strong><?= money($product['price']) ?></strong><a class="btn btn-outline-light" href="product.php?id=<?= (int)$product['id'] ?>">Detail</a></div></div></div></div>
    <?php endforeach; else: ?>
      <div class="col"><div class="alert alert-dark border-warning">Produk belum tersedia. Import database.sql untuk data contoh.</div></div>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
