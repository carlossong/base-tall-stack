<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Usuários</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg justify-items-end">
        <div class="space-y-4">
            <form wire:submit.prevent="save">
                <!-- Name -->
                <div class="mt-2">
                    <x-label for="user.name" value="{{ __('Name') }}" />
                    <x-input id="user.name" type="text" class="block w-full" wire:model.defer="user.name"
                        autocomplete="user.name" placeholder="Nome do Usuário" />
                    <x-input-error for="user.name" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-2">
                    <x-label for="user.email" value="{{ __('Email') }}" />
                    <x-input id="user.email" type="email" class="block w-full" wire:model.defer="user.email"
                        autocomplete="user.email" placeholder="E-mail" />
                    <x-input-error for="user.email" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-2 gap-2">
                    <x-label for="password" value="{{ __('Senha') }}" />
                    <x-input id="password" type="password" class="block w-full" wire:model.defer="password"
                        autocomplete="password" placeholder="Senha" />
                    <x-input-error for="password" class="mt-2" />
                </div>

                <!-- Roles-->
                <div class="mt-2">
                    <x-label for="user.roles" value="{{ __('Hierarquias') }}" />
                    @foreach ($formRoles as $id => $role)
                        <label for="{{ $id }}" class="flex items-center">
                            <x-checkbox name="roles[]" id="{{ $id }}" wire:model.defer="roles"
                                value="{{ $id }}" />
                            <span class="ml-2 text-sm text-gray-600">{{ $role }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-2 text-end">
                    <x-secondary-button wire:click='cancel' wire:loading.attr="disabled">
                        {{ __('Fechar') }}
                    </x-secondary-button>
                    <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                        {{ __('Salvar') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

</div>
