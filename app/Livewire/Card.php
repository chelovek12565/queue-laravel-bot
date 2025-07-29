<?php

namespace App\Livewire;

use Livewire\Component;

class Card extends Component
{
    public string $title;

    public string $text;

    public string $link = "#";

    public function render()
    {
        return view('livewire.card');
    }
}
