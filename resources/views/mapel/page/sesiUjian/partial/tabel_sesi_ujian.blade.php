<table class="display" style="width: 100%" id="js-table-sesi">
    <!-- head -->
    <thead>
        <tr>
            <th>No.</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- row 1 -->
        {{-- @foreach ($sesi as $item)
            <tr>
                <th>{{ $loop->index + 1 }}</th>
                <td>{{ auth()->user()->mapel->nama_mapel }}</td>
                <td>{{ date('d-m-Y', strtotime($item->tanggal_ujian)) }}</td>
                <td>{{ $item->start }}</td>
                <td>{{ $item->end }}</td>
                <td>
                    @if ($item->status == 0)
                        <a href="javascript:void(0)" class="btn-update-status btn btn-xs btn-circle btn-warning text-white w-full" data-value="0" data-id="{{ $item->id }}">Belum Mulai</a>                            
                    @endif
                    @if ($item->status == 1)
                        <a href="javascript:void(0)" class="btn-update-status btn btn-xs btn-success btn-circle text-white w-full" data-value="1" data-id="{{ $item->id }}">Sedang Mulai</a>                            
                    @endif
                    @if ($item->status == 2)
                        <a href="javascript:void(0)" class="btn btn-xs btn-error btn-circle text-white w-full">Selesai</a>                            
                    @endif
                </td>
                <td>
                    <div class="tooltip" data-tip="Buat Soal">
                        <a href="{{ route('mapel.soal-ujian', ['id' => $item->id ]) }}" class="btn btn-sm btn-warning text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                        </a>
                    </div>
                    <div class="tooltip" data-tip="Edit Sesi Ujian">
                        <x-mapel-edit-sesi-ujian :idSesi="$item->id" :tanggal="$item->tanggal_ujian" :start="$item->start" :end="$item->end"/>
                    </div>
                    <div class="tooltip" data-tip="Hapus Sesi Ujian">
                        <a class="btn btn-sm btn-error text-white btn-delete-sesi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach --}}
    </tbody>
</table>

@foreach ($sesi as $item)    
<dialog id="my_modal_{{ $item->id }}" class="modal p-0 m-0" data-url="{{ route('mapel.soal-ujian', ["id" => $item->id ]) }}">
    <div class="modal-box">
        <div class="modal-action w-full flex justify-between p-0 m-0">
            <h3 class="font-bold text-lg">Edit Sesi Ujian</h3>
            <form method="dialog">
                <button class="btn btn-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/></svg>
                </button>
            </form>
        </div>
        <form class="w-full" id="form-edit-sesi">
            @csrf
            <div class="flex flex-row flex-wrap gap-3">
                <input type="hidden" name="idSesi" value="{{ $item->id }}">
                <div class="flex-grow">
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Tanggal Ujian</span>
                        </div>
                        <input type="date" name="tanggal_ujian" value="{{ $item->tanggal_ujian }}" class="input input-sm input-bordered w-full" />
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Waktu Mulai</span>
                        </div>
                        <input type="time" name="start" value="{{ $item->start }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Waktu Selesai</span>
                        </div>
                        <input type="time" name="end" value="{{ $item->end }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                    </label>
                </div>
            </div>
            <div class="w-full mt-5">
                <button type="submit" class="btn btn-success w-full text-white text-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</dialog>
@endforeach