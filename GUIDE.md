# 📦 Product Management System - Panduan Lengkap

Sistem CRUD berbasis web untuk manajemen produk dengan fitur login, built with PHP, JavaScript, dan MySQL.

---

## 🎯 Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| ✅ **Login Aman** | Form login dengan password hashing |
| ✅ **CRUD Produk** | Tambah, lihat, edit, dan hapus produk |
| ✅ **Validasi Quantity** | Minimal 1, tidak boleh 0 atau minus |
| ✅ **Dashboard** | Tampilkan statistik dan daftar produk |
| ✅ **Responsive Design** | Mobile-friendly dan modern UI |
| ✅ **Session Management** | Auto logout setelah 30 menit idle |
| ✅ **Security** | Prepared statements, password hashing |

---

## 📁 Struktur Project

```
project-ukk/
│
├── 📄 index.php              ← Dashboard utama (setelah login)
├── 📄 login.php              ← Halaman login
├── 📄 logout.php             ← Logout & session destroy
├── 📄 setup.php              ← Setup database otomatis
│
├── 📄 add_product.php        ← Form tambah produk baru
├── 📄 edit_product.php       ← Form edit produk
├── 📄 delete_product.php     ← Proses hapus produk
│
├── 📄 db_setup.sql           ← SQL script (manual setup)
├── 📄 README.md              ← Dokumentasi singkat
├── 📄 GUIDE.md               ← Panduan lengkap (file ini)
├── 📄 .gitignore             ← Git ignore file
│
├── 📁 includes/              ← Include files
│   ├── 📄 db.php             ← Database config & connection
│   └── 📄 session.php        ← Session check & timeout
│
└── 📁 assets/                ← Static files
    ├── 📁 css/
    │   └── 📄 style.css      ← Styling global (responsive)
    └── 📁 js/
        └── 📄 script.js      ← Validasi & konfirmasi delete
```

---

## 🚀 Instalasi & Setup

### Langkah 1: Persiapan

1. **Copy folder project** ke direktori web server:
   - XAMPP: `C:\xampp\htdocs\project-ukk`
   - WAMP: `C:\wamp64\www\project-ukk`
   - PHP Built-in: Anywhere

2. **Pastikan MySQL/Database Running**

### Langkah 2: Setup Database (2 Pilihan)

#### **PILIHAN A: Setup Otomatis (Recommended)**

1. Buka browser: `http://localhost:8000/setup.php` (atau sesuai server Anda)
2. Form akan terisi otomatis dengan default config
3. Klik tombol **"🚀 Setup Database"**
4. Tunggu hingga muncul pesan sukses ✅

#### **PILIHAN B: Setup Manual (SQL)**

1. Buka MySQL Console atau PhpMyAdmin
2. Copy-paste script dari `db_setup.sql`
3. Execute script
4. Database dan tabel akan terbuat otomatis

### Langkah 3: Konfigurasi (Opsional)

Edit file `includes/db.php` jika MySQL config berbeda:

```php
define('DB_HOST', 'localhost');   // Host database
define('DB_USER', 'root');        // Username MySQL  
define('DB_PASS', '');            // Password MySQL (kosong jika tidak ada)
define('DB_NAME', 'product_crud'); // Nama database
```

### Langkah 4: Jalankan Server

**Pilihan 1: PHP Built-in Server**
```bash
cd d:\project-ukk
php -S localhost:8000
# Akses: http://localhost:8000/login.php
```

**Pilihan 2: XAMPP/WAMP**
- Letakkan folder di `htdocs` atau `www`
- Jalankan Apache & MySQL
- Akses: `http://localhost/project-ukk/login.php`

---

## 🔐 Login

### Kredensial Demo

```
Username: user1
Password: password123
```

Setelah login:
1. Anda akan diarahkan ke **Dashboard** (`index.php`)
2. Di sini bisa melihat statistik dan daftar produk
3. Klik **"+ Tambah Produk"** untuk membuat produk baru

---

## 📝 Panduan Penggunaan

### 1. **TAMBAH PRODUK** (CREATE)

**Path:** `add_product.php` (Klik "+ Tambah Produk" di Dashboard)

**Form Fields:**
- **Nama Produk** (required)
  - Contoh: "Laptop Lenovo"
