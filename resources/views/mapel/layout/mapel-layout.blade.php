<div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col items-center justify-center">
        <section class="w-full md:pl-[320px]">
            <div class="w-full bg-blue-700 fixed top-0 left-0 p-3 z-10 flex justify-between items-center md:hidden">
                <label for="my-drawer-2" class="btn btn-sm drawer-button lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6.001h18m-18 6h18m-18 6h18"/></svg>
                </label>
                <h1 class="text-white font-bold text-xl pr-4">SMKN 7 BANDAR LAMPUNG</h1>
            </div>
            <header class="bg-purple-300 mt-14 px-2 md:px-0 md:mt-0 md:absolute top-0 right-0 w-full  md:pl-[350px] py-2">
                <h1 class="text-lg">{{ getCurrentTimeOfDay(auth()->user()->mapel->nama_guru) }}</h1>
            </header>
            <main class="w-full md:h-[92vh] lg:px-10 p-3">
                {{ $slot }}
            </main>
        </section>
    </div> 

    <div class="drawer-side">
        <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu p-0 w-80 min-h-full bg-blue-700 text-white fixed top-0 left-0 z-20">
            <li class="w-full flex justify-center items-center mb-3">
                <h1 class="text-xl text-center font-bold">SMKN 7 BANDAR LAMPUNG</h1>
            </li>
            <li class="px-2 py-1">
                <a href="{{ route('mapel.dashboard') }}" class="{{ request()->routeIs('mapel.dashboard') ? 'btn-active' : ''}} py-1 flex flex-row justify-start items-center btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 144h288M160 256h288M160 368h288"/><circle cx="80" cy="144" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="256" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="368" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                    Dashboard Guru
                </a>
            </li>
            <li class="px-2 py-1">
                <a href="{{ route('mapel.sesi-ujian') }}" class="{{ request()->routeIs('mapel.sesi-ujian') ? 'btn-active' : ''}} py-1 flex flex-row justify-start items-center btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3m1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z"/></svg>
                    Kelola Ujian
                </a>
            </li>
            <li class="px-2 py-1">
                <a href="{{ route('mapel.hasil-ujian') }}" class="{{ request()->routeIs('mapel.hasil-ujian') ? 'btn-active' : ''}} py-1 flex flex-row justify-start items-center btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="M3.5 3.75a.25.25 0 0 1 .25-.25h13.5a.25.25 0 0 1 .25.25v10a.75.75 0 0 0 1.5 0v-10A1.75 1.75 0 0 0 17.25 2H3.75A1.75 1.75 0 0 0 2 3.75v16.5c0 .966.784 1.75 1.75 1.75h7a.75.75 0 0 0 0-1.5h-7a.25.25 0 0 1-.25-.25z"/><path fill="currentColor" d="M6.25 7a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5zm-.75 4.75a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75m16.28 4.53a.75.75 0 1 0-1.06-1.06l-4.97 4.97l-1.97-1.97a.75.75 0 1 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0z"/></svg>
                    Kelola Hasil Ujian
                </a>
            </li>
            <li class="absolute bottom-0 right-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"  class="btn btn-ghost btn-sm absolute bottom-5 right-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M11.25 19a.75.75 0 0 1 .75-.75h6a.25.25 0 0 0 .25-.25V6a.25.25 0 0 0-.25-.25h-6a.75.75 0 0 1 0-1.5h6c.966 0 1.75.784 1.75 1.75v12A1.75 1.75 0 0 1 18 19.75h-6a.75.75 0 0 1-.75-.75"/><path fill="currentColor" d="M15.612 13.115a1 1 0 0 1-1 1H9.756c-.023.356-.052.71-.086 1.066l-.03.305a.718.718 0 0 1-1.025.578a16.844 16.844 0 0 1-4.885-3.539l-.03-.031a.721.721 0 0 1 0-.998l.03-.031a16.843 16.843 0 0 1 4.885-3.539a.718.718 0 0 1 1.025.578l.03.305c.034.355.063.71.086 1.066h4.856a1 1 0 0 1 1 1z"/></svg>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>