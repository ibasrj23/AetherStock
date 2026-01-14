# Product Management System

Sistem CRUD untuk manajemen produk dengan PHP, JavaScript, dan MySQL.

## Fitur Utama

✅ **Autentikasi Login** - Form login dengan validasi
✅ **CRUD Produk** - Tambah, lihat, edit, dan hapus produk
✅ **Validasi Quantity** - Quantity minimal 1, tidak boleh minus atau nol
✅ **Dashboard** - Tampilan statistik dan daftar produk
✅ **Responsive UI** - Desain modern dan mobile-friendly
✅ **Session Management** - Timeout otomatis 30 menit

## Struktur Project

```
project-ukk/
├── index.php              # Dashboard utama
├── login.php              # Halaman login
├── logout.php             # Logout & session destroy
├── add_product.php        # Form tambah produk
├── edit_product.php       # Form edit produk
├── delete_product.php     # Hapus produk
├── db_setup.sql           # Script setup database
├── includes/
│   ├── db.php             # Konfigurasi database
│   └── session.php        # Session check & timeout
└── assets/
    ├── css/
    │   └── style.css      # Styling responsive
    └── js/
        └── script.js      # Validasi & konfirmasi
```

## Instalasi

### 1. Setup Database

```sql
-- Buka MySQL dan jalankan script berikut:
CREATE DATABASE IF NOT EXISTS product_crud;
USE product_crud;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  quantity INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert user demo
INSERT INTO users (username, email, password) VALUES 
('user1', 'user1@example.com', '$2y$10$K2Y1ZpP3e2L4I5T6G7D8g.xV8H9K0M1N2O3P4Q5R6S7T8');
```

### 2. Konfigurasi Database

Edit file `includes/db.php`:
```php
define('DB_HOST', 'localhost');   // Host database
define('DB_USER', 'root');        // Username MySQL
define('DB_PASS', '');            // Password MySQL
define('DB_NAME', 'product_crud'); // Nama database
```

### 3. Jalankan Server

```bash
# Gunakan PHP Built-in Server
php -S localhost:8000

# atau gunakan XAMPP/WAMP/LAMP
# Akses via http://localhost/project-ukk
```

## Kredensial Demo Login

- **Username:** user1
- **Password:** password123

## Fitur Keamanan

✅ **Password Hashing** - Menggunakan bcrypt
✅ **SQL Injection Prevention** - Prepared statements
✅ **Session Security** - Auto logout after 30 minutes
✅ **User Authorization** - Hanya bisa lihat produk milik sendiri
✅ **Form Validation** - Server & client side validation

## Validasi Quantity

- **Minimal:** 1 (tidak boleh 0 atau minus)
- **Tipe:** Integer
- **Pesan Error:** Ditampilkan jika kurang dari 1

## Fitur CRUD

### CREATE (Tambah Produk)
- Klik tombol "+ Tambah Produk"
- Isi form dengan validasi:
  - Nama produk (required)
  - Harga > 0 (required)
  - Quantity >= 1 (required)
  - Deskripsi (opsional)
- Klik "Simpan Produk"

### READ (Lihat Produk)
- Dashboard menampilkan semua produk dalam tabel
- Menampilkan: Nama, Harga, Quantity, Total
- Stats box: Total produk, total quantity, total nilai

### UPDATE (Edit Produk)
- Klik tombol "Edit" pada produk yang ingin diubah
- Ubah data sesuai kebutuhan
- Klik "Perbarui Produk"

### DELETE (Hapus Produk)
- Klik tombol "Hapus" pada produk
- Konfirmasi penghapusan
- Produk dihapus dari database

## Teknologi

- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Security:** Bcrypt Password Hashing

## Tips Penggunaan

1. **Login:** Gunakan kredensial demo untuk akses awal
2. **Tambah Produk:** Pastikan quantity minimal 1
3. **Validasi Client:** JavaScript akan memperingatkan jika input tidak valid
4. **Auto Logout:** Sesi akan berakhir setelah 30 menit tidak aktif
5. **Responsive:** Akses dari mobile/tablet, UI akan menyesuaikan

## Troubleshooting

### Database Connection Error
- Pastikan MySQL server berjalan
- Cek kredensial di `includes/db.php`
- Pastikan database sudah dibuat

### Session Error
- Pastikan `session.save_path` writable di `php.ini`
- Clear cookies browser jika ada masalah

### File Not Found
- Pastikan struktur folder sesuai
- Cek path file di HTML/PHP

## Lisensi

Free to use untuk keperluan pembelajaran.
