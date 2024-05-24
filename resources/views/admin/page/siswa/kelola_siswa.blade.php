@extends("frontendmaster")

@section('title')
    <title>
        Kelola Akun Siswa
    </title>
@endsection

@section('content')
    <x-admin-all-layout>
        <h1 class="text-2xl font-bold my-2">Buat Akun Siswa</h1>
        @include('admin.page.siswa.partial.form_akun')
        <h1 class="text-2xl font-bold mt-10 mb-5">List Akun Siswa</h1>
        @include('admin.page.siswa.partial.tabel_siswa')
        {{-- @include('admin.page.siswa.partial.modal_siswa') --}}
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(document).on('click', '#import-siswa', function(){
                 Swal.fire({
                    title: "Select File",
                    input: "file",
                    inputAttributes: {
                        "accept": ".xls, .xlsx",
                        "aria-label": "upload File Excel Anda"
                }}).then( async (result) => {
                    if(result.value){
                        const formData = new FormData();
                        formData.append('file_siswa', result.value);
                        formData.append('_token','{{ csrf_token() }}');

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
                            url: '{{ route('admin.siswa.import') }}',
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
                                        timer: 1500
                                    }).then( () => {
                                        $('#js-table-siswa').DataTable().ajax.reload();
                                    });
                                }
                                if(response.type === "error"){
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: response.msg,
                                        icon: 'error',
                                    });
                                }
                            }
                        });
                    };
                });
            });

            $(document).on('click','.btn-delete-siswa', function(){
                Swal.fire({
                    title: "Hapus Akun Siswa?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                }).then( async (result) => {
                    if(result.isConfirmed){
                        var el = $(this);
                        var id_siswa = el.data('id');

                        await $.ajax({
                            url: '{{ route('admin.siswa.delete') }}',
                            type: 'GET',
                            data: {
                                'id_siswa' : id_siswa
                            },
                            beforeSend: function(){
                                $('.loader').show();
                            },
                            success: function(response){
                                $('.loader').hide();
                                if(response.msg){
                                    toastr.success(response.msg);
                                    $('#js-table-siswa').DataTable().ajax.reload();
                                }
                            }
                        })
                    }
                });
            });

            $(document).on('submit', '#form-siswa', function(e){
                e.preventDefault();
                var el = $(this);
                var data = new FormData(this);
                
                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.siswa.store') }}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        $('.loader').hide();
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            $('#js-table-siswa').DataTable().ajax.reload();
                            el.find('input').val('');
                            el.find('select').val('');
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                        }
                    },
                    error: function(response) {
                        $.each(response.responseJSON.error, function(index, value){
                            toastr.error(value);
                        })
                        $('.loader').hide();
                    }
                })
            });

            $(document).on('click','.js-btn-reset', function(){
                $('#form-siswa input').val('');
                $('#form-siswa select').val('');
            });

            $(document).on('submit', '#form-edit-siswa', function(e){
                e.preventDefault();
                var el = $(this);
                var data = new FormData(this);
                var spinner = '<span class="loading loading-spinner loading-sm"></span>';
                var btn_save = el.find('button[type="submit"]');
                var id_siswa = el.data('id_siswa');

                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.siswa.update') }}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function(){
                        btn_save.html(spinner);
                        btn_save.addClass('btn-disabled');
                    },
                    success: function(response){
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            $('#js-table-siswa').DataTable().ajax.reload();
                            btn_save.removeClass('btn-disabled');
                            btn_save.text('Simpan');
                            $('.close-btn-modal').trigger('click');
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                            btn_save.removeClass('btn-disabled');
                            btn_save.text('Simpan');
                        }
                    },
                    error: function(response){
                        toastr.error(response.msg);
                        btn_save.removeClass('btn-disabled');
                        btn_save.text('Simpan');
                    }
                })
            });

            $('#js-table-siswa').DataTable({
                ajax: '{{ route('admin.getDataSiswa') }}',
                columns: [
                     { data: null, orderable: false, searchable: false },
                     {data: 'nama'},
                     {data: 'nis'},
                     {data: 'kelas'},
                     {data: 'tanggal_lahir'},
                     {data: 'orang_tua'},
                     {data: 'nomor_telp'},
                     {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) { 
                            var render_item = `
                                <button class="btn btn-sm btn-success text-white" onclick="$('#my_modal_${row.id_siswa}').get(0).showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3"/></g></svg>
                                </button>
                                <dialog id="my_modal_${row.id_siswa}" class="modal p-0 m-0">
                                    <div class="modal-box">
                                        <div class="modal-action w-full flex justify-between p-0 m-0">
                                            <h3 class="font-bold text-lg">Edit Akun ${row.nama}</h3>
                                            <form method="dialog">
                                                <button class="btn btn-xs close-btn-modal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <form class="mt-3" id="form-edit-siswa" data-id_siswa="${row.id_siswa}">
                                            @csrf
                                            <div class="flex flex-row flex-wrap gap-3">
                                                <input type="hidden" name="id_siswa" value="${row.id_siswa}">
                                                <div class="flex-grow">
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">Username</span>
                                                        </div>
                                                        <input type="text" placeholder="Username" name="username" value="${row.username}" class="input input-sm input-bordered w-full" />
                                                    </label>
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">Password</span>
                                                        </div>
                                                        <input type="text" placeholder="Password" name="password" value="${row.password}" class="input input-sm input-bordered w-full" />
                                                    </label>
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">Nama Siswa</span>
                                                        </div>
                                                        <input type="text" placeholder="Nama Siswa" name="nama_siswa" value="${row.nama}" class="input input-sm input-bordered w-full" />
                                                    </label>
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">NIS</span>
                                                        </div>
                                                        <input type="number" placeholder="NIS" name="nis" value="${row.nis}" class="input input-sm input-bordered w-full" />
                                                    </label>
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">Tanggal Lahir</span>
                                                        </div>
                                                        <input type="date" name="tanggal_lahir" value="${row.tanggal_lahir}" class="input input-sm input-bordered w-full" />
                                                    </label>
                                                </div>
                                                <div class="flex-grow">
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">Kelas</span>
                                                        </div>
                                                        <select required name="kelas" class="select select-sm select-bordered w-full">
                                                            <option disabled>Pilih kelas</option>`;
                                                            
                                                            var all_kelas = row.all_kelas;
                                                            $.each(all_kelas, function(key, value){
                                                                var selected = '';
                                                                if(key == row.id_kelas){
                                                                    selected = 'selected';
                                                                }
                                                                render_item += `<option value="${key}" ${selected}>
                                                                                    ${value}
                                                                                </option>`;
                                                            });

                            render_item += `</select>
                                                    </label>
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">Nama Orang Tua</span>
                                                        </div>
                                                        <input type="text" placeholder="Orang Tua" name="nama_orangtua" value="${row.orang_tua}" class="input input-sm input-bordered w-full" />
                                                    </label>
                                                    <label class="form-control w-full"> 
                                                        <div class="label">
                                                            <span class="label-text font-bold">Nomor Telpon Orang Tua</span>
                                                        </div>
                                                        <input type="text" placeholder="Nomor Telepon" name="nomor_telepon" value="${row.nomor_telp}" class="input input-sm input-bordered w-full" />
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

                                <a class="btn btn-sm btn-error text-white btn-delete-siswa" data-id="${row.id_siswa}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                                </a>
                            `;

                            return render_item;
                        }
                     }
                ],
                columnDefs : [{
                        'target': '_all',
                        'className': 'dt-head-center'
                    },
                    {
                        'target': '_all',
                        'className': 'dt-body-center'
                    },
                    { width: '50px', target: 0 }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Set nomor urut
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });
        })
    </script>
@endpush

