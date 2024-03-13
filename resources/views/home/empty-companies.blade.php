@extends('layouts.master')

@section('title', 'Buildings')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<!-- Include the alerts file -->
@include('layouts.alerts')

<section class="section-padding">
    <div class="container">
        <div class="row mb-4">

            <div class="col-lg-10 col-12  mx-auto mb-4">
                <h2 class="mb-5 text-center">Bellow buildings have empty flats </h2>
                <p>Results Found: <strong>{{ $companies->count() }}</strong></p>
                <div class="row d-flex justify-content-center gap-2">
                    @if ($companies->count() > 0)
                    @foreach ($companies as $company)
                    <div class="card w-250">
                        <div class="card-body text-center">
                            <div class="d-flex flex-column justify-content-center">
                                <!-- Icon from Material Design Icons -->
                                <i class="fa-solid fa-building-circle-check icon-md text-secondary mb-4 text-center"></i>
                                <h5 class="card-title">{{ $company->name }}</h5>
                                <p class="card-text">{{ $company->address }}</p>
                            </div>
                            <a href="{{ route('companies.emptyposition.search.details',['companyId'=>$company->id]) }}" class="btn btn-secondary mt-3">Details</a>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h5 class="text-center">No results found</h5>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection