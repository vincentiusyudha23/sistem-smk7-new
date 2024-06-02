<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PresensiExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }
    
    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Nama Kelas',
            'Jurusan',
            'Status'
        ];
    }
}
