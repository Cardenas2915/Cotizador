<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class panelCategorias extends Component
{
    public $categorias;

    public function __construct($categorias)
    {
        //
        $this->categorias=$categorias;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.panel-categorias');
    }
}
