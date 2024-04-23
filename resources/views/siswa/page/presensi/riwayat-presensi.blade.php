@extends('frontendmaster')

@section('title')
    <title>Riwayat Presensi</title>
@endsection

@section('content')
    <x-layout-siswa>
        <div class="w-full mt-5">
            <h1 class="text-2xl font-bold mb-3">List Riwayat Presensi</h1>
            @include('siswa.page.dashboard.partials.tabel-presensi')
        </div>
    </x-layout-siswa>
@endsection