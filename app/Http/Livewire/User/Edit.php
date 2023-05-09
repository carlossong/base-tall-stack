<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

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
        $this->clearValidation();
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
                'min:8',
            ]
        ];
    }

    public function save()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate();
        if ($this->password) {
            $this->user->password = bcrypt($this->password);
        }
        $this->user->save();
        $this->user->roles()->sync($this->roles);
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário salvo com sucesso!',
            'text' => '',
        ]);
    }

    public function cancel()
    {
        return redirect()->route('user.index');
    }

    public function render()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->formRoles = Role::pluck('title', 'id');
        return view('livewire.user.edit');
    }
}
