<?php
require_once __DIR__ . '/config.php';
$cart = $_SESSION['cart'] ?? []; if (!$cart) redirect('cart.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify(); $shipping = $_POST['shipping'] === 'J&T' ? 'J&T' : 'SPX'; $shipCost = $shipping === 'J&T' ? 18000 : 15000; $total = array_sum(array_map(fn($i)=>$i['price']*$i['qty'], $cart));
    $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
    $pdo=db(); $pdo->beginTransaction();
    $stmt=$pdo->prepare('INSERT INTO orders(invoice_number,customer_name,phone,address,shipping_courier,shipping_cost,total,grand_total,status,notes) VALUES(?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute([$invoice,$_POST['name'],$_POST['phone'],$_POST['address'],$shipping,$shipCost,$total,$total+$shipCost,'pending',$_POST['notes'] ?? '']); $orderId=$pdo->lastInsertId();
    $itemStmt=$pdo->prepare('INSERT INTO order_items(order_id,product_id,product_name,price,qty,subtotal) VALUES(?,?,?,?,?,?)');
    foreach($cart as $i){ $itemStmt->execute([$orderId,$i['id'],$i['name'],$i['price'],$i['qty'],$i['price']*$i['qty']]); }
    $pdo->commit(); unset($_SESSION['cart']); redirect('invoice.php?invoice='.$invoice);
}
$title='Checkout - DENIADESIGN'; include __DIR__ . '/includes/header.php';
?>
<main class="container page"><h1>Checkout</h1><form method="post" class="row g-4"><input type="hidden" name="_csrf" value="<?= csrf_token() ?>"><div class="col-lg-7"><input class="form-control mb-3" name="name" placeholder="Nama lengkap" required><input class="form-control mb-3" name="phone" placeholder="Nomor WhatsApp" required><textarea class="form-control mb-3" name="address" placeholder="Alamat lengkap" required></textarea><select class="form-select mb-3" name="shipping"><option>SPX</option><option>J&T</option></select><textarea class="form-control" name="notes" placeholder="Catatan pesanan"></textarea></div><div class="col-lg-5"><div class="premium-card p-4"><h4>Ringkasan</h4><?php $total=0; foreach($cart as $i): $total+=$i['price']*$i['qty']; ?><div class="d-flex justify-content-between"><span><?= e($i['name']) ?> x <?= (int)$i['qty'] ?></span><span><?= money($i['price']*$i['qty']) ?></span></div><?php endforeach; ?><hr><button class="btn btn-light w-100 btn-lg">Buat Invoice</button></div></div></form></main><?php include __DIR__ . '/includes/footer.php'; ?>
