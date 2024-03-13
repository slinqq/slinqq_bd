@extends('adminlayouts.master')

@section('title', 'Companies')

@section('description', 'Building Management System. A web application for managing members of an organization.')



@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5 d-flex gap-2">
                    <h5><a href="{{ route('companies') }}">Buildings</a> /</h5>
                    <h5>Payment Collection</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.alerts')
<div class="container-fluid">
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMonthlyEarnings }} TK</div>
                        </div>
                        <div class="col-auto">
                            <i class="mdi mdi-calendar text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAnnualEarnings }} TK</div>
                        </div>
                        <div class="col-auto">
                            <i class="mdi mdi-currency-usd text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Total) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-fuchsia shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-fuchsia text-uppercase mb-1">
                                Earnings (Total)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEarningsPaid }} TK</div>
                        </div>
                        <div class="col-auto">
                            <i class="mdi mdi-calendar text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Paid (montly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paidMembersCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="mdi mdi-account text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Unpaid (monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unpaidMembersCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="mdi mdi-account text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
