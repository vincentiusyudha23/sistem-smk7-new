@extends('frontendmaster')

@section('title')
    <title>SMK 7 Bandar Lampung</title>
@endsection

@section('content')
    <div class="w-full h-full md:h-screen md:flex md:flex-col">
        <div class="w-full h-full md:h-[50%] absolute z-10 md:z-0 md:relative bg-gray-300 flex justify-center items-center">
            <img src="{{ asset('asset/logo/logo_smk7.png') }}" style="width: 268px; height: 320px;" class="md:scale-75">
        </div>
        <div class="bg-black/20 md:hidden w-full h-full absolute z-20 top-0 right-0">

        </div>
        <div class="w-full h-full md:h-[50%] flex justify-center items-center gap-10 flex-col md:flex-row absolute top-0 right-0 z-30 md:z-0 md:relative">
            <div class="flex flex-col w-56 bg-gray-100 p-5 rounded-lg border border-blue-500">
                <div class="flex justify-center items-center mb-5">
                    <h1 class="text-blue-600 font-bold text-2xl w-32 text-center">Halaman Admin</h1>
                </div>
                <a href="{{ route('admin.login') }}" class="btn btn-primary mb-3 text-white text-lg">Masuk</a>
            </div>
            <div class="flex flex-col w-56 bg-gray-100 p-5 rounded-lg border border-blue-500">
                <div class="flex justify-center items-center mb-5">
                    <h1 class="text-blue-600 font-bold text-2xl w-32 text-center">Halaman Guru</h1>
                </div>
                <a href="{{ route('mapel.login') }}" class="btn btn-primary mb-3 text-white text-lg">Masuk</a>
            </div>
            <div class="flex flex-col w-56 bg-gray-100 p-5 rounded-lg border border-blue-500">
                <div class="flex justify-center items-center mb-5">
                    <h1 class="text-blue-600 font-bold text-2xl w-32 text-center">Halaman Siswa</h1>
                </div>
                <a href="{{ route('siswa.login') }}" class="btn btn-primary mb-3 text-white text-lg">Masuk</a>
            </div>
        </div>
    </div>
@endsection