<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pegawai;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'role' => 1
        ]);

        User::create([
            'kode' => '332364647',
            'nama' => 'Eko Prayoga',
            'email' => 'eko@gmail.com',
            'password' => bcrypt('12345'),
            'jurusan' => 'Teknik Informatika',
            'fakultas' => 'Teknik',
            'tentang' => 'Saya Sebagai Dosen Disini',
            'alamat' => 'Lamongan, jawa Timur',
            'no_telp' => '08385893585829',
            'role' => 2
        ]);

        User::create([
            'kode' => '78675665',
            'nama' => 'Khoirony Arief',
            'email' => 'khoirony@gmail.com',
            'password' => bcrypt('12345'),
            'jurusan' => 'Teknik Informatika',
            'fakultas' => 'Teknik',
            'tentang' => 'Programmer Pemula',
            'alamat' => 'Lamongan, jawa Timur',
            'no_telp' => '083870461640',
            'role' => 3
        ]);
        
    }
}
