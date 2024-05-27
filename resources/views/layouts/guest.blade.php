<div class="w-full h-screen flex flex-row">
    <div class="w-[50%] hidden h-full bg-gray-300 md:flex justify-center items-center">
        <img src="{{ asset('asset/logo/logo_smk7.png') }}" style="width: 268px; height: 320px;">
    </div>
    <div class="w-full md:w-[50%] h-full flex justify-center items-center">
        <div class="flex flex-col w-3/4 md:w-[40%]">
            {{ $slot }}
        </div>
    </div>
</div>