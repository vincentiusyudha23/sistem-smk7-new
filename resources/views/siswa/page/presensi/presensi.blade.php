@extends('frontendmaster')

@section('title')
    <title>Presensi Page</title>
@endsection

@push('style')
    <style>
        #reader {
            width: 80%;
            max-width: 80%;
            height: 47vh;
            aspect-ratio: 1;
            border: 1px solid #ccc;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        @media (min-width: 640px) {
            #reader {
                width: 100%;
                max-width: 400px;
                height: 300px;
            }
        }
    </style>
@endpush

@section('content')
    <x-layout-siswa>
        <div class="w-full flex flex-col justify-center items-center gap-10">
            <h1 class="text-2xl font-bold">Scan Barcode Presensi</h1>
    
            <a href="javascript:void(0)" id="permission-location" class="btn text-white bg-blue-600">
                Hidupkan Lokasi
            </a>
            {{-- Scanner --}}
            <div id="reader" class="hidden">
                
            </div>
            {{-- <h1>Jarak kamu dari Sekolah : <span class="distance">0</span> Meter</h1> --}}
            {{-- Btn to Riwayat --}}
            <a href="{{ route('siswa.riwayat-presensi') }}" class="btn btn-active">Riwayat Presensi</a>
        </div>
    </x-layout-siswa>
@endsection

@push('script')
   {{-- @include('siswa.page.presensi.partials.instascan') --}}
   @include('siswa.page.presensi.partials.html5scan')
@endpush