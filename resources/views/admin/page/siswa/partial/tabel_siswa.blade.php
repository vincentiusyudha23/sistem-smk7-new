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
                <tr>
                    <th>1</th>
                    <td>Vincentius Yudha R</td>
                    <td>112873981273917</td>
                    <td>20/23/2024</td>
                    <td>Multimedia</td>
                    <td>12</td>
                    <td>Mariyadi</td>
                    <td>0877213123</td>
                    <td>
                        <x-admin-edit-siswa>
                            @slot('id_siswa')
                                1
                            @endslot
                            @slot('siswa')
                                Vincentius Yudha R
                            @endslot
                        </x-admin-edit-siswa>
                        <a class="btn btn-sm btn-error text-white btn-delete-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>1</th>
                    <td>Vincentius Yudha R</td>
                    <td>112873981273917</td>
                    <td>20/23/2024</td>
                    <td>Multimedia</td>
                    <td>12</td>
                    <td>Mariyadi</td>
                    <td>0877213123</td>
                    <td>
                        <x-admin-edit-siswa>
                            @slot('id_siswa')
                                2
                            @endslot
                            @slot('siswa')
                                Vincentius Yudha R
                            @endslot
                        </x-admin-edit-siswa>
                        <a class="btn btn-sm btn-error text-white btn-delete-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>1</th>
                    <td>Vincentius Yudha R</td>
                    <td>112873981273917</td>
                    <td>20/23/2024</td>
                    <td>Multimedia</td>
                    <td>12</td>
                    <td>Mariyadi</td>
                    <td>0877213123</td>
                    <td>
                        <x-admin-edit-siswa>
                            @slot('id_siswa')
                                3
                            @endslot
                            @slot('siswa')
                                Vincentius Yudha R
                            @endslot
                        </x-admin-edit-siswa>
                        <a class="btn btn-sm btn-error text-white btn-delete-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>