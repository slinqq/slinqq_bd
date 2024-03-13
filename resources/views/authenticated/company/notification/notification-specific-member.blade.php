@extends('adminlayouts.master')

@section('title', 'Send Notification')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('authenticate_content')
<section class="section-padding">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5">
                    <h5><a href="{{ route('companies') }}">Buildings</a> / Send Notification</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row gy-4 d-flex justify-content-center">
            <div class="col-md-9 grid-margin stretch-card d-flex justify-content-center">
                <div class="card">
                    <div class="card-body">
                        @include('layouts.alerts')
                        <h4 class="card-title">Notify to {{ $member->name }}</h4>
                        <form method="POST" action="{{ route('notification.specific.member',['memberId' => $member->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder=" Write your subject">{{ old('subject') }}</input>
                            </div>
                            @error('subject')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="exampleTextarea1">Message</label>
                                <textarea class="form-control" id="exampleTextarea1" name="message" rows="4" placeholder="Write your message">{{ old('message') }}</textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="formFileSm" class="mr-2">Attach File</label>
                                <input class="form-control form-control-sm" id="formFileSm" type="file" name="attachment">
                            </div>
                            @error('attachment')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            @error('message')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-center gap-2">
                                <button type="submit" class="btn btn-secondary me-2">Send</button>
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
