<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminEditMapel extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $idMapel,
        public $namaMapel,
        public $username,
        public $password,
        public $kodeMapel,
        public $namaGuru,
        public $nip,
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.admin-edit-mapel');
    }
}
