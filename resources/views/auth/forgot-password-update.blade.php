@extends('layouts.master')

@section('title', 'Update Password')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="row gy-4 d-flex justify-content-center">
            <div class="login-block col-lg-6">
                <div class="card p-4 border-0">
                    <h2 class="login-block-text">Change Password</h2>
                    <form method="POST" action="{{ route('forgot-password.update',['token' => request('token')]) }}" class="form-inline">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="exampleInputpassword1" class="mr-2">New Password</label>
                            <input type="password" class="form-control" id="exampleInputpassword1" aria-describedby="passwordHelp" placeholder="Enter new password" name="password" value="{{ old('password') }}" autocomplete="password" autofocus>
                        </div>
                        @error('password')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

                        <div class="form-group mb-4">
                            <label for="exampleInputpassword1" class="mr-2">New Password</label>
                            <input type="password" class="form-control" id="exampleInputcpassword1" aria-describedby="cpasswordHelp" placeholder="Confirm password" name="password_confirmation">
                        </div>

                        @error('error')
                        <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                        @enderror
                        @include('layouts.alerts')
                        <div class="form-group mb-4">
                            <button type="submit" class="btn custom-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
