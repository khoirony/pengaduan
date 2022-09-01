@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item">Mahasiswa</li>
      <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="card">
    <div class="card-body pt-5">

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Waktu</th>
            <th scope="col">Aduan</th>
            <th scope="col">Status</th>
            <th scope="col">Tanggapan</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($aduan as $a)
          <tr>
            <th scope="row">{{ $a->created_at }}</th>
            <td>{{ $a->isi_aduan }}</td>
            <td>
              @switch($a->status)
                  @case(0)
                    {{ 'Menunggu' }}
                    @break
                  @case(1)
                    {{ 'Sedang Diproses' }}
                    @break
                  @case(2)
                    {{ 'Selesai' }}
                    @break
                  @case(9)
                    {{ 'Ditolak' }}
                    @break
              @endswitch
            </td>
            @if ($a->status == 1 && $a->status == 2)    
              <td>{{ $a->tanggapan }}</td>
              <td>{{ $a->pegawai->nama }}</td>
              <td></td>
            @else
              <td>-Belum Ada-</td>
              <td>-Belum Ada-</td>
              <td>
                <a href="/editaduan/{{ $a->id }}" class="btn btn-sm btn-primary">Edit</a>
              </td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</section>

@endsection