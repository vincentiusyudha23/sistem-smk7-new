<div class="overflow-x-auto">
    <table class="table table-zebra">
        <!-- head -->
        <thead class="bg-gray-200 text-black">
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
            </tr>
        </thead>
        <tbody>
            <!-- row 1 -->
            <tr>
                <th>1</th>
                <td>Matematika</td>
                <td>MT001</td>
                <td>Multimedia</td>
                <td>12</td>
                <td>31/03/2024</td>
                <td>10:00</td>
                <td>12:00</td>
                <td>
                    <div class="tooltip" data-tip="Buat Soal">
                        <a href="{{ route('mapel.soal-ujian') }}" class="btn btn-sm btn-warning text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                        </a>
                    </div>
                    <div class="tooltip" data-tip="Edit Sesi Ujian">
                        <x-mapel-edit-sesi-ujian>
                            @slot('id_sesi')
                                1
                            @endslot
                        </x-mapel-edit-sesi-ujian>
                    </div>
                    <div class="tooltip" data-tip="Hapus Sesi Ujian">
                        <a class="btn btn-sm btn-error text-white btn-delete-sesi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <th>2</th>
                <td>jaringan</td>
                <td>JR001</td>
                <td>Multimedia</td>
                <td>12</td>
                <td>31/03/2024</td>
                <td>10:00</td>
                <td>12:00</td>
                <td>
                    <div class="tooltip" data-tip="Buat Soal">
                        <a href="{{ route('mapel.soal-ujian') }}" class="btn btn-sm btn-warning text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                        </a>
                    </div>
                    <div class="tooltip" data-tip="Edit Sesi Ujian">
                        <x-mapel-edit-sesi-ujian>
                            @slot('id_sesi')
                                2
                            @endslot
                        </x-mapel-edit-sesi-ujian>
                    </div>
                    <div class="tooltip" data-tip="Hapus Sesi Ujian">
                        <a class="btn btn-sm btn-error text-white btn-delete-sesi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <th>3</th>
                <td>Desain</td>
                <td>DS001</td>
                <td>Multimedia</td>
                <td>12</td>
                <td>31/03/2024</td>
                <td>10:00</td>
                <td>12:00</td>
                <td>
                    <div class="tooltip" data-tip="Buat Soal">
                        <a href="{{ route('mapel.soal-ujian') }}" class="btn btn-sm btn-warning text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                        </a>
                    </div>
                    <div class="tooltip" data-tip="Edit Sesi Ujian">
                        <x-mapel-edit-sesi-ujian>
                            @slot('id_sesi')
                                3
                            @endslot
                        </x-mapel-edit-sesi-ujian>
                    </div>
                    <div class="tooltip" data-tip="Hapus Sesi Ujian">
                        <a class="btn btn-sm btn-error text-white btn-delete-sesi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            
        </tbody>
    </table>
</div>