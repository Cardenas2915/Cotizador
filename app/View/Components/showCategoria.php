<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class showCategoria extends Component
{
    public $productos;

    public function __construct($productos)
    {
        //
        $this->productos = $productos;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.show-categoria');
    }
}
