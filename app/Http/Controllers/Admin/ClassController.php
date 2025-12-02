<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('major')->latest()->get();
        $majors  = Major::pluck('name', 'id'); // untuk select di modal
        return view('admin.class', compact('classes', 'majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:50',
            'major_id'  => 'required|exists:majors,id',
        ], [
            'major_id.exists' => 'Jurusan yang dipilih tidak valid.',
        ]);

        // Cek apakah nama kelas + jurusan sudah ada (unik per jurusan)
        $exists = Classes::where('name', $request->name)
                         ->where('major_id', $request->major_id)
                         ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Kelas dengan nama tersebut sudah ada di jurusan ini.');
        }

        DB::beginTransaction();
        try {
            Classes::create([
                'name'     => strtoupper($request->name),
                'major_id' => $request->major_id,
            ]);

            DB::commit();
            return redirect()->route('data.classes.index')
                ->with('success', 'Kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambah kelas.');
        }
    }

    public function update(Request $request, $id)
    {
        $class = Classes::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:50',
            'major_id'  => 'required|exists:majors,id',
        ]);

        // Cek unik kecuali data saat ini
        $exists = Classes::where('name', $request->name)
                         ->where('major_id', $request->major_id)
                         ->where('id', '!=', $class->id)
                         ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Kelas dengan nama tersebut sudah ada di jurusan ini.');
        }

        DB::beginTransaction();
        try {
            $class->update([
                'name'     => strtoupper($request->name),
                'major_id' => $request->major_id,
            ]);

            DB::commit();
            return redirect()->route('data.classes.index')
                ->with('success', 'Kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui kelas.');
        }
    }

    public function destroy($id)
    {
        $class = Classes::findOrFail($id);

        DB::beginTransaction();
        try {
            $class->delete();
            DB::commit();
            return redirect()->route('data.classes.index')
                ->with('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus kelas. Mungkin masih digunakan oleh siswa.');
        }
    }
}
