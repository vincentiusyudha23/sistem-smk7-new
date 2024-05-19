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
                <h1>{{ getCurrentTimeOfDay(auth()->user()->siswa->nama) }}</h1>
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
                <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'btn-active' : ''}} py-1 flex flex-row justify-start items-center btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 144h288M160 256h288M160 368h288"/><circle cx="80" cy="144" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="256" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="368" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                    Dashboard Siswa
                </a>
            </li>
            <li class="px-2 py-1">
                <a href="{{ route('siswa.ujian') }}" class="{{ request()->routeIs('siswa.ujian') ? 'btn-active' : ''}} py-1 flex flex-row justify-start items-center btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 32 32"><path fill="currentColor" d="M12 4a5 5 0 1 1-5 5a5 5 0 0 1 5-5m0-2a7 7 0 1 0 7 7a7 7 0 0 0-7-7m10 28h-2v-5a5 5 0 0 0-5-5H9a5 5 0 0 0-5 5v5H2v-5a7 7 0 0 1 7-7h6a7 7 0 0 1 7 7zm0-26h10v2H22zm0 5h10v2H22zm0 5h7v2h-7z"/></svg>
                    Ujian
                </a>
            </li>
            <li class="px-2 py-1">
                <a href="{{ route('siswa.presensi') }}" class="{{ request()->routeIs('siswa.presensi') ? 'btn-active' : ''}} py-1 flex flex-row justify-start items-center btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 512 512"><path fill="currentColor" d="M101.667 400H464V16H100.667A60.863 60.863 0 0 0 40 76.667V430.25h.011c0 .151-.011.3-.011.453c0 35.4 27.782 65.3 60.667 65.3H464V464H100.667C85.664 464 72 448.129 72 430.7c0-16.64 13.585-30.7 29.667-30.7M360 48.333v172.816l-48.4-42.49L264 220.9V48.333ZM232 48v216h31.641l48.075-42.659L360.305 264H392V48h40v320H136.08L136 48Zm-131.333 0H104l.076 320h-2.413A59.793 59.793 0 0 0 72 375.883V76.917A28.825 28.825 0 0 1 100.667 48"/></svg>
                    Presensi
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