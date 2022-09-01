@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      @if(Auth::user()->role == 1)
        <li class="breadcrumb-item">Admin</li>
      @elseif(Auth::user()->role == 2)
        <li class="breadcrumb-item">Pegawai</li>
      @endif
      <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
@if(session()->has('success'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('loginError'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('loginError') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<section class="section dashboard">
  <div class="card">
    <div class="card-body pt-5">

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Tgl</th>
            <th scope="col">Nama Pengirim</th>
            <th scope="col">Aduan</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Tanggapan</th>
            <th scope="col">Status</th>
            <th scope="col" width="17%">aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($aduandiproses as $proses)
          <tr>
            <th scope="row">{{ $proses->created_at }}</th>
            <td>{{ $proses->mahasiswa->nama }}</td>
            <td>{{ $proses->isi_aduan }}</td>
            <td>{{ $proses->pegawai->nama }}</td>
            <td>{{ $proses->tanggapan }}</td>
            <td>
              @switch($proses->status)
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
            <td><a href="/selesaikanaduan/{{ $proses->id }}" class="btn btn-sm btn-success">Selesaikan</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</section>

@endsection