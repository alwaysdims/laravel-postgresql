<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->get();
        return view('admin.subject', compact('subjects'));
    }

    public function create()
    {
        // tidak dipakai karena pakai modal di index
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:subjects,name',
            'code_subject'  => 'required|string|max:20|unique:subjects,code_subject',
        ], [
            'name.unique'         => 'Nama mata pelajaran sudah ada.',
            'code_subject.unique' => 'Kode mata pelajaran sudah digunakan.',
        ]);

        DB::beginTransaction();
        try {
            Subject::create([
                'name'         => $request->name,
                'code_subject' => strtoupper($request->code_subject),
            ]);

            DB::commit();
            return redirect()->route('data.subjects.index')
                ->with('success', 'Mata pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambah mata pelajaran. Silakan coba lagi.');
        }
    }

    public function show($id)
    {
        // tidak dipakai
    }

    public function edit($id)
    {
        // tidak dipakai karena edit langsung di modal index
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'code_subject' => 'required|string|max:20|unique:subjects,code_subject,' . $subject->id,
        ], [
            'name.unique'         => 'Nama mata pelajaran sudah ada.',
            'code_subject.unique' => 'Kode mata pelajaran sudah digunakan.',
        ]);

        DB::beginTransaction();
        try {
            $subject->update([
                'name'         => $request->name,
                'code_subject' => strtoupper($request->code_subject),
            ]);

            DB::commit();
            return redirect()->route('data.subjects.index')
                ->with('success', 'Mata pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui mata pelajaran.');
        }
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);

        DB::beginTransaction();
        try {
            $subject->delete();
            DB::commit();
            return redirect()->route('data.subjects.index')
                ->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus mata pelajaran. Mungkin masih digunakan.');
        }
    }
}
