@extends('layouts.master')

@section('title', 'Setion Add')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="row gy-4 d-flex justify-content-center">
            <div class="login-block col-lg-6" data-aos="fade-up" data-aos-delay="250">
                <div class="card p-4 border-0">
                    <h2 class="login-block-text">Add floor for {{ $company->name }}</h2>
                    <form method="POST" action="{{ route('section.store',['companyId'=> $company->id ])  }}" class="form-inline">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="exampleInputtitle1" class="mr-2">Title</label>
                            <input type="text" class="form-control" id="exampleInputtitle1"  placeholder="Enter title" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>
                        </div>
                        @error('title')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

                        @error('error')
                        <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                        @enderror
                        @include('layouts.alerts')
                        <div class="form-group mb-4 d-flex justify-content-between">
                            <button type="submit" class="btn custom-btn">Submit</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection
