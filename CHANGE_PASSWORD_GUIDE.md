# Panduan Ubah Password

## Informasi Awal
- **Username**: user1
- **Password Awal**: password123

## Cara Mengubah Password

1. Login menggunakan username dan password awal
2. Setelah berhasil login, klik tombol "🔐 Ubah Password" di navbar
3. Isi form:
   - **Password Lama**: Masukkan password saat ini (password123)
   - **Password Baru**: Masukkan password baru (minimal 6 karakter)
   - **Konfirmasi Password Baru**: Masukkan ulang password baru
4. Klik tombol "Ubah Password"
5. Jika berhasil, Anda akan di-logout otomatis dan diminta login kembali dengan password baru

## Validasi
- Semua field harus diisi
- Password baru minimal 6 karakter
- Password baru dan konfirmasi harus cocok
- Password lama harus sesuai dengan password yang tersimpan di database

## File yang Ditambahkan
- `change_password.php` - Halaman ubah password

## File yang Dimodifikasi
- `index.php` - Menambahkan link "Ubah Password" di navbar
