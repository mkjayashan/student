@extends('layouts.app')
@push('title')
    Subject
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        Subject
    @endpush

    @livewire('create-subject')
    @livewire('subject-list')

@endsection


