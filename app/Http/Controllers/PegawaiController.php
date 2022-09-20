<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Aduan;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('dashboard.pegawai.index', [
            'title' => 'Dashboard',
        ]);
    }

    public function tambahmahasiswa()
    {
        $user   = User::where('role', 3)->paginate(10);
        return view('dashboard.pegawai.tambahmahasiswa', [
            'title' => 'Tambah Mahasiswa',
             'user' => $user,
            'n' => 1
        ]);
    }

    public function storemahasiswa(Request $request)
    {   
        if(strcmp($request->input('repassword'), $request->input('password')) != 0){
            return redirect()->back()->with('error','Password dan repassword tidak boleh berbeda.');
        }

        $user = new User;
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = 3;
        $user->save();

        return redirect('/tambahmahasiswa')->with('success', 'Mahasiswa Berhasil Ditambah');
    }

    public function editmahasiswa($id)
    {
        $user   = User::where('role', 3)->paginate(10);
        $mahasiswa = User::where('id', $id)->first();
        return view('dashboard.pegawai.editmahasiswa', [
            'title' => 'Edit Mahasiswa',
            'user' => $user,
            'mahasiswa' => $mahasiswa,
            'n' => 1
        ]);
    }

    public function updatemahasiswa(Request $request)
    {   
        if(strcmp($request->input('repassword'), $request->input('password')) != 0){
            return redirect()->back()->with('error','Password dan repassword tidak boleh berbeda.');
        }

        $user = User::find($request->input('id'));
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = 3;
        $user->update();

        return redirect('/tambahmahasiswa')->with('success', 'Mahasiswa Berhasil Ditambah');
    }

    public function hapusmahasiswa($id)
    {
        $user = User::where('id', $id)->delete();
        return redirect('/tambahmahasiswa')->with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function aduanmasuk()
    {
        $aduanmasuk  = Aduan::where('status', 0)->orderBy('created_at', 'desc')->get();
        return view('dashboard.pegawai.aduanmasuk', [
            'title' => 'Pengaduan Masuk',
            'aduanmasuk' => $aduanmasuk
        ]);
    }

    public function kelolatanggapan($id)
    {
        $aduan  = Aduan::where('id', $id)->first();
        return view('dashboard.pegawai.kelolatanggapan', [
            'title' => 'Kelola Aduan',
            'aduan' => $aduan,
            'id' => $id
        ]);
    }

    public function storetanggapan(Request $request)
    {
        $aduan = Aduan::find($request->input('id'));
        $aduan->id_pegawai = Auth::user()->id;
        $aduan->tanggapan = $request->input('tanggapan');
        $aduan->status = $request->input('status');
        $aduan->update();

        switch($request->input('status')){
            case 1: 
                $stat = 'Diproses'; 
                $link = 'aduandiproses';
                break;
            case 2: 
                $stat = 'Diselesaikan';
                $link = 'aduanselesai';
                break;
            case 9: 
                $stat = 'Ditolak';
                $link = 'aduanditolak';
                break;
            case 0: 
                $stat = 'Dibatalkan';
                $link = 'aduanmasuk';
                break;
        }

        return redirect('/'.$link)->with('success', 'Aduan Berhasil '. $stat);
    }

    public function hapustanggapan($id)
    {
        $aduan = Aduan::where('id', $id)->delete();
        return back()->with('success', 'Aduan Berhasil Dihapus');
    }

    public function aduandiproses()
    {
        $aduandiproses  = Aduan::where('status', 1)->orderBy('updated_at', 'desc')->get();
        return view('dashboard.pegawai.aduandiproses', [
            'title' => 'Pengaduan Diproses',
            'aduandiproses' => $aduandiproses
        ]);
    }

    public function aduanditolak()
    {
        $aduanditolak  = Aduan::where('status', 9)->orderBy('updated_at', 'desc')->get();
        return view('dashboard.pegawai.aduanditolak', [
            'title' => 'Pengaduan Ditolak',
            'aduanditolak' => $aduanditolak
        ]);
    }

    public function aduanselesai()
    {
        $aduanselesai  = Aduan::where('status', 2)->orderBy('updated_at', 'desc')->get();
        return view('dashboard.pegawai.aduanselesai', [
            'title' => 'Pengaduan Selesai',
            'aduanselesai' => $aduanselesai
        ]);
    }

}
