<?php

namespace App\Http\Livewire\User;

use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
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
        return (new StoreUserRequest())->rules();
    }

    public function save()
    {
        try {
            abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
            $this->validate();
            $this->form->password = bcrypt($this->password);
            $this->form->save();
            $this->form->roles()->sync($this->roles);
            $user = $this->form;
            session()->flash('success', 'Usuário Adicionado com Sucesso!');
            return redirect()->route('user.index');
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => $exception->getMessage(),
                'text' => 'Contate o Administrador',
            ]);
        }
    }

    public function cancel()
    {
        return redirect()->route('user.index');
    }

    public function render()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
        $this->formRoles = Role::pluck('title', 'id');
        return view('livewire.user.create');
    }
}
