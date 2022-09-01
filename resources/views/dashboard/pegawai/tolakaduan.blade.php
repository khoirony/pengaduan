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
        <div class="card-body">

            <!-- Floating Labels Form -->
            <form class="row g-3" action="/tolakaduan" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $id }}">
                <div class="col-12 mt-5">
                    <div class="form-floating">
                        <input class="form-control bg-light" type="text" value="{{ $aduan->mahasiswa->nama }}" readonly>
                        <label>Aduan Dari</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control bg-light" style="height: 100px;" readonly>{{ $aduan->isi_aduan }}</textarea>
                        <label for="floatingTextarea">Isi Aduan</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('tanggapan') is-invalid @enderror" name="tanggapan" id="tanggapan" style="height: 250px;" required></textarea>
                        <label for="floatingTextarea">Alasan Penolakan</label>
                        @error('tanggapan')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End floating Labels Form -->

        </div>
    </div>
</section>

@endsection
