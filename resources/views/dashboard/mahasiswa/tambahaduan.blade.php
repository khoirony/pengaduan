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
            <form class="row g-3" action="/tambahaduan" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}">
                <div class="col-12 mt-5">
                    <div class="form-floating">
                        <textarea class="form-control @error('aduan') is-invalid @enderror" name="aduan" id="aduan" style="height: 250px;" required></textarea>
                        <label for="floatingTextarea">Masukkan Keluhan</label>
                        @error('aduan')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                  <input class="form-control" type="file" name="gambar" id="gambar">
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
