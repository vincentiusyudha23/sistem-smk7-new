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
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- row 1 -->
            <tr>
                <td>1</td>
                <td>Matematika</td>
                <td>MT001</td>
                <td>Multimedia</td>
                <td>12</td>
                <td>31/03/2024</td>
                <td>10:00</td>
                <td>12:00</td>
                <td>
                    <div class="tooltip" data-tip="Mulai">
                        <a  href="{{ route('siswa.soal-ujian') }}"  class="btn btn-sm btn-success text-white">
                            Ikut Ujian
                        </a>
                    </div>
                </td>
                <td>
                    <h1 class="btn btn-sm btn-warning text-white">
                       Belum Mulai
                    </h1>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Matematika</td>
                <td>MT001</td>
                <td>Multimedia</td>
                <td>12</td>
                <td>31/03/2024</td>
                <td>10:00</td>
                <td>12:00</td>
                <td>
                    <div class="tooltip" data-tip="Mulai">
                        <a  href="{{ route('siswa.soal-ujian') }}"  class="btn btn-sm btn-success text-white">
                            Ikut Ujian
                        </a>
                    </div>
                </td>
                <td>
                    <h1 class="btn btn-sm btn-success text-white">
                       Mulai
                    </h1>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Matematika</td>
                <td>MT001</td>
                <td>Multimedia</td>
                <td>12</td>
                <td>31/03/2024</td>
                <td>10:00</td>
                <td>12:00</td>
                <td>
                    <div class="tooltip" data-tip="Mulai">
                        <a href="{{ route('siswa.soal-ujian') }}" class="btn btn-sm btn-success text-white">
                            Ikut Ujian
                        </a>
                    </div>
                </td>
                <td>
                    <h1 class="btn btn-error btn-sm text-white">
                       selesai
                    </h1>
                </td>
            </tr>
            
        </tbody>
    </table>
</div>