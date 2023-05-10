<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

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
                'min:8',
            ]
        ];
    }

    public function save()
    {
        $this->validate();
        $this->form->password = bcrypt($this->password);
        $this->form->save();
        $this->form->roles()->sync($this->roles);
        $user = $this->form;
        session()->flash('success', 'Usuário adicionado com sucesso!');
        return redirect()->route('user.edit', $user);
    }

    public function cancel()
    {
        return redirect()->route('user.index');
    }

    public function render()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->formRoles = Role::pluck('title', 'id');
        return view('livewire.user.create');
    }
}
