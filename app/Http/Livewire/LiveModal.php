<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\User;
use App\Models\Apellido;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RequestUpdateUser;
use Livewire\WithFileUploads;

class LiveModal extends Component
{
    use WithFileUploads;

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
    public $profile_photo_path = null;

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

        $profile = ['profile_photo_path' => $this->loadImage($values['profile_photo_path'])];

        $values = array_merge($values, $profile);


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
        $user->profile_photo_path = loadImage($values['profile_photo_path']);
        $user->password = bcrypt($values['password']);
        DB::transaction(function() use ($user, $apellido){
            $user->save();
            $apellido->r_user()->associate($user)->save();
        });

        $this->closeModal();
    }

    private function loadImage($image)
    {
        $extension = $image->getClientOriginalExtension();

        $location = \Storage::disk('public')->put('img/', $image);
    }
}
