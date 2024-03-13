@extends('layouts.master')

@section('title', 'Forgot Password')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="row gy-4 d-flex justify-content-center">
            <div class="login-block col-lg-6">
                <div class="card p-4 border-0">
                    <h2 class="login-block-text">Forgot Password</h2>
                    <form method="POST" action="{{ route('forgot-password.store') }}" class="form-inline">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1" class="mr-2">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                        </div>
                        @error('email')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

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
