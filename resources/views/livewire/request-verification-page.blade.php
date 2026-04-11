<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-20" dir="rtl">

        {{-- Flash Messages --}}
        @if(session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                <p class="font-bold">{{ session('error') }}</p>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- CASE 1: Already Verified --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @if($isVerified)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center max-w-xl mx-auto">
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-green-500">
                        <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">حسابك موثّق بالفعل</h2>
                <p class="text-gray-500 mb-6">يظهر شارة التوثيق على ملفك المهني في نتائج البحث والصفحة الشخصية.</p>
                <a href="{{ route('pro.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-sm inline-block">
                    العودة للوحة التحكم
                </a>
            </div>

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- CASE 2: Pending Review --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @elseif($hasPending)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center max-w-xl mx-auto">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">طلب التوثيق قيد المراجعة</h2>
                <p class="text-gray-500 mb-2">تم إرسال طلبك بتاريخ {{ $latestRequest->submitted_at->format('Y/m/d - H:i') }}</p>
                <p class="text-gray-400 text-sm mb-6">سيتم إشعارك فور اتخاذ قرار من الإدارة.</p>
                <a href="{{ route('pro.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-sm inline-block">
                    العودة للوحة التحكم
                </a>
            </div>

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- CASE 3: Rejected (allow resubmission) --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @elseif($latestRequest && $latestRequest->status === 'rejected' && $isEligible)
            {{-- Show rejection reason banner --}}
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <div>
                    <h3 class="font-bold text-amber-900 mb-0.5">تم رفض طلب التوثيق السابق</h3>
                    <p class="text-sm text-amber-700 mb-1">السبب: {{ $latestRequest->admin_notes }}</p>
                    <p class="text-xs text-amber-600">يمكنك تصحيح المستندات وإعادة الإرسال أدناه.</p>
                </div>
            </div>

            {{-- Show the submission form (reuse below) --}}
            @include('livewire.partials.verification-form')

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- CASE 4: Eligible — Fresh Request --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @elseif($isEligible)
            @include('livewire.partials.verification-form')

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- CASE 5: Not eligible (e.g. profile not active) --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @else
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center max-w-xl mx-auto">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">لا يمكنك طلب التوثيق حالياً</h2>
                <p class="text-gray-500 mb-6">يجب أن يكون ملفك المهني فعّالاً (معتمداً) قبل طلب التوثيق.</p>
                <a href="{{ route('pro.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-sm inline-block">
                    العودة للوحة التحكم
                </a>
            </div>
        @endif

</div>
