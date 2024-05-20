@extends("frontendmaster")

@section('title')
    <title>
        Kelola Akun Mapel
    </title>
@endsection

@section('content')
    <x-adminlayout>
        <h1 class="text-2xl font-bold my-2">Buat Akun Mata Pelajaran</h1>
        @include('admin.page.mapel.partial.form_akun_mapel')
        <h1 class="text-2xl font-bold mt-10">List Mata Pelajaran</h1>
        @include('admin.page.mapel.partial.tabel_mapel')
    </x-adminlayout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('.btn-delete-mapel').on('click', function(){
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
                                    location.reload();
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
                            location.reload();
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                        }
                        $('.loader').hide();
                    },
                    error: function(response){
                        toastr.error(response.msg);
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