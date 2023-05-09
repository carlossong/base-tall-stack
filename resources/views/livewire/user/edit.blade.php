<x-authentication-card>
    <x-slot name="logo">
        <x-authentication-card-logo />
    </x-slot>
    <div class="space-y-4">
        <form wire:submit.prevent="save">
            <!-- Name -->
            <div class="mt-2">
                <x-label for="user.name" value="{{ __('Name') }}" />
                <x-input id="user.name" type="text" class="block w-full" wire:model.defer="user.name"
                    autocomplete="user.name" placeholder="Nome do cliente" />
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
                <x-label for="user.roles" value="{{ __('Roles') }}" />
                @foreach ($formRoles as $id => $role)
                    <label for="{{ $id }}" class="flex items-center">
                        <x-checkbox name="roles[]" id="{{ $id }}" wire:model.defer="roles"
                            value="{{ $id }}" />
                        <span class="ml-2 text-sm text-gray-600">{{ $role }}</span>
                    </label>
                @endforeach
            </div>
            <div class="mt-2">
                <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                    {{ __('Salvar') }}
                </x-button>
            </div>
        </form>
    </div>
</x-authentication-card>
