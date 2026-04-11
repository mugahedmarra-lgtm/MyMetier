<div class="w-full">
    <form method="POST" wire:submit="updatePassword" class="space-y-6">
        <flux:input
            wire:model="current_password"
            :label="__('كلمة المرور الحالية')"
            type="password"
            required
            autocomplete="current-password"
            viewable
        />
        <flux:input
            wire:model="password"
            :label="__('كلمة المرور الجديدة')"
            type="password"
            required
            autocomplete="new-password"
            viewable
        />
        <flux:input
            wire:model="password_confirmation"
            :label="__('تأكيد كلمة المرور')"
            type="password"
            required
            autocomplete="new-password"
            viewable
        />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full sm:w-auto" data-test="update-password-button">{{ __('حفظ') }}</flux:button>
            </div>

            <x-action-message class="me-3 text-sm text-green-600 font-medium" on="password-updated">
                {{ __('تم تحديث كلمة المرور.') }}
            </x-action-message>
        </div>
    </form>

    @if ($canManageTwoFactor)
        <hr class="my-8 border-gray-100">
        
        <section class="mt-6">
            <flux:heading>{{ __('التحقق بخطوتين') }}</flux:heading>
            <flux:subheading>{{ __('قم بإدارة إعدادات المصادقة الثنائية لحماية حسابك') }}</flux:subheading>

            <div class="flex flex-col w-full mx-auto space-y-6 text-sm mt-4" wire:cloak>
                @if ($twoFactorEnabled)
                    <div class="space-y-4">
                        <flux:text>
                            {{ __('سيتم مطالبتك برمز تحقق إضافي في كل مرة تحاول فيها تسجيل الدخول. يمكنك الحصول عليه من تطبيق المصادقة لديك.') }}
                        </flux:text>

                        <div class="flex justify-start">
                            <flux:button
                                variant="danger"
                                wire:click="disable"
                            >
                                {{ __('تعطيل التحقق بخطوتين') }}
                            </flux:button>
                        </div>

                        <livewire:settings.two-factor.recovery-codes :$requiresConfirmation/>
                    </div>
                @else
                    <div class="space-y-4">
                        <flux:text variant="subtle">
                            {{ __('عند تفعيل التحقق بخطوتين، سيتم مطالبتك برقم تعريف آمن عند تسجيل الدخول، مما يشكل طبقة حماية إضافية لك.') }}
                        </flux:text>

                        <flux:button
                            variant="primary"
                            wire:click="enable"
                        >
                            {{ __('تفعيل التحقق بخطوتين') }}
                        </flux:button>
                    </div>
                @endif
            </div>
        </section>

        <!-- Modals for 2FA as they were -->
        <flux:modal
            name="two-factor-setup-modal"
            class="max-w-md md:min-w-md"
            @close="closeModal"
            wire:model="showModal"
        >
            <div class="space-y-6">
                <div class="flex flex-col items-center space-y-4">
                    <div class="p-0.5 w-auto rounded-full border border-stone-100 dark:border-stone-600 bg-white dark:bg-stone-800 shadow-sm">
                        <div class="p-2.5 rounded-full border border-stone-200 dark:border-stone-600 overflow-hidden bg-stone-100 dark:bg-stone-200 relative">
                            <div class="flex items-stretch absolute inset-0 w-full h-full divide-x [&>div]:flex-1 divide-stone-200 dark:divide-stone-300 justify-around opacity-50">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div></div>
                                @endfor
                            </div>

                            <div class="flex flex-col items-stretch absolute w-full h-full divide-y [&>div]:flex-1 inset-0 divide-stone-200 dark:divide-stone-300 justify-around opacity-50">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div></div>
                                @endfor
                            </div>

                            <flux:icon.qr-code class="relative z-20 dark:text-accent-foreground"/>
                        </div>
                    </div>

                    <div class="space-y-2 text-center">
                        <flux:heading size="lg">{{ $this->modalConfig['title'] }}</flux:heading>
                        <flux:text>{{ $this->modalConfig['description'] }}</flux:text>
                    </div>
                </div>

                @if ($showVerificationStep)
                    <div class="space-y-6">
                        <div class="flex flex-col items-center space-y-3 justify-center text-left" dir="ltr">
                            <flux:otp
                                name="code"
                                wire:model="code"
                                length="6"
                                label="OTP Code"
                                label:sr-only
                                class="mx-auto"
                            />
                        </div>

                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <flux:button
                                variant="outline"
                                class="flex-1"
                                wire:click="resetVerification"
                            >
                                {{ __('رجوع') }}
                            </flux:button>

                            <flux:button
                                variant="primary"
                                class="flex-1"
                                wire:click="confirmTwoFactor"
                                x-bind:disabled="$wire.code.length < 6"
                            >
                                {{ __('تأكيد') }}
                            </flux:button>
                        </div>
                    </div>
                @else
                    @error('setupData')
                        <flux:callout variant="danger" icon="x-circle" heading="{{ $message }}"/>
                    @enderror

                    <div class="flex justify-center">
                        <div class="relative w-64 overflow-hidden border rounded-lg border-stone-200 dark:border-stone-700 aspect-square">
                            @empty($qrCodeSvg)
                                <div class="absolute inset-0 flex items-center justify-center bg-white dark:bg-stone-700 animate-pulse">
                                    <flux:icon.loading/>
                                </div>
                            @else
                            <div x-data class="flex items-center justify-center h-full p-4">
                                <div
                                    class="bg-white p-3 rounded"
                                    :style="($flux.appearance === 'dark' || ($flux.appearance === 'system' && $flux.dark)) ? 'filter: invert(1) brightness(1.5)' : ''"
                                >
                                        {!! $qrCodeSvg !!}
                                    </div>
                                </div>
                            @endempty
                        </div>
                    </div>

                    <div>
                        <flux:button
                            :disabled="$errors->has('setupData')"
                            variant="primary"
                            class="w-full"
                            wire:click="showVerificationIfNecessary"
                        >
                            {{ $this->modalConfig['buttonText'] }}
                        </flux:button>
                    </div>

                    <div class="space-y-4">
                        <div class="relative flex items-center justify-center w-full">
                            <div class="absolute inset-0 w-full h-px top-1/2 bg-stone-200 dark:bg-stone-600"></div>
                            <span class="relative px-2 text-sm bg-white dark:bg-stone-800 text-stone-600 dark:text-stone-400">
                                {{ __('أو ادخل الرمز يدوياً') }}
                            </span>
                        </div>

                        <div
                            class="flex items-center space-x-2 rtl:space-x-reverse"
                            x-data="{
                                copied: false,
                                async copy() {
                                    try {
                                        await navigator.clipboard.writeText('{{ $manualSetupKey }}');
                                        this.copied = true;
                                        setTimeout(() => this.copied = false, 1500);
                                    } catch (e) {
                                        console.warn('Could not copy to clipboard');
                                    }
                                }
                            }"
                        >
                            <div class="flex items-stretch w-full border rounded-xl dark:border-stone-700" dir="ltr">
                                @empty($manualSetupKey)
                                    <div class="flex items-center justify-center w-full p-3 bg-stone-100 dark:bg-stone-700">
                                        <flux:icon.loading variant="mini"/>
                                    </div>
                                @else
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $manualSetupKey }}"
                                        class="w-full p-3 bg-transparent outline-none text-stone-900 dark:text-stone-100 text-center tracking-widest font-mono"
                                    />

                                    <button
                                        @click="copy()"
                                        class="px-3 transition-colors border-l cursor-pointer border-stone-200 dark:border-stone-600"
                                    >
                                        <flux:icon.document-duplicate x-show="!copied" variant="outline"></flux:icon>
                                        <flux:icon.check
                                            x-show="copied"
                                            variant="solid"
                                            class="text-green-500"
                                        ></flux:icon>
                                    </button>
                                @endempty
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </flux:modal>
    @endif
</div>
