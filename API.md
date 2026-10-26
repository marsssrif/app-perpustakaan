# Dokumentasi REST API — App Perpustakaan (Pertemuan 9)

Dokumentasi seluruh endpoint REST API yang dibangun pada Pertemuan 9.
Base URL default: `http://127.0.0.1:8000/api` (atau port server yang berjalan).

Header standar yang disarankan untuk setiap request:
```http
Accept: application/json
Content-Type: application/json
```

---

## Ringkasan Endpoint

| No | Method | Endpoint | Fungsi | Status Sukses |
|---|---|---|---|---|
| 1 | `GET` | `/api/books` | Mengambil daftar buku (dengan relasi kategori, search, dan pagination) | `200 OK` |
| 2 | `GET` | `/api/books/{id}` | Mengambil detail 1 buku berdasarkan ID | `200 OK` / `404 Not Found` |
| 3 | `POST` | `/api/books` | Menambahkan data buku baru | `201 Created` / `422 Unprocessable Content` |
| 4 | `PUT` | `/api/books/{id}` | Memperbarui data buku | `200 OK` / `404 Not Found` / `422 Unprocessable Content` |
| 5 | `DELETE` | `/api/books/{id}` | Menghapus data buku | `200 OK` / `404 Not Found` |
| 6 | `GET` | `/api/members` | Mengambil daftar anggota (dengan pagination) | `200 OK` |
| 7 | `GET` | `/api/members/{id}` | Mengambil detail 1 anggota berdasarkan ID | `200 OK` / `404 Not Found` |
| 8 | `GET` | `/api/loans` | Mengambil daftar transaksi peminjaman (eager load member, petugas, & buku) | `200 OK` |
| 9 | `POST` | `/api/loans` | Mencatat transaksi peminjaman baru (multi-buku) | `201 Created` / `422 Unprocessable Content` |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | Mengubah status peminjaman menjadi 'dikembalikan' | `200 OK` / `404 Not Found` |
| 11 | `GET` | `/api/stats` | Mengambil ringkasan statistik (total buku, anggota, peminjaman aktif) | `200 OK` |

---

## Rincian Endpoint

### 1. GET `/api/books`
- **Deskripsi:** Menampilkan daftar buku dengan eager loading relasi kategori serta paginasi 10 item per halaman.
- **Query Parameter (Opsional):**
  - `judul` (string): Mencari judul buku sebagian (`LIKE %judul%`).
  - `category_id` (integer): Menyaring berdasarkan id kategori.
  - `page` (integer): Nomor halaman paginasi.
- **Response Sukses (`200 OK`):**
```json
{
  "data": [
    {
      "id": 1,
      "judul": "Laskar Pelangi",
      "penulis": "Andrea Hirata",
      "penerbit": "Bentang Pustaka",
      "tahun_terbit": 2005,
      "isbn": "978-979-3062-79-2",
      "stok": 10,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Sastra"
      },
      "created_at": "2026-10-27T05:16:30.000000Z",
      "updated_at": "2026-10-27T05:16:30.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/books?page=1",
    "last": "http://127.0.0.1:8000/api/books?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://127.0.0.1:8000/api/books?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "http://127.0.0.1:8000/api/books",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 2. GET `/api/books/{id}`
- **Deskripsi:** Menampilkan detail 1 buku beserta data kategorinya.
- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 1,
    "judul": "Laskar Pelangi",
    "penulis": "Andrea Hirata",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": 2005,
    "isbn": "978-979-3062-79-2",
    "stok": 10,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Sastra"
    },
    "created_at": "2026-10-27T05:16:30.000000Z",
    "updated_at": "2026-10-27T05:16:30.000000Z"
  }
}
```
- **Response Gagal (`404 Not Found`):**
```json
{
  "message": "No query results for model [App\\Models\\Book] 9999"
}
```

---

### 3. POST `/api/books`
- **Deskripsi:** Menambahkan buku baru ke database (divalidasi dengan `StoreBookRequest`).
- **Request Body (JSON):**
```json
{
  "judul": "Clean Code",
  "penulis": "Robert C. Martin",
  "penerbit": "Prentice Hall",
  "tahun_terbit": 2008,
  "isbn": "978-0132350884",
  "stok": 5,
  "category_id": 1
}
```
- **Response Sukses (`201 Created`):**
```json
{
  "data": {
    "id": 2,
    "judul": "Clean Code",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2008,
    "isbn": "978-0132350884",
    "stok": 5,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-10-27T05:16:31.000000Z",
    "updated_at": "2026-10-27T05:16:31.000000Z"
  }
}
```
- **Response Gagal (`422 Unprocessable Content`):**
```json
{
  "message": "Judul buku wajib diisi. (and 5 more errors)",
  "errors": {
    "judul": [
      "Judul buku wajib diisi."
    ],
    "penulis": [
      "Nama penulis wajib diisi."
    ],
    "penerbit": [
      "Nama penerbit wajib diisi."
    ],
    "tahun_terbit": [
      "Tahun terbit wajib diisi."
    ],
    "stok": [
      "Stok wajib diisi."
    ],
    "category_id": [
      "Kategori wajib dipilih."
    ]
  }
}
```

---

