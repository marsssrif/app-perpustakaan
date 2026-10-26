# Skenario Demo Aplikasi Live (UAS) — Sistem Perpustakaan Digital Kampus

Dokumen ini adalah panduan langkah demi langkah untuk melakukan demonstrasi live aplikasi `app-perpustakaan` di hadapan dosen penguji, sesuai panduan modul Pertemuan 11.

---

## Persiapan Sebelum Demo

1. **Jalankan Dua Server Bersamaan (Dua Terminal Berbeda):**
   - **Terminal 1 (Server Utama untuk Browser):**
     ```bash
     php artisan serve --port=8000
     ```
   - **Terminal 2 (Server Internal API):**
     ```bash
     php artisan serve --port=8011
     ```
2. **Reset Database ke Kondisi Bersih:**
   ```bash
   php artisan migrate:fresh --seed
   ```
3. **Akun Pengujian (dari `UserSeeder`):**
   - **Admin:** `admin@pens.ac.id` / `password` (Nama: Bambang Sutrisno)
   - **Petugas:** `petugas1@pens.ac.id` / `password` (Nama: Siti Rahmawati)
4. **Buka Aplikasi & Tool:**
   - Browser terbuka di `http://127.0.0.1:8000`
   - Postman terbuka dengan koleksi endpoint `app-perpustakaan`

---

## Langkah Demonstrasi Live

### Langkah 1: Login sebagai Admin / Petugas
- **Aksi:** Buka `http://127.0.0.1:8000/login`, masukkan email `admin@pens.ac.id` dan password `password`.
- **Hasil yang Dilihat:**
  - Login berhasil, sistem me-redirect langsung ke **Dashboard** (`/`).
  - Pesan sukses: *"Login berhasil, selamat datang Bambang Sutrisno."*
  - Navbar menampilkan identitas user: *"Bambang Sutrisno (Admin)"* beserta menu lengkap (Dashboard, Buku, Kategori, Anggota, Peminjaman, Laporan, Profil, Logout).

---

### Langkah 2: Tampilkan Dashboard Statistik
- **Aksi:** Tunjukkan 3 kartu statistik di halaman Dashboard (`http://127.0.0.1:8000/`).
- **Hasil yang Dilihat:**
  - Kartu **Total Buku** (20), **Total Anggota** (15), dan **Peminjaman Aktif**.
  - **Penjelasan Teknis:** Angka statistik ini didapatkan oleh `DashboardController` dengan mengonsumsi `GET /api/stats` lewat Laravel HTTP Client (`Http::get()`), bukan query database langsung. Jika server API port 8011 mati, halaman tetap tampil dengan fallback angka 0 tanpa error 500 karena dibungkus `try/catch (ConnectionException $e)`.

---

### Langkah 3: Tambah Kategori Baru (Fitur Khusus Admin)
- **Aksi:**
  1. Klik menu **Kategori** (`/categories`).
  2. Klik **Tambah Kategori**.
  3. Masukkan:
     - Nama Kategori: `Filsafat`
     - Deskripsi: `Buku-buku pemikiran dan filsafat klasik.`
  4. Klik tombol **Simpan**.
- **Hasil yang Dilihat:** Kategori baru muncul di daftar kategori dengan pesan flash sukses.

---

### Langkah 4: Tambah Buku dengan Kategori Baru
- **Aksi:**
  1. Klik menu **Buku** (`/books`).
  2. Klik **Tambah Buku**.
  3. Masukkan data:
     - Judul: `Dunia Sophie`
     - Penulis: `Jostein Gaarder`
     - Penerbit: `Mizan`
     - Tahun Terbit: `1996`
     - ISBN: `978-979-433-074-6`
     - Stok: `5`
     - Kategori: Pilih `Filsafat` yang baru dibuat.
  4. Klik **Simpan**.
- **Hasil yang Dilihat:** Buku baru tersimpan dan tampil di tabel buku lengkap dengan nama kategori `Filsafat` (bukan ID angka mentah).

---

### Langkah 5: Tambah Anggota Baru
- **Aksi:**
  1. Klik menu **Anggota** (`/members`).
  2. Klik **Tambah Anggota**.
  3. Masukkan:
     - Nama: `Rian Maulana`
     - NIM: `3122500099`
     - Email: `rian.maulana@pens.ac.id`
     - Nomor Telepon: `081298765432`
     - Alamat: `Jl. Raya ITS, Sukolilo, Surabaya`
     - Status: `aktif`
  4. Klik **Simpan**.
