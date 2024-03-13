@extends('layouts.master')

@section('title', 'Login')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="row gy-4 d-flex justify-content-center">
            <div class="login-block col-lg-6" data-aos="fade-up" data-aos-delay="250">
                <div class="card p-4 border-0">
                    <h2 class="login-block-text">Login</h2>
                    @include('layouts.alerts')
                    <form method="POST" action="{{ route('login.store') }}" class="form-inline">
                        @csrf
                        @if($query)
                        <input type="hidden" name="query" value="{{ $query }}">
                        @endif
                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1" class="mr-2">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                        </div>
                        @error('email')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-4">
                            <label for="exampleInputPassword1" class="mr-2">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" autocomplete="password">
                        </div>
                        @error('password')
                        <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                        @enderror

                        @error('error')
                        <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-4 d-flex justify-content-between">
                            <button type="submit" class="btn custom-btn">Submit</button>
                            <a href="{{ route('forgot-password') }}">Forgot Password ?</a>
                        </div>

                        <!--@if (request('requestUrl')) after div @endif-->
                        <div class="form-group mb-4">
                            Don't have an account?
                            <a href="{{ route('signup.index',['routeName' => 'companies.emptyposition.search.details']) }}"
                             class="text-primary"> Signup</a>
                        </div>
                      
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection