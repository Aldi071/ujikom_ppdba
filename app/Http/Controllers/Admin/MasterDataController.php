<?php
// app/Http/Controllers/Admin/MasterDataController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gelombang;
use App\Models\Biaya;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Artisan;

class MasterDataController extends Controller
{
    public function jurusan()
    {
        $jurusan = Jurusan::orderBy('kode')->get();
        return view('admin.master.jurusan', compact('jurusan'));
    }

    public function storeJurusan(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:jurusan,kode|max:10',
            'nama' => 'required|max:100',
            'kuota' => 'required|integer|min:1'
        ]);

        try {
            Jurusan::create($request->all());
            return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan jurusan: ' . $e->getMessage());
        }
    }

    public function updateJurusan(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|max:10|unique:jurusan,kode,' . $id,
            'nama' => 'required|max:100',
            'kuota' => 'required|integer|min:1'
        ]);

        try {
            $jurusan = Jurusan::findOrFail($id);
            $jurusan->update($request->all());
            return redirect()->back()->with('success', 'Jurusan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui jurusan: ' . $e->getMessage());
        }
    }

    public function editJurusan($id)
{
    $jurusan = Jurusan::all();
    $editJurusan = Jurusan::findOrFail($id);
    return view('admin.master.jurusan', compact('jurusan', 'editJurusan'));
}

    public function destroyJurusan($id)
    {
        try {
            // Cek apakah jurusan digunakan di pendaftar
            $used = DB::table('pendaftar')->where('jurusan_id', $id)->exists();
            
            if ($used) {
                return redirect()->back()->with('error', 'Jurusan tidak dapat dihapus karena sudah digunakan oleh pendaftar.');
            }

            $jurusan = Jurusan::findOrFail($id);
            $jurusan->delete();
            
            return redirect()->back()->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus jurusan: ' . $e->getMessage());
        }
    }

    // Method lainnya tetap sama...
     public function gelombang()
    {
        $gelombang = Gelombang::orderBy('tahun', 'desc')
            ->orderBy('tgl_mulai')
            ->get();
        return view('admin.master.gelombang', compact('gelombang'));
    }

    public function storeGelombang(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'tahun' => 'required|integer|min:2020|max:2030',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'biaya_daftar' => 'required|numeric|min:0'
        ]);

        try {
            Gelombang::create($request->all());
            return redirect()->back()->with('success', 'Gelombang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan gelombang: ' . $e->getMessage());
        }
    }

    public function editGelombang($id)
    {
        $gelombang = Gelombang::all();
        $editGelombang = Gelombang::findOrFail($id);
        return view('admin.master.gelombang', compact('gelombang', 'editGelombang'));
    }

    public function updateGelombang(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'tahun' => 'required|integer|min:2020|max:2030',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'biaya_daftar' => 'required|numeric|min:0'
        ]);

        try {
            $gelombang = Gelombang::findOrFail($id);
            $gelombang->update($request->all());
            return redirect()->back()->with('success', 'Gelombang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui gelombang: ' . $e->getMessage());
        }
    }

    public function destroyGelombang($id)
    {
        try {
            // Cek apakah gelombang digunakan di pendaftar
            $used = DB::table('pendaftar')->where('gelombang_id', $id)->exists();
            
            if ($used) {
                return redirect()->back()->with('error', 'Gelombang tidak dapat dihapus karena sudah digunakan oleh pendaftar.');
            }

            $gelombang = Gelombang::findOrFail($id);
            $gelombang->delete();
            
            return redirect()->back()->with('success', 'Gelombang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus gelombang: ' . $e->getMessage());
        }
    }

    public function biaya()
    {
        $biaya = Biaya::orderBy('kategori')
            ->orderBy('kode')
            ->get();
            
        // Debug: Cek data yang diambil
        if (config('app.debug')) {
            \Log::info('Data Biaya:', ['count' => $biaya->count(), 'data' => $biaya->toArray()]);
        }
        
        return view('admin.master.biaya', compact('biaya'));
    }

    public function storeBiaya(Request $request)
    {
        // Debug: Log request data (only when APP_DEBUG=true)
        if (config('app.debug')) {
            \Log::info('Store Biaya Request:', $request->all());
        }
        
        $request->validate([
            'kode' => 'required|unique:biaya,kode|max:20',
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable|max:255',
            'jumlah' => 'required|numeric|min:0',
            'jenis' => 'required|in:TUNAI,TRANSFER',
            'kategori' => 'required|in:DAFTAR,PANGKAL,SPP,LAINNYA',
            'wajib' => 'boolean',
            'aktif' => 'boolean'
        ]);

        try {
            $biaya = Biaya::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'wajib' => $request->has('wajib') ? 1 : 0,
                'aktif' => $request->has('aktif') ? 1 : 0,
            ]);

            // Debug: Log data yang berhasil dibuat (only when APP_DEBUG=true)
            if (config('app.debug')) {
                \Log::info('Biaya Created:', $biaya->toArray());
            }

            return redirect()->route('admin.master.biaya')->with('success', 'Biaya berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Debug: Log error
            \Log::error('Error creating biaya: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menambahkan biaya: ' . $e->getMessage())->withInput();
        }
    }

    public function editBiaya($id)
    {
        $biaya = Biaya::all();
        $editBiaya = Biaya::findOrFail($id);
        return view('admin.master.biaya', compact('biaya', 'editBiaya'));
    }

    public function updateBiaya(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|max:20|unique:biaya,kode,' . $id,
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable|max:255',
            'jumlah' => 'required|numeric|min:0',
            'jenis' => 'required|in:TUNAI,TRANSFER',
            'kategori' => 'required|in:DAFTAR,PANGKAL,SPP,LAINNYA',
            'wajib' => 'boolean',
            'aktif' => 'boolean'
        ]);

        try {
            $biaya = Biaya::findOrFail($id);
            $biaya->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
                'wajib' => $request->has('wajib'),
                'aktif' => $request->has('aktif'),
            ]);

            return redirect()->back()->with('success', 'Biaya berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui biaya: ' . $e->getMessage());
        }
    }

    public function destroyBiaya($id)
    {
        try {
            // TODO: Cek apakah biaya sudah digunakan di transaksi sebelum hapus
            // $used = DB::table('pembayaran')->where('biaya_id', $id)->exists();
            
            // if ($used) {
            //     return redirect()->back()->with('error', 'Biaya tidak dapat dihapus karena sudah digunakan dalam transaksi.');
            // }

            $biaya = Biaya::findOrFail($id);
            $biaya->delete();
            
            return redirect()->back()->with('success', 'Biaya berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus biaya: ' . $e->getMessage());
        }
    }

    public function wilayah(Request $request)
    {
        $search = $request->get('search');
        
        $wilayah = Wilayah::when($search, function($query) use ($search) {
                        return $query->search($search);
                    })
                    ->orderBy('provinsi')
                    ->orderBy('kabupaten')
                    ->orderBy('kecamatan')
                    ->orderBy('kelurahan')
                    ->paginate(20);

        $provinsiList = Wilayah::getProvinsi();

        // Jika tidak ada data wilayah, tampilkan pesan
    if ($wilayah->total() == 0) {
        return view('admin.master.wilayah', compact('wilayah', 'provinsiList', 'search'))
            ->with('info', 'Belum ada data wilayah. Silakan tambah data wilayah menggunakan form di samping.');
    }

        return view('admin.master.wilayah', compact('wilayah', 'provinsiList', 'search'));
    }

    public function storeWilayah(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|max:100',
            'kabupaten' => 'required|max:100',
            'kecamatan' => 'required|max:100',
            'kelurahan' => 'required|max:100',
            'kodepos' => 'required|max:10'
        ]);

        try {
            // Cek duplikasi
            $existing = Wilayah::where('provinsi', $request->provinsi)
                            ->where('kabupaten', $request->kabupaten)
                            ->where('kecamatan', $request->kecamatan)
                            ->where('kelurahan', $request->kelurahan)
                            ->first();

            if ($existing) {
                return redirect()->back()->with('error', 'Data wilayah sudah ada dalam database.');
            }

            Wilayah::create($request->all());

            return redirect()->back()->with('success', 'Wilayah berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan wilayah: ' . $e->getMessage());
        }
    }

    public function editWilayah($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $provinsiList = Wilayah::getProvinsi();
        $kabupatenList = Wilayah::getKabupaten($wilayah->provinsi);
        $kecamatanList = Wilayah::getKecamatan($wilayah->kabupaten);

        return view('admin.master.wilayah-edit', compact('wilayah', 'provinsiList', 'kabupatenList', 'kecamatanList'));
    }

    public function updateWilayah(Request $request, $id)
    {
        $request->validate([
            'provinsi' => 'required|max:100',
            'kabupaten' => 'required|max:100',
            'kecamatan' => 'required|max:100',
            'kelurahan' => 'required|max:100',
            'kodepos' => 'required|max:10'
        ]);

        try {
            $wilayah = Wilayah::findOrFail($id);
            
            // Cek duplikasi (kecuali data yang sedang diedit)
            $existing = Wilayah::where('provinsi', $request->provinsi)
                            ->where('kabupaten', $request->kabupaten)
                            ->where('kecamatan', $request->kecamatan)
                            ->where('kelurahan', $request->kelurahan)
                            ->where('id', '!=', $id)
                            ->first();

            if ($existing) {
                return redirect()->back()->with('error', 'Data wilayah sudah ada dalam database.');
            }

            $wilayah->update($request->all());

            return redirect()->route('admin.master.wilayah')->with('success', 'Wilayah berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui wilayah: ' . $e->getMessage());
        }
    }

    public function destroyWilayah($id)
    {
        try {
            // Cek apakah wilayah digunakan di data siswa
            $used = DB::table('pendaftar_data_siswa')->where('wilayah_id', $id)->exists();
            
            if ($used) {
                return redirect()->back()->with('error', 'Wilayah tidak dapat dihapus karena sudah digunakan oleh data pendaftar.');
            }

            $wilayah = Wilayah::findOrFail($id);
            $wilayah->delete();
            
            return redirect()->back()->with('success', 'Wilayah berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus wilayah: ' . $e->getMessage());
        }
    }

    // AJAX methods untuk dropdown
    public function getKabupatenByProvinsi(Request $request)
    {
        $provinsi = $request->provinsi;
        
        // Debug: Log the request (only when APP_DEBUG=true)
        if (config('app.debug')) {
            \Log::info('Get Kabupaten for Provinsi: ' . $provinsi);
        }
        
        $kabupaten = Wilayah::getKabupaten($provinsi);
        
        // Debug: Log the result (only when APP_DEBUG=true)
        if (config('app.debug')) {
            \Log::info('Kabupaten Result: ', $kabupaten->toArray());
        }
        
        return response()->json($kabupaten);
    }

    public function getKecamatanByKabupaten(Request $request)
    {
        $kabupaten = $request->kabupaten;
        
        // Debug: Log the request (only when APP_DEBUG=true)
        if (config('app.debug')) {
            \Log::info('Get Kecamatan for Kabupaten: ' . $kabupaten);
        }
        
        $kecamatan = Wilayah::getKecamatan($kabupaten);
        
        // Debug: Log the result (only when APP_DEBUG=true)
        if (config('app.debug')) {
            \Log::info('Kecamatan Result: ', $kecamatan->toArray());
        }
        
        return response()->json($kecamatan);
    }

    public function getKelurahanByKecamatan(Request $request)
    {
        $kecamatan = $request->kecamatan;
        $kelurahan = Wilayah::getKelurahan($kecamatan);
        return response()->json($kelurahan);
    }

    public function quickAddWilayah()
{
    try {
        // Panggil seeder untuk menambah data contoh
        Artisan::call('db:seed', ['--class' => 'WilayahSeeder']);
        
        return redirect()->route('admin.master.wilayah')->with('success', 'Data wilayah contoh berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->route('admin.master.wilayah')->with('error', 'Gagal menambah data contoh: ' . $e->getMessage());
    }
}

    public function syarat()
    {
        return view('admin.master.syarat');
    }
}