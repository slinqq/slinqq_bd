@extends('adminlayouts.master')

@section('title', $member->name . "'s Details")

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
                    <h5><a href="{{ route('companies') }}">Buildings</a> /</h5>
                    <h5><a href="{{ route('company.manage', ['companyId'=>$company->id]) }}">{{ $company->name }}</a> /</h5>
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
                <h4>Member Info</h4>
                <a class="badge bg-secondary" href="{{ route('member.payment.add',['companyId' => $company->id,'sectionId' => $section->id,'memberId' => $member->id]) }}" class="btn btn-primary">Create Payment</a>
            </div>
            <div class="card-body text-secondary">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $member->name }}</p>
                        <p><strong>Email:</strong> {{ $member->email }}</p>
                        <p><strong>Contact No:</strong> {{ $member->contact_no }}</p>
                        <p><strong>Address:</strong> {{ $member->address }}</p>
                        <p><strong>Occupation:</strong> {{ $member->occupation }}</p>
                        <p><strong>Member ID:</strong> {{ $member->member_id }}</p>
                        <p><strong>Monthly Fee:</strong> {{ $member->monthly_fee }}</p>
                        <p><strong>Join Date:</strong> {{ $member->join_date }}</p>
                        <p><strong>Advance Amount:</strong> {{ $member->advance_amount }} TK</p>
                        <p><strong>Building:</strong> <a href="{{ route('company.manage',['companyId' => $member->company->id]) }}">{{ $member->company->name }}</a></p>
                        <p><strong>Section:</strong> {{ $section->title }}</p>
                        <p><strong>Status:</strong> <span class="badge @if($member->status == 'active') bg-success @else bg-danger @endif">{{ $member->status }}</span>
                        </p>
                        <div class="d-flex flex-wrap gap-1 member-action">
                            <a class="badge bg-success" href="{{ route('notification.specific.member.form',['memberId' => $member->id]) }}">Send Notification</a>
                            <div class="badge bg-danger" onclick="deleteMember({{ $member->id }})" style="cursor: pointer;">Delete Member</div>
                            <div class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#editUserInfo" style="cursor: pointer;">Update Member Info</div>
                            <form id="delete-form-{{ $member->id }}" action="{{ route('member.delete',['companyId'=>request('companyId'),'sectionId'=>request('sectionId'),'memberId'=>request('memberId')]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ URL::to('assets/images/avatar/user.png') }}" alt="Member Image" class="img-fluid rounded-circle" style="width: 300px; height: 300px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="overflow-x: auto;">
        <div class="row gy-4 d-flex justify-content-center mt-3">
            <div class="col-md-12 grid-margin stretch-card d-flex justify-content-center">
                <div class="card">
                    <div class="card-title p-4 text-secondary">
                        <h4>Member Payment History</h4>
                    </div>
                    <div class="card-body text-secondary">
                        <div class="table-responsive">
                            <table id="memberPaymentHistory" class="table display responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Amount</th>
                                        <th>Payment for month</th>
                                        <th>Method</th>
                                        <th>Currency</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $payment->member_name }}</td>
                                        <td>{{ $payment->contact_no }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td>{{ $payment->payment_for_month }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->currency }}</td>
                                        <td><span class="badge bg-success">{{ $payment->status }}</span></td>
                                        <td><span style="cursor:pointer;" class="badge bg-danger" onclick="deletePayment({{ $payment->id }})">
                                                Remove
                                            </span>
                                            <form id="delete-payment-form-{{ $payment->id }}" action="{{ route('member.payment.remove',['companyId' => $company->id,'sectionId' => $section->id,'memberId' => $member->id,'paymentId' => $payment->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade " id="editUserInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="card-title">Update member under section</h4>
                    <form class="forms-sample" id="updateForm" onsubmit="handleSubmit({{ $company->id }}, {{ $section->id }}, {{ $member->id }})">

                        <div class="form-group">
                            <label for="member_id">Flat ID</label>
                            <input type="text" class="form-control" id="member_id" name="member_id" value="{{ $member->member_id }}" placeholder="Member ID">
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" placeholder="Name" autofocus>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $member->email }}" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="contact_no">Contact No</label>
                            <input type="tel" class="form-control" id="contact_no" name="contact_no" value="{{ $member->contact_no }}" placeholder="Contact No">
                        </div>

                        <div class="form-group">
                            <label for="added_date">Jining Date</label>
                            <input type="date" class="form-control" id="added_date" name="join_date" value="{{ $member->join_date }}">
                        </div>

                        <div class="form-group">
                            <label for="monthly_fee">Monthly Fee</label>
                            <input type="text" class="form-control" id="monthly_fee" name="monthly_fee" value="{{ $member->monthly_fee }}" placeholder="Monthly Fee">
                        </div>

                        <div class="form-group">
                            <label for="advance_amount">Advance Amount</label>
                            <input type="text" class="form-control" id="advance_amount" name="advance_amount" value="{{ $member->advance_amount }}" placeholder="Advance amount">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $member->address }}" placeholder="Address">
                        </div>

                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $member->occupation }}" placeholder="Occupation">
                        </div>



                        @error('error')
                        <div class="alert alert-danger" role='alert'>{{ $message }}</div>
                        @enderror

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
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

        function deleteMember(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "After deleting this member, then position of this member will be empty",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your member is safe :)',
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

                    setTimeout(function() {
                        location.reload();
                    }, 1500);

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