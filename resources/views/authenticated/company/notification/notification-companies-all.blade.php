@extends('adminlayouts.master')

@section('title', 'Send Notification')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('authenticate_content')
<section class="section-padding">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5">
                    <h5><a href="{{ route('companies') }}">Buildings</a> / Send Notification to building's members</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row gy-4 d-flex justify-content-center">
            <div class="col-md-9 grid-margin stretch-card d-flex justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Notify members under your companies</h4>
                        <form method="POST" action="{{ route('notification.companies.all.send') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-4">
                                <div class="form-floating">
                                    <input class="form-control" placeholder="Write your subjct here" id="floatinginput" name="subject" autocomplete="off">{{ old('subject') }}</input>
                                    <label for="floatinginput">Subject</label>
                                </div>
                            </div>
                            @error('message')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror

                            <div class="form-group mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="message" placeholder="Enter your message" autocomplete="off" style="height: 100px">{{ old('message') }}</textarea>
                                    <label for="floatingTextarea2">Message</label>
                                </div>
                            </div>
                            @error('message')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror

                            <div class="form-group mb-4">
                                <label for="formFileSm" class="mr-2">Attach File</label>
                                <input class="form-control form-control-sm" id="formFileSm" type="file" name="attachment">
                            </div>
                            @error('attachment')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror

                            <div class="form-group d-flex justify-content-center gap-2">
                                <button type="submit" class="btn btn-secondary">Send </button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
