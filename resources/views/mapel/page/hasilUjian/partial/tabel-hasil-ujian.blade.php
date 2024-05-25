<table class="display" style="width: 100%" id="js-table">
    <!-- head -->
    <thead>
        <tr>
            <th>No.</th>
            <th>Mata Pelajaran</th>
            <th>Tanggal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- row 1 -->
        @foreach ($sesi as $item)
            <tr>
                <th>{{ $loop->index + 1 }}</th>
                <td>{{ auth()->user()->mapel->nama_mapel }}</td>
                <td>{{ date('d-m-Y', strtotime($item->tanggal_ujian)) }}</td>
                <td>{{ $item->start }}</td>
                <td>{{ $item->end }}</td>
                <td>
                    @if ($item->status == 0)
                        <a href="javascript:void(0)" class="btn btn-xs btn-circle btn-warning text-white w-full">Belum Mulai</a>                            
                    @endif
                    @if ($item->status == 1)
                        <a href="javascript:void(0)" class="btn btn-xs btn-success btn-circle text-white w-full">Sedang Mulai</a>                            
                    @endif
                    @if ($item->status == 2)
                        <a href="javascript:void(0)" class="btn btn-xs btn-error btn-circle text-white w-full">Selesai</a>                            
                    @endif
                </td>
                <td>
                    <div class="tooltip" data-tip="Lihat">
                        <a href="{{ route('mapel.hasil-ujian-siswa', ['id' => $item->id]) }}" class="{{ count($item->hasil_ujian) > 0 ? '' : 'btn-disabled' }} btn btn-sm btn-info text-white">
                            Lihat
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>