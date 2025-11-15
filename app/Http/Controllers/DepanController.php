<?php
// app/Http/Controllers/DepanController.php

namespace App\Http\Controllers;

use App\Models\Gelombang;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class DepanController extends Controller
{
    public function index()
    {
        // Ambil data gelombang aktif
        $gelombangAktif = Gelombang::where('aktif', 1)
            ->where('tgl_selesai', '>=', now())
            ->orderBy('tgl_mulai', 'asc')
            ->first();

        // Hitung total kuota semua jurusan
        $totalKuota = Jurusan::where('aktif', 1)->sum('kuota');

        // Hitung kuota tersisa (total kuota - pendaftar yang sudah submit)
        $pendaftarSubmit = \App\Models\Pendaftar::where('status', 'SUBMIT')->count();
        $kuotaTersisa = max(0, $totalKuota - $pendaftarSubmit);

        return view('depan.pages.index', compact('gelombangAktif', 'totalKuota', 'kuotaTersisa'));
    }
}