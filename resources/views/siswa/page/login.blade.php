@extends('frontendmaster')

@section('title')
    <title>Login Mapel</title>
@endsection

@section('content')
    <div class="w-full h-screen flex flex-row">
        <div class="w-[50%] h-full bg-gray-300 flex justify-center items-center">
            <img src="{{ asset('asset/logo/logo_smk7.png') }}" style="width: 268px; height: 320px;">
        </div>
        <div class="w-[50%] h-full flex justify-center items-center">
            <div class="flex flex-col w-[40%]">
                <div class="flex justify-center items-center mb-5">
                    <h1 class="text-blue-600 font-bold text-2xl text-center">Login Siswa</h1>
                </div>
                <form class="w-full" method="POST" action="{{ route('siswa.login') }}">
                    @csrf
                    <div>
                        <x-text-input id="username" 
                                placeholder="Username" 
                                class="input input-bordered input-primary w-full max-w-md mb-5 bg-blue-500/10" 
                                type="text" 
                                name="username" 
                                :value="old('username')" 
                                required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                     <div class="mt-4">
                        <x-text-input id="password" class="pw-admin input input-bordered input-primary w-full max-w-md bg-blue-500/10"
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mb-3 py-2">
                       <label class="cursor-pointer chx-pw inline-flex items-center">
                           <input type="checkbox" class="checkbox checkbox-primary" />
                           <span class="ms-3">Show Password</span> 
                       </label>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3 text-white text-lg w-full">Sign In</button>
                    {{-- <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary mb-3 text-white text-lg w-full">Sign In</a> --}}
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