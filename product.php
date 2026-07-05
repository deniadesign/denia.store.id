<?php
require_once __DIR__ . '/config.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT p.*, c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.is_active=1');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) { http_response_code(404); exit('Produk tidak ditemukan'); }
$title = $product['name'] . ' - DENIADESIGN'; include __DIR__ . '/includes/header.php';
?>
<main class="container product-detail"><div class="row g-5"><div class="col-lg-6"><img class="w-100 rounded-4" src="<?= e($product['image'] ?: 'product-placeholder.jpg') ?>" alt="<?= e($product['name']) ?>"></div><div class="col-lg-6"><span class="text-warning"><?= e($product['category_name']) ?></span><h1><?= e($product['name']) ?></h1><p class="lead"><?= e($product['description']) ?></p><h2><?= money($product['price']) ?></h2><form method="post" action="cart.php"><input type="hidden" name="_csrf" value="<?= csrf_token() ?>"><input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>"><label class="form-label">Jumlah</label><input class="form-control w-25 mb-3" type="number" name="qty" value="1" min="1" max="<?= (int)$product['stock'] ?>"><button class="btn btn-light btn-lg" name="add" value="1">Tambah ke Keranjang</button></form></div></div></main>
<?php include __DIR__ . '/includes/footer.php'; ?>
