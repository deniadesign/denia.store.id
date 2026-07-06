<?php
require_once __DIR__ . '/config.php';
$invoice=$_GET['invoice'] ?? ''; $stmt=db()->prepare('SELECT * FROM orders WHERE invoice_number=?'); $stmt->execute([$invoice]); $order=$stmt->fetch(); if(!$order){http_response_code(404);exit('Invoice tidak ditemukan');}
$items=db()->prepare('SELECT * FROM order_items WHERE order_id=?'); $items->execute([$order['id']]); $rows=$items->fetchAll();
$msg="Halo DENIADESIGN, saya ingin checkout invoice {$order['invoice_number']}%0A"; foreach($rows as $r){$msg.='- '.rawurlencode($r['product_name']).' x '.$r['qty'].'%0A';} $msg.='Total: '.rawurlencode(money($order['grand_total']));
$title='Invoice '.$invoice; include __DIR__ . '/includes/header.php';
?>
<main class="container page"><div class="premium-card p-4"><h1>Invoice <?= e($order['invoice_number']) ?></h1><p>Status: <span class="badge text-bg-warning"><?= e($order['status']) ?></span></p><p><?= e($order['customer_name']) ?> - <?= e($order['phone']) ?><br><?= e($order['address']) ?></p><table class="table table-dark"><tr><th>Produk</th><th>Qty</th><th>Subtotal</th></tr><?php foreach($rows as $r): ?><tr><td><?= e($r['product_name']) ?></td><td><?= (int)$r['qty'] ?></td><td><?= money($r['subtotal']) ?></td></tr><?php endforeach; ?></table><p>Kurir: <?= e($order['shipping_courier']) ?> (<?= money($order['shipping_cost']) ?>)</p><h3>Grand Total <?= money($order['grand_total']) ?></h3><a class="btn btn-success btn-lg" target="_blank" href="https://wa.me/<?= WA_NUMBER ?>?text=<?= $msg ?>">Konfirmasi WhatsApp</a></div></main><?php include __DIR__ . '/includes/footer.php'; ?>
