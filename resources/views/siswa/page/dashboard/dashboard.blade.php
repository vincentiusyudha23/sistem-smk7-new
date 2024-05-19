@extends('frontendmaster')

@section('title')
    <title>Dashboard Siswa</title>
@endsection

@section('content')
    <x-layout-siswa>
         <div class="w-full mt-5">
            <h1 class="text-2xl font-bold mb-3">List Sesi Ujian</h1>
            @include('siswa.page.ujian.partials.tabel-ujian')
        </div>
        <div class="w-full mt-5">
            <h1 class="text-2xl font-bold mb-3">List Riwayat Presensi</h1>
            @include('siswa.page.dashboard.partials.tabel-presensi')
        </div>
    </x-layout-siswa>
@endsection
