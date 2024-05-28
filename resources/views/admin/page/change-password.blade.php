@extends('frontendmaster')

@section('title')
    <title>Login Admin</title>
@endsection

@section('content')
    <div class="w-full h-full md:h-screen flex flex-col md:flex-row">
        <div class="w-full md:w-[50%] h-[40vh] md:h-full bg-gray-300 flex justify-center items-center">
            <img src="{{ asset('asset/logo/logo_smk7.png') }}" style="width: 268px; height: 320px;" class="scale-50 md:scale-100">
        </div>
        <div class="w-full md:w-[50%] h-[50vh] md:h-full flex justify-center items-center">
            <div class="flex flex-col md:w-[40%] mt-2">
                <div class="flex justify-center items-center mb-5">
                    <h1 class="text-blue-600 font-bold text-2xl text-center">Lupa Password</h1>
                </div>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form class="w-full" method="POST" action="{{ route('admin.user_confirm') }}">
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
                    <div>
                        <x-text-input id="email" 
                                placeholder="email" 
                                class="input input-bordered input-primary w-full max-w-md mb-5 bg-blue-500/10" 
                                type="text" 
                                name="email" 
                                :value="old('email')" 
                                required autofocus autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <button type="submit" class="btn btn-primary mb-3 text-white text-lg w-full">Submit</button>
                    
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