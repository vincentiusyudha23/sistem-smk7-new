<button class="btn btn-sm btn-success text-white"  onclick="my_modal_{{ $idSesi }}.showModal()">
    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3"/></g></svg>
</button>
<dialog id="my_modal_{{ $idSesi }}" class="modal p-0 m-0">
    <div class="modal-box">
        <div class="modal-action w-full flex justify-between p-0 m-0">
            <h3 class="font-bold text-lg">Edit Sesi Ujian</h3>
            <form method="dialog">
                <button class="btn btn-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/></svg>
                </button>
            </form>
        </div>
        <form class="w-full" id="form-edit-sesi">
            @csrf
            <div class="flex flex-row flex-wrap gap-3">
                <input type="hidden" name="idSesi" value="{{ $idSesi }}">
                <div class="flex-grow">
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Tanggal Ujian</span>
                        </div>
                        <input type="date" name="tanggal_ujian" value="{{ $tanggal }}" class="input input-sm input-bordered w-full" />
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Waktu Mulai</span>
                        </div>
                        <input type="time" name="start" value="{{ $start }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Waktu Selesai</span>
                        </div>
                        <input type="time" name="end" value="{{ $end }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                    </label>
                </div>
            </div>
            <div class="w-full mt-5">
                <button type="submit" class="btn btn-success w-full text-white text-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</dialog>