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
            'nama' => $this->toStringKey($row['Orang Tua']),
            'nomor_telepon' => $this->toStringKey($row['Nomor Telepon'], false) 
        ]);

        $jurusan = Jurusan::where('jurusan', $this->toStringKey($row['Jurusan']))->first();
        
        $kelas =Kelas::where('kelas', $this->toStringKey($row['Kelas'], false))->first();

        if($kelas && $jurusan){
            return new Siswa([    
                'user_id' => $user->id,
                'id_orangtua' => $orang_tua->id_orangtua,
                'id_jurusan' => $jurusan->id_jurusan,
                'id_kelas' => $kelas->id_kelas,
                'password' => $password,
                'nama' => $this->toStringKey($row['Nama']),
                'nis' => $this->toStringKey($row['NIS']),
                'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', $row['Tanggal Lahir'])->toDateString()
            ]);
        }
    }

    private function toStringKey($value, $key = true)
    {
        if($key){
            return (string)$value;
        } else{
            return (integer)$value;
        }
    }
}
