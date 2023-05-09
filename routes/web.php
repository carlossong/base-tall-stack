<?php

use App\Http\Livewire\Role\Index as RoleIndex;
use App\Http\Livewire\User\Create as UserCreate;
use App\Http\Livewire\User\Edit as UserEdit;
use App\Http\Livewire\User\Index as UserIndex;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('usuarios', UserIndex::class)->name('user.index');
    Route::get('usuarios/novo', UserCreate::class)->name('user.create');
    Route::get('usuarios/editar/{user}', UserEdit::class)->name('user.edit');

    Route::get('hierarquias', RoleIndex::class)->name('role.index');
});
