@extends("frontendmaster")

@section('title')
    <title>
        Presensi Siswa
    </title>
@endsection

@section('content')
    <x-admin-all-layout>
        <h1 class="text-2xl font-bold my-2">Data Presensi Siswa</h1>
        <div class="w-full flex justify-end">
            <a class="btn btn-sm mt-2 btn-kembali hidden">Kembali</a>
        </div>
        <div class="w-full list-presensi">
            @foreach ($dataPresensiPerHari as $tanggal => $presensi) 
                <div class="w-full my-3 p-4 bg-gray-200 hover:cursor-pointer hover:bg-gray-300 rounded-lg">
                    <a href="{{ route('admin.detail_presensi', ['id' => $loop->index ]) }}" class="w-full flex justify-between items-center font-bold presensi-list">
                        <h1>{{ $tanggal }}</h1>
                        <h1>{{ $presensi }} Siswa</h1>
                    </a>
                </div>
            @endforeach
        </div>
        {{-- @include('admin.page.presensi.partial.tabel_presensi') --}}
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
       $(document).ready(function(){
            $('.presensi-list').on('click', function(){
                $('.loader').show();
            });
       })
    </script>
@endpush