@extends('frontendmaster')

@section('title')
    <title>Ujian {{ $ujian->mapel->nama_mapel }}</title>
@endsection

@section('content')
    @php
        $soalUjian = json_decode($ujian->soal_ujian, true) ?? [];
    @endphp
    <x-layout-siswa>
        <div class="w-full h-full pt-5">
            <h1 class="text-2xl font-bold mb-3">Ujian {{ $ujian->mapel->nama_mapel }}</h1>
            <div class="fixed top-14 right-0 bg-blue-400 p-2 rounded-l-lg">
                <h1 id="countdown" class="text-white font-bold text-lg">01:02:00</h1>
            </div>
            <div class="w-full bg-gray-300 rounded-lg p-5 soal-ujian">
                <form id="form-ujian-siswa" data-url="{{ route('siswa.submit.ujian', ["mapel" => $ujian->mapel->nama_mapel]) }}">
                    @csrf
                    <input type="hidden" id="mapel" value="{{ $ujian->mapel->nama_mapel }}">
                    <input type="hidden" name="id_sesi" value="{{ $ujian->id }}">
                    <div class="w-full">
                        <ul class="list-soal mt-3">
                        @foreach ($soalUjian as $key => $soal)
                            <li class=" my-2 soal-1">
                                <label class="form-control">
                                    <textarea class="rounded-md p-2" readonly>{{ $soal['soal'] }}</textarea>
                                </label>
                                <div class="flex flex-col gap-2 my-3">
                                    <div class="form-control parent-opsiSoal-1 flex flex-col gap-2 bg-white pt-2 rounded-lg p-2">
                                        @foreach ($soal['opsi_soal'] ?? [] as $opsi)
                                        <label class="cursor-pointer js-opsi-soal label justify-start hover:bg-slate-200 active:bg-slate-200 hover:rounded-lg">
                                            <input type="radio" name="{{ $key }}" data-id="{{ $loop->index + 1 }}" value="{{ $opsi == $soal['jawaban'][0] ? encrypt(1) : encrypt(0) }}" class="radio radio-primary radio-sm"/>
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
            function updateCountdown(endTime) {
                var now = new Date().getTime();
                var distance = endTime - now;

                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');

                $('#countdown').html(hours + ":" + minutes + ":" + seconds);
            }

            var endTime = new Date("<?php echo $ujian->end; ?>").getTime(); // Mendapatkan waktu selesai dari PHP

            var timerInterval = setInterval(function() {
                updateCountdown(endTime);

                // Jika waktu selesai, hentikan interval dan lakukan permintaan AJAX untuk memperbarui status
                if (endTime <= new Date().getTime()) {
                    clearInterval(timerInterval);
                    $('#countdown').parent().removeClass('bg-blue-400');
                    $('#countdown').parent().addClass('bg-red-400');
                    $('#countdown').text('Waktu Ujian Telah Selesai');
                    
                    var formData = $('#form-ujian-siswa').serialize();
                    var url = $('#form-ujian-siswa').data('url');
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
                                localStorage.clear();
                                window.location.href = url;
                            }
                            if(response.type == 'error'){
                                toastr.error(response.msg);
                            }
                        }
                    });
                }
            }, 1000);

            $('input[type="radio"]').on('change', function() {
                var inputName = $(this).attr('name');
                var inputValue = $(this).data('id');
                localStorage.setItem(inputName, inputValue);
            });

            // Muat kembali nilai input dari Local Storage saat halaman dimuat
            $('input[type="radio"]').each(function() {
                var inputName = $(this).attr('name');
                var storedID = localStorage.getItem(inputName);
                var inputID = $(this).attr('data-id'); 
                if (storedID && storedID === inputID) {
                    $(this).prop('checked', true);
                }
            });

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
                                    localStorage.clear();
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