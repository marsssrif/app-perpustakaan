<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_protected_routes(): void
    {
        $response = $this->get('/books');

        $response->assertRedirect('/login');
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@pens.ac.id',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@pens.ac.id',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@pens.ac.id',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@pens.ac.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/books');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_petugas_cannot_access_categories(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
        ]);

        $response = $this->actingAs($petugas)->get('/categories');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_categories(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/categories');

        $response->assertStatus(200);
    }

    public function test_loan_creation_automatically_assigns_authenticated_user(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
        ]);

        $category = Category::create([
            'nama_kategori' => 'Teknologi',
            'deskripsi' => 'Buku Teknologi',
        ]);

        $book = Book::create([
            'judul' => 'Belajar Laravel',
            'penulis' => 'Taylor',
            'penerbit' => 'Laravel Press',
            'tahun_terbit' => 2024,
            'stok' => 5,
            'category_id' => $category->id,
        ]);

        $member = Member::create([
            'nim' => '1234567890',
            'nama' => 'John Doe',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2023,
            'email' => 'john@test.local',
            'telepon' => '08123456789',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($petugas)->post('/loans', [
            'member_id' => $member->id,
            'tanggal_pinjam' => '2026-10-13',
            'tanggal_kembali' => '2026-10-20',
            'book_ids' => [$book->id],
        ]);

        $response->assertRedirect('/loans');
        $this->assertDatabaseHas('loans', [
            'member_id' => $member->id,
            'user_id' => $petugas->id,
            'tanggal_pinjam' => '2026-10-13',
        ]);
    }

    public function test_user_can_view_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'Budi Petugas',
            'email' => 'budi@pens.ac.id',
            'role' => 'petugas',
        ]);

        $response = $this->actingAs($user)->get('/profil');

        $response->assertStatus(200);
        $response->assertSee('Budi Petugas');
        $response->assertSee('budi@pens.ac.id');
        $response->assertSee('Petugas');
    }

    public function test_user_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user)->put('/profil/password', [
            'current_password' => 'oldpassword123',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect('/profil');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_user_cannot_update_password_with_incorrect_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user)->put('/profil/password', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors('current_password');

        $user->refresh();
        $this->assertTrue(Hash::check('oldpassword123', $user->password));
    }
}
