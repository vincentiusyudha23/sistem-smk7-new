@extends('frontendmaster')

@section('title')
    @yield('title')
@endsection

@push('style')
    @stack('style')
@endpush

@section('content')
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('admin.sidebar.sidebar')
        </div>
        <div class="w-[80%]">
            @yield('content')
        </div>
    </div>
@endsection

@push('script')
    @stack('script')
@endpush

