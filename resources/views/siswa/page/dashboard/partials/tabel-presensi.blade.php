<table class="display responsive nowrap" width="100%" id="js-table-presensi">
    <!-- head -->
    <thead >
        <tr>
            <th>No.</th>
            <th>Hari</th>
            <th>Tanggal</th>
            <th>Nama Siswa</th>
            <th>NIS</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($presensi as $riwayat)
            <tr>
                <td>{{ $loop->index + 1}}</td>
                <td>{{ Carbon\Carbon::parse($riwayat->created_at)->locale('id')->isoFormat('dddd') }}</td>
                <td>{{  date('d/m/Y', strtotime($riwayat->created_at)) }}</td>
                <td>{{ auth()->user()->siswa->nama }}</td>
                <td>{{ auth()->user()->siswa->nis }}</td>
                <td>{{ $riwayat->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('#js-table-presensi').DataTable({
            responsive: {
                details : false
            },
            columnDefs : [{
                    'target': '_all',
                    'className': 'dt-head-center'
                },
                {
                    'target': '_all',
                    'className': 'dt-body-center'
                },
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ]
        });
    });
</script>