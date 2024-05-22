@extends("frontendmaster")

@section('title')
    <title>
        Kelola Akun Mapel
    </title>
@endsection

@section('content')
    <x-admin-all-layout>
        <h1 class="text-2xl font-bold my-2">Buat Akun Mata Pelajaran</h1>
        @include('admin.page.mapel.partial.form_akun_mapel')
        <h1 class="text-2xl font-bold mt-10">List Mata Pelajaran</h1>
        @include('admin.page.mapel.partial.tabel_mapel')
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(document).on('click','.btn-delete-mapel', function(){
                Swal.fire({
                    title: "Hapus Akun Mata Pelajaran?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                    customClass: {
                        popup: 'remove-cart-popup',
                    }
                }).then( async (result) => {
                    if(result.isConfirmed){
                        var el = $(this);
                        var id_siswa = el.data('id');

                        await $.ajax({
                            url: '{{ route('admin.mapel.delete') }}',
                            type: 'GET',
                            data: {
                                'id_mapel' : id_siswa
                            },
                            beforeSend: function(){
                                $('.loader').show();
                            },
                            success: function(response){
                                if(response.msg){
                                    toastr.success(response.msg);
                                    $('#js-table-mapel').DataTable().ajax.reload();
                                }
                                $('.loader').hide();
                            }
                        })
                    }
                });
            })

            $(document).on('submit', '#form-mapel', function(e){
                e.preventDefault();
                var el = $(this);
                var data = new FormData(this);
                var spinner = '<span class="loading loading-spinner loading-sm"></span>';
                var btn_save = $('#save-btn');
                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.mapel.store') }}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            $('#js-table-mapel').DataTable().ajax.reload();
                            el.find('input').val('');
                            el.find('select').val('');
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                        }
                        $('.loader').hide();
                    },
                    error: function(response){
                        $.each(response.responseJSON.error, function(index, value){
                            toastr.error(value);
                        })
                        $('.loader').hide();
                    }
                })
            });

             $(document).on('submit', '#form-edit-mapel', function(e){
                e.preventDefault();
                var el = $(this);
                var data = new FormData(this);
                var spinner = '<span class="loading loading-spinner loading-sm"></span>';
                var btn_save = el.find('button[type="submit"]');
                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.mapel.update') }}',
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
                            $('#js-table-mapel').DataTable().ajax.reload();
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

            $('#js-table-mapel').DataTable({
                ajax: '{{ route('admin.getDataMapel') }}',
                columns: [
                     { data: null, orderable: false, searchable: false },
                     {data: 'nama_mapel'},
                     {data: 'kode_mapel'},
                     {data: 'nama_guru'},
                     {data: 'nip'},
                     {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            return `
                                <x-admin-edit-mapel 
                                    idMapel="${row.id_mapel}"
                                    username="${row.username}"
                                    password="${row.password}"
                                    namaMapel="${row.nama_mapel}"
                                    kodeMapel="${row.kode_mapel}"
                                    namaGuru="${row.nama_guru}"
                                    nip="${row.nip}"
                                    />

                                <a class="btn btn-sm btn-error text-white btn-delete-mapel" data-id="${row.id_mapel}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                                </a>
                            `;
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