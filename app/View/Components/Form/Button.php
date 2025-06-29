<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $type = 'submit',
        public string $variant = 'primary',
        public string $text = 'Simpan',
        public bool $fullWidth = false
    ) {}

    public function render()
    {
        return view('components.form.button');
    }
}
