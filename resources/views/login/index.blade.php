@extends('layouts.main')

@section('container')

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                

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

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                            <p class="text-center small">Enter your username & password to login</p>
                        </div>
                        <form action="/" method="POST" class="row g-3 needs-validation">
                            @csrf
                            <div class="col-12">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                                    
                                @error('email')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                                    required>
                                <div class="invalid-feedback">Please enter your password!</div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>

                            <div class="col-12">
                                <p class="small mb-0">Don't have account? <a href="/register">Create an account</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection
