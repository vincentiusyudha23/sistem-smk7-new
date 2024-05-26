<div id="modal-kelas-edit">
@foreach ($kelas_jurusan as $kelas)
    <dialog id="my_modal_{{ $kelas->id_kelas }}" class="modal p-0 m-0">
        <div class="modal-box">
            <div class="modal-action w-full flex justify-between p-0 m-0">
                <h3 class="font-bold text-lg">Edit Kelas {{ $kelas->nama_kelas }}</h3>
                <form method="dialog">
                    <button class="btn btn-xs close-btn-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/></svg>
                    </button>
                </form>
            </div>
            <form class="mt-3" id="form-edit-kelas" data-id_kelas="{{ $kelas->id_kelas }}" >
                 @csrf
                 <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">
                <div class="flex-grow">
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Jurusan</span>
                        </div>
                        <input required type="text" value="{{ $kelas->jurusan }}" placeholder="jurusan" name="jurusan" class="input input-sm input-bordered w-full" />
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Kelas</span>
                        </div>
                        <select required name="kelas" class="select select-sm select-bordered w-full">
                            <option disabled selected>Pilih Kelas</option>
                            <option value="10" {{ $kelas->kelas == 10 ? 'selected' : '' }} class="font-bold">X</option>
                            <option value="11" {{ $kelas->kelas == 11 ? 'selected' : '' }} class="font-bold">XI</option>
                            <option value="12" {{ $kelas->kelas == 12 ? 'selected' : '' }} class="font-bold">XII</option>
                        </select>
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Nama Kelas</span>
                        </div>
                        <input required value="{{ $kelas->nama_kelas }}" type="text" placeholder="Nama Kelas" name="nama_kelas" class="input input-sm input-bordered w-full" />
                    </label>
                </div>
                <div class="w-full mt-5">
                    <button type="submit" class="btn btn-success w-full text-white text-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </dialog>
@endforeach
</div>