<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

define('APP_NAME', 'DENIADESIGN');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost/Denia.store.id');
define('WA_NUMBER', '6283822941348');

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'deniadesign');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}

function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function money(int|float $value): string { return 'Rp' . number_format((float)$value, 0, ',', '.'); }
function redirect(string $path): never { header('Location: ' . $path); exit; }
function csrf_token(): string { $_SESSION['_csrf'] ??= bin2hex(random_bytes(32)); return $_SESSION['_csrf']; }
function csrf_verify(): void { if (($_POST['_csrf'] ?? '') !== ($_SESSION['_csrf'] ?? null)) { http_response_code(419); exit('CSRF token tidak valid.'); } }
function is_admin(): bool { return isset($_SESSION['admin_id']); }
function require_admin(): void { if (!is_admin()) { redirect('admin/login.php'); } }
function upload_image(string $field, ?string $old = null): ?string {
    if (empty($_FILES[$field]['name'])) { return $old; }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) { throw new RuntimeException('Upload gambar gagal.'); }
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = mime_content_type($_FILES[$field]['tmp_name']);
    if (!isset($allowed[$mime])) { throw new RuntimeException('Format gambar harus JPG, PNG, atau WEBP.'); }
    $dir = __DIR__ . '/uploads';
    if (!is_dir($dir)) { mkdir($dir, 0755, true); }
    $name = date('YmdHis') . '-' . bin2hex(random_bytes(5)) . '.' . $allowed[$mime];
    move_uploaded_file($_FILES[$field]['tmp_name'], $dir . '/' . $name);
    return 'uploads/' . $name;
}
function cart_count(): int { return array_sum(array_column($_SESSION['cart'] ?? [], 'qty')); }
