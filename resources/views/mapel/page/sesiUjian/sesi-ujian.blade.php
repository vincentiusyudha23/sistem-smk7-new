@extends("frontendmaster")

@section('title')
    <title>
        Kelola Sesi Ujian
    </title>
@endsection

@section('content')
    <x-mapel-layout>
        <h1 class="text-2xl font-bold my-2">Buat Sesi Ujian</h1>
        @include('mapel.page.sesiUjian.partial.form_sesi_ujian')
        <h1 class="text-2xl font-bold mt-10">List Sesi Ujian</h1>
        @include('mapel.page.sesiUjian.partial.tabel_sesi_ujian')
        @include('mapel.page.sesiUjian.partial.modal-edit')
    </x-mapel-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btn-reset-form', function(){
                $('#form-sesi-ujian')[0].reset();
                $('.js-example-basic-multiple').val(null).trigger('change');
            })
            $('.js-example-basic-multiple').select2({
                placeholder: 'Pilih Kelas'
            });
            $(document).on('click', '.btn-edit-click', function(){
                var id_sesi = $(this).data('id');
                $('.js-example-basic-multiple2').select2({
                    placeholder: 'Pilih Kelas',
                    dropdownParent: $(`#my_modal_${id_sesi}`)
                });
            });
            $(document).on('click','.btn-delete-sesi', function(){
                Swal.fire({
                    title: "Hapus Sesi Ujian?",
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
                        var id_sesi = el.data('id');

                        await $.ajax({
                            url: '{{ route('mapel.sesi-ujian.delete') }}',
                            type: 'GET',
                            data: {
                                'id_sesi' : id_sesi
                            },
                            beforeSend: function(){
                                $('.loader').show();
                            },
                            success: function(response){
                                $('.loader').hide();
                                if(response.msg){
                                    toastr.success(response.msg);
                                    $('#js-table-sesi').DataTable().ajax.reload();
                                }
                            }
                        })
                    }
                });
            })

            $(document).on('click','.btn-update-status', function(){
                var el = $(this);
                var id_sesi = el.data('id');
                var status = el.data('value');

                $.ajax({
                    type: 'post',
                    url: '{{ route('mapel.sesi_ujian.update.status') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_sesi: id_sesi,
                        status: status
                    },
                    beforeSend: function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        $('.loader').hide();
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            if(status === 0){
                                var _html = `<a href="javascript:void(0)" class="btn-update-status btn btn-xs btn-success btn-circle text-white w-full" data-value="1" data-id="${id_sesi}">Sedang Mulai</a>`;
                                el.parent().html(_html);
                            } else {
                                var _html = '<a href="javascript:void(0)" class="btn btn-xs btn-error btn-circle text-white w-full">Selesai</a> ';
                                el.parent().html(_html);
                            }
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                        }
                    }
                });
            });

            $(document).on('submit', '#form-sesi-ujian', function(e){
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: 'post',
                    url: '{{ route('mapel.sesi-ujian.store') }}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend:function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            $('#js-table-sesi').DataTable().ajax.reload();
                            $('#modal-sesiedit-container').html(response.render);
                            $('#form-sesi-ujian')[0].reset()
                            $('.js-example-basic-multiple').val(null).trigger('change');
                        }
                    },
                    error: function(response){
                        if(response.type === 'error'){
                            toastr.error(response.msg)
                        }
                    },
                    complete: function(){
                        $('.loader').hide();
                    }
                });
            });

            $(document).on('submit', '#form-edit-sesi', function(e){
                e.preventDefault();
                var data = new FormData(this);
                var btn_save = $(this).find('button[type="submit"]');
                var spinner = '<span class="loading loading-spinner loading-sm"></span>';
                $.ajax({
                    type : 'post',
                    url: '{{ route('mapel.sesi-ujian.update') }}',
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
                            $('#js-table-sesi').DataTable().ajax.reload();
                            btn_save.removeClass('btn-disabled');
                            btn_save.text('Simpan');
                            $('.btn-close-modal').trigger('click');
                            
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

            $('#js-table-sesi').DataTable({
                ajax: '{{ route('mapel.getDataSesi', ["id_mapel" => auth()->user()->mapel->id_mapel]) }}',
                responsive: true,
                columns: [
                    { data: null, orderable: false, searchable: false },
                    {data: 'mata_pelajaran'},
                    {
                        data: 'kelas',
                        render: function(data, type, row){
                            return data.map(kelas => `<span>${kelas}</span><br>`).join('');
                        }
                    },
                    {data: 'tanggal'},
                    {data: 'start'},
                    {data: 'end'},
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            var render = '';
                            if(row.status == 0){
                                render = `<a href="javascript:void(0)" class="btn-update-status btn btn-xs btn-circle btn-warning text-white w-full" data-value="0" data-id="${row.id_sesi}">Belum Mulai</a>`;
                            }
                            if(row.status == 1){
                                render = `<a href="javascript:void(0)" class="btn-update-status btn btn-xs btn-success btn-circle text-white w-full" data-value="1" data-id="${row.id_sesi}">Sedang Mulai</a>`;
                            }
                            if(row.status == 2){
                                render = '<a href="javascript:void(0)" class="btn btn-xs btn-error btn-circle text-white w-full">Selesai</a>';
                            }

                            return render;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            var render = '';
                            
                            if(row.soal){
                                render = `
                                    <div class="tooltip" data-tip="Lihat/Edit Soal">
                                        <a href="{{ url('/mapel/soal-ujian/${row.id_sesi}') }}" class="btn btn-sm btn-warning text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg>
                                        </a>
                                    </div>`;
                            } else {
                                render = `
                                    <div class="tooltip" data-tip="Buat Soal">
                                        <a href="{{ url('/mapel/soal-ujian/${row.id_sesi}') }}" class="btn btn-sm btn-warning text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                                        </a>
                                    </div>`;
                            }
                                render += `
                                    <button class="btn btn-sm btn-success btn-squer btn-edit-click text-white" data-id="${row.id_sesi}"  onclick="my_modal_${row.id_sesi}.showModal()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3"/></g></svg>
                                    </button>
                                    <div class="tooltip" data-tip="Hapus Sesi Ujian">
                                        <a class="btn btn-sm btn-error text-white btn-delete-sesi" data-id="${row.id_sesi}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                                        </a>
                                    </div>`;
                            return render;
                            
                        }
                    },
                ],
                columnDefs : [{
                        'target': '_all',
                        'className': 'dt-head-center'
                    },
                    {
                        'target': '_all',
                        'className': 'dt-body-center'
                    },
                    { width: '50px', target: 0 },
                    { width: '50px', target: 4 },
                    { width: '50px', target: 5 },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Set nomor urut
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });
        })
    </script>
@endpush