@extends('layouts.master')

@section('title', $company->name)

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<!-- Include the alerts file -->
@include('layouts.alerts')

<section class="section-padding">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h5>Building Info</h5>
                    <p><strong>Name:</strong> {{ $company->name }}</p>
                    <p><strong>Contact No:</strong>
                        @guest
                        <span class="badge bg-danger py-2">Please login to see the contact number.</span>
                        @endguest
                        @auth
                        <span class="badge bg-success py-2">
                            {{ $company->contact_no }}
                        </span>
                        @endauth
                    </p>
                    <p><strong>Address:</strong> {{ $company->address }}</p>
                    <p><strong>Country:</strong> {{ $company->country }}</p>
                    <p><strong>Empty flats:</strong> {{ $company->members->count() }}</p>
                    @guest
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="btn btn-secondary text-white gap-2" style="cursor:pointer;">
                            <a href="{{ route('login.index',['requestUrl' => request()->path()]) }}" class="text-white">Contact</a>
                            <i class="fa-solid fa-phone"></i>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h5>Floor Info</h5>
                    <p><strong>Total Floor:</strong> {{ $company->sections->count() }}</p>
                    <p><strong>Empty Floor Name:</strong>
                        @foreach ($emptySections as $section)
                        <span class="badge bg-info py-2">{{ $section->title }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
