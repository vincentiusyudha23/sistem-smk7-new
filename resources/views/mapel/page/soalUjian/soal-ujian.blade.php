@extends("frontendmaster")

@section('title')
    <title>
        Soal Ujian Matematik
    </title>
@endsection

@section('content')
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('mapel.sidebar.sidebar')
        </div>
        <div class="w-[80%] p-10">
            <h1 class="text-2xl font-bold my-2">Soal Ujian Matematika</h1>
            @include('mapel.page.soalUjian.partial.form-soal')
        </div>
    </div>
@endsection

@push('script')
    <script>
    
        $(document).on('click', '#addopsiSoal', function(){
            var el = $(this);
            var id_soal = el.data('soal');
            $('.parent-opsiSoal-'+id_soal).append(`
                <label class="label cursor-pointer justify-start">
                    <input type="radio" name="radio-${id_soal}" class="radio radio-primary radio-sm"/>
                    <input type="text" class="input input-bordered input-sm mx-3 w-[50%]">
                        <button type="button" class="btn btn-xs btn-outline btn-circle border-2 remove-opsi-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                        </button>
                </label>
            `);
            
        })

        $(document).on('click', '.remove-opsi-btn', function(){
            $(this).parent().remove();
        })
        var id_soal = 1;
        $(document).on('click', '.btn-tambah-soal', function(){
            id_soal++;
            var form_soal = `
                <li class="bg-gray-200 p-3 rounded-lg my-2 soal-${id_soal}">
                    <form>
                        <label class="form-control">
                            <div class="label">
                                <span class="label-text text-lg font-semibold">Soal ${id_soal}.</span>
                                <button type="button" class="btn btn-sm btn-error text-white btn-remove-soal" data-soal="${id_soal}">Hapus</button>
                            </div>
                            <textarea class="textarea textarea-bordered textarea-sm w-full max-h-[50px] bg-white"></textarea>
                        </label>
                        <div class="flex flex-col gap-2 my-3">
                            <div class="form-control parent-opsiSoal-${id_soal}">
                                <label class="label cursor-pointer justify-start">
                                    <input type="radio" name="radio-${id_soal}" class="radio radio-primary radio-sm"/>
                                    <input type="text" class="input input-bordered input-sm mx-3 w-[50%]">
                                    <button type="button" class="btn btn-xs btn-outline btn-circle border-2 remove-opsi-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                                    </button>
                                </label>
                            </div>
                            <span class="px-2 hover:text-black/50 hover:cursor-pointer" id="addopsiSoal" data-soal="${id_soal}">Tambah Opsi Jawaban</span>
                        </div>
                    </form>
                </li>`;
            $('.list-soal').append(form_soal);
        })

        $(document).on('click', '.btn-remove-soal', function(){
            id_soal--;
            $(this).parent().parent().parent().parent().remove();
        })
    </script>
@endpush