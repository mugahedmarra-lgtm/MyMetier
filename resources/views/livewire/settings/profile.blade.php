<div class="w-full">
    <form wire:submit="updateProfileInformation" class="w-full space-y-6">
        <flux:input wire:model="name" :label="__('الاسم')" type="text" required autofocus autocomplete="name" />

        <flux:input wire:model="phone" :label="__('رقم الهاتف')" type="tel" required autocomplete="tel" dir="ltr" class="text-left" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full sm:w-auto">{{ __('حفظ') }}</flux:button>
            </div>

            <x-action-message class="me-3 text-sm text-green-600 font-medium" on="profile-updated">
                {{ __('تم الحفظ بنجاح.') }}
            </x-action-message>
        </div>
    </form>

    @if ($this->showDeleteUser)
        <hr class="my-8 border-gray-100">
        <div class="pt-2">
            <livewire:settings.delete-user-form />
        </div>
    @endif
</div>
