@extends('layouts.main')

@section('container')

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                            <p class="text-center small">Enter your personal details to create account</p>
                        </div>

                        <form action="/register" method="post" class="row g-3 needs-validation">
                            @csrf
                            <div class="col-12">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    id="name" placeholder="Name" required value="{{ old('name') }}">

                                @error('name')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                                @error('email')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password"
                                    placeholder="Password" required>
                                @error('password')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Pilih Role</label>
                                <select class="form-select" name="role" id="role" aria-label="Default select example">
                                    <option value="1">Admin</option>
                                    <option value="2">Pegawai</option>
                                    <option value="3">Mahasiswa</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Create Account</button>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">Already have an account? <a href="/">Log in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
