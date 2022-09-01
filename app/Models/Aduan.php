<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function mahasiswa() 
	{
		return $this->belongsTo('App\Models\User', 'id_mahasiswa');
	}
    public function pegawai() 
	{
		return $this->belongsTo('App\Models\User', 'id_pegawai');
	}
}
