<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\KelasSiswa;
use Illuminate\Support\Str;
use App\Models\KelasJurusan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $errors = [];
        $success = [];
        foreach ($rows as $row) {
            // Abaikan baris kosong
            if (empty($row['Nama Siswa']) || empty($row['Nama Orang Tua']) || empty($row['Kelas'])) {
                continue;
            }
            
            // Penanganan base_acct
            $base_acct = substr($row['Nama Siswa'], 0, 3).Str::random(5);
    
            // Penanganan nomor telepon
            $nomor_telepon = substr($row['Nomor Telepon Orang Tua'], 0, 1);
            $nomor_telepon_ortu = '';
            if($nomor_telepon !== '0'){
                $nomor_telepon_ortu = '08'.substr($row['Nomor Telepon Orang Tua'], 1);
            } else {
                $nomor_telepon_ortu = (string) $row['Nomor Telepon Orang Tua'];
            }

            if (Siswa::where('nis', $row['NIS'])->exists()) {
                $errors[] = "NIS <strong>" . $row['NIS'] . "</strong> sudah terdaftar dalam sistem.";
                continue;
            }
            
            // Buat user
            $user = User::create([
                'username' => $row['Username'] ?? $base_acct,
                'password' => $row['Password'] ?? Hash::make($base_acct),
                'role' => 'siswa'
            ]);

            // Buat orang tua
            $orang_tua = OrangTua::create([
                'nama' => (string) $row['Nama Orang Tua'],
                'nomor_telepon' => (string) $nomor_telepon_ortu
            ]);

            // Cari kelas
            $kelas = KelasJurusan::where('nama_kelas', (string) $row['Kelas'])->first();
            $tanggal_lahir = Date::excelToDateTimeObject((int) $row["Tanggal Lahir"]);

            if($kelas){
                // Buat siswa
                try {
                    $siswa = Siswa::create([    
                        'user_id' => $user->id,
                        'id_orangtua' => $orang_tua->id_orangtua,
                        'password' => $row['Password'] ?? $base_acct,
                        'nama' => (string) $row['Nama Siswa'],
                        'nis' => (string) $row['NIS'],
                        'tanggal_lahir' => $tanggal_lahir
                    ]);
    
                    // Buat relasi kelas siswa
                    KelasSiswa::create([
                        'id_kelas' => $kelas->id_kelas,
                        'id_siswa' => $siswa->id_siswa
                    ]);

                    $success[] = 'success';

                } catch(\Exception $ex){
                    User::destroy($user->id);
                    OrangTua::destroy($orang_tua->id_orangtua);
                }
            } else {
                User::destroy($user->id);
                OrangTua::destroy($orang_tua->id_orangtua);

                $errors[] = "Kelas <strong>".$row['Kelas']."</strong> Pada Siswa bernama <strong>".$row['Nama Siswa']."</strong> Tidak Ditemukan!";
            }
        }

        if (count($errors) > 0) {
            Session::flash('import_errors', $errors);
        }
        if(count($success) > 0){
            Session::flash('import_success', $success);
        }
    }
}
