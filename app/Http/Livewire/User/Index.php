<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class Index extends Component
{
    public $search;
    public ?User $user;
    protected $listeners = ['delete'];

    public function confirmingUserDeletion(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->user = $user;
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'question',
            'title' => 'Remover ' . $user->name . '?',
            'text' => '',
            'id' => $user->id,
        ]);
    }

    public function delete()
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->user->delete();
        session()->flash('success', 'Usuário removido com sucesso!');
        return redirect()->route('user.index');
    }

    public function getUsersProperty()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return User::with('roles')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('name')->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.index');
    }
}
