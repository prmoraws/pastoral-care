<?php

namespace App\Livewire;

use App\Models\Pessoa;
use Livewire\Component;

class CardPessoa extends Component
{
    public Pessoa $pessoa;

    public function render()
    {
        return view('livewire.card-pessoa');
    }
}