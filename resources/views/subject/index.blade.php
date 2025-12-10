@extends('layouts.app')
@push('title')
    Subject
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        <i class="bi bi-book me-2"></i>Subject Management
    @endpush

    @livewire('create-subject')
    @livewire('subject-list')

@endsection


