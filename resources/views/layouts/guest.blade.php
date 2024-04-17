<div class="w-full h-screen flex flex-row">
    <div class="w-[50%] h-full bg-gray-300 flex justify-center items-center">
        <img src="{{ asset('asset/logo/logo_smk7.png') }}" style="width: 268px; height: 320px;">
    </div>
    <div class="w-[50%] h-full flex justify-center items-center">
        <div class="flex flex-col w-[40%]">
            {{ $slot }}
        </div>
    </div>
</div>