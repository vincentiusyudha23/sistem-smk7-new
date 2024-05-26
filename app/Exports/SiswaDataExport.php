<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaDataExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('role', 'siswa')->with('siswa')->get()
                ->map(function ($user) {
                    return [
                        'username' => $user->username,
                        'password' => $user->siswa->password, // Perhatikan, ini menghasilkan password yang di-hash
                        'nama_siswa' => $user->siswa->nama,
                        'nis' => $user->siswa->nis,
                        'kelas' => $user->siswa->kelas->nama_kelas,
                        'jurusan' => $user->siswa->kelas->jurusan
                    ];
                });
    }

    public function headings(): array
    {
        return [
            'Username',
            'Password',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Jurusan',
        ];
    }
}
