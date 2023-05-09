<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $search;

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
