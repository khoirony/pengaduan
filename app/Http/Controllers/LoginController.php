<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Mahasiswa;

class LoginController extends Controller
{
    public function index(){
        return view('login.index', [
            'title' => 'Login Pengaduan Mahasiswa'
        ]);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', 'like', "%" . $request->email . "%")->first();
        // echo $user->role;
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            if($user->role == 1){
                
                return redirect()->intended('/admin');
            }elseif($user->role == 2){
                return redirect()->intended('/pegawai');
            }elseif($user->role == 3){
                return redirect()->intended('/mahasiswa');
            }
        }

        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request){
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
