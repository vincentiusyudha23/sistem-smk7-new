@extends('frontendmaster')

@section('title')
    <title>Login Mapel</title>
@endsection

@section('content')
    @php
        $url;

        if ($role === 'admin') {
            $url = route('admin.dashboard');
        } else if ($role === 'mapel'){
            $url = route('mapel.dashboard');
        } else {
            $url = route('siswa.dashboard');
        }
    @endphp
    <x-guest-layout>
        <div class="flex justify-center items-center mb-5">
            <h1 class="text-blue-600 font-bold text-2xl text-center">
                @if ($role === 'admin')
                    Login Admin
                @elseif($role === 'mapel')
                    Login Guru
                @else
                    Login Siswa
                @endif
            </h1>
        </div>
            <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- <form method="POST" action="{{ route('login') }}"> --}}
        <form>
            @csrf

            <!-- Email Address -->
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
            <!-- Password -->
            <div class="mt-4">
                <x-text-input id="password" class="pw-admin input input-bordered input-primary w-full max-w-md bg-blue-500/10"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="mt-4 flex-col flex gap-2">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="checkbox checkbox-primary" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                <label class="cursor-pointer inline-flex items-center chx-pw">
                   <input type="checkbox" class="checkbox checkbox-primary" />
                   <span class="ms-2 text-sm text-gray-600">Show Password</span> 
               </label>
            </div>

            <div class="flex flex-col items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline my-3  text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Lupa Password ?
                    </a>
                @endif
                
                <a href="{{ $url }}" class="btn btn-primary mb-3 text-white text-lg w-full">
                    {{ __('Log in') }}
                </a>
                @if ($role === 'admin')
                    <div class="w-full text-center my-3 text-blue-600">
                        <a href="{{ route('admin.register') }}">Belum Memiliki Akun?</a>
                    </div>
                @endif
            </div>
        </form>
    </x-guest-layout>
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
