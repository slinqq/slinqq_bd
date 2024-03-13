@extends('adminlayouts.master')

@section('title', 'Dashboard')

@section('description', 'Building Management System. A web application for managing members of an organization.')



@section('styles')
<!-- Font Awesom -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
@endsection

@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="me-md-3 me-xl-5 mb-2 mb-md-0">
                <h2 class="fs-4">Welcome back, {{ auth()->user()->name }}</h2>
            </div>

            <span class="badge bg-success d-flex justify-content-between align-items-center">
                Total Count :
                <strong>
                    {{ count($admins) }}
                </strong>
            </span>
        </div>
    </div>
</div>
<!-- Include the alerts file -->
@include('layouts.alerts')
<div class=" row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @if (count($admins))
            @foreach ($admins as $admin)
            <div class="card w-300">
                <div class="card-body text-center">
                    <div class="d-flex flex-column justify-content-center">
                        <!-- Icon from Material Design Icons -->
                        <i class="fa-solid fa-building-circle-check icon-md text-secondary mb-4 text-center"></i>
                        <h5 class="card-title">{{ $admin->name }}</h5>
                        <p class="card-text">{{ $admin->address }}</p>
                    </div>
                    <a href="{{ route('superadmin.manage',['userId' => $admin->id]) }}" class="btn btn-secondary mt-3">Manage</a>
                </div>
            </div>
            @endforeach
            @else
            <h1>No admins found</h1>
            @endif
        </div>
    </div>
</div>
@endsection
