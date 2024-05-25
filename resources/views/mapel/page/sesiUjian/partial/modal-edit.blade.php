@php
    $all_kelas = App\Models\KelasJurusan::pluck('nama_kelas', 'id_kelas')->toArray();
@endphp
@foreach ($sesi as $item)  
<dialog id="my_modal_{{ $item['id'] }}" class="modal p-0 m-0">
    <div class="modal-box">
        <div class="modal-action w-full flex justify-between p-0 m-0">
            <h3 class="font-bold text-lg">Edit Sesi Ujian</h3>
            <form method="dialog">
                <button class="btn btn-xs btn-close-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/></svg>
                </button>
            </form>
        </div>
        <form class="w-full" id="form-edit-sesi">
            @csrf
            <div class="flex flex-row flex-wrap gap-3">
                <input type="hidden" name="idSesi" value="{{ $item['id'] }}">
                <div class="flex-grow">
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Tanggal Ujian</span>
                        </div>
                        <input type="date" name="tanggal_ujian" value="{{ $item['tanggal'] }}" class="input input-sm input-bordered w-full" />
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Kelas</span>
                        </div>
                        <select class="js-example-basic-multiple2 w-full" name="kelas[]" multiple="multiple">
                            @foreach ($all_kelas as $key => $kelas)
                                <option value="{{ $key }}" {{ in_array($kelas, $item['kelas']) ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Waktu Mulai</span>
                        </div>
                        <input type="time" name="start" value="{{ $item['start'] }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                    </label>
                    <label class="form-control w-full"> 
                        <div class="label">
                            <span class="label-text font-bold">Waktu Selesai</span>
                        </div>
                        <input type="time" name="end" value="{{ $item['end'] }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
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
@endforeach