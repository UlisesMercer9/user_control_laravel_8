<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\User;
use App\Http\Requests\RequestUpdateUser;

class LiveModal extends Component
{   
    public $showModal = 'hidden';
    public $name = '';
    public $lastname = '';
    public $email = '';
    public $role = '';
    public $user = null;

    protected $listeners = [
        'showModal'
    ];

    public function render()
    {
        return view('livewire.live-modal');
    }

    public function showModal(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->lastname = $user->r_lastname->lastname;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->showModal = '';
    }

    public function closeModal()
    {
        $this->reset();
    }

    public function updateUser()
    {
        $requestUser = new RequestUpdateUser();

        $values = $this->validate($requestUser->rules(), $requestUser->messages());

        $this->user->update($values);

        $this->user->r_lastname()->update(['lastname' => $values['lastname']]);

        $this->emit('userListUpdate');

        $this->reset();
    }

    public function updated($label)
    {
        $requestUser = new RequestUpdateUser();
        $this->validateOnly($label, $requestUser->rules(), $requestUser->messages());
    }
}
