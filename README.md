# DENIADESIGN E-Commerce

Website e-commerce profesional berbasis PHP 8 Native, MySQL, Bootstrap 5, HTML5, CSS3, dan JavaScript.

## Fitur
- Landing page premium dengan banner dinamis
- Login dan dashboard admin
- CRUD produk, kategori, dan banner
- Upload gambar JPG/PNG/WEBP
- Keranjang belanja, checkout, invoice
- WhatsApp checkout ke `083822941348`
- Pilihan jasa kirim SPX dan J&T
- Halaman Contact dan About
- Meta SEO dasar, canonical, Open Graph
- `.htaccess` siap hosting

## Instalasi
1. Upload semua file ke hosting PHP 8.
2. Buat database MySQL lalu import `database.sql`.
3. Atur kredensial database di `config.php` atau environment variable `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
4. Pastikan folder `uploads/` writable.
5. Login admin di `/admin/login.php`.

## Akun Admin Demo
- Email: `admin@deniadesign.id`
- Password: `admin123`

## Struktur Penting
- `index.php` landing page dan katalog.
- `admin/` dashboard dan CRUD.
- `cart.php`, `checkout.php`, `invoice.php` alur belanja.
- `database.sql` skema dan data awal.