- **Hasil yang Dilihat:** Anggota baru tersimpan. Jika diuji submit dengan NIM/Email yang sama, sistem menampilkan pesan error validasi unik.

---

### Langkah 6: Buat Transaksi Peminjaman Baru
- **Aksi:**
  1. Klik menu **Peminjaman** (`/loans`).
  2. Klik **Tambah Peminjaman** (`/loans/create`).
  3. Pilih Anggota: `Rian Maulana`.
  4. Tanggal Pinjam: Hari ini.
  5. Tanggal Kembali: 7 hari ke depan.
  6. Pilih Buku: Centang `Dunia Sophie`.
  7. Klik **Simpan**.
- **Hasil yang Dilihat:** Transaksi peminjaman berhasil dibuat. `user_id` petugas pencatat diisi otomatis dari user yang sedang login (`auth()->id()`), tidak dipilih manual.

---

### Langkah 7: Lihat Daftar Peminjaman Aktif
- **Aksi:** Perhatikan tabel di halaman `/loans`.
- **Hasil yang Dilihat:** Transaksi baru muncul di daftar peminjaman dengan status `dipinjam`, menampilkan nama anggota `Rian Maulana`, nama petugas `Bambang Sutrisno`, dan judul buku `Dunia Sophie` (eager loaded tanpa N+1 query problem).

---

### Langkah 8: Proses Pengembalian Buku
- **Aksi:**
  - Klik tombol **Kembalikan** pada baris transaksi peminjaman milik `Rian Maulana` (atau via endpoint API `PUT /api/loans/{id}/kembalikan` di Postman).
- **Hasil yang Dilihat:**
  - Status peminjaman berubah dari `dipinjam` menjadi `dikembalikan`.
  - Tanggal dikembalikan terisi otomatis dengan tanggal hari ini.

---

### Langkah 9: Tampilkan Halaman Laporan Peminjaman
- **Aksi:** Klik menu **Laporan** (`/loans/report`).
- **Hasil yang Dilihat:**
  - Seluruh transaksi peminjaman (termasuk yang baru saja dikembalikan) tampil dalam tabel laporan.
  - **Penjelasan Teknis:** Data ini diambil oleh `LoanController@report` melalui pemanggilan internal API `GET /api/loans`, lalu dirender dalam format Blade dengan pagination manual.

---

### Langkah 10: Demonstrasi REST API di Postman
Buka aplikasi Postman dan uji endpoint berikut:
1. **GET `http://127.0.0.1:8000/api/books`**
   - Header: `Accept: application/json`
   - Tunjukkan respons JSON terstruktur dengan format `BookResource` (kategori ter-nested, pagination `data`, `links`, `meta`).
2. **GET `http://127.0.0.1:8000/api/books?judul=sophie`**
   - Tunjukkan filter pencarian judul berfungsi.
3. **GET `http://127.0.0.1:8000/api/stats`**
   - Tunjukkan angka `total_buku`, `total_anggota`, dan `peminjaman_aktif` sesuai kondisi database terbaru.
4. **PUT `http://127.0.0.1:8000/api/loans/{id}/kembalikan`**
   - Tunjukkan status `200 OK` dan data pengembalian berhasil di-update lewat API.

---

## Rangkuman Konsep Penting untuk Tanya Jawab

1. **Deadlock Server Lokal:** `php artisan serve` bersifat single-threaded (hanya 1 request per waktu). Memanggil API sendiri pada port yang sama menyebabkan deadlock. Solusinya adalah menjalankan 2 instance server di port berbeda (`8000` dan `8011`). Di server produksi (Nginx + PHP-FPM), masalah ini tidak terjadi karena multi-process/multi-threading.
2. **Eager Loading vs N+1 Problem:** Memakai `with(['member', 'user', 'loanItems.book'])` menjalankan 4 query cepat di awal daripada mengeksekusi 1 query tambahan untuk setiap baris data peminjaman di dalam perulangan view (1 + N query).
3. **API Resource:** Memberikan lapisan transformasi data yang konsisten, menyembunyikan kolom sensitif (seperti password hash), dan mengubah relasi database menjadi struktur JSON yang rapi bagi klien luar.
4. **Seeder vs Factory:** Seeder menentukan apa dan urutan data yang dimasukkan ke database (misal 5 kategori tetap atau orkestrasi via `DatabaseSeeder`). Factory memanfaatkan Faker untuk membuat puluhan/ratusan data dummy acak yang realistis.
