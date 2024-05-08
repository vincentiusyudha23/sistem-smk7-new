@extends("frontendmaster")

@section('title')
    <title>
        Hasil Ujian
    </title>
@endsection

@section('content')
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('mapel.sidebar.sidebar')
        </div>
        <div class="w-[80%] p-10">
            <div class="inline-flex justify-between w-full items-center mt-10 mb-5">
                <h1 class="text-2xl font-bold">List Hasil Ujian {{ $sesi->mapel->nama_mapel }}</h1>
                <a href="{{ route('mapel.hasil-ujian') }}" class="btn btn-sm btn-error text-white">Kembali</a>
            </div>
            <div class="p-2 bg-slate-200 rounded-md flex justify-between items-center">
                <ul >
                    <li>Nama Mata Pelajaran : {{ $sesi->mapel->nama_mapel }}</li>
                    <li>Tanggal Ujian       : {{ $sesi->tanggal_ujian }}</li>
                    <li>Start               : {{ date('H:m', strtotime($sesi->start)) }}</li>
                    <li>End                 : {{ date('H:m', strtotime($sesi->end)) }}</li>
                </ul>
                <div class="w-32 h-full flex flex-col justify-center items-center bg-slate-50 mr-5 rounded-sm">
                    <h1 class="text-2xl font-bold">{{ count($hasil_ujians) }}</h1>
                    <h1 class="text-lg">Jawaban</h1>
                </div>
            </div>
            <table class="display" style="width: 100%" id="js-table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Nilai</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasil_ujians as $ujian)
                        <tr>
                            <th>{{ $loop->index + 1 }}</th>
                            <td>{{ $ujian->siswa->nama }}</td>
                            <td>{{ $ujian->siswa->nis }}</td>
                            <td>{{ $ujian->siswa->kelas->kelas }}</td>
                            <td>{{ $ujian->siswa->jurusan->jurusan }}</td>
                            <td>{{ $ujian->nilai }}</td>
                            <td>{{ $ujian->sesi_ujian->tanggal_ujian }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
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
        })
    </script>
@endpush