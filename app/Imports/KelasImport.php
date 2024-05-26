<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Models\KelasJurusan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class KelasImport implements ToCollection, WithHeadingRow
{
    public function collection(collection $rows)
    {
        $data = [];
        $errors = [];
        $success = [];
        foreach($rows as $row)
        {
            if(KelasJurusan::where('nama_kelas',$row['Nama Kelas'])->exists() || KelasJurusan::where('slug',Str::slug($row['Nama Kelas']))->exists()){
                $errors[] = "Kelas ".$row['Nama Kelas']." Sudaf Terdaftar";
                continue;
            }
            $kelas = [
                'jurusan' => (string) $row['Jurusan'],
                'kelas' => (string) $row['Kelas'],
                'nama_kelas' => (string) $row['Nama Kelas'],
                'slug' => Str::slug((string) $row['Nama Kelas'])
            ];

            $data[] = $kelas;
            $success[] = 'success'; 
        }

        KelasJurusan::insert($data);

        if(count($errors) > 0){
            Session::flash('kelas_import_error', $errors);
        }
        if(count($success) > 0){
            Session::flash('kelas_import_success', $success);
        }
    }
} 