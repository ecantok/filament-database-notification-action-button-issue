<x-filament-panels::page>
    <form method="post" wire:submit="send">
        {{ $this->form }}

        <div wire:loading>
            <x-filament::button class="mt-6" disabled>
                <x-filament::loading-indicator class="h-5 w-5 inline" />
                {{ __('Send Message') }}
            </x-filament::button>
        </div>
        <div wire:loading.remove>
            <x-filament::button class="mt-6" type="submit">
                {{ __('Send Message') }}
            </x-filament::button>
        </div>
    </form>
    <x-filament-actions::modals />
</x-filament-panels::page>
