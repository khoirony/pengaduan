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
        $aduanmasuk  = Aduan::where('status', 0)->where('id_mahasiswa', Auth::user()->id)->count();
        $aduandiproses  = Aduan::where('status', 1)->where('id_mahasiswa', Auth::user()->id)->count();
        $aduanselesai  = Aduan::where('status', 2)->where('id_mahasiswa', Auth::user()->id)->count();
        $aduanditolak  = Aduan::where('status', 9)->where('id_mahasiswa', Auth::user()->id)->count();
        return view('dashboard.mahasiswa.index', [
            'title' => 'Dashboard',
            'aduanmasuk' => $aduanmasuk,
            'aduandiproses' => $aduandiproses,
            'aduanselesai' => $aduanselesai,
            'aduanditolak' => $aduanditolak
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
            'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
        ]);
        $file = $request->file('gambar');
        $name = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'aduan';
	    $file->move($tujuan_upload,$name);
           
        $aduan = new Aduan;
        $aduan->id_mahasiswa = $request->input('id');
        $aduan->isi_aduan = $request->input('aduan');
        $aduan->gambar = $name;
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

    public function editaduan($id)
    {
        $aduan  = Aduan::where('id', $id)->first();
        return view('dashboard.mahasiswa.editaduan', [
            'title' => 'Kelola Aduan',
            'aduan' => $aduan,
        ]);
    }

    public function storeedit(Request $request)
    {
        $request->validate([
            'aduan' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
        ]);
        
        $file = $request->file('gambar');
        $name = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'aduan';
	    $file->move($tujuan_upload,$name);
        
        $aduan = Aduan::find($request->input('id'));
        $aduan->isi_aduan = $request->input('aduan');
        $aduan->gambar = $name;
        $aduan->status = 0;
        $aduan->update();

        return redirect('/historyaduan')->with('success', 'Aduan Sukses Diedit');
    }

    public function hapusaduan($id)
    {
        $aduan = Aduan::where('id', $id)->delete();
        return redirect('/historyaduan')->with('success', 'Aduan Berhasil Dihapus');
    }
}
