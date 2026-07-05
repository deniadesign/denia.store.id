<?php
require_once __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    if (isset($_POST['add'])) {
        $id = (int)$_POST['product_id']; $qty = max(1, (int)$_POST['qty']);
        $stmt = db()->prepare('SELECT id,name,price,image,stock FROM products WHERE id=? AND is_active=1'); $stmt->execute([$id]); $p=$stmt->fetch();
        if ($p) { $_SESSION['cart'][$id] = ['id'=>$id,'name'=>$p['name'],'price'=>$p['price'],'image'=>$p['image'],'qty'=>(($_SESSION['cart'][$id]['qty'] ?? 0)+$qty)]; }
    }
    if (isset($_POST['remove'])) { unset($_SESSION['cart'][(int)$_POST['remove']]); }
    redirect('cart.php');
}
$title='Keranjang - DENIADESIGN'; include __DIR__ . '/includes/header.php'; $cart=$_SESSION['cart'] ?? []; $total=0;
?>
<main class="container page"><h1>Keranjang Belanja</h1><?php if(!$cart): ?><div class="alert alert-dark">Keranjang kosong.</div><?php else: ?><div class="table-responsive"><table class="table table-dark align-middle"><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th></th></tr><?php foreach($cart as $item): $sub=$item['price']*$item['qty']; $total+=$sub; ?><tr><td><?= e($item['name']) ?></td><td><?= money($item['price']) ?></td><td><?= (int)$item['qty'] ?></td><td><?= money($sub) ?></td><td><form method="post"><input type="hidden" name="_csrf" value="<?= csrf_token() ?>"><button class="btn btn-sm btn-outline-danger" name="remove" value="<?= (int)$item['id'] ?>">Hapus</button></form></td></tr><?php endforeach; ?></table></div><div class="text-end"><h3>Total <?= money($total) ?></h3><a class="btn btn-light btn-lg" href="checkout.php">Checkout</a></div><?php endif; ?></main><?php include __DIR__ . '/includes/footer.php'; ?>
