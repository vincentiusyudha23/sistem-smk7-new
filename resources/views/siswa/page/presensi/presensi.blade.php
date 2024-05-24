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

            {{-- Message Alert --}}
            @if (session()->has('success'))
                <div role="alert" class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session()->get('success') }}</span>
                </div>
            @endif
            @if (session()->has('error'))
                <div role="alert" class="alert alert-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                  <span>{{ session()->get('error') }}</span>
                </div>
            @endif
            <a href="javascript:void(0)" id="permission-location" class="btn text-white bg-blue-600">
                Hidupkan Lokasi
            </a>
            {{-- Scanner --}}
            <div id="reader" class="hidden">
                
            </div>

            {{-- Btn to Riwayat --}}
            <a href="{{ route('siswa.riwayat-presensi') }}" class="btn btn-active">Riwayat Pesan</a>
        </div>
    </x-layout-siswa>
@endsection

@push('script')
   {{-- @include('siswa.page.presensi.partials.instascan') --}}
   @include('siswa.page.presensi.partials.html5scan')
@endpush