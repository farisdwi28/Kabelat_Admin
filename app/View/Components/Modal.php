<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $title;
    public $nama;
    public $tempat;
    public $tanggal;
    public $jenisKelamin;
    public $alamat;
    public $foto;

    public function __construct($id, $title, $nama = '', $tempat = '', $tanggal = '', $jenisKelamin = '', $alamat = '', $foto = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->nama = $nama;
        $this->tempat = $tempat;
        $this->tanggal = $tanggal;
        $this->jenisKelamin = $jenisKelamin;
        $this->alamat = $alamat;
        $this->foto = $foto;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
