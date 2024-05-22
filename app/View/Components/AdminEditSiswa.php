<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminEditSiswa extends Component
{

    public function __construct(
        public $ranId, 
        public $siswa,
        public $username,
        public $password,
        public $nis,
        public $tanggallahir,
        public $kelas,
        public $orangtua,
        public $nomorOrangtua,
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.admin-edit-siswa');
    }
}
