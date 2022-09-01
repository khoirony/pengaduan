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

    public function aduanmasuk()
    {
        $aduanmasuk  = Aduan::where('status', 0)->get();
        return view('dashboard.pegawai.aduanmasuk', [
            'title' => 'Pengaduan Masuk',
            'aduanmasuk' => $aduanmasuk
        ]);
    }

    public function tanggapiaduan($id)
    {
        $aduan  = Aduan::where('id', $id)->first();
        return view('dashboard.pegawai.tanggapiaduan', [
            'title' => 'Tanggapi Aduan',
            'aduan' => $aduan,
            'id' => $id
        ]);
    }

    public function storetanggapan(Request $request)
    {
        $aduan = Aduan::find($request->input('id'));
        $aduan->id_pegawai = Auth::user()->id;
        $aduan->tanggapan = $request->input('tanggapan');
        $aduan->status = 1;
        $aduan->update();

        return redirect('/aduanmasuk')->with('success', 'Aduan Sukses Ditanggapi');
    }

    public function aduandiproses()
    {
        $aduandiproses  = Aduan::where('status', 1)->get();
        return view('dashboard.pegawai.aduandiproses', [
            'title' => 'Pengaduan Diproses',
            'aduandiproses' => $aduandiproses
        ]);
    }

    public function aduanditolak()
    {
        $aduanditolak  = Aduan::where('status', 9)->get();
        return view('dashboard.pegawai.aduanditolak', [
            'title' => 'Pengaduan Ditolak',
            'aduanditolak' => $aduanditolak
        ]);
    }

    public function aduanselesai()
    {
        $aduanselesai  = Aduan::where('status', 2)->get();
        return view('dashboard.pegawai.aduanselesai', [
            'title' => 'Pengaduan Selesai',
            'aduanselesai' => $aduanselesai
        ]);
    }
}
