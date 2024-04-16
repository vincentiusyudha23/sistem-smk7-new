<div class="w-full bg-slate-200 rounded-lg p-5">
    <form class="w-full">
        <div class="flex flex-row flex-wrap gap-3">
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Username</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Password</span>
                    </div>
                    <input type="password" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Siswa</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">NIS</span>
                    </div>
                    <input type="number" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Tanggal Lahir</span>
                    </div>
                    <input type="date" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
            </div>
            <div class="flex-grow">
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Jurusan</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Kelas</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nama Orang Tua</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <label class="form-control w-full"> 
                    <div class="label">
                        <span class="label-text font-bold">Nomor Telpon Orang Tua</span>
                    </div>
                    <input type="text" placeholder="Type here" class="input input-sm input-bordered w-full" />
                </label>
                <div class="w-full h-full flex justify-end mt-8 gap-2 ">
                    <a class="btn btn-sm btn-warning text-white">
                        <label for="import-akun" class="hover:cursor-pointer">Import Akun</label>
                        <input type="file" class="hidden" id="import-akun">
                    </a>
                    <button type="submit" class="btn btn-sm btn-success text-white">Simpan</button>
                    <button type="submit" class="btn btn-sm btn-error text-white">Batalkan</button>
                </div>
            </div>
        </div>
    </form>
</div>