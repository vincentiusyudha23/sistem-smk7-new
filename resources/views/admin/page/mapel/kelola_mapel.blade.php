@extends("frontendmaster")

@section('title')
    <title>
        Kelola Akun Mapel
    </title>
@endsection

@section('content')
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('admin.sidebar.sidebar')
        </div>
        <div class="w-[80%] p-10">
            <h1 class="text-2xl font-bold my-2">Buat Akun Mata Pelajaran</h1>
            @include('admin.page.mapel.partial.form_akun_mapel')
            <h1 class="text-2xl font-bold mt-10">List Mata Pelajaran</h1>
            @include('admin.page.mapel.partial.tabel_mapel')
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('.btn-delete-siswa').on('click', function(){
                Swal.fire({
                    title: "Hapus Akun Mata Pelajaran?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                    customClass: {
                        popup: 'remove-cart-popup',
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
                    success: function(response){
                        toastr.success(response.msg);
                        el.reset();
                    },
                    error: function(response){
                        toastr.error(response.msg);
                    }
                })
            });
        })
    </script>
@endpush