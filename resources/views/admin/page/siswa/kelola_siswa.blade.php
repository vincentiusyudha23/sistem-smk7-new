@extends("frontendmaster")

@section('title')
    <title>
        Kelola Akun Siswa
    </title>
@endsection

@section('content')
    <x-admin>
        <h1 class="text-2xl font-bold my-2">Buat Akun Siswa</h1>
        @include('admin.page.siswa.partial.form_akun')
        <h1 class="text-2xl font-bold mt-10">List Akun Siswa</h1>
        @include('admin.page.siswa.partial.tabel_siswa')
    </x-admin>
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
                    if (result.value) {
                        const formData = new FormData();
                        formData.append('file_siswa', result.value);
                        formData.append('_token', '{{ csrf_token() }}');

                        await $.ajax({
                            url: '{{ route('admin.siswa.import') }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function(){
                                $('.loader').show();
                            },
                            success: function(response){
                                $('.loader').hide();
                                if(response.type === 'success'){
                                    Swal.fire({
                                        title: 'Success',
                                        text: response.msg,
                                        icon: 'success',
                                        timer: 1500
                                    }).then( () => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: response.msg,
                                        icon: 'error'
                                    });
                                }
                            },
                        });
                    }
                });
            })

            $('.btn-delete-siswa').on('click', function(){
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
                                if(response.msg){
                                    toastr.success(response.msg);
                                    location.reload();
                                }
                                $('.loader').hide();
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
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            location.reload();
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                            $('.loader').hide();
                        }
                    },
                    error: function(response){
                        toastr.error(response.msg);
                        $('.loader').hide();
                    }
                })
            });

            $(document).on('click','.js-btn-reset', function(){
                $('input').val('');
                $('select').val('');
            });

            $(document).on('submit', '#form-edit-siswa', function(e){
                e.preventDefault();
                var el = $(this);
                var data = new FormData(this);
                var spinner = '<span class="loading loading-spinner loading-sm"></span>';
                var btn_save = el.find('button[type="submit"]');
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
                            location.reload();
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
        })
    </script>
@endpush