<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Major;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user','subject')->latest()->get();
        $subjects = Subject::all();
        return view('admin.data-teacher', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'required|string|max:20|unique:teachers,nip',
            'name'          => 'required|string|max:255',
            'subject_id'       => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email',
            'username'      => 'required|string|max:50|unique:users,username',
            'password'      => 'required|min:6|confirmed',
            'address'       => 'nullable|string',
            'number_phone'  => 'nullable|string|max:15',
        ]);


        DB::beginTransaction();
        try {
            // Buat User dulu (role = teacher)
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => 'teacher',
            ]);

            // Buat Teacher
            Teacher::create([
                'user_id'      => $user->id,
                'nip'          => $request->nip,
                'name'         => $request->name,
                'subjects_id'      => $request->subject_id,
                'address'      => $request->address,
                'number_phone' => $request->number_phone,
            ]);

            DB::commit();
            return redirect()->route('data.teachers.index')
                ->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambah guru. Pastikan data tidak duplikat.');
        }
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'nip'           => 'required|string|max:20|unique:teachers,nip,' . $teacher->id,
            'name'          => 'required|string|max:255',
            'subject_id'       => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email,' . $teacher->user_id,
            'username'      => 'required|string|max:50|unique:users,username,' . $teacher->user_id,
            'password'      => 'nullable|min:6|confirmed',
            'address'       => 'nullable|string',
            'number_phone'  => 'nullable|string|max:15',
        ]);

        DB::beginTransaction();
        try {
            // Update User
            $teacher->user->update([
                'name'     => $request->name,
                'email'    => $request->email,
                'username' => $request->username,
                'password' => $request->filled('password') ? Hash::make($request->password) : $teacher->user->password,
            ]);

            // Update Teacher
            $teacher->update([
                'nip'          => $request->nip,
                'name'         => $request->name,
                'subject_id'      => $request->subject_id,
                'address'      => $request->address,
                'number_phone' => $request->number_phone,
            ]);

            DB::commit();
            return redirect()->route('data.teachers.index')
                ->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data guru.');
        }
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        DB::beginTransaction();
        try {
            $teacher->user()->delete(); // Hapus user terkait
            $teacher->delete();

            DB::commit();
            return redirect()->route('data.teachers.index')
                ->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus guru.');
        }
    }
}
