@extends('layouts.app')
@push('title')
    Create Subject
@endpush
@push("page_header_title")
    Create subject
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-10">


                @livewire('create-subject')


            </div>


            {{--<div class="col-8">
                @livewire('student-list-table')
        </div>--}}
        </div>
@endsection
