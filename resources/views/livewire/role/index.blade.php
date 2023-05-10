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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Hierarquias</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </h2>
    </x-slot>
    <div class="md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg overflow-hidden shadow-xl">
                <div class="shadow-lg rounded-lg overflow-hidden">
                    <div class="flex justify-start items-center">
                        @can('user_edit')
                            <a>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-10 h-10 ml-4 text-indigo-900 dark:hover:text-indigo-400 dark:text-indigo-500 cursor-pointer justify-between hover:text-indigo-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </a>
                            <a href="{{ route('role.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-10 h-10 ml-4 text-indigo-900 dark:hover:text-indigo-400 dark:text-indigo-500 cursor-pointer justify-between hover:text-indigo-600"
                                    alt="Verificado">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </a>
                        @endcan
                        <x-input type="text" wire:model.debounce.300ms="search" id="search" class="m-4 w-full"
                            type="text" placeholder="Buscar Usuário" autocomplete="nope" />
                    </div>
                    <div x-data class="p-4 grid md:grid-cols-2 gap-4">
                        @foreach ($this->roles as $index => $role)
                            <div x-data="{ opened_tab: null }" class="flex flex-col">
                                <div class="flex flex-col border rounded shadow mb-2">
                                    <div @click="opened_tab = opened_tab == {{ $index }} ? null : {{ $index }} "
                                        class="text-sm font-medium text-gray-700 dark:text-gray-400 p-4 cursor-pointer flex justify-between hover:text-indigo-600 hover:text-base">
                                        <div class="flex items-center">
                                            {{ $role->title }}
                                        </div>
                                    </div>
                                    <div x-show="opened_tab=={{ $index }}" class="p-4 text-gray-500">
                                        <div>
                                            <div class="p-2">
                                                <p>Permissões</p>
                                                @foreach ($role->permissions as $permission)
                                                    <span
                                                        class="inline-flex mr-2 text-xs leading-5 font-semibold rounded-lg uppercase text-green-800 items-center cursor-pointer hover:text-indigo-600">
                                                        {{ $permission->title }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            <div class="p-2">
                                                <p class="mx-1">Usuários</p>
                                                @foreach ($role->users as $user)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-green-100 text-green-800 items-center">
                                                        {{ $user->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex justify-end">
                                            <svg wire:click='edit({{ $role->id }})'
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6 mr-3 hover:text-gray-700 cursor-pointer">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            <svg wire:click='confirmingRoleDeletion({{ $role->id }})'
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6 text-red-700 hover:text-red-500 cursor-pointer">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="m-4">
                        {{ $this->roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-dialog-modal wire:model="openModalCreate">
        <x-slot name="title">
            @if ($form->id)
                {{ __('Editar Hierarquia: ') }} {{ $form->title }}
            @else
                {{ __('Nova Hierarquia') }}
            @endif
        </x-slot>

        <x-slot name="content">

            <div class="space-y-4">

                <!-- Title -->
                <div class="mt-2">
                    <x-label for="form.title" value="{{ __('Título') }}" />
                    <x-input id="form.title" type="text" class="block w-full" wire:model.defer="form.title"
                        autocomplete="form.title" placeholder="Título" />
                    <x-input-error for="form.title" class="mt-2" />
                </div>

                <!-- Roles-->
                <div class="mt-2">
                    <x-label for="form.roles" value="{{ __('Hierarquias') }}" />
                    @foreach ($allPermissions as $id => $permission)
                        <label for="{{ $id }}" class="flex items-center">
                            <x-checkbox name="permissions[]" id="{{ $id }}" wire:model.defer="permissions"
                                value="{{ $id }}" />
                            <span class="ml-2 text-sm text-gray-600">{{ $permission }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-2"></div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('openModalCreate')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                {{ __('Salvar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
