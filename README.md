# 📚 Sistem Perpustakaan Digital Kampus (`app-perpustakaan`)

Aplikasi web manajemen perpustakaan kampus berbasis **Laravel 12**, dibangun secara bertahap mulai dari Pertemuan 1 hingga Pertemuan 10 sebagai bagian dari mata kuliah Pemrograman Framework.

Aplikasi ini mencakup manajemen data buku, kategori, anggota, transaksi peminjaman multi-buku, sistem autentikasi dan otorisasi multi-role (Admin & Petugas), REST API publik lengkap dengan API Resource, konsumsi API internal via Laravel HTTP Client pada Dashboard dan Laporan, serta data dummy realistis berbahasa Indonesia.

---

## 🚀 Fitur Utama

- **Autentikasi & Otorisasi:**
  - Login & logout berbasis session dengan proteksi CSRF.
  - Multi-role: `admin` (akses penuh termasuk CRUD Kategori) dan `petugas` (akses operasional sirkulasi).
  - Middleware custom `CheckAdminRole`.
  - Halaman profil petugas dan fitur ganti password yang aman (`Hash::check` & `Hash::make`).
- **Manajemen Data (CRUD):**
  - **Buku:** Judul, penulis, penerbit, tahun terbit, ISBN, stok, dan relasi kategori.
  - **Kategori:** Nama kategori dan deskripsi (khusus role Admin).
  - **Anggota:** Nama, NIM unik, email kampus `@pens.ac.id`, nomor telepon, alamat, dan status aktif/nonaktif.
  - **Peminjaman:** Peminjaman multi-buku (`book_ids[]`), pencatatan otomatis ID petugas login, dan fitur pengembalian buku.
- **REST API (Pertemuan 9):**
  - 11 endpoint REST API untuk `books`, `members`, `loans`, dan `stats`.
  - Format response JSON konsisten menggunakan `BookResource`, `MemberResource`, dan `LoanResource`.
  - Dokumentasi API lengkap tersedia di [API.md](./API.md).
- **Konsumsi API & Dashboard (Pertemuan 10):**
  - Halaman **Dashboard** mengonsumsi `GET /api/stats` untuk menampilkan kartu statistik live.
  - Halaman **Laporan Peminjaman** mengonsumsi `GET /api/loans` untuk menampilkan tabel transaksi.
  - Menggunakan Laravel HTTP Client dengan penanganan fallback `ConnectionException`.
- **Seeder & Factory Realistis:**
  - Data kurasi bergaya Indonesia (`APP_FAKER_LOCALE=id_ID`).
  - Judul buku dikurasi per kategori, penerbit resmi Indonesia, dan email mahasiswa kampus PENS.
- **Tampilan Bersih & Pagination Rapi:**
  - Pagination custom teks/link yang konsisten tanpa dependensi framework CSS eksternal.

---

## 📋 Prasyarat Sistem

- PHP >= 8.2 (dengan ekstensi `pdo`, `sqlite3` atau `pdo_mysql`)
- Composer
- Git

---

## ⚙️ Instalasi & Menjalankan Aplikasi

### 1. Clone Repository & Masuk Direktori
```bash
git clone <url-repo-anda>
cd app-perpustakaan
```

### 2. Install Dependency
```bash
composer install
```

### 3. Setup Environment File
Salin file `.env.example` ke `.env`:
```bash
cp .env.example .env
```
Pastikan pengaturan URL di `.env` mencakup `INTERNAL_API_URL`:
```env
APP_URL=http://localhost:8000
INTERNAL_API_URL=http://127.0.0.1:8011
APP_FAKER_LOCALE=id_ID
```
Generate application key:
```bash
php artisan key:generate
```

### 4. Migrasi & Seeding Database
Jalankan migrasi dan isi database dengan data dummy realistis:
```bash
php artisan migrate:fresh --seed
```

---

## 🌐 Menjalankan Dua Server (Wajib untuk Dashboard & Laporan)

Server bawaan `php artisan serve` hanya memproses satu request pada satu waktu (single-threaded). Karena halaman Dashboard dan Laporan memanggil API aplikasi ini sendiri via HTTP, **dibutuhkan dua terminal server** agar tidak terjadi *deadlock*:

- **Terminal 1 — Server Utama (untuk akses browser):**
  ```bash
  php artisan serve --port=8000
  ```
  Akses di browser: [http://127.0.0.1:8000](http://127.0.0.1:8000)

- **Terminal 2 — Server Internal API (khusus menerima request `Http::get()`):**
  ```bash
  php artisan serve --port=8011
  ```

---

## 🔑 Akun Login Bawaan (Hasil Seeding)

| Role | Email | Password | Nama | Hak Akses |
|---|---|---|---|---|
| **Admin** | `admin@pens.ac.id` | `password` | Bambang Sutrisno | Akses semua menu (termasuk menu Kategori) |
| **Petugas** | `petugas1@pens.ac.id` | `password` | Siti Rahmawati | Sirkulasi buku, anggota, peminjaman |
| **Petugas** | `petugas2@pens.ac.id` | `password` | Ahmad Fauzi | Sirkulasi buku, anggota, peminjaman |

---

## 🧪 Menjalankan Pengujian Otomatis

Aplikasi dilengkapi feature test komprehensif (30 assertions testing mencakup autentikasi, otorisasi, REST API, dashboard, dan laporan):
```bash
php artisan test
```
atau:
```bash
php vendor/phpunit/phpunit/phpunit
```

---

## 📄 Dokumen Terkait

- [DEMO.md](./DEMO.md) — Panduan skenario demonstrasi aplikasi live langkah demi langkah untuk UAS (Pertemuan 11).
- [API.md](./API.md) — Dokumentasi lengkap seluruh 11 endpoint REST API beserta contoh request dan response JSON.
