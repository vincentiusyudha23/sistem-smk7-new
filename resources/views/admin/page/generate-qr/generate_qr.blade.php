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
                    <img src="data:image/png;base64, {!! base64_encode(generateQrcode($qr_code['masuk'])) !!} ">
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.generate-qr.download', ['id' => 1]) }}" class="btn bg-gray-300 btn-download-qr" data-value="masuk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>
                    </a>
                    @if ($qr_code['status_masuk'] == 1)
                        <a id="btn-update-qr" data-value="masuk" class="btn btn-success text-white" data-value="masuk">
                            Aktif
                        </a>
                    @else
                        <a id="btn-update-qr" data-value="masuk" class="btn bg-gray-300" data-value="masuk">
                            Belum Aktif
                        </a>
                    @endif
                </div>
            </div>
            <div class="w-1/2 h-full flex flex-col justify-center items-center">
                <strong class="mb-2 text-lg">Qr Code Pulang</strong>
                <div class="qr-code-pulang mb-5 w-[300px] h-[300px] flex justify-center items-center bg-black/10 border-2 border-black">
                   <img src="data:image/png;base64, {!! base64_encode(generateQrcode($qr_code['pulang'])) !!} ">
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.generate-qr.download', ['id' => 2]) }}" class="btn bg-gray-300 btn-download-qr">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>
                    </a>
                    @if ($qr_code['status_pulang'] == 1)
                        <a id="btn-update-qr" data-value="pulang" class="btn btn-success text-white" data-value="pulang">
                            Aktif
                        </a>
                    @else
                        <a id="btn-update-qr" data-value="pulang" class="btn bg-gray-300" data-value="pulang">
                            Belum Aktif
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
                            el.removeClass('bg-gray-300');
                            el.addClass('btn-success text-white');
                            el.text('Aktif')
                        }
                        if(response.type === 'danger'){
                            toastr.success(response.msg);
                            el.removeClass('btn-success text-white');
                            el.addClass('bg-gray-300');
                            el.text('Belum Aktif')
                        }
                    },
                });
            })
        });
    </script>
@endpush