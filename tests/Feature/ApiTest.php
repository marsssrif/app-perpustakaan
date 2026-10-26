<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    private function createCategory(string $nama = 'Teknologi'): Category
    {
        return Category::create([
            'nama_kategori' => $nama,
            'deskripsi' => 'Deskripsi '.$nama,
        ]);
    }

    private function createBook(Category $category, string $judul = 'Laskar Pelangi'): Book
    {
        return Book::create([
            'judul' => $judul,
            'penulis' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun_terbit' => 2005,
            'isbn' => '978-979-3062-79-2',
            'stok' => 10,
            'category_id' => $category->id,
        ]);
    }

    private function createMember(): Member
    {
        return Member::create([
            'nama' => 'Ahmad Faiz',
            'nim' => '2024001',
            'email' => 'faiz@example.com',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Surabaya',
            'status' => 'aktif',
        ]);
    }

    public function test_can_get_books_list_with_pagination_and_category(): void
    {
        $category = $this->createCategory();
        $this->createBook($category);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'judul',
                        'penulis',
                        'penerbit',
                        'tahun_terbit',
                        'isbn',
                        'stok',
                        'sampul',
                        'category' => ['id', 'nama_kategori'],
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_filter_books_by_judul_and_category(): void
    {
        $cat1 = $this->createCategory('Sains');
        $cat2 = $this->createCategory('Sastra');
        $this->createBook($cat1, 'Fisika Dasar');
        $this->createBook($cat2, 'Laskar Pelangi');

        $resJudul = $this->getJson('/api/books?judul=laskar');
        $resJudul->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.judul', 'Laskar Pelangi');

        $resCat = $this->getJson('/api/books?category_id='.$cat1->id);
        $resCat->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.judul', 'Fisika Dasar');
    }

    public function test_can_create_book_and_returns_201(): void
    {
        $category = $this->createCategory();

        $payload = [
            'judul' => 'Clean Code',
            'penulis' => 'Robert C. Martin',
            'penerbit' => 'Prentice Hall',
            'tahun_terbit' => 2008,
            'isbn' => '978-0132350884',
            'stok' => 5,
            'category_id' => $category->id,
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('data.judul', 'Clean Code')
            ->assertJsonPath('data.category.nama_kategori', 'Teknologi');
    }

    public function test_create_book_validation_fails_returns_422(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok', 'category_id']);
    }

    public function test_can_show_single_book(): void
    {
        $category = $this->createCategory();
        $book = $this->createBook($category);

        $response = $this->getJson('/api/books/'.$book->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $book->id)
            ->assertJsonPath('data.judul', $book->judul);
    }

    public function test_show_non_existent_book_returns_404(): void
    {
        $response = $this->getJson('/api/books/9999');

        $response->assertStatus(404);
    }

    public function test_can_update_book(): void
    {
        $category = $this->createCategory();
        $book = $this->createBook($category);

        $response = $this->putJson('/api/books/'.$book->id, [
            'judul' => 'Judul Baru',
            'penulis' => 'Penulis Baru',
            'penerbit' => 'Penerbit Baru',
            'tahun_terbit' => 2022,
            'isbn' => '123456',
            'stok' => 15,
            'category_id' => $category->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.judul', 'Judul Baru')
            ->assertJsonPath('data.stok', 15);
    }

    public function test_can_delete_book(): void
    {
        $category = $this->createCategory();
        $book = $this->createBook($category);

        $response = $this->deleteJson('/api/books/'.$book->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Buku berhasil dihapus.']);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_can_get_members_list_and_detail(): void
    {
        $member = $this->createMember();

        $indexRes = $this->getJson('/api/members');
        $indexRes->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonPath('data.0.nama', 'Ahmad Faiz');

        $showRes = $this->getJson('/api/members/'.$member->id);
        $showRes->assertStatus(200)
            ->assertJsonPath('data.id', $member->id)
            ->assertJsonPath('data.nim', '2024001');
    }

    public function test_can_create_and_return_loan(): void
    {
        $category = $this->createCategory();
        $book = $this->createBook($category);
        $member = $this->createMember();
        $user = User::factory()->create(['name' => 'Petugas Perpustakaan']);

        $createRes = $this->postJson('/api/loans', [
            'member_id' => $member->id,
            'user_id' => $user->id,
            'tanggal_pinjam' => '2026-10-27',
            'tanggal_kembali' => '2026-11-03',
            'book_ids' => [$book->id],
        ]);

        $createRes->assertStatus(201)
            ->assertJsonPath('data.status', 'dipinjam')
            ->assertJsonPath('data.petugas.name', 'Petugas Perpustakaan')
            ->assertJsonPath('data.member.nama', 'Ahmad Faiz')
            ->assertJsonPath('data.books.0.judul', 'Laskar Pelangi');

        $loanId = $createRes->json('data.id');

        $indexRes = $this->getJson('/api/loans');
        $indexRes->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);

        $returnRes = $this->putJson('/api/loans/'.$loanId.'/kembalikan');
        $returnRes->assertStatus(200)
            ->assertJsonPath('data.status', 'dikembalikan')
            ->assertJsonPath('data.tanggal_dikembalikan', now()->toDateString());
    }

    public function test_can_get_stats(): void
    {
        $category = $this->createCategory();
        $this->createBook($category);
        $this->createMember();

        $response = $this->getJson('/api/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_buku',
                'total_anggota',
                'peminjaman_aktif',
            ])
            ->assertJson([
                'total_buku' => 1,
                'total_anggota' => 1,
                'peminjaman_aktif' => 0,
            ]);
    }
}
