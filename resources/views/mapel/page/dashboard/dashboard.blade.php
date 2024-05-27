@extends('frontendmaster')

@section('title')
    <title>Dashboard Guru</title>
@endsection

@push('style')
    <style>
        .box-detail{
            width: 312px;
            height: 170px;
        }
        .box-detail .box-content-1{
            width: 100%;
            height: 70%;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 0 3rem;
            align-items: center;
        }
        .box-detail .box-content-2{
            width: 100%;
            height: 30%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }
    </style>
@endpush

@section('content')
    <x-mapel-layout>
        <div class="w-full">
            <div class="w-full mt-5">
                <h1 class="text-2xl font-bold">Grafik Hasil Ujian</h1>
                <canvas id="myChart"  height="75"></canvas>
            </div>
            <div class="w-full mt-5">
                <h1 class="text-2xl font-bold mb-3">List Sesi Ujian</h1>
                @include('mapel.page.sesiUjian.partial.tabel_sesi_ujian')
            </div>
            <div class="w-full mt-5">
                <h1 class="text-2xl font-bold mb-3">List Hasil Ujian</h1>
                @include('mapel.page.hasilUjian.partial.tabel-hasil-ujian')
            </div>
        </div>
    </x-mapel-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){

            const mychart = document.getElementById('myChart');

            const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const chartData = @json(array_values($chartData));

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: chartData,
                    fill: true,
                    borderColor: 'rgb(96 165 250)',
                    backgroundColor: getGradient('rgb(96 165 250)'),
                    borderWidth: 3,
                    pointBackgroundColor: '#ff00',
                    pointBorderColor: '#ff00',
                    tension: 0.04
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: false
                        },
                        legend: {
                            display: false
                        },
                        tooltip: {
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    responsive: true,
                }
            };

            new Chart(mychart, config);

            function getGradient(color) {
                const ctx = document.getElementById('myChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, color); // Start color
                gradient.addColorStop(1, '#35B0A500'); // End color
                return gradient;
            }

            $('.js-example-basic-multiple').select2({
                placeholder: 'Pilih Kelas'
            });
            $(document).on('click', '.btn-edit-click', function(){
                var id_sesi = $(this).data('id');
                $('.js-example-basic-multiple2').select2({
                    placeholder: 'Pilih Kelas',
                    dropdownParent: $(`#my_modal_${id_sesi}`)
                });
            });
            $(document).on('click','.btn-delete-sesi', function(){
                Swal.fire({
                    title: "Hapus Sesi Ujian?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                    customClass: {
                        popup: 'remove-cart-popup',
                    }
                }).then( async (result) => {
                    if(result.isConfirmed){
                        var el = $(this);
                        var id_sesi = el.data('id');

                        await $.ajax({
                            url: '{{ route('mapel.sesi-ujian.delete') }}',
                            type: 'GET',
                            data: {
                                'id_sesi' : id_sesi
                            },
                            beforeSend: function(){
                                $('.loader').show();
                            },
                            success: function(response){
                                $('.loader').hide();
                                if(response.msg){
                                    toastr.success(response.msg);
                                    $('#js-table-sesi').DataTable().ajax.reload();
                                }
                            }
                        })
                    }
                });
            });

            $(document).on('submit', '#form-edit-sesi', function(e){
                e.preventDefault();
                var data = new FormData(this);
                var btn_save = $(this).find('button[type="submit"]');
                var spinner = '<span class="loading loading-spinner loading-sm"></span>';
                $.ajax({
                    type : 'post',
                    url: '{{ route('mapel.sesi-ujian.update') }}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function(){
                        btn_save.html(spinner);
                        btn_save.addClass('btn-disabled');
                    },
                    success: function(response){
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            $('#js-table-sesi').DataTable().ajax.reload();
                            btn_save.removeClass('btn-disabled');
                            btn_save.text('Simpan');
                            $('.btn-close-modal').trigger('click');
                            
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                            btn_save.removeClass('btn-disabled');
                            btn_save.text('Simpan');
                        }
                    },
                    error: function(response){
                        toastr.error(response.msg);
                        btn_save.removeClass('btn-disabled');
                        btn_save.text('Simpan');
                    }
                })
            });

            $('#js-table-sesi').DataTable({
                ajax: '{{ route('mapel.getDataSesi', ["id_mapel" => auth()->user()->mapel->id_mapel]) }}',
                responsive: true,
                columns: [
                    { data: null, orderable: false, searchable: false },
                    {data: 'mata_pelajaran'},
                    {
                        data: 'kelas',
                        render: function(data, type, row){
                            return data.map(kelas => `<span>${kelas}</span><br>`).join('');
                        }
                    },
                    {data: 'tanggal'},
                    {data: 'start'},
                    {data: 'end'},
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            var render = '';
                            if(row.status == 0){
                                render = `<a href="javascript:void(0)" class="btn-update-status btn btn-xs btn-circle btn-warning text-white w-full" data-value="0" data-id="${row.id_sesi}">Belum Mulai</a>`;
                            }
                            if(row.status == 1){
                                render = `<a href="javascript:void(0)" class="btn-update-status btn btn-xs btn-success btn-circle text-white w-full" data-value="1" data-id="${row.id_sesi}">Sedang Mulai</a>`;
                            }
                            if(row.status == 2){
                                render = '<a href="javascript:void(0)" class="btn btn-xs btn-error btn-circle text-white w-full">Selesai</a>';
                            }

                            return render;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            var render = '';
                            
                            if(row.soal){
                                render = `
                                    <div class="tooltip" data-tip="Lihat/Edit Soal">
                                        <a href="{{ url('/mapel/soal-ujian/${row.id_sesi}') }}" class="btn btn-sm btn-warning text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg>
                                        </a>
                                    </div>`;
                            } else {
                                render = `
                                    <div class="tooltip" data-tip="Buat Soal">
                                        <a href="{{ url('/mapel/soal-ujian/${row.id_sesi}') }}" class="btn btn-sm btn-warning text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                                        </a>
                                    </div>`;
                            }
                                render += `
                                    <div class="tooltip" data-tip="Hapus Sesi Ujian">
                                        <a class="btn btn-sm btn-error text-white btn-delete-sesi" data-id="${row.id_sesi}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                                        </a>
                                    </div>`;
                            return render;
                            
                        }
                    },
                ],
                columnDefs : [{
                        'target': '_all',
                        'className': 'dt-head-center'
                    },
                    {
                        'target': '_all',
                        'className': 'dt-body-center'
                    },
                    { width: '50px', target: 0 },
                    { width: '50px', target: 4 },
                    { width: '50px', target: 5 },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Set nomor urut
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });

        });
    </script>
@endpush

