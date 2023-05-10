<?php

namespace App\Http\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class Index extends Component
{
    public $search;

    public function getRolesProperty()
    {
        // abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Role::with('users')
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('title')->paginate(10);
    }

    public function render()
    {
        return view('livewire.role.index');
    }
}
