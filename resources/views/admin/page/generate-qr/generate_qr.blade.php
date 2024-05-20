@extends("frontendmaster")

@section('title')
    <title>
        Generate Qr Code
    </title>
@endsection

@section('content')
    <x-admin-all-layout>
        <div class="w-full h-full flex pt-20">
            <div class="w-1/2 h-full flex flex-col justify-center items-center">
                <strong class="mb-2 text-lg">Qr Code Masuk</strong>
                <div class="qr-code-masuk mb-5 w-[300px] h-[300px] flex justify-center items-center bg-black/10 border-2 border-black">
                   <a href="javascript:void(0)">
                    @if ($qr_code['masuk'])
                        <img id="qr-code-masuk" src="data:image/png;base64, {!!  base64_encode($qr_code['masuk']) !!}"/>
                    @else
                        Belum Ada Qr Code
                    @endif
                    </a>
                </div>
                <div class="flex gap-2">
                    <a class="btn bg-gray-300 btn-generate-qr" data-value="masuk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M2 12a9 9 0 0 0 9 9c2.39 0 4.68-.94 6.4-2.6l-1.5-1.5A6.7 6.7 0 0 1 11 19c-6.24 0-9.36-7.54-4.95-11.95S18 5.77 18 12h-3l4 4h.1l3.9-4h-3a9 9 0 0 0-18 0"/></svg>
                    </a>
                    <a class="btn bg-gray-300 btn-download-qr @if(!$qr_code['masuk']) btn-disabled @endif" data-value="masuk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>
                    </a>
                    @if ($qr_code['status_masuk'] == 1)
                        <a id="btn-update-qr" data-value="masuk" class="btn btn-success text-white" data-value="masuk">
                            Aktif
                        </a>
                    @else
                        <a id="btn-update-qr" data-value="masuk" class="btn bg-gray-300 @if(!$qr_code['masuk']) btn-disabled @endif" data-value="masuk">
                            Aktifkan
                        </a>
                    @endif
                </div>
            </div>
            <div class="w-1/2 h-full flex flex-col justify-center items-center">
                <strong class="mb-2 text-lg">Qr Code Pulang</strong>
                <div class="qr-code-pulang mb-5 w-[300px] h-[300px] flex justify-center items-center bg-black/10 border-2 border-black">
                    <a href="javascript:void(0)">
                    @if ($qr_code['pulang'])
                        <img  id="qr-code-pulang" src="data:image/png;base64, {!!  base64_encode($qr_code['pulang']) !!}"/>
                    @else
                        Belum Ada Qr Code
                    @endif
                    </a>
                </div>
                <div class="flex gap-2">
                    <a class="btn bg-gray-300 btn-generate-qr" data-value="pulang">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M2 12a9 9 0 0 0 9 9c2.39 0 4.68-.94 6.4-2.6l-1.5-1.5A6.7 6.7 0 0 1 11 19c-6.24 0-9.36-7.54-4.95-11.95S18 5.77 18 12h-3l4 4h.1l3.9-4h-3a9 9 0 0 0-18 0"/></svg>
                    </a>
                    <a class="btn bg-gray-300 btn-download-qr @if(!$qr_code['pulang']) btn-disabled @endif" data-value="pulang">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>
                    </a>
                    @if ($qr_code['status_pulang'] == 1)
                        <a id="btn-update-qr" data-value="pulang" class="btn btn-success text-white" data-value="pulang">
                            Aktif
                        </a>
                    @else
                        <a id="btn-update-qr" data-value="pulang" class="btn bg-gray-300 @if(!$qr_code['pulang']) btn-disabled @endif" data-value="pulang">
                            Aktifkan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btn-generate-qr', function(){
                var el = $(this);
                var value = el.data('value');

                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.generate-qr.render') }}',
                    data: {
                        _token : '{{ csrf_token() }}',
                        nama : value,
                    },
                    beforeSend: function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        if(response.type === 'success'){
                            location.reload();
                        }
                        if(response.type === 'error'){
                            toastr.error(response.msg);
                            $('.loader').hide();
                        }
                    },
                });
            })

            $(document).on('click', '#btn-update-qr', function(){
                var el = $(this);
                var value = el.data('value');

                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.generate-qr.update') }}',
                    data: {
                        _token : '{{ csrf_token() }}',
                        nama : value,
                    },
                    beforeSend: function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        $('.loader').hide();
                        if(response.type === 'success'){
                            toastr.success(response.msg);
                            location.reload();
                        }
                        if(response.type === 'danger'){
                            toastr.warning(response.msg);
                            location.reload();
                        }
                    },
                });

            })

            $(document).on('click', '.btn-download-qr', function(){
                var el = $(this);
                var value = el.data('value');

                downloadImage(value);
            });

            function downloadImage(value) {
                // Mendapatkan elemen <a> dengan ID qr-code-masuk
                let link = document.getElementById(`qr-code-${value}`);

                // Mendapatkan elemen <img> di dalam elemen <a>
                let img = link.querySelector('img');

                if (img) {
                    // Buat elemen <canvas> sementara
                    let canvas = document.createElement('canvas');
                    let ctx = canvas.getContext('2d');

                    // Mengatur ukuran canvas sesuai dengan ukuran gambar
                    canvas.width = img.width;
                    canvas.height = img.height;

                    // Menggambar latar belakang putih
                    ctx.fillStyle = '#ffffff'; // Warna latar belakang (putih)
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    // Menggambar gambar di atas latar belakang putih
                    ctx.drawImage(img, 0, 0);

                    // Mengonversi canvas menjadi URL data PNG
                    let imageDataUrl = canvas.toDataURL('image/png');

                    // Membuat elemen <a> baru untuk mengunduh gambar
                    let downloadLink = document.createElement('a');
                    downloadLink.href = imageDataUrl;
                    downloadLink.download = `qr_code_${value}.png`; // Nama file untuk diunduh

                    // Simulasikan klik pada elemen <a> untuk memulai unduhan
                    document.body.appendChild(downloadLink);
                    downloadLink.click();

                    // Hapus elemen <a> setelah unduhan selesai
                    document.body.removeChild(downloadLink);

                    // Hapus elemen <canvas> sementara
                    document.body.removeChild(canvas);
                }
            }
        });
    </script>
@endpush