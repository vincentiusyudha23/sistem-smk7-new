<div class="w-100 bg-gray-300 rounded-lg p-5">
    <div class="w-full">
        <ul class="list-soal mt-3">
            <li class="bg-gray-200 p-3 rounded-lg my-2 soal-1">
                <form>
                    <label class="form-control">
                        <div class="label">
                            <span class="label-text text-lg font-semibold">Soal 1.</span>
                            <button type="button" class="btn btn-sm btn-error text-white btn-remove-soal" data-soal="1">Hapus</button>
                        </div>
                        <textarea class="textarea textarea-bordered textarea-sm w-full max-h-[50px] bg-white"></textarea>
                    </label>
                    <div class="flex flex-col gap-2 my-3">
                        <div class="form-control parent-opsiSoal-1">
                            <label class="label cursor-pointer justify-start">
                                <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                <input type="text" class="input input-bordered input-sm mx-3 w-[50%]">
                                <button type="button" class="btn btn-xs btn-outline btn-circle border-2 remove-opsi-btn">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                                </button>
                            </label>
                        </div>
                    </div>
                    <span class="px-2 hover:text-black/50 hover:cursor-pointer" id="addopsiSoal" data-soal="1">Tambah Opsi Jawaban</span>
                </form>
            </li>
        </ul>
        <div class="w-full flex justify-between items-center">
            <label class="text-lg font-semibold">Tambah Soal Ujian</label>
            <button type="button" class="btn btn-sm btn-outline btn-circle border-2 btn-tambah-soal">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
            </button>
        </div>
    </div>
</div>