### 4. PUT `/api/books/{id}`
- **Deskripsi:** Memperbarui data buku berdasarkan ID.
- **Request Body (JSON):**
```json
{
  "judul": "Clean Code (Edisi Revisi)",
  "penulis": "Robert C. Martin",
  "penerbit": "Prentice Hall",
  "tahun_terbit": 2009,
  "isbn": "978-0132350884",
  "stok": 12,
  "category_id": 1
}
```
- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 2,
    "judul": "Clean Code (Edisi Revisi)",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2009,
    "isbn": "978-0132350884",
    "stok": 12,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-10-27T05:16:31.000000Z",
    "updated_at": "2026-10-27T05:16:32.000000Z"
  }
}
```

---

### 5. DELETE `/api/books/{id}`
- **Deskripsi:** Menghapus data buku dari sistem.
- **Response Sukses (`200 OK`):**
```json
{
  "message": "Buku berhasil dihapus."
}
```

---

### 6. GET `/api/members`
- **Deskripsi:** Menampilkan daftar anggota perpustakaan dengan paginasi 10 data per halaman.
- **Response Sukses (`200 OK`):**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Ahmad Faiz",
      "nim": "2024001",
      "email": "faiz@example.com",
      "nomor_telepon": "081234567890",
      "alamat": "Surabaya",
      "status": "aktif",
      "created_at": "2026-10-27T05:16:33.000000Z",
      "updated_at": "2026-10-27T05:16:33.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/members?page=1",
    "last": "http://127.0.0.1:8000/api/members?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://127.0.0.1:8000/api/members",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 7. GET `/api/members/{id}`
- **Deskripsi:** Menampilkan detail 1 anggota perpustakaan berdasarkan ID.
- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 1,
    "nama": "Ahmad Faiz",
    "nim": "2024001",
    "email": "faiz@example.com",
    "nomor_telepon": "081234567890",
    "alamat": "Surabaya",
    "status": "aktif",
    "created_at": "2026-10-27T05:16:33.000000Z",
    "updated_at": "2026-10-27T05:16:33.000000Z"
  }
}
```

---

### 8. GET `/api/loans`
- **Deskripsi:** Menampilkan daftar transaksi peminjaman lengkap dengan detail member, petugas pencatat, dan array buku yang dipinjam.
- **Response Sukses (`200 OK`):**
```json
{
  "data": [
    {
      "id": 1,
      "member": {
        "id": 1,
        "nama": "Ahmad Faiz"
      },
      "petugas": {
        "id": 1,
        "name": "Petugas Perpustakaan"
      },
      "tanggal_pinjam": "2026-10-27",
      "tanggal_kembali": "2026-11-03",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        {
          "id": 1,
          "judul": "Laskar Pelangi"
        }
      ]
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/loans?page=1",
    "last": "http://127.0.0.1:8000/api/loans?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://127.0.0.1:8000/api/loans",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 9. POST `/api/loans`
- **Deskripsi:** Membuat transaksi peminjaman buku baru (karena tanpa session auth, `user_id` dikirim eksplisit di body).
- **Request Body (JSON):**
```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-10-27",
  "tanggal_kembali": "2026-11-03",
  "book_ids": [1]
}
```
- **Response Sukses (`201 Created`):**
```json
{
  "data": {
    "id": 1,
    "member": {
      "id": 1,
      "nama": "Ahmad Faiz"
    },
    "petugas": {
      "id": 1,
      "name": "Petugas Perpustakaan"
    },
    "tanggal_pinjam": "2026-10-27",
    "tanggal_kembali": "2026-11-03",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      {
        "id": 1,
        "judul": "Laskar Pelangi"
      }
    ]
  }
}
```
- **Response Gagal (`422 Unprocessable Content`):**
```json
{
  "message": "Anggota wajib dipilih. (and 5 more errors)",
  "errors": {
    "member_id": ["Anggota wajib dipilih."],
    "user_id": ["Petugas (user_id) wajib diisi."],
    "tanggal_pinjam": ["Tanggal pinjam wajib diisi."],
    "tanggal_kembali": ["Tanggal kembali wajib diisi."],
    "book_ids": ["Pilih minimal satu buku."]
  }
}
```

---

### 10. PUT `/api/loans/{id}/kembalikan`
- **Deskripsi:** Memproses pengembalian buku peminjaman, otomatis mengisi `tanggal_dikembalikan` dengan tanggal hari ini dan mengubah status menjadi `'dikembalikan'`.
- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 1,
    "member": {
      "id": 1,
      "nama": "Ahmad Faiz"
    },
    "petugas": {
      "id": 1,
      "name": "Petugas Perpustakaan"
    },
    "tanggal_pinjam": "2026-10-27",
    "tanggal_kembali": "2026-11-03",
    "tanggal_dikembalikan": "2026-10-27",
    "status": "dikembalikan",
    "books": [
      {
        "id": 1,
        "judul": "Laskar Pelangi"
      }
    ]
  }
}
```

---

### 11. GET `/api/stats`
- **Deskripsi:** Mengambil data ringkasan statistik perpustakaan untuk dikonsumsi dashboard.
- **Response Sukses (`200 OK`):**
```json
{
  "total_buku": 15,
  "total_anggota": 8,
  "peminjaman_aktif": 3
}
```
