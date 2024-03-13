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
                <form class="forms-sample" method="POST" action="{{ route('companies.managers.store') }}">
                    @csrf

                    @if ($companyId != null)
                    <input type="hidden" name="companyId" value="{{ $companyId }}" />
                    @endif
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
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contact No">
                        @error('phone')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="country" class="mr-2">Country</label>
                        <div class="input-group">
                            <select class="form-select" name="country" id="country" aria-label="Default select example">
                                <option selected>Select your country</option>
                                @foreach ($countries as $key => $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('country')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city" class="mr-2">City</label>
                        <div class="input-group">
                            <select class="form-select" name="city" id="city" aria-label="Default select example" disabled>
                            </select>
                        </div>
                        @error('city')
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
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="password">
                        @error('password')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password">
                        @error('password_confirmation')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('error')
                    <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                    @enderror
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary mt-3 me-2 text-center">Assign </button>
                        <a href="#" class="btn btn-danger mt-3 me-2 text-center" onclick="history.back()">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('admin_scripts')

<script>
    $(document).ready(function() {
        $('#country').on('change', function() {
            var country = this.value;
            console.log(country);
            // Ajax call to fetch cities
            $.ajax({
                url: '/get-cities/' + country,
                type: 'GET',
                success: function(data) {
                    // Populate the city dropdown with fetched data
                    $('#city').empty();
                    // enable city dropdown
                    $('#city').prop('disabled', false);
                    $.each(data, function(key, value) {
                        $('#city').append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        });
    });
</script>

@endsection