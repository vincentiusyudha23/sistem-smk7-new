@extends("frontendmaster")

@section('title')
    <title>
        Kelola Sesi Ujian
    </title>
@endsection

@section('content')
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('mapel.sidebar.sidebar')
        </div>
        <div class="w-[80%] p-10">
            <h1 class="text-2xl font-bold my-2">Buat Sesi Ujian</h1>
            @include('mapel.page.sesiUjian.partial.form_sesi_ujian')
            <h1 class="text-2xl font-bold mt-10">List Sesi Ujian</h1>
            @include('mapel.page.sesiUjian.partial.tabel_sesi_ujian')
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('.btn-delete-sesi').on('click', function(){
                Swal.fire({
                    title: "Hapus Sesi Ujian?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                    customClass: {
                        popup: 'remove-cart-popup',
                    }
                });
            })

            $('.btn-update-status').on('click', function(){
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
                            location.reload();
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg)
                        }
                        $('.loader').hide();
                    },
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