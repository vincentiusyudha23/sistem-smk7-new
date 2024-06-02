<dialog id="modal_download" class="modal">
    <div class="modal-box">
        <h2 class="font-bold">Unduh Data presensi</h2>
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form id="form-download-presensi" action="{{ route('admin.download.presensi') }}" method="POST">
            @csrf
            <div class="p-1">
                <div class="flex flex-col w-full items-center my-3">
                    <h1 class="mx-2 w-24">Berdasarkan</h1> 
                    <div class="join">
                        <input class="join-item btn btn-sm" type="radio" name="options" value="0" aria-label="Semua Data" />
                        <input class="join-item btn btn-sm" type="radio" name="options" value="1" aria-label="Tanggal" />
                        <input class="join-item btn btn-sm" type="radio" name="options" value="2" aria-label="Nama Siswa" />
                        <input class="join-item btn btn-sm" type="radio" name="options" value="3" aria-label="Kelas" />
                        <input class="join-item btn btn-sm" type="radio" name="options" value="4" aria-label="Jurusan" />
                    </div>
                </div>
                <div class="filter-siswa w-full my-5 hidden">
                    <div class="flex-row w-full items-center flex">
                        <h1 class="mx-2 w-24">Nama Siswa</h1> 
                        <select id="filter-siswa" class="w-3/4" name="siswa[]" multiple="multiple">
                            @foreach ($siswas ?? [] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter-kelas w-full my-5 hidden">
                    <div class="flex-row w-full items-center flex">
                        <h1 class="mx-2 w-24">Kelas</h1> 
                        <select id="filter-kelas" class="w-3/4" name="kelas[]" multiple="multiple">
                            @foreach ($kelas ?? [] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter-jurusan w-full my-5 hidden">
                    <div class="flex-row w-full items-center flex">
                        <h1 class="mx-2 w-24">Jurusan</h1> 
                        <select id="filter-jurusan" class="w-3/4" name="jurusan[]" multiple="multiple">
                            @foreach ($jurusans ?? [] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex-row w-full items-center my-2 filter-date hidden">
                    <h1 class="mx-2">From</h1> 
                    <input type="date" name="dateFrom" class="input input-sm input-bordered w-full max-w-xs">
                    <h1 class="mx-2">To</h1> 
                    <input type="date" name="dateTo" class="input input-sm input-bordered w-full max-w-xs">
                </div>
            </div>
            <div class="w-full">
                <button type="submit" class="btn btn-success text-white w-full text-lg">Unduh</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
