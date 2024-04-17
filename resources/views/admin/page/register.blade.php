@extends('frontendmaster')

@section('title')
    <title>Register Admin</title>
@endsection

@section('content')
    @if (session('warning'))
        <div role="alert" class="alert alert-warning fixed top-2 right-2 w-[30%] z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <span>{{ session('warning') }}</span>
            <div class="inline-flex items-end">
                <a id="close-alert" class="btn btn-ghost btn-circle btn-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/></svg>
                </a>
            </div>
        </div>
    @endif
    <x-guest-layout>
        <div class="flex justify-center items-center mb-5">
            <h1 class="text-blue-600 font-bold text-2xl text-center">Register Admin</h1>
        </div>
        <form class="w-full" action="{{ route('register') }}" method="POST">
            @csrf
            
            {{-- Username --}}
            <div>
                <input id="username" name="username" value="{{ old('username') }}" autofocus autocomplete="username" required type="text" placeholder="Username" class="input input-bordered input-primary w-full max-w-md mb-5 bg-blue-500/10" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <div>
                <input id="email" name="email" required autocomplete="email" type="email" placeholder="Email" class="input input-bordered input-primary w-full max-w-md mb-5 bg-blue-500/10" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <input id="password" name="password" class="input input-bordered input-primary bg-blue-500/10 flex items-center gap-2 mb-5 pw-admin w-full" required type="password" placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                
                <input id="password_confirmation" name="password_confirmation" class="input input-bordered input-primary bg-blue-500/10 flex items-center gap-2 mb-5 w-full pw-admin" required type="password" placeholder="Confirm Password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            
            <div class="mb-3">
                <label class="cursor-pointer chx-pw inline-flex items-start">
                    <input type="checkbox" class="checkbox checkbox-primary mx-2" />
                    <span class="label-text">Show Password</span> 
                </label>
            </div>
            <button type="submit" class="btn btn-primary mb-3 text-white text-lg w-full">Sign Up</button>
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
        $(document).on('click', '#close-alert', function(){
            $('.alert-warning').addClass('hidden');
        })
    </script>
@endpush