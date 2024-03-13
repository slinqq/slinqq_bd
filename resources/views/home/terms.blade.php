@extends('layouts.master')

@section('title', 'Terms & Condition')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<!-- Include the alerts file -->
@include('layouts.alerts')

<section class="section-padding bg-image">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-10 col-12 mx-auto mb-4">
                <h2 class="mb-5 text-center">Terms & Conditions</h2>
                <p>
                After sign in, you will be a member of our family. 
                You can use your account for free 3 months (may extend another 3 months).
                After that you have to pay a minimum amount for a month for your account.
                If you get trouble to manage your account or face any difficulties or any
                suggestion, contact us in the number (+8801537403196) or email to sayeedakib6009@gmail.com
                </p>
            </div>
        </div>
    </div>
</section>

@endsection