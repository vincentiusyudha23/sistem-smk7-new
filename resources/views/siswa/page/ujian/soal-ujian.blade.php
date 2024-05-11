@extends('frontendmaster')

@section('title')
    <title>Ujian Matematika</title>
@endsection

@section('content')
    @php
        $soalUjian = json_decode($ujian->soal_ujian, true) ?? [];
      
    @endphp
    <x-layout-siswa>
        <div class="w-full mt-5">
            <h1 class="text-2xl font-bold mb-3">Ujian {{ $mapel }}</h1>
            <div class="w-full bg-gray-300 rounded-lg p-5 soal-ujian">
                <form id="form-ujian-siswa" data-url="{{ route('siswa.submit.ujian', ["mapel" => $mapel]) }}">
                    @csrf
                    <input type="hidden" id="mapel" value="{{ $mapel }}">
                    <input type="hidden" name="id_sesi" value="{{ $ujian->id }}">
                    <div class="w-full">
                        <ul class="list-soal mt-3">
                        @foreach ($soalUjian as $key => $soal)
                            <li class=" my-2 soal-1">
                                <label class="form-control">
                                    <textarea class="textarea textarea-bordered textarea-xs w-full text-sm" disabled>{{ $soal['soal'] }}</textarea>
                                </label>
                                <div class="flex flex-col gap-2 my-3">
                                    <div class="form-control parent-opsiSoal-1 flex flex-col gap-2 bg-white pt-2 rounded-lg p-2">
                                        @foreach ($soal['opsi-soal'] ?? [] as $opsi)
                                        <label class="cursor-pointer js-opsi-soal label justify-start hover:bg-slate-200 active:bg-slate-200 hover:rounded-lg">
                                            <input type="radio" name="{{ $key }}" value="{{ $opsi == $soal['jawaban'][0] ? encrypt(1) : encrypt(0) }}" class="radio radio-primary radio-sm"/>
                                            <span class="mx-2">{{ $opsi }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                        <div class="w-full flex justify-end items-end gap-2">
                            <button type="submit" class="btn btn-sm btn-success text-white border-2">
                                Simpan
                            </button>
                            <button type="button" class="btn btn-sm btn-error text-white border-2 btn-tambah-soal">
                                Batalkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-layout-siswa>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('#form-ujian-siswa').submit(function(e){
                e.preventDefault();
    
                Swal.fire({
                    title: "Submit Jawaban?",
                    text: 'Sudah Yakin Dengan Jawaban Anda?',
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#00a96e",
                    confirmButtonText: "Submit",
                    cancelButtonText: 'Cancel'
                }).then(async (result) => {
                    if(result.value){
                        var formData = $(this).serialize();
                        var url = $(this).data('url');
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('siswa.submit.jawaban') }}',
                            data: formData,
                            beforeSend: function(){
                                $('.loader').show();
                            },
                            success: function(response){
                                $('.loader').hide();
                                if(response.type == 'success'){
                                    window.location.href = url;
                                }
                                if(response.type == 'error'){
                                    toastr.error(response.msg);
                                }
                            }
                        });
                    }
                });
            });
        });
        $(document).on('click', '.btn-tambah-soal', function(){
            var selesai = `
                <div class="w-full bg-gray-300 rounded-lg p-5 text-center">
                    <h1 class="text-xl font-bold">Jawaban Anda Telah Tersimpan Terimakasih telah mengikuti Ujian</h1>
                </div>
            `;
            
            $('.soal-ujian').html(selesai);
        })
    </script>
@endpush