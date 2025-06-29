<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public function __construct(
        public string $action = '',
        public string $method = 'POST',
        public string $enctype = 'application/x-www-form-urlencoded'
    ) {}

    public function render()
    {
        return view('components.form');
    }
}
