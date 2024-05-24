<?php

namespace App\Imports;

use App\Models\KelasJurusan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class KelasImport implements ToCollection, WithHeadingRow
{
    public function collection(collection $rows)
    {
        $data = [];

        foreach($rows as $row)
        {
            $kelas = [
                'jurusan' => (string) $row['Jurusan'],
                'kelas' => (string) $row['Kelas'],
                'nama_kelas' => (string) $row['Nama Kelas']
            ];

            $data[] = $kelas; 
        }

        KelasJurusan::insert($data);

        return true;
    }
} 