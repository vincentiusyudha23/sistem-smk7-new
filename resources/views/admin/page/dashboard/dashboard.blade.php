@extends('frontendmaster')

@section('title')
    <title>Dashboard Admin</title>
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
            justify-content: center;
            align-items: center;
            padding: 0 2rem;
        }
    </style>
@endpush

@section('content')
    <x-admin-all-layout>
        <div class="overflow-x-auto max-w-full md:w-full md:p-10 flex gap-5 md:gap-10 md:justify-center">
            <div class="box-detail border border-blue-600 rounded-md">
                <div class="box-content-1 bg-blue-600 rounded-t-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19M12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4"/></svg>
                    <div class="text-center">
                        <h1 class="text-4xl font-bold">{{ $siswa }}</h1>
                        <h1>Total Siswa</h1>
                    </div>
                </div>
                <div class="box-content-2 text-blue-600">
                    <a>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</a>
                </div>
            </div>
            <div class="box-detail border border-green-400 rounded-md">
                <div class="box-content-1 bg-green-400 rounded-t-md">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold">{{ $presensiMasuk }}</h1>
                        <h1>Siswa Masuk</h1>
                    </div>
                    <div class="text-center">
                        <h1 class="text-4xl font-bold">{{ $presensiPulang }}</h1>
                        <h1>Siswa Pulang</h1>
                    </div>
                </div>
                <div class="box-content-2 text-green-400">
                    <a>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</a>
                </div>
            </div>
            
            <div class="box-detail border border-yellow-400 rounded-md">
                <div class="box-content-1 bg-yellow-400 rounded-t-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19M12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4"/></svg>
                    <div class="text-center">
                        <h1 class="text-4xl font-bold">{{ number_format($persen_hadir, 1) }}%</h1>
                        <h1>Presentasi Hadir</h1>
                    </div>
                </div>
                <div class="box-content-2 text-yellow-400">
                    <a>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</a>
                </div>
            </div>
        </div>
        <div class="w-full md:px-10">
            <h1 class="text-2xl font-bold mb-3">Grafik Presensi Masuk Siswa</h1>
            <canvas id="myChart"  height="75"></canvas>
        </div>
        @include('admin.page.dashboard.partial.table_presensi')
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            const presensiChart  = document.getElementById('myChart');
    
            const labels = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];
            const data = @json(array_values($weeklyData));
            
            const config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Presensi',
                    data: data,
                    fill: true,
                    borderColor: 'rgb(96, 165, 250)',
                    backgroundColor: getGradient('rgb(96, 165, 250)'),
                    borderWidth: 3,
                    pointBackgroundColor: '#0659bf',
                    pointBorderColor: '#0659bf',
                    tension: 0.04
                }]
            },
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
                responsive: true
            }
        };

        new Chart(presensiChart, config);

        function getGradient(color) {
            const ctx = presensiChart.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, color); // Start color
            gradient.addColorStop(1, 'rgba(53, 176, 165, 0)'); // End color
            return gradient;
        }

        $('#js-table-list-presensi').DataTable({
            ajax: "{{ route('admin.getDataPresensi') }}",
            responsive: true,
            columns: [
                { data: null, orderable: false, searchable: false },
                {data: 'tanggal'},
                {data: 'nama_siswa'},
                {data: 'nis'},
                {data: 'kelas'},
                {data: 'status'},
            ],
            columnDefs : [
                {
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
        });
    </script>
@endpush

