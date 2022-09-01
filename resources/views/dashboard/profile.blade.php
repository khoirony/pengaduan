@extends('dashboard.layouts.main')

@section('container')
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            @if(Auth::user()->role == 1)
                <li class="breadcrumb-item">Admin</li>
            @elseif(Auth::user()->role == 2)
                <li class="breadcrumb-item">Pegawai</li>
            @else
                <li class="breadcrumb-item">Mahasiswa</li>
            @endif
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

@if(session()->has('success'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <img src="/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                    <h2>{{ Auth::user()->nama }}</h2>
                    <h3>{{ Auth::user()->email }}</h3>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        @if(Auth::user()->role == 2 || Auth::user()->role == 3)
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>
                        @endif

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Change Password</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-2">
                        @if(Auth::user()->role == 2 || Auth::user()->role == 3)
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Tentang</h5>
                            <p class="small fst-italic">{{ Auth::user()->tentang }}</p>

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->nama }}</div>
                            </div>
                            
                            <div class="row">
                                @if(Auth::user()->role == 2)
                                    <div class="col-lg-3 col-md-4 label">NIDN</div>
                                @elseif(Auth::user()->role == 3)
                                    <div class="col-lg-3 col-md-4 label">NPM</div>
                                @endif
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->kode }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Jurusan</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->jurusan }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Fakultas</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->fakultas }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Alamat</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->alamat }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">No Telp</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->no_telp }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form action="/profile" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}">
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="/img/profile-img.jpg" alt="Profile">
                                        <div class="pt-2">
                                            <input name="image" id="image" type="file" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="nama" type="text" class="form-control" id="nama"
                                            value="{{ Auth::user()->nama }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="tentang" class="col-md-4 col-lg-3 col-form-label">Tentang</label>
                                    <div class="col-md-8 col-lg-9">
                                        <textarea name="tentang" class="form-control" id="tentang"
                                            style="height: 100px">{{ Auth::user()->tentang }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    @if(Auth::user()->role == 2)
                                        <label for="kode" class="col-md-4 col-lg-3 col-form-label">NIDN</label>
                                    @elseif(Auth::user()->role == 3)
                                        <label for="kode" class="col-md-4 col-lg-3 col-form-label">NPM</label>
                                    @endif
                                    <div class="col-md-8 col-lg-9">
                                        <input name="kode" type="text" class="form-control" id="kode"
                                            value="{{ Auth::user()->kode }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="jurusan" class="col-md-4 col-lg-3 col-form-label">Jurusan</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="jurusan" type="text" class="form-control" id="jurusan"
                                            value="{{ Auth::user()->jurusan }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fakultas" class="col-md-4 col-lg-3 col-form-label">Fakultas</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="fakultas" type="text" class="form-control" id="fakultas" value="{{ Auth::user()->fakultas }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="alamat" type="text" class="form-control" id="alamat"
                                            value="{{ Auth::user()->alamat }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="no_telp" class="col-md-4 col-lg-3 col-form-label">No Telp</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="no_telp" type="text" class="form-control" id="no_telp"
                                            value="{{ Auth::user()->no_telp }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email"
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form><!-- End Profile Edit Form -->

                        </div>
                        @endif

                        <div class="tab-pane fade @if(Auth::user()->role == 1) show active @endif pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form action="/changepass" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Current
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="current_password" type="password" class="form-control"
                                            id="current_password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Password" class="col-md-4 col-lg-3 col-form-label">New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="Password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password_confirm" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password_confirm" type="password" class="form-control"
                                            id="password_confirm" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection