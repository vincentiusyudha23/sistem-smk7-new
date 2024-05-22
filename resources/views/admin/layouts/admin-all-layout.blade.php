<div class="flex flex-row">
    <aside class="lg:w-[20%]">
        @include('admin.sidebar.sidebar')
    </aside>
    <section class="w-full lg:w-[80%]">
        <div class="w-full bg-blue-800 p-2 text-center lg:hidden">
            <h1 class="text-white font-bold text-2xl">SMKN 7 BANDAR LAMPUNG</h1>
        </div>
        <header class="w-full h-14 bg-purple-200 flex items-center px-14 text-lg font-semibold">
            <h1>{{ getCurrentTimeOfDay("Admin") }}</h1>
        </header>
        <main class="w-full lg:px-10">
            {{ $slot }}
        </main>
    </section>
</div>