<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek role dan arahkan ke view yang sesuai
        switch ($user->role) {
            case 'admin':
                return view('admin.admin');
            case 'verifikator_adm':
                return view('verifikator.verifikator');
            case 'keuangan':
                return view('keuangan.keuangan');
            case 'kepsek':
                return view('kepsek.kepsek');
            default:
                abort(403, 'Akses tidak diizinkan');
        }
    }
}
