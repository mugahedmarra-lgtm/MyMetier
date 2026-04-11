<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">إعدادات الحساب</h1>
        <p class="mt-2 text-sm text-gray-500">إدارة معلوماتك الشخصية والأمان.</p>
    </div>

    <!-- Profile Info -->
    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-900">المعلومات الأساسية</h2>
            <p class="mt-1 text-sm text-gray-500">تحديث اسمك ورقم هاتفك.</p>
        </div>
        <div class="p-6">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.profile', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3488802574-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
        </div>
    </div>

    <!-- Security Info -->
    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-900">كلمة المرور والأمان</h2>
            <p class="mt-1 text-sm text-gray-500">تأكد من استخدام كلمة مرور قوية لحماية حسابك وتفعيل التحقق بخطوتين.</p>
        </div>
        <div class="p-6">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.security', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3488802574-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Mugahed\Desktop\MyMetier\resources\views/livewire/settings-page.blade.php ENDPATH**/ ?>