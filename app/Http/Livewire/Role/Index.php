<?php

namespace App\Http\Livewire\Role;

use App\Models\Permission;
use App\Models\Role;
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
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->form = $role;
        $this->openModalCreate = true;
        $this->clearValidation();
    }

    public function save()
    {
        $this->validate();
        $this->form->save();
        $this->form->permissions()->sync($this->permissions);
        $this->openModalCreate = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Hierarquia salva com sucesso!',
            'text' => '',
        ]);
    }

    public function confirmingRoleDeletion(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($role->permissions->count() || $role->users->count()) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => 'Hirarquia não pode ser apagada!',
                'text' => '',
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
    }

    public function delete()
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->roleToRemove->delete();

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Hierarquia removida com sucesso!',
            'text' => '',
        ]);
    }

    public function mount(Role $form)
    {
        $this->form = $form;
    }

    public function getRolesProperty()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
