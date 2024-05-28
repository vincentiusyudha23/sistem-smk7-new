@extends("frontendmaster")

@section('title')
    <title>
        Soal Ujian Matematik
    </title>
@endsection

@section('content')
    <x-mapel-layout>
        <div class="inline-flex justify-between items-center w-full my-3">
            <h1 class="text-2xl font-bold">Soal Ujian {{ auth()->user()->mapel->nama_mapel }}</h1>
            <div>
                <button type="button" class="btn btn-info btn-sm text-white btn-import-soal" data-id="{{ $sesi->id }}">Import Soal</button>
                <div class="font-light text-sm"><sup>*</sup>Template Soal, <a href="{{ route('mapel.template_soal') }}" class="text-blue-600">Unduh</a></div>
            </div>
        </div>
        @include('mapel.page.soalUjian.partial.form-soal')
    </x-mapel-layout>
    @php
        $soal_ujian = json_decode($sesi->soal_ujian, true) ?? [];
    @endphp
@endsection

@push('script')
    <script>

        $(document).on('click', '.btn-import-soal', function(){
                Swal.fire({
                title: "Select File",
                input: "file",
                inputAttributes: {
                    "accept": ".xls, .xlsx",
                    "aria-label": "upload File Excel Anda"
            }}).then( async (result) => {
                if(result.value){
                    const formData = new FormData();
                    var id_sesi = $(this).data('id');
                    formData.append('file_soal', result.value);
                    formData.append('_token','{{ csrf_token() }}');
                    formData.append('id_sesi', id_sesi);

                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Harap tunggu, kami sedang memproses file anda.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    await $.ajax({
                        url: '{{ route('mapel.import_soal') }}',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(response){
                            Swal.hideLoading()
                            if(response.type === "success"){
                                Swal.fire({
                                    title: 'Success',
                                    text: response.msg,
                                    icon: 'success',
                                }).then( () => {
                                   $('#form-soal-container').html(response.render);
                                });
                            }
                            if(response.type === "error"){
                                Swal.fire({
                                    title: 'Gagal',
                                    html: response.msg,
                                    icon: 'error',
                                });
                            }
                        }
                    });
                };
            });
        });

        var id_soal = "{{ count($soal_ujian) }}";

        $(document).on('input', 'textarea', function() {
            this.style.height = 'auto'; // Setel tinggi ke auto agar textarea dapat menyesuaikan tingginya
            this.style.height = (this.scrollHeight) + 'px'; // Atur tinggi textarea sesuai dengan tinggi kontennya
        });
        
        $(document).on('click', '.btn-tambah-soal', function(){
            id_soal++;
            var form_soal = `
                <li class="bg-gray-200 p-3 rounded-lg my-2 soal-${id_soal}">
                    <label class="form-control">
                        <div class="label">
                            <span class="label-text text-lg font-semibold">Soal ${id_soal}.</span>
                            <button type="button" class="btn btn-sm btn-error text-white btn-remove-soal" data-soal="${id_soal}">Hapus</button>
                        </div>
                        <textarea style="resize: vertical;" placeholder="input soal" required name="soal[soal-${id_soal}][soal]" class="rounded-md p-2"></textarea>
                    </label>
                    <div class="flex flex-col gap-2 my-3">
                        <div class="form-control parent-opsiSoal-${id_soal}">
                            <label class="label cursor-pointer justify-start">
                                <input type="radio" required name="soal[soal-${id_soal}][jawaban][]" for="opsi-${id_soal}" class="radio radio-primary radio-sm"/>
                                <input type="text" required placeholder="input jawaban" name="soal[soal-${id_soal}][opsi_soal][]" id="opsi-${id_soal}" class="input input-bordered input-sm mx-3 w-full md:w-[50%]">
                                <button type="button" class="btn btn-xs btn-outline btn-circle border-2 remove-opsi-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                                </button>
                            </label>
                        </div>
                        <span class="px-2 hover:text-black/50 hover:cursor-pointer" id="addopsiSoal" data-soal="${id_soal}">Tambah Opsi Jawaban</span>
                    </div>
                </li>`;
            $('.list-soal').append(form_soal);
        })

        $(document).on('click', '#addopsiSoal', function(){
            var el = $(this);
            var id_soal = el.data('soal');
            
            $('.parent-opsiSoal-'+id_soal).append(`
                <label class="label cursor-pointer justify-start">
                    <input type="radio" required name="soal[soal-${id_soal}][jawaban][]" class="radio radio-primary radio-sm" for="opsi-${id_soal}"/>
                    <input type="text" required placeholder="input jawaban" name="soal[soal-${id_soal}][opsi_soal][]" id="opsi-${id_soal}" class="input input-bordered input-sm mx-3 w-full md:w-[50%]">
                    <button type="button" class="btn btn-xs btn-outline btn-circle border-2 remove-opsi-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                    </button>
                </label>
            `);
            
        })

        $(document).on('click', '.remove-opsi-btn', function(){
            $(this).parent().remove();
        })

        $(document).on('click', '.btn-remove-soal', function(){
            id_soal--;
            var id = $(this).data('soal');
            
            $('li.soal-'+id).remove();
        })

        $(document).on('change', 'input[type="text"]', function(){
            var el = $(this);
            var value = el.val();
            el.prev().val(value);
        });
    </script>
@endpush