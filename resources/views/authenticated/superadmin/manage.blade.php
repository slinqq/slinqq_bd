@extends('adminlayouts.master')

@section('title', $user->name . "'s Details")

@section('description', 'Buildings Management System. A web application for managing members of an organization.')

@section('styles')
<link href="{{ URL::to('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<!-- Sweet Alart -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sweet alert animate Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5 d-flex gap-2">
                    <h5><a href="{{ route('superadmin') }}">Dashboard</a> /</h5>
                    <h5><a href="{{ route('superadmin.manage', ['userId'=>$user->id]) }}">{{ $user->name }}</a> /</h5>
                    <h5>Flat Details</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Include the alerts file -->
@include('layouts.alerts')
<div class="row justify-content-center">
    <div class="col-md-12 grid-margin stretch-card d-flex justify-content-center">
        <div class="card p-4">
            <div class="card-title text-secondary d-flex justify-content-between">
                <h4>Admin Info</h4>
            </div>
            <div class="card-body text-secondary">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Contact No:</strong> {{ $user->phone }}</p>
                        <p><strong>Address:</strong> {{ $user->address }}</p>
                        <p><strong>Occupation:</strong> {{ $user->city }}</p>
                        <p><strong>Member ID:</strong> {{ $user->country }}</p>
                        <p><strong>Join Date:</strong> {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
                        <p><strong>Blocked:</strong> <span class="badge @if($user->is_blocked == 1) bg-danger @else bg-success @endif">{{ $user->is_blocked ==1 ? 'Yes' : 'No' }}</span></p>
                        <p><strong>Status:</strong> <span class="badge @if($user->status == 'active') bg-success @else bg-danger @endif">{{ $user->status }}</span>
                        </p>
                        <div class="d-flex flex-wrap gap-1 member-action">
                            <a class="badge bg-primary" href="{{ route('notification.specific.member.form',['memberId' => $user->id]) }}">Send Notification</a>
                            <div class="badge @if ($user->is_blocked == 0)
                                bg-danger
                                @else
                                bg-success
                                @endif" onclick="dactivateOrActivateUser({{ $user->id }})" style="cursor: pointer;">
                                @if($user->is_blocked == 0)
                                Deactivate
                                @else
                                Activate
                                @endif
                            </div>
                            <form id="update-form-{{ $user->id }}" action="{{ route('superadmin.manage.update',['userId'=>$user->id]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Buildings :</strong> {{ count($user->companies) }}</p>
                        <p><strong>Total Flats</strong>
                            @php
                            $totalMembers = 0;
                            foreach ($user->companies as $company) {
                            $totalMembers += count($company->members);
                            }
                            echo $totalMembers;
                            @endphp
                        </p>
                        <p><strong>Contact No:</strong> {{ $user->phone }}</p>
                        <p><strong>Address:</strong> {{ $user->address }}</p>
                        <p><strong>Occupation:</strong> {{ $user->city }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('admin_scripts')
<script src="{{ URL::to('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('assets/js/dataTables.bootstrap5.min.js') }}"></script>
<!-- sweet Alart CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#memberPaymentHistory').DataTable({
            responsive: true,
        });
    });

    function dactivateOrActivateUser(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to @if($user->status == 'active') deactivate @else activate @endif this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();
                document.getElementById('update-form-' + id).submit();
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'error'
                )
            }
        })
    }

    function handleSubmit(companyId, sectionId, memberId) {
        event.preventDefault();
        // Get the URL for the named route
        var updateRoute = "{{ route('member.update', ['companyId' => ':companyId', 'sectionId' => ':sectionId', 'memberId' => ':memberId']) }}";

        // Replace placeholders with actual values
        updateRoute = updateRoute.replace(':companyId', companyId).replace(':sectionId', sectionId).replace(':memberId', memberId);

        var formData = $('#updateForm').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        // Perform an AJAX request
        $.ajax({
            type: 'PUT',
            url: updateRoute,
            data: {
                "_token": "{{ csrf_token() }}",
                ...formData
            },
            success: function(response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Member updated successfully',
                    timer: 1500
                })

            },
            error: function(xhr, status, error) {
                console.error('Update failed:', error);
                var responseObj = JSON.parse(xhr.responseText);

                if (responseObj && typeof responseObj === 'object') {
                    $.each(responseObj.errors, function(key, value) {
                        $('#' + key).after('<div class="alert alert-danger">' + value + '</div>');
                    });
                } else {
                    console.log('Unexpected response format:', xhr.responseText);
                }
            }
        });
    }

    function deletePayment(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "After deleting this payment, you can't recover this payment!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();
                document.getElementById('delete-payment-form-' + id).submit();
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    '',
                    'info'
                )
            }
        })
    }
</script>
@endsection
