<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Pembagi;
use App\Models\Normalisasi;
use App\Models\Terbobot;
use App\Models\Positifnegatif;
use App\Models\Dpositif;
use App\Models\Dnegatif;
use App\Models\Preferensi;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatif   = Alternatif::paginate(10);
        return view('dashboard.alternatif.index', [
            'title' => 'Manage Alternatif',
            'active' => 'alternatif',
            'alternatif' => $alternatif
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $alternatif = Alternatif::where('name', 'like', "%" . $keyword . "%")->paginate(5);
        return view('dashboard.alternatif.index', [
            'title' => $keyword,
            'active' => 'alternatif',
            'alternatif' => $alternatif
        ])->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('dashboard.alternatif.tambah', [
            'title' => 'Tambah Alternatif',
            'active' => 'alternatif'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Alternatif::create($request->all());

        $this->_hitung();
        return redirect('/alternatif')->with('success', 'Data Sukses Ditambahkan');
    }

    public function edit($id)
    {
        $alternatif = Alternatif::find($id);
        return view('dashboard.alternatif.edit',[
            'title' => 'Edit Data',
            'active' => 'alternatif'
        ], compact('alternatif'));
    }

    public function update(Request $request, $id)
    {
        $alternatif = Alternatif::find($id);
        $alternatif->name = $request->input('name');
        $alternatif->status_bangunan = $request->input('status_bangunan');
        $alternatif->status_lahan = $request->input('status_lahan');
        $alternatif->luas_lantai = $request->input('luas_lantai');
        $alternatif->jenis_lantai = $request->input('jenis_lantai');
        $alternatif->jenis_dinding = $request->input('jenis_dinding');
        $alternatif->fas_bab = $request->input('fas_bab');
        $alternatif->daya_listrik = $request->input('daya_listrik');
        $alternatif->status_bantuan = $request->input('status_bantuan');
        $alternatif->update();

        $this->_hitung();
        return redirect('/alternatif')->with('success', 'Data Sukses Diedit');
    }

    public function destroy($id)
    {
        $alternatif = Alternatif::where('id', $id)->delete();
        $this->_hitung();
        return redirect('/alternatif')->with('success', 'Data Sukses Dihapus');
    }

    private function _hitung()
	{
        // Mengisi Tabel Pembagi
        Pembagi::truncate();
        $alternatif = Alternatif::all();
        
        $status_lahan=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['status_lahan'], 2);
            $status_lahan += $kriteria;
        }
        $status_bangunan=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['status_bangunan'], 2);
            $status_bangunan += $kriteria;
        }
        $luas_lantai=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['luas_lantai'], 2);
            $luas_lantai += $kriteria;
        }
        $jenis_lantai=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['jenis_lantai'], 2);
            $jenis_lantai += $kriteria;
        }
        $jenis_dinding=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['jenis_dinding'], 2);
            $jenis_dinding += $kriteria;
        }
        $fas_bab=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['fas_bab'], 2);
            $fas_bab += $kriteria;
        }
        $daya_listrik=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['daya_listrik'], 2);
            $daya_listrik += $kriteria;
        }
        $status_bantuan=0;
        foreach ($alternatif as $a){
            $kriteria = 0;
            $kriteria = pow($a['status_bantuan'], 2);
            $status_bantuan += $kriteria;
        }

        Pembagi::insert([
            'status_lahan' => sqrt($status_lahan),
            'status_bangunan' => sqrt($status_bangunan),
            'luas_lantai' => sqrt($luas_lantai),
            'jenis_lantai' => sqrt($jenis_lantai),
            'jenis_dinding' => sqrt($jenis_dinding),
            'fas_bab' => sqrt($fas_bab),
            'daya_listrik' => sqrt($daya_listrik),
            'status_bantuan' => sqrt($status_bantuan)
        ]);

        //Mengisi Tabel Normalisasi
        Normalisasi::truncate();
        $pembagi = Pembagi::all();

        foreach ($pembagi as $p){
            $pembagi1 = $p['status_bangunan'];
            $pembagi2 = $p['status_lahan'];
            $pembagi3 = $p['luas_lantai'];
            $pembagi4 = $p['jenis_lantai'];
            $pembagi5 = $p['jenis_dinding'];
            $pembagi6 = $p['fas_bab'];
            $pembagi7 = $p['daya_listrik'];
            $pembagi8 = $p['status_bantuan'];
        }

        foreach ($alternatif as $a){
            Normalisasi::insert([
                'name' => $a['name'],
                'status_bangunan' => $a['status_bangunan']/$pembagi1,
                'status_lahan' => $a['status_lahan']/$pembagi2,
                'luas_lantai' => $a['luas_lantai']/$pembagi3,
                'jenis_lantai' => $a['jenis_lantai']/$pembagi4,
                'jenis_dinding' => $a['jenis_dinding']/$pembagi5,
                'fas_bab' => $a['fas_bab']/$pembagi6,
                'daya_listrik' => $a['daya_listrik']/$pembagi7,
                'status_bantuan' => $a['status_bantuan']/$pembagi8
            ]);
        }

        //Mengisi Tabel Normalisasi Terbobot
        Terbobot::truncate();
        $normalisasi = Normalisasi::all();

        foreach ($normalisasi as $n){
            Terbobot::insert([
                'name' => $n['name'],
                'status_bangunan' => $n['status_bangunan']*3,
                'status_lahan' => $n['status_lahan']*3,
                'luas_lantai' => $n['luas_lantai']*4,
                'jenis_lantai' => $n['jenis_lantai']*4,
                'jenis_dinding' => $n['jenis_dinding']*4,
                'fas_bab' => $n['fas_bab']*3,
                'daya_listrik' => $n['daya_listrik']*3,
                'status_bantuan' => $n['status_bantuan']*5
            ]);
        }

        //Mengisi Tabel PositifNegatif
        Positifnegatif::truncate();
        $terbobot = Terbobot::all();

        Positifnegatif::insert([
            'name' => 'Positif',
            'status_bangunan' => Terbobot::max('status_bangunan'),
            'status_lahan' => Terbobot::max('status_lahan'),
            'luas_lantai' => Terbobot::min('luas_lantai'),
            'jenis_lantai' => Terbobot::max('jenis_lantai'),
            'jenis_dinding' => Terbobot::max('jenis_dinding'),
            'fas_bab' => Terbobot::max('fas_bab'),
            'daya_listrik' => Terbobot::min('daya_listrik'),
            'status_bantuan' => Terbobot::max('status_bantuan')
        ]);
        Positifnegatif::insert([
            'name' => 'Negatif',
            'status_bangunan' => Terbobot::min('status_bangunan'),
            'status_lahan' => Terbobot::min('status_lahan'),
            'luas_lantai' => Terbobot::max('luas_lantai'),
            'jenis_lantai' => Terbobot::min('jenis_lantai'),
            'jenis_dinding' => Terbobot::min('jenis_dinding'),
            'fas_bab' => Terbobot::min('fas_bab'),
            'daya_listrik' => Terbobot::max('daya_listrik'),
            'status_bantuan' => Terbobot::min('status_bantuan')
        ]);

        //Mengisi Tabel D Positif
        Dpositif::truncate();
        $positif = Positifnegatif::find(1);

        foreach ($terbobot as $t){
            $status_bangunan = pow($positif->status_bangunan-$t['status_bangunan'], 2);
            $status_lahan = pow($positif->status_lahan-$t['status_lahan'], 2);
            $luas_lantai = pow($positif->luas_lantai-$t['luas_lantai'], 2);
            $jenis_lantai = pow($positif->jenis_lantai-$t['jenis_lantai'], 2);
            $jenis_dinding = pow($positif->jenis_dinding-$t['jenis_dinding'], 2);
            $fas_bab = pow($positif->fas_bab-$t['fas_bab'], 2);
            $daya_listrik = pow($positif->daya_listrik-$t['daya_listrik'], 2);
            $status_bantuan = pow($positif->status_bantuan-$t['status_bantuan'], 2);
            $hasil = $status_bangunan+$status_lahan+$luas_lantai+$jenis_lantai+$jenis_dinding+$fas_bab+$daya_listrik+$status_bantuan;

            Dpositif::insert([
                'name' => $t['name'],
                'nilai' => sqrt($hasil)
            ]);
        }

        //Mengisi Tabel D Negatif
        Dnegatif::truncate();
        $negatif = Positifnegatif::find(2);

        foreach ($terbobot as $t){
            $status_bangunan = pow($t['status_bangunan']-$negatif->status_bangunan, 2);
            $status_lahan = pow($t['status_lahan']-$negatif->status_lahan, 2);
            $luas_lantai = pow($t['luas_lantai']-$negatif->luas_lantai, 2);
            $jenis_lantai = pow($t['jenis_lantai']-$negatif->jenis_lantai, 2);
            $jenis_dinding = pow($t['jenis_dinding']-$negatif->jenis_dinding, 2);
            $fas_bab = pow($t['fas_bab']-$negatif->fas_bab, 2);
            $daya_listrik = pow($t['daya_listrik']-$negatif->daya_listrik, 2);
            $status_bantuan = pow($t['status_bantuan']-$negatif->status_bantuan, 2);
            $hasil = $status_bangunan+$status_lahan+$luas_lantai+$jenis_lantai+$jenis_dinding+$fas_bab+$daya_listrik+$status_bantuan;

            Dnegatif::insert([
                'name' => $t['name'],
                'nilai' => sqrt($hasil)
            ]);
        }

        //Mengisi Tabel Preferensi
        Preferensi::truncate();
        $dnegatif = Dnegatif::all();

        $n=1;
        foreach ($dnegatif as $dn){
            if($dn['nilai'] != 0){
                $dp = Dpositif::find($n);
                $nilai = $dn['nilai']/($dn['nilai']+$dp->nilai);
                Preferensi::insert([
                    'name' => $dn['name'],
                    'nilai' => $nilai,
                    'rangking' => 0
                ]);
                $n++;
            }else{
                Preferensi::insert([
                    'name' => $dn['name'],
                    'nilai' => 0,
                    'rangking' => 0
                ]);
            }
        }

        //Mengisi Rangking
        $preferensi = Preferensi::all()->SortByDesc('nilai');
        $n=1;
        foreach ($preferensi as $pre){
            $preferensi = Preferensi::find($pre['id']);
            $preferensi->rangking = $n++;
            $preferensi->update();
        }

    }
}
