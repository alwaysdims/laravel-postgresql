<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->get();
        return view('admin.data-admin', compact('admins'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name'         => 'required',
            'username'     => 'required|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'number_phone' => 'nullable',
            'address'      => 'nullable',
        ]);

        // Buat user dulu
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => 'admin',
            'password' => Hash::make($request->password),
        ]);

        // Kalau user berhasil dibuat, buat data admin
        if ($user) {
            Admin::create([
                'user_id'      => $user->id,
                'name'         => $request->name,
                'address'      => $request->address,
                'number_phone' => $request->number_phone,
            ]);

            return redirect()->route('data.admins.index')
                ->with('success', 'Admin berhasil ditambahkan!');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan admin!');
        }
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->back()->with('error', 'Data admin tidak ditemukan!');
        }

        // Validasi (password boleh kosong = tidak diganti)
        $request->validate([
            'name'         => 'required',
            'username'     => 'required|unique:users,username,' . $admin->user->id,
            'email'        => 'required|email|unique:users,email,' . $admin->user->id,
            'password'     => 'nullable|min:6|confirmed', // boleh kosong
        ]);

        // Update User
        $admin->user->username = $request->username;
        $admin->user->email    = $request->email;

        if ($request->filled('password')) {
            $admin->user->password = Hash::make($request->password);
        }

        $admin->user->save();

        // Update Admin
        $admin->name         = $request->name;
        $admin->address      = $request->address;
        $admin->number_phone = $request->number_phone;
        $admin->save();

        return redirect()->route('data.admins.index')
            ->with('success', 'Admin berhasil diupdate!');
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        $user = User::find($admin->user_id);
        if ($admin) {
            $admin->delete(); // hapus user dulu, admin ikut kehapus karena cascade
            $user->delete(); // hapus admin setelah user
            return redirect()->back()->with(['success','Admin berhasil dihapus!']);
        } else {
            return redirect()->back()->with(['error' => false, 'message' =>  'Data tidak ditemukan!']);
        }
    }
}
