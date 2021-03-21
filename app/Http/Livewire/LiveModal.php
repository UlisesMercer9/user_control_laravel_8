<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LiveModal extends Component
{   
    public $showModal = '';

    protected $listeners = [
        'showModal'
    ];

    public function render()
    {
        return view('livewire.live-modal');
    }

    public function showModal($user)
    {
        $this->showModal = '';
    }

    public function closeModal()
    {
        $this->showModal = 'hidden';
    }
}
