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

        $this->user = $user;
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'question',
            'title' => 'Remover ' . $user->name .'?',
            'text' => '',
            'id' => $user->id,
        ]);
    }

    public function delete()
    {

        $this->user->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'title' => 'Usuário removido com sucesso!',
            'text' => '',
        ]);
    }

    public function getUsersProperty()
    {
        return User::with('roles')
        ->where('name', 'like', '%'.$this->search.'%')
        ->orWhere('email', 'like', '%'.$this->search.'%')
        ->orderBy('name')->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.index');
    }
}
