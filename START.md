# 🎯 START HERE

## Welcome to Product Management System!

Sistem CRUD untuk manajemen produk dengan PHP, JavaScript, dan MySQL telah siap digunakan.

---

## ⚡ Quick Start (3 Langkah)

### 1️⃣ **Setup Database**
- Buka file `setup.php` di browser
- Atau akses: `http://localhost:8000/setup.php`
- Klik tombol "🚀 Setup Database"
- Tunggu pesan sukses ✅

### 2️⃣ **Login**
- URL: `http://localhost:8000/login.php`
- Username: `user1`
- Password: `password123`

### 3️⃣ **Mulai Gunakan**
- Dashboard akan muncul setelah login
- Klik "+ Tambah Produk" untuk membuat produk
- Edit atau hapus produk dari tabel

---

## 📁 File Penting

| File | Tujuan |
|------|--------|
| **setup.php** | Setup database otomatis (buka pertama kali) |
| **login.php** | Halaman login |
| **index.php** | Dashboard utama |
| **GUIDE.md** | Panduan lengkap |
| **QUICKSTART.md** | Panduan cepat |

---

## 🛠️ Cara Menjalankan

### Menggunakan PHP Built-in Server
```bash
# Buka Command Prompt/Terminal di folder project
php -S localhost:8000

# Akses browser
http://localhost:8000/setup.php
```

### Menggunakan XAMPP/WAMP
```
1. Copy folder ke htdocs (XAMPP) atau www (WAMP)
2. Jalankan Apache & MySQL
3. Akses: http://localhost/project-ukk/setup.php
```

### Menggunakan Windows Batch Script
```bash
# Double-click install.bat
# Atau buka Command Prompt:
install.bat
```

### Menggunakan Linux/Mac
```bash
# Jalankan installer script
bash install.sh
```

---

## ✨ Fitur Utama

✅ **Login & Authentication**
- Form login dengan validasi
- Password hashing (bcrypt)
- Session timeout 30 menit

✅ **CRUD Produk**
- **Create:** Tambah produk baru
- **Read:** Lihat semua produk
- **Update:** Edit produk
- **Delete:** Hapus produk dengan konfirmasi

✅ **Validasi Quantity**
- Minimal: 1 (tidak boleh 0 atau minus)
- Validasi server-side & client-side
- Error message yang jelas

✅ **Dashboard**
- Statistik: Total produk, quantity, nilai
- Tabel responsive
- Mobile-friendly

✅ **Keamanan**
- SQL Injection prevention
- Password hashing
- User authorization
- Input validation

---

## 📱 Responsive Design

✅ Mobile phones (320px+)
✅ Tablets (768px+)
✅ Laptops (1024px+)
✅ Desktops (1200px+)

---

## 🔐 Demo Credentials

```
Username: user1
Password: password123
```

---

## 📚 Dokumentasi

- **QUICKSTART.md** - Mulai dalam 3 langkah
- **GUIDE.md** - Panduan lengkap dan detail
- **README.md** - Overview project
- **SUMMARY.md** - Ringkasan fitur

---

## 🐛 Troubleshooting

### "Connection failed"
→ Pastikan MySQL running dan konfigurasi benar

### "Database not found"
→ Akses setup.php untuk auto create database

### "Session error"
→ Clear cookies browser

### "Quantity input 0"
→ Server-side validation akan menolak

---

## ✅ Verification

Jalankan test page:
```
http://localhost:8000/test.php
```

Page ini akan check:
- PHP version
- Database connection
- File structure
- System status

---

## 🚀 Ready?

1. Buka setup.php
2. Setup database
3. Login dengan user1/password123
4. Mulai gunakan!

---

## 📞 Support

Jika ada pertanyaan, lihat:
- GUIDE.md untuk dokumentasi lengkap
- test.php untuk diagnostik sistem
- setup.php untuk setup ulang

---

## 🎉 Enjoy!

Semoga sistem ini membantu dalam belajar PHP dan web development!

**Happy Coding!** 👨‍💻👩‍💻
