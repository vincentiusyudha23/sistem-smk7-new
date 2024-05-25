<table class="display responsive nowrap" width="100%" id="js-table-ujian">
    <thead>
        <tr>
            <th>No.</th>
            <th>Mata Pelajaran</th>
            <th>Kode Mapel</th>
            <th>Tanggal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- row 1 -->
        {{-- @foreach ($ujians as $ujian)
            @if ($ujian->soal_ujian)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $ujian->mapel->nama_mapel }}</td>
                    <td>{{ $ujian->mapel->kode_mapel }}</td>
                    <td>{{ date('d/m/Y', strtotime($ujian->tanggal_ujian)) }}</td>
                    <td>{{ date('H:i', strtotime($ujian->start)) }}</td>
                    <td>{{ date('H:i', strtotime($ujian->end)) }}</td>
                    <td>
                        <div class="tooltip" data-tip="Mulai">
                            @php
                                $status = false;
                                $get_sesiUjian = \App\Models\HasilUjian::where('id_siswa', auth()->user()->siswa->id_siswa)
                                                        ->where('id_sesi_ujian',$ujian->id)->first();
                                if(isset($get_sesiUjian)){
                                    $status = true;
                                }
                            @endphp
                            <a  href="{{ route('siswa.soal-ujian', ["id" => $ujian->id, "mapel" => $ujian->mapel->nama_mapel]) }}"  
                                class="@if ($status || $ujian->status !== 1) btn-disabled @endif btn btn-sm btn-success text-white">
                                Ikut Ujian
                            </a>
                        </div>
                    </td>
                    <td>
                        @if ($ujian->status == 0)
                            <a href="javascript:void(0)" class="px-2 py-1 btn btn-xs btn-circle btn-warning text-white w-full">Belum Mulai</a>                            
                        @endif
                        @if ($ujian->status == 1)
                            <a href="javascript:void(0)" class="px-2 py-1 btn btn-xs btn-success btn-circle text-white w-full">Sedang Mulai</a>                            
                        @endif
                        @if ($ujian->status == 2)
                            <a href="javascript:void(0)" class="px-2 py-1 btn btn-xs btn-error btn-circle text-white w-full">Selesai</a>                            
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach --}}
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#js-table-ujian').DataTable({
            ajax: "{{ route('siswa.getSesiUjian') }}",
            columns: [
                {data: null, orderable: false, searchable: false},
                {data: 'mata_pelajaran'},
                {data: 'kode_mapel'},
                {data: 'tanggal_ujian'},
                {data: 'start'},
                {data: 'end'},
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row){
                        var render;
                        if (row.status == 0){
                            render = '<a href="javascript:void(0)" class="px-2 py-1 btn btn-xs btn-circle btn-warning text-white w-full">Belum Mulai</a>'                     
                        }
                        
                        if (row.status == 1){
                            render = '<a href="javascript:void(0)" class="px-2 py-1 btn btn-xs btn-success btn-circle text-white w-full">Sedang Mulai</a>'                            
                        }
                        
                        if (row.status == 2){
                            render = '<a href="javascript:void(0)" class="px-2 py-1 btn btn-xs btn-error btn-circle text-white w-full">Selesai</a>'                            
                        }
                        return render;
                    }
                },
                {
                    data: null,
                    orderable: null,
                    searchable: null,
                    render: function(data, type, row){
                        var status = '';
                        if(row.status_hasil || row.soal_ujian === null || row.status === 0){
                            status = 'btn-disabled';
                        }
                        var render = `<a  href="{{ url('/siswa/soal-ujian/${row.id}') }}"  
                                        class="btn ${status} btn-sm btn-success text-white">
                                        Ikut Ujian
                                    </a>`;
                        
                        return render;
                    }
                }
            ],
            responsive: true,
            columnDefs : [{
                    'target': '_all',
                    'className': 'dt-head-center'
                },
                {
                    'target': '_all',
                    'className': 'dt-body-center'
                },
                { width: '20px', target: 0 },
            ],
            createdRow: function(row, data, dataIndex) {
                // Set nomor urut
                $('td:eq(0)', row).html(dataIndex + 1);
            }
        });
    });
</script>