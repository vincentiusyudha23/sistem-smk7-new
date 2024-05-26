<div class="w-full bg-slate-200 rounded-lg p-5">
    <form class="w-full" id="form-sesi-ujian">
        @csrf
        <div class="flex w-full flex-row flex-wrap">
            <div class="flex-grow w-1/2 px-1">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Mata Pelajaran</span>
                    </div>
                    <input required type="text" value="{{ auth()->user()->mapel->nama_mapel }}" disabled class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Kode Mapel</span>
                    </div>
                    <input required type="text" value="{{ auth()->user()->mapel->kode_mapel }}" disabled class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Tanggal Ujian</span>
                    </div>
                    <input required type="date" name="tanggal_ujian" class="input input-sm input-bordered w-full" />
                </label>
            </div>
            <div class="flex-grow w-1/2 px-1">
                <label class="form-control"> 
                    <div class="label">
                        <span class="label-text font-bold">Kelas</span>
                    </div>
                    <select required class="js-example-basic-multiple w-full" name="kelas[]" multiple="multiple">
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Waktu Mulai</span>
                    </div>
                    <input required type="time" name="start" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Waktu Selesai</span>
                    </div>
                    <input required type="time" name="end" class="input input-sm input-bordered w-full" />
                </label>
                <div class="w-full h-full flex justify-end mt-8 gap-2 ">
                    <button type="submit" class="btn btn-sm btn-success text-white">Simpan</button>
                    <button type="button" class="btn btn-sm btn-error text-white btn-reset-form">Batalkan</button>
                </div>
            </div>
        </div>
    </form>
</div>