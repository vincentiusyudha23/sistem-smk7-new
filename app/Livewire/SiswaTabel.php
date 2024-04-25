<?php

namespace App\Livewire;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class SiswaTabel extends DataTableComponent
{
    protected $model = Siswa::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    // public function builder(): Builder
    // {
    //     $siswa = Siswa::query()->select('*')->with(['jurusan', 'kelas', 'orangTua'])->latest();

    //     return $siswa;
    // }

    public function columns(): array
    {
        return [
            Column::make("Nama", "nama")
                ->sortable(),
            Column::make("Nis", "nis")
                ->sortable(),
            Column::make("Jurusan", "id_jurusan"),
        ];
    }
}
