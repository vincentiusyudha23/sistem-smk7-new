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
        })
    </script>
@endpush