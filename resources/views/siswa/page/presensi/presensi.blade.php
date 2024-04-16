@extends('frontendmaster')

@section('title')
    <title>Presensi Page</title>
@endsection

@section('content')
    <x-layout-siswa>
        <div class="w-full flex flex-col justify-center items-center mt-12">
            <h1 class="text-2xl font-bold">Scan Barcode Presensi</h1>
            <div class="w-[500px] h-[500px] mt-20">
                <video id="scanner"></video>
            </div>
        </div>
    </x-layout-siswa>
@endsection

@push('script')
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });
      scanner.addListener('scan', function (content) {
        console.log(content);
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    </script>
@endpush