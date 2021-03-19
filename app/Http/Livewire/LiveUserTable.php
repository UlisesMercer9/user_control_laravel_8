<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LiveUserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    public function render()
    {
        return view('livewire.live-user-table', [
            'users' => User::where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->paginate($this->perPage),
        ]);
    }
}
