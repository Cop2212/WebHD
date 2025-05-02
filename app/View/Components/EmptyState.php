<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmptyState extends Component
{
    public $title;
    public $description;
    public $icon;

    public function __construct($title = null, $description = null, $icon = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.empty-state');
    }
}
