<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        ['id' => 1, 'nama' => 'Budi Santoso', 'nim' => '2241720001', 'email' => 'budi@example.com', 'nomor_telepon' => '08123456789', 'alamat' => 'Jl. Merdeka No. 1, Malang', 'status' => 'aktif'],
        ['id' => 2, 'nama' => 'Siti Aminah', 'nim' => '2241720002', 'email' => 'siti@example.com', 'nomor_telepon' => '08234567890', 'alamat' => 'Jl. Pahlawan No. 5, Surabaya', 'status' => 'aktif'],
        ['id' => 3, 'nama' => 'Ahmad Fauzi', 'nim' => '2241720003', 'email' => 'ahmad@example.com', 'nomor_telepon' => null, 'alamat' => 'Jl. Diponegoro No. 10, Malang', 'status' => 'nonaktif'],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    public function edit(string $id)
    {
        return "MemberController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return "MemberController@destroy, id: {$id}";
    }
}
