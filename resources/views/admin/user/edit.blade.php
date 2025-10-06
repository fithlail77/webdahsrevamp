@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Ubah Data Pengguna</h1>

<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="#">Profile</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="{{ asset('adminpage/img/undraw_profile.svg') }}" alt="" />
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
            <div class="card-header">Detil Akun</div>
                <div class="card-body">
                    <form action="{{route('user.update', [$user->id])}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Nama Pengguna</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Nama Pengguna" value="{{$user->name}}" readonly />
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">Email </label>
                                <input class="form-control" id="inputFirstName" type="text" placeholder="Nama Profil" value="{{$user->email}}" readonly />
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                @foreach ($user->roles as $role)
                                <label class="small mb-1" for="inputLastName">Akses</label>
                                <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" value="{{$role->name}}" readonly />
                                @endforeach
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Ubah Akses</label>
                            <select id="roles" name="role" class="form-control" required>
                                <option value="">--Pilih Akses--</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="ke">Kerani Estate</option>
                                <option value="dc">Data Center</option>
                                <option value="kcpo">Admin Mill</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary btn-send" type="submit">Simpan</button>
                        <a href="{{ route('user.index') }}"><input type="Button" class="btn btn-secondary btn-send" value="Kembali"></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection