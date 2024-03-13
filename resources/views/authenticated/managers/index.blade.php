@extends('adminlayouts.master')

@section('title', 'All Managers')

@section('description', 'Building Management System. A web application for managing members of an organization.')


@section('styles')
<link href="{{ URL::to('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<!-- Sweet Alart -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sweet alert animate Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection


@section('authenticate_content')
<div class="row" style="overflow-x: auto;">
    <!-- Include the alerts file -->
    @include('layouts.alerts')
    <div class="col-md-12">
        <div class="me-md-3 me-xl-5 d-flex justify-content-between">
            <h5><a href="{{ route('companies') }}">Buildings</a> / Managers</h5>
        </div>

        <div class="row gy-4 d-flex justify-content-center mt-4">
            <table id="myTable" class="table bg-white p-2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Building</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($managers as $manager)
                    <tr>
                        <td>{{ $manager->user->name }}</td>
                        <td>{{ $manager->user->email }}</td>
                        <td>{{ $manager->company->name }}</td>
                        <td><span class="badge bg-success">Manager</span></td>
                        <td class="d-flex gap-2">
                            <a class="badge bg-secondary" href="{{ route('companies.managers.reassign',['user' => $manager->user->id]) }}">New Assign </a>
                            <!-- href="{{ route('manager.remove',['managerId' => $manager->id]) }}" -->
                            <span class="badge bg-danger" style="cursor:pointer;" class="badge bg-danger" onclick="deleteManager({{ $manager->id }})">Remove</span>
                            <form id="delete-manager-{{ $manager->id }}" action="{{ route('manager.remove',['managerId' => $manager->id]) }}" method="POST" style="display: none;">
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
@endsection


@section('admin_scripts')
<script src="{{ URL::to('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('assets/js/dataTables.bootstrap5.min.js') }}"></script>
<!-- sweet Alart CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({});
    });

    function deleteManager(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to delete this manager!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();
                document.getElementById('delete-manager-' + id).submit();
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    '',
                    'error'
                )
            }
        })
    }
</script>
@endsection