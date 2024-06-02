@extends("frontendmaster")

@section('title')
    <title>
        Presensi Siswa
    </title>
@endsection

@section('content')
    <x-admin-all-layout>
        <div class="pb-5">
            <div class="w-full inline-flex justify-between items-center">
                <h1 class="text-2xl font-bold my-2">Data Presensi Siswa</h1>
                <button type="button" class="btn btn-info text-white btn-sm" onclick="modal_download.showModal()">Unduh Data Presensi</button>
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
        </div>
        @include('admin.page.presensi.partial.modal-download')
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
       $(document).ready(function(){
           $('input[type=radio][name=options]').change(function() {
                var value = $(this).val();
                
                if(value == 0){
                    $(".filter-siswa").addClass('hidden');
                    $(".filter-kelas").addClass('hidden');
                    $(".filter-jurusan").addClass('hidden');
                    $('#filter-siswa').val(null).trigger('change');
                    $('#filter-kelas').val(null).trigger('change');
                    $('#filter-jurusan').val(null).trigger('change');
                    $('.filter-date').addClass('hidden');
                }
                if(value == 1){
                    $(".filter-siswa").addClass('hidden');
                    $(".filter-kelas").addClass('hidden');
                    $(".filter-jurusan").addClass('hidden');
                    $('#filter-siswa').val(null).trigger('change');
                    $('#filter-kelas').val(null).trigger('change');
                    $('#filter-jurusan').val(null).trigger('change');
                    $('.filter-date').removeClass('hidden');
                    $('.filter-date').addClass('flex');
                }
                if(value == 2){
                    $(".filter-siswa").removeClass('hidden');
                    $(".filter-kelas").addClass('hidden');
                    $(".filter-jurusan").addClass('hidden');
                    $('#filter-siswa').select2({
                        dropdownParent: $(`#modal_download`)
                    });
                    $('#filter-kelas').val(null).trigger('change');
                    $('#filter-jurusan').val(null).trigger('change');
                    $('.filter-date').removeClass('hidden');
                    $('.filter-date').addClass('flex');
                }
                if(value == 3){
                    $(".filter-siswa").addClass('hidden');
                    $(".filter-kelas").removeClass('hidden');
                    $(".filter-jurusan").addClass('hidden');
                    $('#filter-kelas').select2({
                        dropdownParent: $(`#modal_download`)
                    });
                    $('#filter-siswa').val(null).trigger('change');
                    $('#filter-jurusan').val(null).trigger('change');
                    $('.filter-date').removeClass('hidden');
                    $('.filter-date').addClass('flex');
                }
                if(value == 4){
                    $(".filter-siswa").addClass('hidden');
                    $(".filter-kelas").addClass('hidden');
                    $(".filter-jurusan").removeClass('hidden');
                    $('#filter-jurusan').select2({
                        dropdownParent: $(`#modal_download`)
                    });
                    $('#filter-kelas').val(null).trigger('change');
                    $('#filter-siswa').val(null).trigger('change');
                    $('.filter-date').removeClass('hidden');
                    $('.filter-date').addClass('flex');
                }
            });

            $('.presensi-list').on('click', function(){
                $('.loader').show();
            });
       })
    </script>
@endpush