- **Deskripsi** (optional)
  - Contoh: "Laptop performa tinggi, RAM 8GB"
- **Harga** (required, > 0)
  - Format: Rp (currency)
  - Contoh: 5000000
- **Quantity** (required, >= 1)
  - Minimal: 1
  - Contoh: 10

**Validasi:**
- ✅ Nama tidak boleh kosong
- ✅ Harga harus > 0 (tidak boleh 0)
- ✅ Quantity harus >= 1 (tidak boleh 0 atau minus)
- ✅ Pesan error ditampilkan jika validasi gagal

**Setelah Submit:**
- Data tersimpan di database
- Redirect ke dashboard dengan pesan success
- Produk langsung tampil di tabel

---

### 2. **LIHAT PRODUK** (READ)

**Path:** `index.php` (Dashboard)

**Tampilan:**
- **Stats Box:** Total produk, total quantity, total nilai
- **Tabel Produk:** Berisi:
  - No. urut
  - Nama produk
  - Harga (format Rp)
  - Quantity (badge dengan warna)
  - Total (Harga × Quantity)
  - Deskripsi (preview)
  - Tombol Aksi (Edit, Hapus)

**Filter & Sorting:**
- Produk ditampilkan berdasarkan user yang login
- Diurutkan dari yang terbaru (created_at DESC)

---

### 3. **EDIT PRODUK** (UPDATE)

**Path:** `edit_product.php?id=X` (Klik tombol "Edit" di tabel)

**Form Fields:**
- Sama seperti form tambah produk
- Data sebelumnya sudah terisi otomatis

**Validasi:**
- Sama seperti saat tambah produk
- Server-side & client-side validation

**Setelah Submit:**
- Data diperbarui di database
- Redirect ke dashboard dengan pesan success
- Perubahan langsung terlihat di tabel

---

### 4. **HAPUS PRODUK** (DELETE)

**Path:** `delete_product.php?id=X` (Klik tombol "Hapus")

**Proses:**
1. Klik tombol "Hapus" pada produk di tabel
2. Pop-up konfirmasi: "Apakah Anda yakin ingin menghapus produk ini?"
3. Klik OK untuk konfirmasi
4. Produk dihapus dari database
5. Redirect ke dashboard dengan pesan success

**Keamanan:**
- ✅ Produk hanya bisa dihapus oleh owner (user_id check)
- ✅ Konfirmasi sebelum delete
- ✅ Hard delete (tidak bisa di-undo)

---

## 🔒 Keamanan

### Implementasi Keamanan

| Fitur | Implementasi |
|-------|--------------|
| **Authentication** | Session-based login |
| **Password** | Bcrypt hashing (PASSWORD_BCRYPT) |
| **SQL Injection** | Prepared statements (mysqli) |
| **Authorization** | User hanya bisa lihat/edit produk miliknya |
| **Session** | Auto logout 30 menit idle |
| **CSRF** | Validasi form (POST method) |

### Best Practices

✅ **Jangan share kredensial** dengan orang lain
✅ **Logout** setelah selesai menggunakan
✅ **Update password** secara berkala (untuk production)
✅ **HTTPS** di production (penting!)
✅ **Input validation** dilakukan server-side

---

## 🎨 Fitur UI/UX

### Design Principles

- **Modern Design:** Gradient backgrounds, smooth animations
- **Responsive:** Mobile, tablet, desktop compatible
- **Intuitive:** Clear buttons, helpful messages
- **Accessible:** Semantic HTML, readable fonts
- **Fast:** Minimal CSS, optimized JavaScript

### Color Scheme

```
Primary: #3498db (Blue)      - Main buttons, highlights
Secondary: #2ecc71 (Green)   - Success, add actions
Danger: #e74c3c (Red)        - Delete, errors
Warning: #f39c12 (Orange)    - Warnings
```

### Responsive Breakpoints

- **Desktop:** 1200px+
- **Tablet:** 768px - 1199px
- **Mobile:** Below 768px

---

## 📊 Database Schema

### Tabel: `users`

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,        -- bcrypt hashed
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabel: `products`

