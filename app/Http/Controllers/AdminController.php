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
}
