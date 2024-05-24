<div class="w-full bg-slate-200 rounded-lg p-5">
    <form class="w-full" id="form-siswa" method="POST">
        @csrf
        <div class="flex flex-row flex-wrap gap-3">
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Username</span>
                    </div>
                    <input required name="username" type="text" placeholder="Username" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Password</span>
                    </div>
                    <input required name="password" type="text" placeholder="Password" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Siswa</span>
                    </div>
                    <input required name="nama_siswa" type="text" placeholder="Nama Siswa" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">NIS</span>
                    </div>
                    <input required name="nis" type="number" placeholder="NIS" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Tanggal Lahir</span>
                    </div>
                    <input required name="tanggal_lahir" type="date" placeholder="Tanggal Lahir" class="input input-sm input-bordered w-full" />
                </label>
            </div>
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Kelas</span>
                    </div>
                    <select required name="kelas" class="select select-sm select-bordered w-full">
                        <option disabled selected>Pilih kelas</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Orang Tua</span>
                    </div>
                    <input required name="nama_orangtua" type="text" placeholder="Nama Orang Tua" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nomor Telpon Orang Tua</span>
                    </div>
                    <input required name="nomor_telepon" type="number" placeholder="Nomor Telepon" class="input input-sm input-bordered w-full" />
                </label>
                <div class="w-full h-full mt-8 ">
                    <div class="w-full  flex justify-end gap-2">
                        <a class="btn btn-sm btn-warning text-white" id="import-siswa">
                            <label for="import-akun" class="hover:cursor-pointer">Import Akun</label>
                        </a>
                        <button type="submit" class="btn btn-sm btn-success text-white">Simpan</button>
                        <a href="javascript:void(0)" class="js-btn-reset btn btn-sm btn-error text-white">Batalkan</a>
                    </div>
                    <div class="w-full flex justify-end mt-2">
                        <span class="text-black text-sm font-light">
                            <sup>*</sup>
                            Template excel import siswa. <a href="{{ route('admin.download.template.siswa') }}" class="text-blue-600">Unduh</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>