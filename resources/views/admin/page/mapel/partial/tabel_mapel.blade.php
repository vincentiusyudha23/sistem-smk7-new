<div>
    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <!-- head -->
            <thead class="bg-gray-200 text-black">
                <tr>
                    <th>No.</th>
                    <th>Mata Pelajaran</th>
                    <th>Kode Mapel</th>
                    <th>Nama Guru</th>
                    <th>NIP</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @if (count($mapels) > 0)
                    @foreach ($mapels as $mapel)
                        <tr>
                            <th>{{ $loop->index + 1 }}</th>
                            <td>{{ $mapel->nama_mapel }}</td>
                            <td>{{ $mapel->kode_mapel }}</td>
                            <td>{{ $mapel->nama_guru }}</td>
                            <td>{{ $mapel->nip }}</td>
                            <td>{{ $mapel->jurusan->jurusan }}</td>
                            <td>{{ $mapel->kelas->kelas }}</td>
                            <td>
                                <x-admin-edit-mapel :idMapel="$mapel->id_mapel"
                                    :username="$mapel->users->username"
                                    :password="$mapel->password"
                                    :namaMapel="$mapel->nama_mapel"
                                    :kodeMapel="$mapel->kode_mapel"
                                    :namaGuru="$mapel->nama_guru"
                                    :nip="$mapel->nip"
                                    :kelas="$mapel->id_kelas"
                                    :jurusan="$mapel->id_jurusan"/>

                                <a class="btn btn-sm btn-error text-white btn-delete-mapel" data-id="{{ $mapel->id_mapel }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>