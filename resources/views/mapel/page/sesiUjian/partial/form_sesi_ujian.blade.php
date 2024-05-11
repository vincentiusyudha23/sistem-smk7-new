<div class="w-full bg-slate-200 rounded-lg p-5">
    <form class="w-full" id="form-sesi-ujian">
        @csrf
        <div class="flex flex-row flex-wrap gap-3">
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Mata Pelajaran</span>
                    </div>
                    <input type="text" value="{{ auth()->user()->mapel->nama_mapel }}" disabled class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Kode Mapel</span>
                    </div>
                    <input type="text" value="{{ auth()->user()->mapel->kode_mapel }}" disabled class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Jurusan</span>
                    </div>
                    <input type="text" value="{{ auth()->user()->mapel->jurusan->jurusan }}" disabled class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Kelas</span>
                    </div>
                    <input type="number" value="{{ auth()->user()->mapel->kelas->kelas }}" disabled class="input input-sm input-bordered w-full" />
                </label>
            </div>
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Tanggal Ujian</span>
                    </div>
                    <input type="date" name="tanggal_ujian" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Waktu Mulai</span>
                    </div>
                    <input type="time" name="start" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Waktu Selesai</span>
                    </div>
                    <input type="time" name="end" class="input input-sm input-bordered w-full" />
                </label>
                <div class="w-full h-full flex justify-end mt-8 gap-2 ">
                    <button type="submit" class="btn btn-sm btn-success text-white">Simpan</button>
                    <button type="button" class="btn btn-sm btn-error text-white">Batalkan</button>
                </div>
            </div>
        </div>
    </form>
</div>