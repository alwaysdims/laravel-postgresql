<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm(){
        return view('login');
    }
    public function login(Request $request){
        $rules = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $cek = User::where('email',$request->email)->first();

        if(!$cek){
            return redirect()->back()->with('error','Email nor found!');
        }

        if(Auth::attempt($rules)){

            $request->session()->regenerate();
            $user = Auth::user();

            if($user->role === 'admin'){
                return redirect()->route('data.admins.index')->with('success','Selamat datang '. Auth::user()->username . '!');
            } elseif($user->role === 'teacher'){
                return redirect()->route('teacher.dashboard')->with('success','Selamat datang '. Auth::user()->username . '!');
            } else{
                return redirect()->route('student.dashboard')->with('success','Selamat datang '. Auth::user()->username . '!');
            }
        }else{
            return redirect()->back()->with('error','Invalid email or password!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }


}

