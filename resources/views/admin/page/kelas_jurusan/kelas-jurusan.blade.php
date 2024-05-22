@extends('frontendmaster')

@section('content')
    <x-admin-all-layout>
        <div class="w-full py-2 gap-2 flex">
            <div class="w-[70%] bg-slate-200 rounded-md">
                <form class="p-3" id="form-kelas_jurusan">
                    @csrf
                    <div class="flex-grow">
                        <label class="form-control w-full"> 
                            <div class="label">
                                <span class="label-text font-bold">Jurusan</span>
                            </div>
                            <input required type="text" placeholder="jurusan" name="jurusan" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full"> 
                            <div class="label">
                                <span class="label-text font-bold">Kelas</span>
                            </div>
                            <select required name="kelas" class="select select-sm select-bordered w-full">
                                <option disabled selected>Pilih Kelas</option>
                                <option value="10" class="font-bold">X</option>
                                <option value="11" class="font-bold">XI</option>
                                <option value="12" class="font-bold">XII</option>
                            </select>
                        </label>
                        <label class="form-control w-full"> 
                            <div class="label">
                                <span class="label-text font-bold">Nama Kelas</span>
                            </div>
                            <input required type="text" placeholder="Nama Kelas" name="nama_kelas" class="input input-sm input-bordered w-full" />
                        </label>
                    </div>
                    <div class="w-full flex justify-end items-center mt-2 gap-2">
                        <a href="javascript:void(0)" class="btn btn-warning btn-sm text-white">
                            Import
                        </a>
                        <button type="submit" class="btn btn-success btn-sm text-white">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
            <div class="w-[30%] text-white bg-blue-500 rounded-md flex flex-col justify-center items-center gap-3">
                <h1 class="text-8xl count-kelas">{{ $kelas }}</h1>
                <h1 class="text-4xl font-bold">Kelas</h1>
            </div>
        </div>
        <div class="w-full p-3">
            <h1 class="text-2xl font-bold mb-2">List Kelas</h1>
            <table class="display" style="width: 100%" id="js-table-kelas">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Total Siswa</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-admin-all-layout>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(document).on('submit','#form-kelas_jurusan', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.store_kelas') }}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function(){
                        $('.loader').show();
                    },
                    success: function(response){
                        $('.loader').hide();
                        if(response.type == 'success'){
                            toastr.success(response.msg);
                            $('.count-kelas').text(response.count);
                        }
                        if(response.type == 'error'){
                            toastr.error(response.msg);
                        }
                        $('#js-table-kelas').DataTable().ajax.reload();
                    },
                    error: function(response){
                        $('.loader').hide();
                        toastr.error(response['message']);
                    }
                });
            });
            $('#js-table-kelas').DataTable({
                ajax: '{{ route('admin.getDataKelas') }}',
                columns: [
                    { data: null, orderable: false, searchable: false },
                    { data: 'jurusan'},
                    { data: 'kelas' },
                    { data: 'nama_kelas' },
                    { data: 'total_siswa' }
                ],
                columnDefs : [{
                        'target': '_all',
                        'className': 'dt-head-center'
                    },
                    {
                        'target': '_all',
                        'className': 'dt-body-center'
                    },
                    { width: '50px', target: 0 }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Set nomor urut
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });
        });
    </script>
@endpush