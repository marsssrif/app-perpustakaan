<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DashboardAndReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_guest_is_redirected_to_login_when_accessing_loan_report(): void
    {
        $response = $this->get('/loans/report');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_renders_stats_from_internal_api(): void
    {
        $user = User::factory()->create();

        Http::fake([
            '*/api/stats' => Http::response([
                'total_buku' => 20,
                'total_anggota' => 15,
                'peminjaman_aktif' => 5,
            ], 200),
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('20');
        $response->assertSee('15');
        $response->assertSee('5');
        $response->assertSee('Dashboard');
    }

    public function test_dashboard_gracefully_handles_api_failure(): void
    {
        $user = User::factory()->create();

        Http::fake([
            '*/api/stats' => Http::response([], 500),
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_loans_report_renders_from_internal_api(): void
    {
        $user = User::factory()->create();

        Http::fake([
            '*/api/loans*' => Http::response([
                'data' => [
                    [
                        'id' => 1,
                        'member' => ['id' => 1, 'nama' => 'Budi Santoso'],
                        'petugas' => ['id' => 1, 'name' => 'Bambang Sutrisno'],
                        'tanggal_pinjam' => '2026-10-20',
                        'tanggal_kembali' => '2026-10-27',
                        'tanggal_dikembalikan' => null,
                        'status' => 'dipinjam',
                        'books' => [
                            ['id' => 1, 'judul' => 'Laskar Pelangi'],
                        ],
                    ],
                ],
                'links' => [],
                'meta' => [
                    'current_page' => 1,
                    'last_page' => 1,
                ],
            ], 200),
        ]);

        $response = $this->actingAs($user)->get('/loans/report');

        $response->assertStatus(200);
        $response->assertSee('Laporan Peminjaman');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Bambang Sutrisno');
        $response->assertSee('Laskar Pelangi');
    }

    public function test_login_redirects_to_dashboard(): void
    {
        User::factory()->create([
            'email' => 'admin@pens.ac.id',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@pens.ac.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
    }
}
