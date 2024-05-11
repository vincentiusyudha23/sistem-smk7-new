<div class="w-100 bg-gray-300 rounded-lg p-5">
    <form id="form-soal-ujian" method="POST" action="{{ route('mapel.soal-ujian.store') }}">
        @csrf
        <input type="hidden" name="id_sesi" value="{{ $sesi->id }}">
        <p>Tanggal Ujian : {{ date('d-M-Y', strtotime($sesi->tanggal_ujian)) }},  <span class="btn btn-success btn-sm text-white">Mulai : {{ $sesi->start }}</span> - <span class="btn btn-error btn-sm text-white">Selesai : {{ $sesi->end }}</span></p>
        <div class="w-full">
            <ul class="list-soal mt-3">
                
            </ul>
            <div class="w-full flex justify-between items-center mt-3">
                <label class="text-lg font-semibold">Tambah Soal Ujian</label>
                <button type="button" class="btn btn-sm btn-outline btn-circle border-2 btn-tambah-soal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                </button>
            </div>
            <div class="w-full flex justify-end items-center mt-3">
                <button type="submit" class="btn btn-sm btn-success text-white">
                    Simpan
                </button>
            </div>
        </div>
    </form>
</div>

