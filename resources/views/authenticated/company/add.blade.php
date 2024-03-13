@extends('adminlayouts.master')

@section('title', 'Add building')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5 d-flex gap-2">
                    <h5><a href="{{ route('companies') }}">Buildings</a>/</h5>
                    <h5>Add Building</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Building</h4>
                <form class="forms-sample" method="POST" action="{{ route('company.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Building Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Building Name" autofocus>
                        @error('name')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="contact_no">Contact No</label>
                        <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ old('contact_no') }}" placeholder="Contact No">
                        @error('contact_no')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="country" class="mr-2">Country</label>

                        <div class="input-group">
                            <select class="form-select" name="country" id="country" aria-label="Default select example">
                                <option selected>Select your country</option>
                                @foreach ($countries as $key => $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @error('country')
                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror

                    <div class="form-group mb-4">
                        <label for="city" class="mr-2">City</label>
                        <div class="input-group">
                            <select class="form-select" name="city" id="city" aria-label="Default select example" disabled>
                            </select>
                        </div>
                    </div>
                    @error('city')
                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Full Address">
                        @error('address')
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
