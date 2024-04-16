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
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('mapel.sidebar.sidebar')
        </div>
        <div class="w-[80%]">
            <div class="w-full h-14 bg-purple-200 flex items-center px-14 text-lg font-semibold">
                <h1>Selamat Siang, Vincentius Yudha</h1>
            </div>
            <div class="w-full px-10">
                <div class="w-full mt-5">
                    <h1 class="text-2xl font-bold">Grafik Hasil Ujian</h1>
                    <canvas id="myChart"  height="75"></canvas>
                </div>
                <div class="w-full mt-5">
                    <h1 class="text-2xl font-bold mb-3">List Sesi Ujian</h1>
                    @include('mapel.page.dashboard.partial.tabel_sesi_ujian')
                </div>
                <div class="w-full mt-5">
                    <h1 class="text-2xl font-bold mb-3">List Hasil Ujian</h1>
                    @include('mapel.page.dashboard.partial.tabel_hasil_ujian')
                </div>
            </div>
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

