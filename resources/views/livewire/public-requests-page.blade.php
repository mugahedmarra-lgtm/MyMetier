<div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col lg:flex-row gap-8">
        
        <!-- Filters Sidebar -->
        <aside class="w-full lg:w-1/4 shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:sticky lg:top-24">
                <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                    </svg>
                    تصفية الطلبات
                </h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">كلمة البحث</label>
                        <div class="relative">
                            <input wire:model.live.debounce.300ms="search" type="text" placeholder="ابحث في عناوين الطلبات..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400 absolute left-3 top-3.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">التصنيف المهني</label>
                        <select wire:model.live="categoryId" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition text-sm appearance-none">
                            <option value="">جميع التصنيفات</option>
                            @foreach($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المحافظة</label>
                        <select wire:model.live="cityId" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition text-sm appearance-none">
                            <option value="">جميع المحافظات</option>
                            @foreach($cities as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Requests Feed -->
        <section class="flex-1 space-y-4">
            @if (session()->has('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="relative min-h-[300px]">
                <div wire:loading.delay wire:target="search, categoryId, cityId, gotoPage, previousPage, nextPage" class="absolute inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm rounded-2xl">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-indigo-900 font-semibold text-lg">جاري التحميل...</span>
                    </div>
                </div>

            @if($requests->isEmpty())
                <div wire:loading.class="invisible" class="bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm p-16 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">لا توجد بيانات</h3>
                    <p class="text-gray-500 mb-6">لم يتم العثور على نتائج، حاول تغيير الفلاتر أو إضافة بيانات جديدة</p>
                    <button wire:click="$set('search', ''); $set('categoryId', ''); $set('cityId', '')" class="text-indigo-600 font-bold hover:text-indigo-800 transition">إعادة ضبط التصفية</button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" wire:loading.class="invisible">
                    @foreach($requests as $req)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col hover:shadow-md transition group relative">
                            <!-- Link Overlay -->
                            <a href="{{ route('requests.show', $req->id) }}" class="absolute inset-0 z-10 w-full h-full"></a>

                            <div class="flex justify-between items-start mb-4">
                                <h3 class="font-bold text-gray-900 text-lg group-hover:text-indigo-600 transition truncate w-full pl-4" title="{{ $req->title }}">{{ $req->title }}</h3>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 mb-6 text-sm text-gray-600 font-medium">
                                <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg border border-indigo-100">{{ optional($req->category)->name }}</span>
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg border border-gray-200">{{ optional($req->city)->name }}</span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between text-sm">
                                <span class="text-gray-400 flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $req->created_at->diffForHumans() }}
                                </span>
                                <span class="text-indigo-600 font-bold flex items-center gap-1 group-hover:translate-x-1 transform transition">
                                    التفاصيل
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-4" wire:loading.class="invisible">
                    {{ $requests->links() }}
                </div>
            @endif
            </div>
        </section>
</div>
