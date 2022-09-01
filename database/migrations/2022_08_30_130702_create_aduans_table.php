<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa')->unsigned();
            $table->longText('isi_aduan')->nullable();
            $table->foreignId('id_pegawai')->unsigned();
            $table->longText('tanggapan')->nullable();
            $table->integer('status')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id')->on('users');  
            $table->foreign('id_pegawai')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aduans');
    }
}
