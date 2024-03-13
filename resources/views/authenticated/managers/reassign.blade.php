@extends('adminlayouts.master')

@section('title', 'Add Manager')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5 d-flex gap-2">
                    <h5><a href="{{ route('companies') }}">Buildings</a> /</h5>
                    <h5>Add Manager</h5>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.alerts')
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add a new manager</h4>
                <form class="forms-sample" method="POST" action="{{ route('companies.managers.reassign.store',['user' => request('user')]) }}">
                    @csrf

                    <div class="form-group">
                        <label for="company" class="mr-2">Company</label>
                        <div class="input-group">
                            <select class="form-select" name="company" id="company" aria-label="Default select example">
                                <option selected>Select your building</option>
                                @foreach ($companies as $key => $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('company')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('error')
                    <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-secondary mt-3 me-2">Assign Manager</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection