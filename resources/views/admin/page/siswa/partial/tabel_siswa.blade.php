<div>
    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <!-- head -->
            <thead class="bg-gray-200 text-black">
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Nis</th>
                    <th>Tanggal Lahir</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Orang Tua</th>
                    <th>No Telp. Orang tua</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @foreach ($siswas as $siswa)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>
                            {{ date('d-m-Y', strtotime($siswa->tanggal_lahir)) }}
                        </td>
                        <td>{{ $siswa->jurusan->jurusan }}</td>
                        <td>{{ $siswa->kelas->kelas }}</td>
                        <td>{{ $siswa->orangTua->nama }}</td>
                        <td>{{ $siswa->orangTua->nomor_telepon }}</td>
                        <td>
                            <x-admin-edit-siswa>
                                @slot('id_siswa')
                                    {{ $siswa->id_siswa }}
                                @endslot
                                @slot('siswa')
                                    {{ $siswa->nama }}
                                @endslot
                            </x-admin-edit-siswa>
                            <a class="btn btn-sm btn-error text-white btn-delete-siswa">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>