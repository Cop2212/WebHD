<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $color;
    public $href;
    public $wireNavigate;

    public function __construct($color = 'blue', $href = null, $wireNavigate = false)
    {
        $this->color = $color;
        $this->href = $href;
        $this->wireNavigate = $wireNavigate;
    }

    public function render()
    {
        return view('components.badge');
    }
}
