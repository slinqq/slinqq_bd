@extends('adminlayouts.master')

@section('title', $company->name)

@section('description', 'Building Management System. A web application for managing members of an organization.')


@section('styles')
<!-- Font Awesom -->

<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<!-- Sweet Alart -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sweet alert animate Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('authenticate_content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-md-flex justify-content-between align-items-center">
            <div class="me-md-3 me-xl-5">
                <h5 class="fs-md-6 fs-sm-5 mb-2 mb-md-0"><a href="{{ route('companies') }}">Buildings</a> / {{ $company->name }}</h5>
            </div>
            @hasrole('admin')
            <a href="{{ route('companies.managers.add',['companyId' => $company->id]) }}" class="btn btn-sm btn-secondary mt-2 mt-md-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add manager for this building">Add Manager</a>
            @endhasrole
            @if (Route::currentRouteName() == 'company.manage')
            <ul class="navbar-nav w-100 my-4 d-lg-none d-md-none d-sm-block">
                <li class="w-100 ">
                    <form method="POST" action="{{ route('company.manage',['companyId' => request('companyId')]) }}" class=" d-flex">
                        @csrf
                        @method('GET')
                        <input type="text" class="form-control w-100" placeholder="Search by flat id" name="search" aria-label=" search" aria-describedby="search">
                        <div class="input-group-prepend">
                            <button class="input-group-text bg-secondary" id="search" style="cursor:pointer;" type="submit">
                                <i class="mdi mdi-magnify text-white" style="font-size: 17px;"></i>
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
            @endif
        </div>
    </div>
    <!-- Include the alerts file -->
    @include('layouts.alerts')
    <div>
        @if (count($sections) == 0)
        <a href=" {{ route('section.add',['companyId'=>request('companyId')]) }}" class="cursor-pointer">
            <div class="d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-start p-3 item gap-3">
                <div class="d-flex align-items-center justify-content-evenly btn btn-success text-dark">
                    <h5 class="mb-0 d-inline-block">Add New Floor</h5>
                    <i class="mdi mdi-plus icon-lg me-3 "></i>
                </div>
            </div>
        </a>
        @endif
        @foreach ($sections as $key => $section)
        <div class="d-flex justify-content-start align-items-center gap-1">
            <h4>{{ $section->title }}</h4>
            <a href="{{ route('section.add',['companyId'=>request('companyId')]) }}">
                <i class="mdi mdi-plus icon-lg me-3 text-secondary"></i>
            </a>

            <i class="mdi mdi-minus icon-lg me-3 text-danger" title="Delete" onclick="deleteSection({{ $section->id }})" style="cursor: pointer;"></i>

            <form id="delete-form-{{ $section->id }}" action="{{ route('section.delete',['companyId'=>request('companyId')]) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <input type="text" name="sectionId" value=" {{ $section->id }}" style="display: none; cursor: pointer;">
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @if (count($section->members) > 0)
                    @foreach ($section->members as $key => $member)
                    <div class="card w-300 @if($member->status == 'inactive') border-2 border-red-800 @endif">
                        <div class="card-body text-center position-relative">
                            <div>
                                <i class="fa-solid fa-house-medical-circle-check icon-md text-muted mb-4"></i>
                                <h5 class="card-title">{{ $member->name ?? $member->member_id }}</h5>
                                <span class="badge {{ $member->status == 'inactive' ? 'bg-danger' : (optional($member->currentMonthPayment)->status ? 'bg-success' : 'bg-warning') }} position-absolute top-0 end-0">
                                    @if ($member->status == 'inactive')
                                    Empty
                                    @elseif ($member->status == 'active')
                                    {{ optional($member->currentMonthPayment)->status ?? 'Unpaid' }}
                                    @endif
                                </span>
                            </div>
                            <a href="{{ route('member.edit', ['companyId' => $company->id, 'sectionId' => $section->id, 'memberId' => $member->id]) }}" class="btn btn-secondary mt-3">Open</a>
                        </div>
                    </div>
                    @endforeach
                    <a href="{{ route('member.add',['companyId'=> $company->id, 'sectionId'=> $section->id]) }}" class="card cursor-pointer">
                        <div class="d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-start p-3 item gap-3">
                            <div class="d-flex align-items-center justify-content-evenly btn btn-success text-dark">
                                <h5 class="mb-0 d-inline-block">Add Another Member</h5>
                                <i class="mdi mdi-plus icon-lg me-3 "></i>
                            </div>
                        </div>
                    </a>
                    @else
                    <a href="{{ route('member.add',['companyId'=> $company->id, 'sectionId'=> $section->id]) }}" class="card cursor-pointer">
                        <div class="d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-start p-3 item gap-3">
                            <div class="d-flex align-items-center justify-content-evenly btn btn-success text-dark">
                                <h5 class="mb-0 d-inline-block">Add Member</h5>
                                <i class="mdi mdi-plus icon-lg me-3 "></i>
                            </div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection

@section('admin_scripts')
<!-- sweet Alart CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>

<script>
    function deleteSection(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "All the members of this section will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
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
                    '',
                    'info'
                )
            }
        })
    }
</script>
@endsection
