@extends('frontendmaster')

@section('content')
    <x-admin-all-layout>
        <h1 class="text-2xl font-bold my-2">Data Presensi Siswa</h1>
        <div class="w-full p-3">
            <table class="display" style="width: 100%" id="js-table-list-presensi">
                <!-- head -->
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presensi as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td>{{ $item['nama_siswa'] }}</td>
                            <td>{{ $item['nis'] }}</td>
                            <td>{{ $item['kelas'] }}</td>
                            <td>{{ $item['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('#js-table-list-presensi').DataTable({
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
            });
        });
    </script>
@endpush