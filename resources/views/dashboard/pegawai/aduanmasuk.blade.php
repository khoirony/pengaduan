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
                    <span class="badge bg-primary">{{ 'Menunggu' }}</span>
                    @break
                  @case(1)
                  <span class="badge bg-warning">{{ 'Sedang Diproses' }}</span>
                    @break
                  @case(2)
                    <span class="badge bg-success">{{ 'Selesai' }}</span>
                    @break
                  @case(9)
                    <span class="badge bg-danger">{{ 'Ditolak' }}</span>
                    @break
              @endswitch
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#id{{ $amasuk->id }}"><i class="bi bi-image"></i></button>
              <a href="/kelolatanggapan/{{ $amasuk->id }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a> 
              <a href="/hapustanggapan/{{ $amasuk->id }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <div class="modal fade" id="id{{ $amasuk->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content w-100">
                <div class="modal-header">
                  <h5 class="modal-title">Gambar Bukti</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @if($amasuk->gambar != null)
                  <div class="text-center">
                    <img src="{{ url('/aduan/'.$amasuk->gambar) }}" alt="gambar" class="w-100">
                  </div>
                  @else
                  <div class="text-center">
                    -kosong-
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</section>

@endsection