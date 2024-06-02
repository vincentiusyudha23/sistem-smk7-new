@extends("frontendmaster")

@section('title')
    <title>
        Hasil Ujian
    </title>
@endsection

@section('content')
    <x-mapel-layout>
        <div class="inline-flex justify-between w-full items-center my-5">
            <h1 class="text-2xl font-bold">List Hasil Ujian {{ $sesi->mapel->nama_mapel }}</h1>
            <div class="flex justify-center items-center gap-1">
                <a href="{{ route('mapel.export_hasil_ujian', [ 'id' => $sesi->id]) }}" class="btn btn-info btn-sm text-white">Unduh Hasil Ujian</a>
                <a href="{{ route('mapel.hasil-ujian') }}" class="btn btn-sm btn-error text-white">Kembali</a>
            </div>
        </div>
        <div class="p-2 bg-slate-200 rounded-md flex flex-col md:flex-row gap-3 justify-center md:justify-between items-center">
            <ul >
                <li>Nama Mata Pelajaran : {{ $sesi->mapel->nama_mapel }}</li>
                <li>Tanggal Ujian       : {{ $sesi->tanggal_ujian->format('d/m/Y') }}</li>
                <li>Start               : {{ $sesi->start->format('H:i') }}</li>
                <li>End                 : {{ $sesi->end->format('H:i') }}</li>
            </ul>
            <div>
                <h1 id="countdown" class="text-2xl font-bold"></h1>
            </div>
            <div class="w-32 h-full flex flex-col justify-center items-center bg-slate-50 mr-5 rounded-sm">
                <h1 class="text-2xl font-bold">{{ count($hasil_ujians) }}</h1>
                <h1 class="text-lg">Siswa</h1>
            </div>
        </div>
        <table class="display" style="width: 100%" id="js-table-hasil-ujian">
            <!-- head -->
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Nilai</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-mapel-layout>
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

            var endTime = new Date("<?php echo $sesi->end; ?>").getTime(); 

            var timerInterval = setInterval(function() {
                updateCountdown(endTime);

                
                if (endTime <= new Date().getTime()) {
                    clearInterval(timerInterval);
                     $('#countdown').text('Ujian Selesai');
                }
            }, 1000);
            
            $('.btn-delete-sesi').on('click', function(){
                Swal.fire({
                    title: "Hapus Sesi Ujian?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                    customClass: {
                        popup: 'remove-cart-popup',
                    }
                });
            })

            $('#js-table-hasil-ujian').DataTable({
                ajax : `{{ route('mapel.getHasilUjianSiswa', ['id' => $sesi->id  ]) }}`,
                responsive: true,
                columns: [
                    { data: null, orderable: false, searchable: false },
                    {data:'nama_siswa'},
                    {data:'nis'},
                    {data:'kelas'},
                    {data:'nilai'},
                    {data:'tanggal'},
                ],
                columnDefs : [{
                        'target': '_all',
                        'className': 'dt-head-center'
                    },
                    {
                        'target': '_all',
                        'className': 'dt-body-center'
                    },
                    { width: '50px', target: 0 }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Set nomor urut
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });
        })
    </script>
@endpush