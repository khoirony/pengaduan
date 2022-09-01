<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Aduan;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('dashboard.mahasiswa.index', [
            'title' => 'Dashboard',
        ]);
    }

    public function tambahaduan()
    {
        return view('dashboard.mahasiswa.tambahaduan', [
            'title' => 'Tambah Pengaduan'
        ]);
    }

    public function storeaduan(Request $request)
    {
        $request->validate([
            'aduan' => 'required',
        ]);

        $aduan = new Aduan;
        $aduan->id_mahasiswa = $request->input('id');
        $aduan->isi_aduan = $request->input('aduan');
        $aduan->id_pegawai = 1;
        $aduan->status = 0;
        $aduan->save();

        return redirect('/tambahaduan')->with('success', 'Aduan Sukses Terkirim');
    }

    public function historyaduan()
    {
        $aduan = Aduan::where('id_mahasiswa', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('dashboard.mahasiswa.historyaduan', [
            'title' => 'History Aduan',
            'aduan' => $aduan
        ]);
    }
}
