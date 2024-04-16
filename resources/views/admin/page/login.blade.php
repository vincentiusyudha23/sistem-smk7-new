@extends('frontendmaster')

@section('title')
    <title>Login Admin</title>
@endsection

@section('content')
    <div class="w-full h-screen flex flex-row">
        <div class="w-[50%] h-full bg-gray-300 flex justify-center items-center">
            <img src="{{ asset('asset/logo/logo_smk7.png') }}" style="width: 268px; height: 320px;">
        </div>
        <div class="w-[50%] h-full flex justify-center items-center">
            <div class="flex flex-col w-[40%]">
                <div class="flex justify-center items-center mb-5">
                    <h1 class="text-blue-600 font-bold text-2xl text-center">Login Admin</h1>
                </div>
                <form class="w-full">
                    <input required type="text" placeholder="Username" class="input input-bordered input-primary w-full max-w-md mb-5 bg-blue-500/10" />
                    <input required type="password" placeholder="Password" class="pw-admin input input-bordered input-primary w-full max-w-md bg-blue-500/10" />
                    <div class="form-control mb-3">
                       <label class="label cursor-pointer chx-pw">
                           <input type="checkbox" class="checkbox checkbox-primary" />
                           <span class="label-text">Show Password</span> 
                       </label>
                    </div>
                    <div class="w-full text-center my-5 text-blue-600">
                        <a>Lupa Password?</a>
                    </div>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3 text-white text-lg w-full">Sign In</a>
                    <div class="w-full text-center my-5 text-blue-600">
                        <a href="{{ route('admin.register') }}">Belum Memiliki Akun?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('.chx-pw').on('click', function(){
                var el = $(this);
                var input = el.find('input').prop('checked');

                if(input === true){
                    el.parent().parent().find('.pw-admin').attr('type','text');
                } else {
                    el.parent().parent().find('.pw-admin').attr('type','password');
                }
            })
        })
    </script>
@endpush