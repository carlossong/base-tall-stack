<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public User $user;
    public $formRoles;
    public array $roles = [];
    public string $password = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->user->load('roles');
        $this->roles = $user->roles->pluck('id')->toArray();
    }

    protected function rules(): array
    {
        return [
            'user.name' => [
                'string',
                'required',
            ],
            'user.email' => [
                'email:rfc',
                'required',
                'unique:users,email,' . $this->user->id,
            ],
            'password' => [
                'string',
                'required',
            ]
        ];
    }

    public function save()
    {
        $this->validate();
        $this->user->password = bcrypt($this->password);
        $this->user->save();
        $this->user->roles()->sync($this->roles);
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário salvo com sucesso!',
            'text' => '',
        ]);

    }
    public function render()
    {
        $this->formRoles = Role::pluck('title', 'id');
        return view('livewire.user.edit');
    }
}