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
            <th scope="col">Waktu</th>
            <th scope="col">Nama Pengirim</th>
            <th scope="col">Aduan</th>
            <th scope="col">Status</th>
            <th scope="col">aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($aduanmasuk as $amasuk)
          <tr>
            <th scope="row">{{ $amasuk->created_at }}</th>
            <td>{{ $amasuk->mahasiswa->nama }}</td>
            <td>{{ $amasuk->isi_aduan }}</td>
            <td>
              @switch($amasuk->status)
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
            <td><a href="/tanggapiaduan/{{ $amasuk->id }}" class="btn btn-sm btn-primary">Tanggapi</a><a href="/tolakaduan/" class="btn btn-sm btn-danger ms-2">Tolak</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</section>

@endsection