<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $fiksi = Category::where('nama_kategori', 'Fiksi')->value('id');
        $teknologi = Category::where('nama_kategori', 'Teknologi')->value('id');

        Book::insert([
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'isbn' => '9789793062792',
                'stok' => 5,
                'category_id' => $fiksi,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'tahun_terbit' => 1980,
                'isbn' => '9789794330746',
                'stok' => 3,
                'category_id' => $fiksi,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2008,
                'isbn' => '9780132350884',
                'stok' => 7,
                'category_id' => $teknologi,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
