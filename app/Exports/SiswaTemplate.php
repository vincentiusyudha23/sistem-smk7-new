<?php

namespace App\Exports;

use App\Models\KelasJurusan;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class SiswaTemplate implements 
    FromCollection, 
    WithHeadings, 
    WithStyles, 
    WithEvents, 
    ShouldAutoSize,
    WithColumnFormatting,
    WithColumnWidths
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
            'Nama Siswa',
            'NIS',
            'Tanggal Lahir',
            'Kelas',
            'Nama Orang Tua',
            'Nomor Telepon Orang Tua'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_TEXT
        ];
    }

    public function columnWidths(): array
    {
        return ['B' => '25', 'D' => '15'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $kelas = KelasJurusan::pluck('nama_kelas')->toArray(); // Ambil data kelas dari database
                
                $worksheet = $event->sheet->getDelegate();
                
                // Definisikan sel dropdown
                $dropDownList = implode(',', $kelas);
                for ($row = 2; $row <= 100; $row++) { // Asumsikan 100 baris untuk template
                    $validation = $worksheet->getCell('D' . $row)->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1('"' . $dropDownList . '"');
                }
            },
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
}
