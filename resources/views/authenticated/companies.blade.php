@extends('adminlayouts.master')

@section('title', 'Buildings')

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
            @hasrole('admin|superadmin')
            <a href="{{ route('companies.managers.add') }}" class="btn btn-secondary mt-2 mt-md-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add manager for all of your buildings">Add Manager</a>
            @endhasrole
        </div>
    </div>
</div>
<!-- Include the alerts file -->
@include('layouts.alerts')
<div class=" row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @if (count($companies))
            @foreach ($companies as $company)
            <div class="card w-300">
                <div class="card-body text-center">
                    <div class="d-flex flex-column justify-content-center">
                        <!-- Icon from Material Design Icons -->
                        <i class="fa-solid fa-building-circle-check icon-md text-secondary mb-4 text-center"></i>
                        <h5 class="card-title">{{ $company->name }}</h5>
                        <p class="card-text">{{ $company->address }}</p>
                    </div>
                    <a href="{{ route('company.manage', ['companyId' => $company->id]) }}" class="btn btn-secondary mt-3">Manage</a>
                </div>
            </div>
            @endforeach
            @hasrole('admin|')
            <a href="{{ route('company.add') }}" class="card cursor-pointer">
                <div class="d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-start p-3 item gap-3">
                    <div class="d-flex align-items-center justify-content-evenly btn btn-success text-dark">
                        <h5 class="mb-0 d-inline-block">Add Another Building</h5>
                        <i class="mdi mdi-plus icon-lg me-3 "></i>
                    </div>
                </div>
            </a>
            @endhasrole
            @else
            @hasrole('admin|')
            <a href="{{ route('company.add') }}" class="card cursor-pointer">
                <div class="d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-start p-3 item gap-3">
                    <div class="d-flex align-items-center justify-content-evenly btn btn-success text-dark">
                        <h5 class="mb-0 d-inline-block">Add Building</h5>
                        <i class="mdi mdi-plus icon-lg me-3 "></i>
                    </div>
                </div>
            </a>
            @endhasrole
            @endif
        </div>
    </div>
</div>
@endsection
