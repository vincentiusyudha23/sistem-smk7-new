@extends("frontendmaster")

@section('title')
    <title>
        Kelola Akun Siswa
    </title>
@endsection

@section('style')
@endsection

@section('content')
    <div class="flex flex-row">
        <div class="w-[20%]">
            @include('admin.sidebar.sidebar')
        </div>
        <div class="w-[80%] p-10">
            <h1 class="text-2xl font-bold my-2">Buat Akun Siswa</h1>
            @include('admin.page.siswa.partial.form_akun')
            <h1 class="text-2xl font-bold mt-10">List Akun Siswa</h1>
            @include('admin.page.siswa.partial.tabel_siswa')
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('.btn-delete-siswa').on('click', function(){
                Swal.fire({
                    title: "Hapus Akun Siswa?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Hapus",
                    customClass: {
                        popup: 'remove-cart-popup',
                    }
                });
            })
        })
    </script>
@endpush