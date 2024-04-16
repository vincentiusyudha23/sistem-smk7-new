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
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('admin.sidebar.sidebar')
        </div>
        <div class="w-[80%]">
            <div class="w-full h-14 bg-purple-200 flex items-center px-14 text-lg font-semibold">
                <h1>Selamat Siang, Vincentius Yudha</h1>
            </div>
            <div class="w-full p-10 flex gap-10 justify-center">
                <div class="box-detail border border-blue-600 rounded-md">
                    <div class="box-content-1 bg-blue-600 rounded-t-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19M12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4"/></svg>
                        <div class="text-center">
                            <h1 class="text-4xl font-bold">300</h1>
                            <h1>Total Siswa</h1>
                        </div>
                    </div>
                    <div class="box-content-2 text-blue-600">
                        <a>View Detail</a>
                        <a>27/03/2024</a>
                    </div>
                </div>
                <div class="box-detail border border-green-400 rounded-md">
                    <div class="box-content-1 bg-green-400 rounded-t-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19M12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4"/></svg>
                        <div class="text-center">
                            <h1 class="text-4xl font-bold">250</h1>
                            <h1>Total Hadir</h1>
                        </div>
                    </div>
                    <div class="box-content-2 text-green-400">
                        <a>View Detail</a>
                        <a>27/03/2024</a>
                    </div>
                </div>
                <div class="box-detail border border-yellow-400 rounded-md">
                    <div class="box-content-1 bg-yellow-400 rounded-t-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19M12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4"/></svg>
                        <div class="text-center">
                            <h1 class="text-4xl font-bold">90%</h1>
                            <h1>Presentasi Hadir</h1>
                        </div>
                    </div>
                    <div class="box-content-2 text-yellow-400">
                        <a>View Detail</a>
                        <a>27/03/2024</a>
                    </div>
                </div>
            </div>
            <div class="w-full px-10">
                <h1 class="text-2xl font-bold">Grafik Presensi Siswa</h1>
                <canvas id="myChart"  height="75"></canvas>
            </div>
            @include('admin.page.dashboard.partial.table_presensi')
        </div>
    </div>
@endsection

@push('script')
    <script>
        const mychart = document.getElementById('myChart');

        const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const data = {
            labels: labels,
            datasets: [{
                label: 'My First Dataset',
                data: [65, 59, 80, 81, 56, 55, 40, 30, 53, 43, 33, 23],
                fill: true,
                borderColor: 'rgb(96 165 250)',
                backgroundColor: getGradient('rgb(96 165 250)'),
                borderWidth: 3,
                pointBackgroundColor: '#ff00',
                pointBorderColor: '#ff00',
                tension: 0.04
            }]
        }
        const config = {
            type: 'line',
            data: data,
            option: {
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
        }

        new Chart(mychart, config)

        function getGradient(color) {
                const ctx = document.getElementById('myChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, color); // Start color
                gradient.addColorStop(1, '#35B0A500'); // End color
                return gradient;
            }
    </script>
@endpush

