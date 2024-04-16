<div class="w-[20%] h-screen bg-blue-700 p-3 text-white fixed z-10 left-0 top-0">
    <h1 class="text-xl text-center font-bold">SMKN 7 BANDAR LAMPUNG</h1>
    <ul class="flex flex-col gap-3 mt-5 px-3">
        <li>
            <a href="{{ route('admin.dashboard') }}" class=" py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M160 144h288M160 256h288M160 368h288"/><circle cx="80" cy="144" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="256" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="80" cy="368" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                Dashboard Admin
            </a>
        </li>
        <li>
            <a href="{{ route('admin.siswa') }}" class=" py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 32 32"><path fill="currentColor" d="M12 4a5 5 0 1 1-5 5a5 5 0 0 1 5-5m0-2a7 7 0 1 0 7 7a7 7 0 0 0-7-7m10 28h-2v-5a5 5 0 0 0-5-5H9a5 5 0 0 0-5 5v5H2v-5a7 7 0 0 1 7-7h6a7 7 0 0 1 7 7zm0-26h10v2H22zm0 5h10v2H22zm0 5h7v2h-7z"/></svg>
                Kelola Akun Siswa
            </a>
        </li>
        <li>
            <a href="{{ route('admin.mapel') }}" class=" py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 512 512"><path fill="currentColor" d="M101.667 400H464V16H100.667A60.863 60.863 0 0 0 40 76.667V430.25h.011c0 .151-.011.3-.011.453c0 35.4 27.782 65.3 60.667 65.3H464V464H100.667C85.664 464 72 448.129 72 430.7c0-16.64 13.585-30.7 29.667-30.7M360 48.333v172.816l-48.4-42.49L264 220.9V48.333ZM232 48v216h31.641l48.075-42.659L360.305 264H392V48h40v320H136.08L136 48Zm-131.333 0H104l.076 320h-2.413A59.793 59.793 0 0 0 72 375.883V76.917A28.825 28.825 0 0 1 100.667 48"/></svg>
                Kelola Akun Mata Pelajaran
            </a>
        </li>
        <li>
            <a href="{{ route('admin.presensi') }}" class=" py-1 flex flex-row justify-start items-center btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="M3.5 3.75a.25.25 0 0 1 .25-.25h13.5a.25.25 0 0 1 .25.25v10a.75.75 0 0 0 1.5 0v-10A1.75 1.75 0 0 0 17.25 2H3.75A1.75 1.75 0 0 0 2 3.75v16.5c0 .966.784 1.75 1.75 1.75h7a.75.75 0 0 0 0-1.5h-7a.25.25 0 0 1-.25-.25z"/><path fill="currentColor" d="M6.25 7a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5zm-.75 4.75a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75m16.28 4.53a.75.75 0 1 0-1.06-1.06l-4.97 4.97l-1.97-1.97a.75.75 0 1 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0z"/></svg>
                Kelola Presensi Siswa
            </a>
        </li>
    </ul>
    <a href="{{ route('login', ['role' => 'admin']) }}" class="btn btn-ghost btn-sm absolute bottom-5 right-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M11.25 19a.75.75 0 0 1 .75-.75h6a.25.25 0 0 0 .25-.25V6a.25.25 0 0 0-.25-.25h-6a.75.75 0 0 1 0-1.5h6c.966 0 1.75.784 1.75 1.75v12A1.75 1.75 0 0 1 18 19.75h-6a.75.75 0 0 1-.75-.75"/><path fill="currentColor" d="M15.612 13.115a1 1 0 0 1-1 1H9.756c-.023.356-.052.71-.086 1.066l-.03.305a.718.718 0 0 1-1.025.578a16.844 16.844 0 0 1-4.885-3.539l-.03-.031a.721.721 0 0 1 0-.998l.03-.031a16.843 16.843 0 0 1 4.885-3.539a.718.718 0 0 1 1.025.578l.03.305c.034.355.063.71.086 1.066h4.856a1 1 0 0 1 1 1z"/></svg>
    </a>
</div>