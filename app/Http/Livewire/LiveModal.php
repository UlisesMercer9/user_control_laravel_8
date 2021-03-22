<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\User;
use App\Models\Apellido;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RequestUpdateUser;

class LiveModal extends Component
{
    public $showModal = 'hidden';
    public $name = '';
    public $lastname = '';
    public $email = '';
    public $role = '';
    public $user = null;
    public $action = '';
    public $method = '';
    public $password = '';
    public $password_confirmation = '';

    protected $listeners = [
        'showModal',
        'showModalNewUser'
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

        $this->action = 'Actualizar';
        $this->method = 'updateUser';
    }

    public function showModalNewUser()
    {
        $this->user = null;
        $this->action = 'Añadir';
        $this->method = 'createUser';
        $this->showModal = '';
    }

    public function closeModal()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }

    public function updateUser()
    {
        $requestUser = new RequestUpdateUser();

        $values = $this->validate($requestUser->rules($this->user), $requestUser->messages());

        $this->user->update($values);

        $this->user->r_lastname()->update(['lastname' => $values['lastname']]);

        $this->emit('userListUpdate');

        $this->resetErrorBag();

        $this->resetValidation();

        $this->reset();
    }

    public function updated($label)
    {
        $requestUser = new RequestUpdateUser();

        $this->validateOnly($label, $requestUser->rules($this->user), $requestUser->messages());
    }

    public function createUser()
    {
        $requestUser = new RequestUpdateUser();

        $values = $this->validate($requestUser->rules($this->user), $requestUser->messages());


        $user = new User;
        $apellido  = new Apellido;
        $apellido->lastname = $values['lastname'];

        $user->fill($values);
        $user->password = bcrypt($values['password']);
        DB::transaction(function() use ($user, $apellido){
            $user->save();
            $apellido->r_user()->associate($user)->save();
        });

        $this->closeModal();
    }
}
