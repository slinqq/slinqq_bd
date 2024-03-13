@extends('adminlayouts.master')

@section('title', 'Add Member')

@section('description', 'Buildings Management System. A web application for managing members of an organization.')

@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5 d-flex gap-2">
                    <h5><a href="{{ route('companies') }}">Buildings</a> /</h5>
                    <h5><a href="{{ route('company.manage', ['companyId'=>$company->id, 'sectionId'=>$section->id]) }}">{{ $company->name }}</a> /</h5>
                    <h5>Add Member</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add flat under building</h4>
                @include('layouts.alerts')
                <form class="forms-sample" method="POST" action="{{ route('member.store', ['companyId'=>$company->id, 'sectionId'=>$section->id]) }}">
                    @csrf

                    <div class="form-group">
                        <label for="member_id">Flat ID</label>
                        <input type="text" class="form-control" id="member_id" name="member_id" value="{{ old('member_id') }}" placeholder="Member ID">
                        @error('member_id')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" autofocus>
                        @error('name')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                        @error('email')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_no">Contact No</label>
                        <input type="tel" class="form-control" id="contact_no" name="contact_no" value="{{ old('contact_no') }}" placeholder="Contact No">
                        @error('contact_no')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="join_date">Join Date</label>
                        <input type="date" class="form-control" id="join_date" name="join_date" value="{{ old('join_date') }}" placeholder="Join Date" max="{{ date('Y-m-d') }}">
                        @error('join_date')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="monthly_fee">Monthly Fee</label>
                        <input type="text" class="form-control" id="monthly_fee" name="monthly_fee" value="{{ old('monthly_fee') }}" placeholder="Monthly Fee">
                        @error('monthly_fee')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="advance_amount">Advance Amount</label>
                        <input type="text" class="form-control" id="advance_amount" name="advance_amount" value="{{ old('advance_amount') }}" placeholder="Advance amount">
                        @error('advance_amount')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Address">
                        @error('address')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" value="{{ old('occupation') }}" placeholder="Occupation">
                        @error('occupation')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('error')
                    <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-secondary mt-3 me-2">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection