<?php

namespace App\Http\Livewire\Role;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class Index extends Component
{
    public $search;
    public Role $form;
    public $allPermissions;
    public array $permissions = [];
    public $openModalDelete = false;
    public $openModalCreate = false;
    public ?Role $roleToRemove = null;
    protected $listeners = ['delete'];

    public function edit(Role $form)
    {
        $this->form = $form;
        $this->form->load('permissions');
        $this->permissions = $form->permissions()->pluck('id')->toArray();
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    protected function rules(): array
    {

        return [
            'form.title' => [
                'string',
                'required',
            ],
        ];
    }

    public function newRole(Role $role)
    {
        try {
            abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
            $this->form = $role;
            $this->openModalCreate = true;
            $this->clearValidation();
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => $exception->getMessage(),
                'text' => 'Contate o Administrador',
            ]);
        }
    }

    public function save()
    {
        try {
            $this->validate();
            $this->form->save();
            $this->form->permissions()->sync($this->permissions);
            $this->openModalCreate = false;
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'success',
                'title' => 'Hierarquia salva com sucesso!',
                'text' => '',
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => $exception->getMessage(),
                'text' => 'Contate o Administrador',
            ]);
        }
    }

    public function confirmingRoleDeletion(Role $role)
    {
        try {
            abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
            if ($role->permissions->count() || $role->users->count()) {
                $this->dispatchBrowserEvent('swal:toast', [
                    'type' => 'error',
                    'title' => 'Ação Negada!',
                    'text' => 'Há Usuario Vinculado.',
                ]);
                return;
            }
            $this->roleToRemove = $role;
            $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'question',
                'title' => 'Remover ' . $role->title . '?',
                'text' => '',
                'id' => $role->id,
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => $exception->getMessage(),
                'text' => 'Contate o Administrador',
            ]);
        }
    }

    public function delete()
    {
        try {
            abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
            $this->roleToRemove->delete();
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'success',
                'title' => 'Hierarquia removida com sucesso!',
                'text' => '',
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => $exception->getMessage(),
                'text' => 'Contate o Administrador',
            ]);
        }
    }

    public function mount(Role $form)
    {
        $this->form = $form;
    }

    public function getRolesProperty()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
        return Role::with('users')
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('title')->paginate(10);
    }

    public function render()
    {
        $this->allPermissions = Permission::pluck('title', 'id');
        return view('livewire.role.index');
    }
}
