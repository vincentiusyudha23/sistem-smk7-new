@extends('frontendmaster')

@section('title')
    <title>Ujian Page</title>
@endsection

@section('content')
    <x-layout-siswa>
        <div class="w-full h-full pt-5">
            <h1 class="text-2xl font-bold mb-3">List Sesi Ujian</h1>
            @include('siswa.page.ujian.partials.tabel-ujian')
        </div>
    </x-layout-siswa>
@endsection