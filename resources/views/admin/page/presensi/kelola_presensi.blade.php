@extends("frontendmaster")

@section('title')
    <title>
        Presensi Siswa
    </title>
@endsection

@section('content')
    <x-admin-all-layout>
        <h1 class="text-2xl font-bold my-2">Data Presensi Siswa</h1>
        <div class="w-full flex justify-between">
            <div class="flex justify-center items-center">
                <h1 class="font-bold">Filter</h1>
                <select class="mx-3 select select-bordered border-2 w-full max-w-sm select-sm">
                    <option disabled selected>Berdasarkan</option>
                    <option>Terbaru</option>
                    <option>Tanggal</option>
                    <option>Jumlah Siswa</option>
                </select>
            </div>
            <div class="flex justify-center items-center">
                <label class="input input-bordered border-2 input-sm flex items-center gap-2 mx-2">
                    <input type="text" class="grow" placeholder="Pencarian" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" /></svg>
                </label>
            </div>
        </div>
        <div class="w-full flex justify-end">
            <a class="btn btn-sm mt-2 btn-kembali hidden">Kembali</a>
        </div>
        <div class="w-full list-presensi">
            <div class="w-full my-3 p-4 bg-gray-200 hover:cursor-pointer hover:bg-gray-300 rounded-lg">
                <a class="w-full flex justify-between items-center font-bold presensi-list">
                    <h1>List Presensi Tanggal : 30/03/2024</h1>
                    <h1>300 Siswa</h1>
                </a>
            </div>
            <div class="w-full my-3 p-4 bg-gray-200 hover:cursor-pointer hover:bg-gray-300 rounded-lg">
                <a class="w-full flex justify-between items-center font-bold presensi-list">
                    <h1>List Presensi Tanggal : 31/03/2024</h1>
                    <h1>200 Siswa</h1>
                </a>
            </div>
        </div>
        {{-- @include('admin.page.presensi.partial.tabel_presensi') --}}
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
       $(document).ready(function(){
            $('.presensi-list').on('click', function(){
                $('.btn-kembali').removeClass('hidden');
                $('.list-presensi').html(`
                    <div class="overflow-x-auto tabel-presensi-siswa my-5">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead class="bg-gray-200 text-black">
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr>
                                    <th>1</th>
                                    <td>20/23/2024</td>
                                    <td>Vincentius Yudha R</td>
                                    <td>112873981273917</td>
                                    <td>Multimedia</td>
                                    <td>12</td>
                                    <td>Masuk</td>
                                </tr>
                                <tr>
                                    <th>2</th>
                                    <td>20/23/2024</td>
                                    <td>Vincentius Yudha R</td>
                                    <td>112873981273917</td>
                                    <td>Multimedia</td>
                                    <td>12</td>
                                    <td>Masuk</td>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <td>20/23/2024</td>
                                    <td>Vincentius Yudha R</td>
                                    <td>112873981273917</td>
                                    <td>Multimedia</td>
                                    <td>12</td>
                                    <td>Masuk</td>
                                </tr>
                                <tr>
                                    <th>4</th>
                                    <td>20/23/2024</td>
                                    <td>Vincentius Yudha R</td>
                                    <td>112873981273917</td>
                                    <td>Multimedia</td>
                                    <td>12</td>
                                    <td>Masuk</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `)
            })

            $('.btn-kembali').on('click', function(){
                location.reload();
            })
       })
    </script>
@endpush