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
                <tr>
                    <th>1</th>
                    <td>Proyek Teknologi Informasi</td>
                    <td>IF0001</td>
                    <td>Vincentius Yudha</td>
                    <td>12345678</td>
                    <td>Informatika</td>
                    <td>10</td>
                    <td>
                        <x-admin-edit-mapel>
                            @slot('id_mapel')
                                1
                            @endslot
                            @slot('mapel')
                                Proyek Teknologi Informasi
                            @endslot
                        </x-admin-edit-mapel>
                        <a class="btn btn-sm btn-error text-white btn-delete-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>2</th>
                    <td>Proyek Teknologi Informasi</td>
                    <td>IF0001</td>
                    <td>Vincentius Yudha</td>
                    <td>12345678</td>
                    <td>Informatika</td>
                    <td>10</td>
                    <td>
                        <x-admin-edit-mapel>
                            @slot('id_mapel')
                                2
                            @endslot
                            @slot('mapel')
                                Proyek Teknologi Informasi
                            @endslot
                        </x-admin-edit-mapel>
                        <a class="btn btn-sm btn-error text-white btn-delete-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>3</th>
                    <td>Proyek Teknologi Informasi</td>
                    <td>IF0001</td>
                    <td>Vincentius Yudha</td>
                    <td>12345678</td>
                    <td>Informatika</td>
                    <td>10</td>
                    <td>
                        <x-admin-edit-mapel>
                            @slot('id_mapel')
                                3
                            @endslot
                            @slot('mapel')
                                Proyek Teknologi Informasi
                            @endslot
                        </x-admin-edit-mapel>
                        <a class="btn btn-sm btn-error text-white btn-delete-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>