<div class="max-w-3xl w-full mx-auto px-4 sm:px-6 py-8">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>

        <div class="mb-8 text-center relative z-10">
            <h2 class="text-3xl font-extrabold text-gray-900">ما الذي تبحث عنه؟</h2>
            <p class="mt-2 text-gray-500 text-sm">قم بوصف المشكلة أو المشروع الذي تريد إنجازه وسيتواصل معك مهنيون متخصصون</p>
        </div>

        <form wire:submit="save" class="space-y-6 relative z-10">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الطلب</label>
                <input wire:model="title" type="text" placeholder="مثال: أحتاج سباك لإصلاح تسريب مياه عاجل" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition shadow-sm placeholder-gray-400">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف</label>
                    <select wire:model="categoryId" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition shadow-sm appearance-none cursor-pointer">
                        <option value="">اختر التصنيف</option>
                        @foreach($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                    </select>
                    @error('categoryId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">المحافظة</label>
                    <select wire:model.live="cityId" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition shadow-sm appearance-none cursor-pointer">
                        <option value="">اختر المحافظة</option>
                        @foreach($cities as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                    </select>
                    @error('cityId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">المديرية</label>
                    <select wire:model="districtId" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition shadow-sm appearance-none cursor-pointer">
                        <option value="">اختر المديرية</option>
                        @foreach($districts as $d) <option value="{{ $d->id }}">{{ $d->name }}</option> @endforeach
                    </select>
                    @error('districtId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تفاصيل الطلب بوضوح</label>
                <textarea wire:model="description" required rows="5" placeholder="قم بوصف المشكلة بدقة حتى يتسنى للمهني تقديم الحل والعرض الأنسب..." class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition shadow-sm placeholder-gray-400"></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-3.5 px-10 rounded-xl transition shadow-md flex items-center justify-center gap-2 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">نشر الطلب</span>
                    <span wire:loading wire:target="save">جاري التنفيذ...</span>
                </button>
            </div>

        </form>
    </div>
</div>