```sql
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,         -- Format: 99999.99
  quantity INT NOT NULL,                 -- >= 1
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Relasi

- **users:products = 1:N** (One user to many products)
- Cascade delete: Hapus user → produk user ikut terhapus
- user_id links product to its owner

---

## 🐛 Troubleshooting

### Problem: "Connection failed: Access denied"

**Penyebab:** Kredensial database salah
**Solusi:**
1. Edit `includes/db.php`
2. Pastikan `DB_USER`, `DB_PASS` benar
3. MySQL server harus running

### Problem: "Table doesn't exist"

**Penyebab:** Database belum di-setup
**Solusi:**
1. Akses `http://localhost:8000/setup.php`
2. Klik "🚀 Setup Database"
3. Tunggu pesan sukses

### Problem: Session tidak berfungsi

**Penyebab:** Session save path tidak writable
**Solusi:**
1. Check `php.ini`: `session.save_path`
2. Pastikan folder writable (755 permissions)
3. Clear browser cookies

### Problem: Upload gambar tidak berfungsi

**Info:** Sistem saat ini tidak support upload gambar
**Workaround:** Gunakan link URL eksternal di deskripsi

### Problem: Quantity bisa input minus/nol

**Penyebab:** Client-side validation bypass
**Solusi:** Server-side validation sudah ada, input akan ditolak

---

## 📱 Mobile Responsive

### Tested Devices

✅ iPhone 12/13/14/15
✅ Samsung Galaxy S21/S22
✅ iPad Pro/Air
✅ Desktop (1920x1080)
✅ Tablet (768x1024)

### Responsive Features

- 📱 Stack layout mobile-first
- 🎯 Touch-friendly buttons (min 44px)
- 📐 Flexible grid system
- 🔤 Readable font sizes
- 📊 Horizontal scroll table (mobile)

---

## 🔄 Workflow Umum

```
1. BUKA APLIKASI
   ↓
2. LOGIN (login.php)
   ├─ Input username & password
   ├─ Validasi server-side
   └─ Create session
   ↓
3. DASHBOARD (index.php)
   ├─ View statistik
   ├─ View tabel produk
   └─ Pilih aksi
   ↓
4. AKSI PRODUK
   ├─ TAMBAH (add_product.php)
   │  ├─ Fill form
   │  ├─ Validasi
   │  └─ Insert to DB
   │
   ├─ EDIT (edit_product.php)
   │  ├─ Load data
   │  ├─ Update form
   │  └─ Update DB
   │
   └─ HAPUS (delete_product.php)
      ├─ Confirm action
      └─ Delete from DB
   ↓
5. LOGOUT (logout.php)
   ├─ Destroy session
   └─ Redirect login
```

---

## 💾 Backup & Recovery

### Backup Database

```bash
# Menggunakan mysqldump
mysqldump -u root -p product_crud > backup.sql
```

### Restore Database

```bash
# Restore dari backup
mysql -u root -p product_crud < backup.sql
```

---

## 🚀 Production Deployment

### Pre-deployment Checklist

- [ ] Update password user default
- [ ] Change database credentials
- [ ] Enable HTTPS/SSL
- [ ] Set error reporting to off
- [ ] Use environment variables for config
- [ ] Setup backup schedule
- [ ] Test all features
- [ ] Monitor error logs

### Security Hardening

```php
// php.ini settings
error_reporting = E_ALL
display_errors = Off
log_errors = On

// Set secure headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
```

---

## 📞 Support & Tips

### Tips Performa

- 💪 Database indexing untuk `user_id` dan `created_at`
- 🔍 Pagination untuk produk (jika > 100 items)
- 🖼️ CDN untuk static files
- 📊 Database optimization queries

### Pengembangan Lebih Lanjut

Bisa ditambahkan:
- 🖼️ Upload gambar produk
- 📊 Export ke Excel/PDF
- 🔔 Email notifications
- 📈 Analytics dashboard
- 💬 Product reviews/comments
- 🏷️ Categories & tags
- 🔎 Advanced search & filter

---

## 📄 License

Free to use untuk keperluan pembelajaran & personal project.

---

## 👨‍💻 Author Notes

Built with ❤️ using:
- PHP (Backend logic)
- MySQL (Database)
- HTML5 (Structure)
- CSS3 (Styling)
- Vanilla JavaScript (Client-side)

**Version:** 1.0.0
**Last Updated:** January 2026

---

**Happy Coding! 🎉**
