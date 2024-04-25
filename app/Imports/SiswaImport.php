<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\OrangTua;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    * 
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        $password = substr($row['Nama'], 0, 3).Str::random(5);
        
        $user = User::create([
            'username' => $row['username'] ?? substr($row['Nama'], 0, 3).Str::random(5),
            'password' => $row['password'] ?? Hash::make($password),
            'role' => 'siswa'
        ]);

        $orang_tua = OrangTua::create([
            'nama' => $row['Orang Tua'],
            'nomor_telepon' => $row['Nomor Telepon']
        ]);

        return new Siswa([
            'user_id' => $user->id,
            'id_orangtua' => $orang_tua->id_orangtua,
            'id_jurusan' => Jurusan::where('jurusan', $row['Jurusan'])->first()->id_jurusan,
            'id_kelas' => Kelas::where('kelas', $row['Kelas'])->first()->id_kelas,
            'password' => $password,
            'nama' => $row['Nama'],
            'nis' => $row['NIS'],
            'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', $row['Tanggal Lahir'])->toDateString()
        ]);
    }
}
