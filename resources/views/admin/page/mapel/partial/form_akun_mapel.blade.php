<div class="w-full bg-slate-200 rounded-lg p-5">
    <form class="w-full" method="POST" id="form-mapel">
        @csrf
        <div class="flex flex-row flex-wrap gap-3">
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Username</span>
                    </div>
                    <input type="text" placeholder="username" name="username" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Password</span>
                    </div>
                    <input type="text" placeholder="Password" name="password" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Mata Pelajaran</span>
                    </div>
                    <input type="text" placeholder="Mata Pelajaran" name="nama_mapel" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Kode Mata Pelajaran</span>
                    </div>
                    <input type="text" placeholder="Kode Mata Pelajaran" name="kode_mapel" class="input input-sm input-bordered w-full" />
                </label>
            </div>
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Guru Pengampu</span>
                    </div>
                    <input type="text" placeholder="Nama Guru" name="nama_guru" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">NIP Guru</span>
                    </div>
                    <input type="text" placeholder="NIP Guru" name="nip" class="input input-sm input-bordered w-full" />
                </label>
                <div class="w-full h-full flex justify-end mt-8 gap-2 ">
                    <button type="submit" class="btn btn-sm btn-success text-white">Simpan</button>
                    <button type="submit" class="btn btn-sm btn-error text-white">Batalkan</button>
                </div>
            </div>
        </div>
    </form>
</div>