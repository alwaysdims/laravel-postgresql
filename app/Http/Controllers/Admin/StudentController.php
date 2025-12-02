<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'classes.major'])->latest()->get();
        $classes  = Classes::with('major')->get(); // untuk select kelas di modal
        return view('admin.data-student', compact('students', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'nis'       => 'required|string|max:20|unique:students,nis',
            'class_id'  => 'required|exists:class,id',
            'username'  => 'required|string|max:50|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->nama,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'student',
            ]);

            Student::create([
                'user_id'  => $user->id,
                'nama'     => $request->nama,
                'nis'      => $request->nis,
                'class_id' => $request->class_id,
            ]);

            DB::commit();
            return redirect()->route('data.students.index')
                ->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambah siswa. Pastikan NIS/Username/Email belum digunakan.');
        }
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'nis'       => 'required|string|max:20|unique:students,nis,' . $student->id,
            'class_id'  => 'required|exists:class,id',
            'username'  => 'required|string|max:50|unique:users,username,' . $student->user_id,
            'email'     => 'required|email|unique:users,email,' . $student->user_id,
            'password'  => 'nullable|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Update User
            $student->user->update([
                'name'     => $request->nama,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => $request->filled('password') ? Hash::make($request->password) : $student->user->password,
            ]);

            // Update Student
            $student->update([
                'nama'     => $request->nama,
                'nis'      => $request->nis,
                'class_id' => $request->class_id,
            ]);

            DB::commit();
            return redirect()->route('data.students.index')
                ->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data siswa.');
        }
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        DB::beginTransaction();
        try {
            $student->user()->delete(); // Hapus user → student otomatis terhapus (cascade)
            $student->delete();

            DB::commit();
            return redirect()->route('data.students.index')
                ->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus siswa.');
        }
    }
}
