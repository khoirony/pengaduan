@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item">Admin</li>
      <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-5">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Form Pegawai</h5>

          <!-- Vertical Form -->
          <form action="/tambahpegawai" method="POST" class="row g-3">
            <div class="col-12">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="col-12">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password">
            </div>
            <div class="col-12">
              <label for="inputAddress" class="form-label">Re-Password</label>
              <input type="repassword" class="form-control" id="repassword">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form><!-- Vertical Form --><!-- End General Form Elements -->

        </div>
      </div>

    </div>

    <div class="col-lg-7">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Pegawai</h5>

          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col" width="17%">aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user as $u)
              <tr>
                <th scope="row">{{ $n++ }}</th>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td><a href="/editpegawai/{{ $u->id }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a> <a href="/editpegawai/{{ $u->id }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>

    </div>
  </div>
</section>

@endsection