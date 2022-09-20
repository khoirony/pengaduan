<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aduan;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $jmlpegawai   = User::where('role', 2)->count();
        $jmlmhs  = User::where('role', 3)->count();
        $aduanmasuk  = Aduan::where('status', 0)->count();
        $aduandiproses  = Aduan::where('status', 1)->count();
        $aduanselesai  = Aduan::where('status', 2)->count();
        $aduanditolak  = Aduan::where('status', 9)->count();
        return view('dashboard.admin.index', [
            'title' => 'Dashboard',
            'jmlpegawai' => $jmlpegawai,
            'jmlmhs' => $jmlmhs,
            'aduanmasuk' => $aduanmasuk,
            'aduandiproses' => $aduandiproses,
            'aduanselesai' => $aduanselesai,
            'aduanditolak' => $aduanditolak
        ]);
    }

    public function tambahpegawai()
    {
        $user   = User::where('role', 2)->paginate(10);
        return view('dashboard.admin.tambahpegawai', [
            'title' => 'Tambah Pegawai',
            'user' => $user,
            'n' => 1
        ]);
    }

    public function storepegawai(Request $request)
    {   
        if(strcmp($request->input('repassword'), $request->input('password')) != 0){
            return redirect()->back()->with('error','Password dan repassword tidak boleh berbeda.');
        }

        $user = new User;
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = 2;
        $user->save();

        return redirect('/tambahpegawai')->with('success', 'Pegawai Berhasil Ditambah');
    }

    public function editpegawai($id)
    {
        $user   = User::where('role', 2)->paginate(10);
        $pegawai = User::where('id', $id)->first();
        return view('dashboard.admin.editpegawai', [
            'title' => 'Edit pegawai',
            'user' => $user,
            'pegawai' => $pegawai,
            'n' => 1
        ]);
    }

    public function updatepegawai(Request $request)
    {   
        if(strcmp($request->input('repassword'), $request->input('password')) != 0){
            return redirect()->back()->with('error','Password dan repassword tidak boleh berbeda.');
        }

        $user = User::find($request->input('id'));
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->update();

        return redirect('/tambahpegawai')->with('success', 'pegawai Berhasil Ditambah');
    }

    public function hapuspegawai($id)
    {
        $user = User::where('id', $id)->delete();
        return redirect('/tambahpegawai')->with('success', 'Pegawai Berhasil Dihapus');
    }
}
