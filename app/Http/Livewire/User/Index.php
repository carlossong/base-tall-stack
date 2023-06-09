<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Exception;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Index extends Component
{
    public $search;
    public ?User $user;
    protected $listeners = ['delete', 'restore'];

    public function condirmDesativeUser(User $user)
    {
        try {
            abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
            if ($user->id === Auth::user()->id) {
                $this->dispatchBrowserEvent('swal:toast', [
                    'type' => 'error',
                    'title' => 'Ação Negada!',
                    'text' => 'Contate o Administrador',
                ]);
                return;
            }
            $this->user = $user;
            $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'question',
                'title' => 'Desativar ' . $user->name . '?',
                'text' => 'Desativar todas as funções do usário?',
                'id' => $user->id,
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => $exception->getMessage(),
                'text' => 'Contate o Administrador',
            ]);
        }
    }

    public function condirmActiveUser($user)
    {
        try {
            $user = User::onlyTrashed()->first();
            $this->user = $user;
            $this->dispatchBrowserEvent('swal:confirm-restore', [
                'type' => 'question',
                'title' => 'Restaurar ' . $user->name . '?',
                'text' => '',
                'id' => $user->id,
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'error',
                'title' => $exception->getMessage(),
                'text' => 'Contate o Administrador',
            ]);
        }
    }

    public function restore()
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');

        $this->user->restore();
        session()->flash('success', 'Usuário restaurado com sucesso!');
        return redirect()->route('user.index');
    }

    public function delete()
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');
        $this->user->delete();
        session()->flash('success', 'Usuário removido com sucesso!');
        return redirect()->route('user.index');
    }

    public function getUsersProperty()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, 'Acesso Negado!');

        return User::withTrashed()
            ->with('roles')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('name')->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.index');
    }
}
