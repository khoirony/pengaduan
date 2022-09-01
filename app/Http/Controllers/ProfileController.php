<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Mahasiswa;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile', [
            'title' => 'Profile',
            'active' => 'profile'
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
        ]);

        $file = $request->file('image');
        $name = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'profpic';
	    $file->move($tujuan_upload,$name);

        $user = User::find($request->input('id'));
        $user->kode = $request->input('kode');
        $user->nama = $request->input('nama');
        $user->image = $name;
        $user->tentang = $request->input('tentang');
        $user->jurusan = $request->input('jurusan');
        $user->fakultas = $request->input('fakultas');
        $user->alamat = $request->input('alamat');
        $user->no_telp = $request->input('no_telp');
        $user->email = $request->input('email');
        $user->update();

        return redirect('/profile')->with('success', 'Data Sukses Diedit');
    }

    public function changepass(Request $request)
    {
        if (!(Hash::check($request->input('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with('error','Current Password Tidak Sesuai. Harap Ulangi Lagi');
        }
             
        if(strcmp($request->input('current_password'), $request->input('password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with('error','Password baru tidak boleh sama dengan password lama, harap gunakan password yang berbeda.');
        }
        
        if(!(strcmp($request->input('password'), $request->input('password_confirm'))) == 0){
            //New password and confirm password are not same
            return redirect()->back()->with('error','Password Baru dan Ulangi Password Harus Sama.');
        }
            
        //Change Password
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->input('password'));
        $user->update();

        return redirect('/profile')->with('success', 'Password Sukses Diganti');
    }
}
