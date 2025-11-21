<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = LogAktivitas::with('user');

            // Filter berdasarkan aksi
            if ($request->has('aksi') && $request->aksi != '') {
                $query->where('aksi', $request->aksi);
            }

            // Filter berdasarkan user
            if ($request->has('user_id') && $request->user_id != '') {
                $query->where('user_id', $request->user_id);
            }

            // Filter berdasarkan tanggal
            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('waktu', '>=', $request->start_date);
            }

            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('waktu', '<=', $request->end_date);
            }

            // Search berdasarkan objek
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('objek', 'like', "%$search%")
                      ->orWhere('aksi', 'like', "%$search%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('nama', 'like', "%$search%");
                      });
                });
            }

            $logs = $query->orderBy('waktu', 'desc')->paginate(20);

            // Get unique actions dan users untuk filter
            $actions = LogAktivitas::distinct('aksi')->pluck('aksi');
            $users = LogAktivitas::with('user')->distinct('user_id')->get()->unique('user_id');

            return view('admin.log-aktivitas.index', compact('logs', 'actions', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat log aktivitas: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.log-aktivitas.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'aksi' => 'required|string|max:100',
                'objek' => 'required|string|max:100',
                'objek_data' => 'nullable|array'
            ]);

            LogAktivitas::create([
                'user_id' => Auth::user()->id,
                'aksi' => $validated['aksi'],
                'objek' => $validated['objek'],
                'objek_data' => $validated['objek_data'] ?? null,
                'waktu' => now(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('admin.log-aktivitas.index')
                           ->with('success', 'Log aktivitas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan log aktivitas: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $log = LogAktivitas::with('user')->findOrFail($id);
            return view('admin.log-aktivitas.show', compact('log'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Log aktivitas tidak ditemukan');
        }
    }

    public function edit($id)
    {
        try {
            $log = LogAktivitas::findOrFail($id);
            return view('admin.log-aktivitas.edit', compact('log'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Log aktivitas tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $log = LogAktivitas::findOrFail($id);

            $validated = $request->validate([
                'aksi' => 'required|string|max:100',
                'objek' => 'required|string|max:100',
                'objek_data' => 'nullable|array'
            ]);

            $log->update([
                'aksi' => $validated['aksi'],
                'objek' => $validated['objek'],
                'objek_data' => $validated['objek_data'] ?? null
            ]);

            return redirect()->route('admin.log-aktivitas.index')
                           ->with('success', 'Log aktivitas berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui log aktivitas: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            LogAktivitas::findOrFail($id)->delete();
            
            return redirect()->route('admin.log-aktivitas.index')
                           ->with('success', 'Log aktivitas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus log aktivitas: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $query = LogAktivitas::with('user');

            if ($request->has('aksi') && $request->aksi != '') {
                $query->where('aksi', $request->aksi);
            }

            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('waktu', '>=', $request->start_date);
            }

            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('waktu', '<=', $request->end_date);
            }

            $logs = $query->orderBy('waktu', 'desc')->get();

            return view('admin.log-aktivitas.export', compact('logs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal export log aktivitas: ' . $e->getMessage());
        }
    }
}
