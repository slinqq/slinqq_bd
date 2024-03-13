@extends('layouts.master')

@section('title', 'Signup')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="row gy-4 d-flex justify-content-center">
            <div class="login-block col-lg-6" data-aos="fade-up" data-aos-delay="250">
                <div class="card p-4 border-0">
                    <h2 class="login-block-text">Sign Up</h2>
                    <form method="POST" action="{{ route('signup.store') }}" class="form-inline">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name" class="mr-2">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                        </div>
                        @error('name')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1" class="mr-2">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" value="{{ old('email') }}" autocomplete="email">
                        </div>
                        @error('email')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

                        <div class="form-group mb-4">
                            <label for="phone" class="mr-2">Phone</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                        </div>
                        @error('phone')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror


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

                        <div class="form-group mb-4">
                            <label for="address" class="mr-2">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter your address" name="address" value="{{ old('address') }}" autocomplete="address">
                        </div>
                        @error('address')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror


                        <div class="form-group mb-4">
                            <label for="password" class="mr-2">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your Password" name="password" autocomplete="address">
                        </div>
                        @error('password')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

                        <div class="form-group mb-4">
                            <label for="cpassword" class="mr-2">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" placeholder="Enter your Confirm Password" name="password_confirmation" autocomplete="address">
                        </div>

                        @error('error')
                        <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                        @enderror

                        <div class="form-group mb-4">
                            <a href="{{ route('terms') }}" target="_blank">Terms and Conditions</a>, By signing up, you are agree our term and conditions
                        </div>
                        <div class="form-group mb-4 d-flex justify-content-evenly">
                            @if ($routeName != 'companies.emptyposition.search.details' && $routeName != 'companies.emptyposition.search')
                            <button type="submit" name="user_type" value="admin" class="btn custom-btn">Signup as Admin</button>
                            @endif

                            @if (request('routeName'))
                            <button type="submit" name="user_type" value="user" class="btn custom-btn">Signup</button>
                            @else
                            <button type="submit" name="user_type" value="user" class="btn custom-btn">Signup as User</button>
                            @endif
                        </div>
                    </form>

                </div>


            </div><!-- End Contact Form -->

        </div>
    </div>
</section>

@endsection

@section('scripts')

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
