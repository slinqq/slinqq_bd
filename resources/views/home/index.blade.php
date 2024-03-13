@extends('layouts.master')

@section('title', 'Home')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<!-- Include the alerts file -->
@include('layouts.alerts')

<section class="hero-section hero-section-full-height">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12 col-12 p-0">
                <div id="hero-slide" class="carousel carousel-fade slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('assets/images/slide/pexels-pixabay-302769(1).jpg') }}" class="carousel-image img-fluid" alt="building image">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('assets/images/slide/pexels-eric-prouzet-6738199.jpg') }}" class="carousel-image img-fluid" alt="building image">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('assets/images/slide/pexels-suki-lee-13644277.jpg') }}" class="carousel-image img-fluid" alt="building image">
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#hero-slide" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#hero-slide" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="section-padding">
    <div class="container">
        <div class="row mb-4">

            <div class="col-lg-10 col-12 text-center mx-auto mb-4">
                <h2 class="mb-5">Our Services</h2>
                <p>
                    Manage your building, Appartment, Flats from here. 
                </p>
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
