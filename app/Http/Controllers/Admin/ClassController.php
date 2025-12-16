<?php

namespace App\Http\Controllers\Admin;

use App\Models\Major;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('major')->latest()->get();
        $majors  = Major::pluck('name', 'id'); // untuk select di modal
        $teachers = Teacher::pluck('name', 'id'); // corrected variable name
        return view('admin.class', compact('classes', 'majors', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:50',
            'major_id'   => 'required|exists:majors,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $name = strtoupper($request->name);

        // Cek nama kelas sudah ada (unik seluruh sekolah)
        $nameExists = Classes::where('name', $name)->exists();
        if ($nameExists) {
            return redirect()->back()->with('error', 'Nama kelas sudah digunakan!');
        }

        // Cek guru sudah menjadi wali kelas lain
        $teacherExists = Classes::where('teacher_id', $request->teacher_id)->exists();
        if ($teacherExists) {
            return redirect()->back()->with('error', 'Guru tersebut sudah menjadi wali kelas lain!');
        }

        DB::beginTransaction();
        try {
            Classes::create([
                'name'       => $name,
                'major_id'   => $request->major_id,
                'teacher_id' => $request->teacher_id,
            ]);

            DB::commit();
            return redirect()->route('data.classes.index')
                ->with('success', 'Kelas berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambah kelas: ' . $e->getMessage());
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
