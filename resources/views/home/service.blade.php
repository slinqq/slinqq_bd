@extends('layouts.master')

@section('title', 'Home')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<!-- Include the alerts file -->
@include('layouts.alerts')

<section class="section-padding bg-image" style="
    background-image: url('{{ asset('assets/images/service/pexels-eric-prouzet-6738199.jpg') }}');
    height: auto;
    background-size: cover;
  ">
    <div class="container">
        <div class="row mb-4">

            <div class="col-lg-10 col-12 text-center mx-auto mb-4">
                <h2 class="mb-5">Our Services</h2>
             
            </div>

            <div class="col-md-12 mb-4 d-flex justify-content-center align-items-center">
                <div class="featured-block d-flex justify-content-center align-items-center py-4">
                    <a href="{{ route('companies') }}" class="d-block">
                        <i class="fa-solid fa-house-signal fa-2x featured-block-image img-fluid my-4"></i>

                        <p class="featured-block-text">Manage Your <strong>Building</strong></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection