{{-- Verification Document Upload Form (partial) --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 md:p-8">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
        <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-600">
                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900">طلب توثيق الحساب</h2>
            <p class="text-sm text-gray-500">أرفق المستندات المطلوبة للتحقق من هويتك المهنية.</p>
        </div>
    </div>

    {{-- What verification means --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mb-6">
        <h3 class="font-bold text-indigo-900 text-sm mb-2">ماذا يعني التوثيق؟</h3>
        <ul class="text-sm text-indigo-700 space-y-1">
            <li class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-indigo-500 mt-0.5 flex-shrink-0"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                شارة "موثّق" تظهر على ملفك في البحث والصفحة الشخصية
            </li>
            <li class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-indigo-500 mt-0.5 flex-shrink-0"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                تعزيز ثقة العملاء وترتيب أعلى في نتائج البحث
            </li>
            <li class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-indigo-500 mt-0.5 flex-shrink-0"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                مستنداتك محمية ولا يطلع عليها إلا الإدارة
            </li>
            <li class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-indigo-500 mt-0.5 flex-shrink-0"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                زيادة الحد الأقصى للصور في معرض الأعمال إلى 10 صور بدلاً من 3
            </li>
        </ul>
    </div>

    {{-- Pricing and Bank Instructions --}}
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
        <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
            <div>
                <h3 class="font-bold text-gray-900">رسوم التوثيق</h3>
                <p class="text-sm text-gray-500">تدفع لمرة واحدة فقط</p>
            </div>
            <div class="text-left">
                <span class="text-2xl font-black text-indigo-600">{{ number_format(config('verification.price', 5000)) }}</span>
                <span class="text-gray-500 font-medium">{{ config('verification.currency', 'ريال يمني') }}</span>
            </div>
        </div>
        
        <h4 class="font-bold text-gray-800 text-sm mb-3">حسابات التحويل المعتمدة:</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach(config('verification.bank_accounts', []) as $bank => $account)
            <div class="bg-white border border-gray-100 rounded-lg p-3 flex justify-between items-center shadow-sm">
                <span class="font-bold text-gray-700">{{ $bank }}</span>
                <span class="text-indigo-600 font-bold font-mono bg-indigo-50 px-2 py-1 rounded">{{ $account }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <form wire:submit="submit" class="space-y-6">

        {{-- Dedicated Payment Proof Section --}}
        <div class="bg-indigo-50 border-2 border-indigo-100 rounded-xl p-5">
            <h3 class="font-bold text-indigo-900 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-600">
                    <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                </svg>
                إيصال التحويل <span class="text-red-500">*</span>
            </h3>
            <p class="text-sm text-indigo-700 mb-4">يرجى إرفاق صورة واضحة لإيصال التحويل البنكي لرسوم التوثيق.</p>
            
            <div class="relative">
                <input type="file" wire:model="paymentProof" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-white file:text-indigo-700 hover:file:bg-indigo-100 border border-indigo-200 rounded-xl py-1.5 px-2 bg-indigo-50">
                <div wire:loading wire:target="paymentProof" class="text-sm text-indigo-600 font-bold mt-1">جاري المعالجة...</div>
            </div>
            @error("paymentProof") <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Document Rows --}}
        @foreach($documentRows as $index => $row)
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 relative" wire:key="doc-row-{{ $index }}">
                {{-- Remove button --}}
                @if(count($documentRows) > 1)
                    <button type="button" wire:click="removeDocumentRow({{ $index }})" class="absolute top-3 left-3 text-gray-400 hover:text-red-500 transition" title="حذف هذا المستند">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Document Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع المستند <span class="text-red-500">*</span></label>
                        <select wire:model="documentRows.{{ $index }}.type" class="w-full text-right bg-white border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                            <option value="">اختر نوع المستند</option>
                            <option value="commercial_register">السجل التجاري</option>
                            <option value="vocational_license">رخصة مهنية</option>
                            <option value="national_id">الهوية الوطنية</option>
                            <option value="other">أخرى</option>
                        </select>
                        @error("documentRows.{$index}.type") <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- File Upload --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">صورة المستند <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="file" wire:model="documentRows.{{ $index }}.file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-xl py-1.5 px-2 bg-white">
                            <div wire:loading wire:target="documentRows.{{ $index }}.file" class="text-sm text-indigo-600 font-bold mt-1">جاري المعالجة...</div>
                        </div>
                        @error("documentRows.{$index}.file") <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Add more documents --}}
        @if(count($documentRows) < 5)
            <button type="button" wire:click="addDocumentRow" class="w-full border-2 border-dashed border-gray-300 hover:border-indigo-400 rounded-xl py-3 text-sm font-bold text-gray-500 hover:text-indigo-600 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                إضافة مستند آخر
            </button>
        @endif

        {{-- Submit --}}
        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" wire:loading.attr="disabled" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md w-full sm:w-auto flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="submit">إرسال طلب التوثيق</span>
                <span wire:loading wire:target="submit">جاري الإرسال...</span>
            </button>
        </div>
    </form>
</div>
