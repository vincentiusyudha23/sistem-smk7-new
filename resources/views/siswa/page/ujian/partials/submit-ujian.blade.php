@extends('frontendmaster')

@section('title')
    <title>Submit Ujian</title>
@endsection

@section('content')
    <x-layout-siswa>
        <div class="w-full mt-5">
            <h1 class="text-2xl font-bold mb-3">Ujian {{ $mapel }}</h1>
            <div class="w-full bg-gray-300 rounded-lg p-5 text-center">
                <h1 class="text-xl font-bold">Jawaban Anda Telah Tersimpan Terimakasih telah mengikuti Ujian</h1>
                <a href="{{ route('siswa.ujian') }}" class="btn text-white mt-2 btn-info">Kembali</a>
            </div>
        </div>
    </x-layout-siswa>
@endsection