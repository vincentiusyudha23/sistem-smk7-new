@extends("frontendmaster")

@section('title')
    <title>
        Kelola Hasil Ujian
    </title>
@endsection

@section('content')
    <x-mapel-layout>
        <h1 class="text-2xl font-bold mb-5">List Hasil Ujian</h1>
        @include('mapel.page.hasilUjian.partial.tabel-hasil-ujian')
    </x-mapel-layuot>
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