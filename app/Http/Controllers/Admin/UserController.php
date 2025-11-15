<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::where('role', '!=', 'pendaftar');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('hp', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('aktif', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        $roleList = [
            'admin' => 'Administrator',
            'verifikator_adm' => 'Verifikator Administrasi',
            'keuangan' => 'Staff Keuangan',
            'kepsek' => 'Kepala Sekolah'
        ];

        $statusList = [
            '1' => 'Aktif',
            '0' => 'Nonaktif'
        ];

        return view('admin.manajemen-akun', compact('users', 'roleList', 'statusList'));
    }

    public function create()
    {
        $roleList = [
            'admin' => 'Administrator',
            'verifikator_adm' => 'Verifikator Administrasi',
            'keuangan' => 'Staff Keuangan',
            'kepsek' => 'Kepala Sekolah'
        ];

        return view('admin.tambah-akun', compact('roleList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'hp' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,verifikator_adm,keuangan,kepsek',
        ]);

        try {
            Pengguna::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->hp,
                'password_hash' => Hash::make($request->password),
                'role' => $request->role,
                'aktif' => true,
                'is_verified' => true,
            ]);

            return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = Pengguna::findOrFail($id);
        
        $roleList = [
            'admin' => 'Administrator',
            'verifikator_adm' => 'Verifikator Administrasi',
            'keuangan' => 'Staff Keuangan',
            'kepsek' => 'Kepala Sekolah'
        ];

        return view('admin.edit-akun', compact('user', 'roleList'));
    }

    public function update(Request $request, $id)
    {
        $user = Pengguna::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna,email,' . $user->id,
            'hp' => 'required|string|max:20',
            'password' => 'nullable|confirmed|min:6',
            'role' => 'required|in:admin,verifikator_adm,keuangan,kepsek',
            'aktif' => 'required|boolean',
        ]);

        try {
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->hp,
                'role' => $request->role,
                'aktif' => $request->aktif,
            ];

            // Update password jika diisi
            if ($request->filled('password')) {
                $data['password_hash'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = Pengguna::findOrFail($id);
            
            // Cegah penghapusan akun sendiri
            if ($user->id === auth()->user()->id) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
            }

            $user->delete();

            return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $user = Pengguna::findOrFail($id);
            
            // Cegah nonaktifkan akun sendiri
            if ($user->id === auth()->user()->id) {
                return redirect()->back()->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
            }

            $user->update([
                'aktif' => !$user->aktif
            ]);

            $status = $user->aktif ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->back()->with('success', "Akun berhasil $status.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}