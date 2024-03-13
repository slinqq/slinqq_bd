@extends('adminlayouts.master')

@section('title', 'Send Notification')

@section('description', 'Buildings Management System. A web application for managing members of an organization.')


@section('styles')
<link href="{{ URL::to('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

@section('authenticate_content')
<div class="row" style="overflow-x: auto;">
    <!-- Include the alerts file -->
    @include('layouts.alerts')
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5">
                    <h5><a href="{{ route('companies') }}">Buildings</a> / All Members</h5>
                </div>

                <div class="container" style="overflow-x: auto;">
                    <div class="row gy-4 d-flex justify-content-center mt-3">
                        <div class="col-md-12 grid-margin stretch-card d-flex justify-content-center">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table display responsive">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Join Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($members as $member)
                                                <tr>
                                                    <td>{{ $member->name }}</td>
                                                    <td>{{ $member->email }}</td>
                                                    <td>{{ $member->contact_no }}</td>
                                                    <td>{{ $member->join_date }}</td>
                                                    <td>
                                                        @if ($member->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                        @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($member->status == 'active')
                                                        <a href="{{ route('notification.speicfic.member', ['memberId' => $member->id]) }}" class="btn btn-success">Send</a>
                                                        @else
                                                        <a href="{{ route('notification.speicfic.member', ['memberId' => $member->id]) }}" class="btn btn-danger">Send</a>
                                                        @endif
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
            </div>
        </div>
    </div>
</div>

@endsection


@section('admin_scripts')
<script src="{{ URL::to('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('assets/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true,
        });
    });
</script>
@endsection