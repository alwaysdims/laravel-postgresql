<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::latest()->get();
        return view('admin.major', compact('majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:majors,name',
            'code_major'  => 'required|string|max:10|unique:majors,code_major',
        ], [
            'name.unique'       => 'Nama jurusan sudah ada.',
            'code_major.unique' => 'Kode jurusan sudah digunakan.',
        ]);

        DB::beginTransaction();
        try {
            Major::create([
                'name'       => $request->name,
                'code_major' => strtoupper($request->code_major),
            ]);

            DB::commit();
            return redirect()->route('data.majors.index')
                ->with('success', 'Jurusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambah jurusan.');
        }
    }

    public function update(Request $request, $id)
    {
        $major = Major::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255|unique:majors,name,' . $major->id,
            'code_major' => 'required|string|max:10|unique:majors,code_major,' . $major->id,
        ], [
            'name.unique'       => 'Nama jurusan sudah ada.',
            'code_major.unique' => 'Kode jurusan sudah digunakan.',
        ]);

        DB::beginTransaction();
        try {
            $major->update([
                'name'       => $request->name,
                'code_major' => strtoupper($request->code_major),
            ]);

            DB::commit();
            return redirect()->route('data.majors.index')
                ->with('success', 'Jurusan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui jurusan.');
        }
    }

    public function destroy($id)
    {
        $major = Major::findOrFail($id);

        DB::beginTransaction();
        try {
            $major->delete();
            DB::commit();
            return redirect()->route('data.majors.index')
                ->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus jurusan. Mungkin masih digunakan di data lain.');
        }
    }
}
