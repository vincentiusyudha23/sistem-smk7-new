@extends('frontendmaster')

@section('content')
    <x-admin-all-layout>
        <div class="w-full py-2 gap-2 flex">
            <div class="w-[70%] bg-slate-200 rounded-md">
                <form class="p-3" id="form-kelas_jurusan">
                    @csrf
                    <div class="flex-grow">
                        <label class="form-control w-full"> 
                            <div class="label">
                                <span class="label-text font-bold">Jurusan</span>
                            </div>
                            <input required type="text" placeholder="jurusan" name="jurusan" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full"> 
                            <div class="label">
                                <span class="label-text font-bold">Kelas</span>
                            </div>
                            <select required name="kelas" class="select select-sm select-bordered w-full">
                                <option disabled selected>Pilih Kelas</option>
                                <option value="10" class="font-bold">X</option>
                                <option value="11" class="font-bold">XI</option>
                                <option value="12" class="font-bold">XII</option>
                            </select>
                        </label>
                        <label class="form-control w-full"> 
                            <div class="label">
                                <span class="label-text font-bold">Nama Kelas</span>
                            </div>
                            <input required type="text" placeholder="Nama Kelas" name="nama_kelas" class="input input-sm input-bordered w-full" />
                        </label>
                    </div>
                    <div class="w-full flex justify-end items-center mt-2 gap-2">
                        <a href="javascript:void(0)" class="btn btn-warning btn-sm text-white btn-import-kelas">
                            Import
                        </a>
                        <button type="submit" class="btn btn-success btn-sm text-white">
                            Simpan
                        </button>
                    </div>
                    <div class="w-full inline-flex p-0 m-0 justify-end">
                        <span class="text-xs font-light"><sup>*</sup>Template file import kelas. <a href="{{ route('admin.download.template.kelas') }}" class="text-blue-600">Unduh</a></span>
                    </div>
                </form>
            </div>
            <div class="w-[30%] text-white bg-blue-500 rounded-md flex flex-col justify-center items-center gap-3">
                <h1 class="text-8xl count-kelas">{{ $kelas }}</h1>
                <h1 class="text-4xl font-bold">Kelas</h1>
            </div>
        </div>
        <div class="w-full p-3">
            <div class="w-full inline-flex justify-between">
                <h1 class="text-2xl font-bold mb-2">List Kelas</h1>
            </div>
            <table class="display" style="width: 100%" id="js-table-kelas">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Total Siswa</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btn-import-kelas', function(){
                 Swal.fire({
                    title: "Select File",
                    input: "file",
                    inputAttributes: {
                        "accept": ".xls, .xlsx",
                        "aria-label": "upload File Excel Anda"
                }}).then( async (result) => {
                    if(result.value){
                        const formData = new FormData();
                        formData.append('template_kelas', result.value);
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
                            url: '{{ route('admin.kelas.import') }}',
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
                                        $('.count-kelas').text(response.count);
                                        $('#js-table-kelas').DataTable().ajax.reload();
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
            $(document).on('submit','#form-kelas_jurusan', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.store_kelas') }}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        $('.loader').hide();
                        if(response.type == 'success'){
                            toastr.success(response.msg);
                            $('.count-kelas').text(response.count);
                        }
                        if(response.type == 'error'){
                            toastr.error(response.msg);
                        }
                        $('#js-table-kelas').DataTable().ajax.reload();
                    },
                    error: function(response){
                        $('.loader').hide();
                        toastr.error(response['message']);
                    }
                });
            });

             $(document).on('click', '.btn-delete-kelas', function(){
                var el = $(this);
                
                
                Swal.fire({
                    title: "Hapus Kelas?",
                    icon: 'warning',
                    text: 'Menghapus data kelas, akan menghapus juga data siswa!',
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                }).then(async (result) => {
                    if(result.isConfirmed){
                        var id_kelas = el.data('id');
                        $.ajax({
                            type: 'GET',
                            url: '{{ route('admin.kelas.delete') }}',
                            data: {
                                id_kelas: id_kelas
                            },
                            beforeSend: function(){
                                $('.loader').show();
                            },
                            success: function(response){
                                $('.loader').hide();
                                if(response.type == 'success'){
                                    toastr.success(response.msg);
                                    $('.count-kelas').text(response.count);
                                    $('#js-table-kelas').DataTable().ajax.reload();
                                };
                                if(response.type == 'error'){
                                    toastr.error(response.msg);
                                };
                            }
                        });
                    }
                })
            })

            $('#js-table-kelas').DataTable({
                ajax: '{{ route('admin.getDataKelas') }}',
                columns: [
                    { data: null, orderable: false, searchable: false },
                    { data: 'jurusan'},
                    { data: 'kelas' },
                    { data: 'nama_kelas' },
                    { data: 'total_siswa' },
                    { 
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            return `<a href="javascript:void(0)" class="btn btn-error btn-sm text-white btn-delete-kelas" data-id="${row.id_kelas}">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                                </a>`
                        }
                    }
                ],
                columnDefs : [
                    {
                        'target': '_all',
                        'className': 'dt-head-center'
                    },
                    {
                        'target': '_all',
                        'className': 'dt-body-center'
                    },
                    { width: '30px', target: 0 },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Set nomor urut
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });

           
        });
    </script>
@endpush