<table class="display w-full" id="js-table">
    <!-- head -->
    {{-- @php
        dd($ujians);
    @endphp --}}
    <thead>
        <tr>
            <th>No.</th>
            <th>Mata Pelajaran</th>
            <th>Kode Mapel</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Aksi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <!-- row 1 -->
        @foreach ($ujians as $ujian)
            @if ($ujian->soal_ujian)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $ujian->mapel->nama_mapel }}</td>
                    <td>{{ $ujian->mapel->kode_mapel }}</td>
                    <td>{{ $ujian->mapel->jurusan->jurusan }}</td>
                    <td>{{ $ujian->mapel->kelas->kelas }}</td>
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
        @endforeach
    </tbody>
</table>