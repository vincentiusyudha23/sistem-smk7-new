<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SoalImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $soal = [];
        $index = 1;
        foreach($rows as $row){
            $soals = [
                "soal" => $row['Soal'],
                "opsi_soal" => [
                    $row['A'],
                    $row['B'],
                    $row['C'],
                    $row['D'],
                ],
                "jawaban" => [$row['Jawaban']]
            ];

            $soal['soal-'.$index] = $soals;
            $index++;
        }

        if(count($soal) > 0){
            Session::flash('soal_ujian', $soal);
        }
    }
}
