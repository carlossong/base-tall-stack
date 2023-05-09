<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public User $form;
    public $formRoles;
    public array $roles = [];
    public string $password = '';

    public function mount(User $form)
    {
        $this->form = $form;
    }

    protected function rules(): array
    {
        return [
            'form.name' => [
                'string',
                'required',
            ],
            'form.email' => [
                'email:rfc',
                'required',
                'unique:users,email',
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
        $this->form->password = bcrypt($this->password);
        $this->form->save();
        $this->form->roles()->sync($this->roles);
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário salvo com sucesso!',
            'text' => '',
        ]);

    }

    public function render()
    {
        $this->formRoles = Role::pluck('title', 'id');
        return view('livewire.user.create');
    }
}
