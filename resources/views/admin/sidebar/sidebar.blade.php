<div class="w-[20%] h-screen bg-blue-700 p-3 text-white fixed z-10 left-0 top-0">
    <h1 class="text-xl text-center font-bold">SMKN 7 BANDAR LAMPUNG</h1>
    <ul class="flex flex-col gap-3 mt-5 px-3">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'btn-active' : '' }} py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 144h288M160 256h288M160 368h288"/><circle cx="80" cy="144" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="256" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="368" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                <span class="text-md font-bold">Dashboard Admin</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kelas_jurusan') }}" class="{{ request()->routeIs('admin.kelas_jurusan') ? 'btn-active' : '' }} py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 8 8"><path fill="currentColor" d="M1 0C.93 0 .87.01.81.03C.42.11.11.42.03.81C0 .87 0 .93 0 1v5.5C0 7.33.67 8 1.5 8H7V7H1.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5H7V.5c0-.28-.22-.5-.5-.5H6v3L5 2L4 3V0z"/></svg>
                <span class="text-md font-bold">Kelas/Jurusan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.siswa') }}" class="{{ request()->routeIs('admin.siswa') ? 'btn-active' : '' }} py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 32 32"><path fill="currentColor" d="M12 4a5 5 0 1 1-5 5a5 5 0 0 1 5-5m0-2a7 7 0 1 0 7 7a7 7 0 0 0-7-7m10 28h-2v-5a5 5 0 0 0-5-5H9a5 5 0 0 0-5 5v5H2v-5a7 7 0 0 1 7-7h6a7 7 0 0 1 7 7zm0-26h10v2H22zm0 5h10v2H22zm0 5h7v2h-7z"/></svg>
                <span class="text-md font-bold">Akun Siswa</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.mapel') }}" class="{{ request()->routeIs('admin.mapel') ? 'btn-active' : '' }} py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 14 14"><path fill="currentColor" fill-rule="evenodd" d="M12.402 8.976H7.259a2.278 2.278 0 0 0-.193-4.547h-1.68A3.095 3.095 0 0 0 4.609 0h7.793a1.35 1.35 0 0 1 1.348 1.35v6.279c0 .744-.604 1.348-1.348 1.348ZM2.898 4.431a1.848 1.848 0 1 0 0-3.695a1.848 1.848 0 0 0 0 3.695m5.195 2.276c0-.568-.46-1.028-1.027-1.028H2.899a2.649 2.649 0 0 0-2.65 2.65v1.205c0 .532.432.963.964.963h.172l.282 2.61A1 1 0 0 0 2.66 14h.502a1 1 0 0 0 .99-.862l.753-5.404h2.16c.567 0 1.027-.46 1.027-1.027Z" clip-rule="evenodd"/></svg>
                <span class="text-md font-bold">Akun Guru</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.presensi') }}" class="{{ request()->routeIs('admin.presensi') ? 'btn-active' : '' }} py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 16 16"><path fill="currentColor" d="M2.5 1.75v11.5c0 .138.112.25.25.25h3.17a.75.75 0 0 1 0 1.5H2.75A1.75 1.75 0 0 1 1 13.25V1.75C1 .784 1.784 0 2.75 0h8.5C12.216 0 13 .784 13 1.75v7.736a.75.75 0 0 1-1.5 0V1.75a.25.25 0 0 0-.25-.25h-8.5a.25.25 0 0 0-.25.25m13.274 9.537l-4.557 4.45a.75.75 0 0 1-1.055-.008l-1.943-1.95a.75.75 0 0 1 1.062-1.058l1.419 1.425l4.026-3.932a.75.75 0 1 1 1.048 1.074M4.75 4h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1 0-1.5M4 7.75A.75.75 0 0 1 4.75 7h2a.75.75 0 0 1 0 1.5h-2A.75.75 0 0 1 4 7.75"/></svg>
                <span class="text-md font-bold">Presensi Siswa</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.generate-qr') }}" class="{{ request()->routeIs('admin.generate-qr') ? 'btn-active' : '' }} py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M1 1h10v10H1zm2 2v6h6V3z"/><path fill="currentColor" fill-rule="evenodd" d="M5 5h2v2H5z"/><path fill="currentColor" d="M13 1h10v10H13zm2 2v6h6V3z"/><path fill="currentColor" fill-rule="evenodd" d="M17 5h2v2h-2z"/><path fill="currentColor" d="M1 13h10v10H1zm2 2v6h6v-6z"/><path fill="currentColor" fill-rule="evenodd" d="M5 17h2v2H5z"/><path fill="currentColor" d="M23 19h-4v4h-6V13h1h-1v6h2v2h2v-6h-2v-2h-1h3v2h2v2h2v-4h2zm0 2v2h-2v-2z"/></svg>
                <span class="text-md font-bold">Generate Qr Code</span>
            </a>
        </li>
    </ul>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"  class="btn btn-ghost btn-sm absolute bottom-5 right-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M11.25 19a.75.75 0 0 1 .75-.75h6a.25.25 0 0 0 .25-.25V6a.25.25 0 0 0-.25-.25h-6a.75.75 0 0 1 0-1.5h6c.966 0 1.75.784 1.75 1.75v12A1.75 1.75 0 0 1 18 19.75h-6a.75.75 0 0 1-.75-.75"/><path fill="currentColor" d="M15.612 13.115a1 1 0 0 1-1 1H9.756c-.023.356-.052.71-.086 1.066l-.03.305a.718.718 0 0 1-1.025.578a16.844 16.844 0 0 1-4.885-3.539l-.03-.031a.721.721 0 0 1 0-.998l.03-.031a16.843 16.843 0 0 1 4.885-3.539a.718.718 0 0 1 1.025.578l.03.305c.034.355.063.71.086 1.066h4.856a1 1 0 0 1 1 1z"/></svg>
        </button>
    </form>
</div>