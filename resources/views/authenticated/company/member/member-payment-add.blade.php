@extends('adminlayouts.master')

@section('title', 'Create Payment')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5 d-flex gap-2">
                    <h5><a href="{{ route('companies') }}">Buildings</a> /</h5>
                    <h5><a href="{{ route('company.manage', ['companyId'=>$company->id, 'sectionId'=>$section->id]) }}">{{ $company->name }}</a> /</h5>
                    <h5>Create Payment</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.alerts')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create payment for {{ $member->name }} On {{ \Carbon\Carbon::now()->format('F Y') }}</h4>
                <form class="forms-sample" method="POST" action="{{ route('member.payment.store', ['companyId'=>$company->id, 'sectionId'=>$section->id, 'memberId'=>$member->id]) }}">
                    @csrf

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="{{ $member->monthly_fee }}" readonly>
                        @error('amount')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select class="form-control" id="currency" name="currency">
                            <option value="BDT">BDT</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                        </select>
                        @error('currency')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Online">Online</option>
                        </select>
                        @error('payment_method')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" readonly>
                        @error('added_date')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_for_month">Payment For Month</label>
                        <select class="form-control" id="payment_for_month" name="payment_for_month">
                            <option value="">Selec Month</option>
                            @foreach ($months as $month)
                            <option value="{{ $month['value'] }}">{{ $month['name'] }}</option>
                            @endforeach
                        </select>
                        @error('payment_for_month')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('error')
                    <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                    @enderror

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary mt-3 me-2">Submit</button>
                        <a href="{{ route('company.manage', ['companyId'=>$company->id, 'sectionId'=>$section->id]) }}" class="btn btn-danger mt-3">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection
