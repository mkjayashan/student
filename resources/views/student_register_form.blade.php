@extends('app')
@push('title') Student Register
@endpush
@push("page_header_title")
    Student Register
@endpush
@section('content')
    <div class="container-fluid">
    <div class="row">
        <div class="col-10">



@livewire('student-register-form')


        </div>




        {{--<div class="col-8">
            @livewire('student-list-table')
    </div>--}}
    </div>
@endsection
