<div class="flex flex-row">
    <aside class="w-[20%]">
        @include('siswa.sidebar.sidebar')
    </aside>
    <section class="w-[80%]">
        <header class="w-full h-14 bg-purple-200 flex items-center px-14 text-lg font-semibold">
            <h1>Selamat Siang, {{ auth()->user()->siswa->nama }}</h1>
        </header>
        <main class="w-full px-10">
            {{ $slot }}
        </main>
    </section>
</div>