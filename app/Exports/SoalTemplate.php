<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SoalTemplate implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['', '', ''],
        ]);
    }

    public function headings(): array
    {
        return [
            'Soal',
            'A',
            'B',
            'C',
            'D',
            'Jawaban'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'name' => 'Arial',
                    'bold' => true,
                    'italic' => false,
                    'underline' => Font::UNDERLINE_DOUBLE,
                    'strikethrough' => false,
                    'color' => [
                        'argb' => Color::COLOR_WHITE
                    ]
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => Color::COLOR_BLUE]
                ]
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
        ];
    }
}
