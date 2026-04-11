<div class="min-h-screen bg-gray-50">


    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        {{-- Page Title --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">نتائج البحث</h1>
            <p class="mt-1 text-sm text-gray-500">ابحث عن المهنيين والحرفيين المتاحين</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ===== LEFT: Filters Sidebar ===== --}}
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">تصفية</h2>
                        @if($this->search || $this->category_id || $this->city_id || $this->district_id || $this->availability_status || $this->sort !== 'best')
                            <button wire:click="clearFilters" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">
                                مسح الفلاتر
                            </button>
                        @endif
                    </div>

                    {{-- Search Input --}}
                    <div class="mb-5 relative">
                        <label for="search-input" class="block text-sm font-medium text-gray-700 mb-2">بحث بالاسم</label>
                        <div class="relative">
                            <input type="text" id="search-input" wire:model.live.debounce.300ms="search" placeholder="ابحث عن حرفي أو مهني..." class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 pr-10 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div class="mb-5">
                        <label for="filter-category" class="block text-sm font-medium text-gray-700 mb-2">التخصص</label>
                        <select id="filter-category" wire:model.live.debounce.300ms="category_id"
                            class="w-full text-right appearance-none bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">جميع التخصصات</option>
                            @foreach($this->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- City Filter --}}
                    <div class="mb-5">
                        <label for="filter-city" class="block text-sm font-medium text-gray-700 mb-2">المحافظة</label>
                        <select id="filter-city" wire:model.live.debounce.300ms="city_id"
                            class="w-full text-right appearance-none bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">جميع المحافظات</option>
                            @foreach($this->cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- District Filter --}}
                    <div class="mb-5">
                        <label for="filter-district" class="block text-sm font-medium text-gray-700 mb-2">المديرية</label>
                        <select id="filter-district" wire:model.live.debounce.300ms="district_id"
                            @if(empty($this->city_id)) disabled @endif
                            class="w-full text-right appearance-none bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition disabled:opacity-50 disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">جميع المديريات</option>
                            @foreach($this->districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Availability Filter --}}
                    <div>
                        <label for="filter-availability" class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                        <select id="filter-availability" wire:model.live="availability_status"
                            class="w-full text-right appearance-none bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">الكل</option>
                            <option value="available">متاح</option>
                            <option value="busy">مشغول</option>
                        </select>
                    </div>

                    {{-- Sort Filter --}}
                    <div class="mt-5">
                        <label for="filter-sort" class="block text-sm font-medium text-gray-700 mb-2">ترتيب حسب</label>
                        <select id="filter-sort" wire:model.live="sort"
                            class="w-full text-right appearance-none bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="best">الأفضل</option>
                            <option value="highest_rated">الأعلى تقييم</option>
                            <option value="newest">الأحدث</option>
                        </select>
                    </div>
                </div>
            </aside>

            {{-- ===== RIGHT: Results Grid ===== --}}
            <div class="flex-1">
                {{-- Results Count --}}
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-gray-500">
                        تم العثور على <span class="font-semibold text-gray-900">{{ $this->results->total() }}</span> نتيجة
                    </p>
                    <div wire:loading class="flex items-center gap-2 text-sm text-indigo-600">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        جاري التحميل...
                    </div>
                </div>

                <div class="relative min-h-[300px]">
                    <div wire:loading.delay wire:target="search, category_id, city_id, district_id, availability_status, sort, gotoPage, previousPage, nextPage" class="absolute inset-0 z-50 bg-white/90 backdrop-blur-sm rounded-2xl transition-opacity">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 p-2">
                            @for ($i = 0; $i < 6; $i++)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full animate-pulse">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="h-5 bg-gray-200 rounded w-3/4 mb-2"></div>
                                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                    </div>
                                    <div class="h-6 w-16 bg-gray-200 rounded-full"></div>
                                </div>
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="h-4 w-4 bg-gray-200 rounded-full"></div>
                                    <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                                </div>
                                <div class="flex items-center gap-1.5 mb-6">
                                    <div class="h-4 bg-gray-200 rounded w-24"></div>
                                </div>
                                <div class="flex items-center justify-between mt-auto pt-5 border-t border-gray-100">
                                    <div class="h-6 w-20 bg-gray-200 rounded-full"></div>
                                    <div class="h-10 w-24 bg-gray-200 rounded-xl"></div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                @if($this->results->count() > 0)
                    <div wire:loading.class="invisible" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach($this->results as $profile)
                            <div wire:key="profile-{{ $profile->id }}" class="bg-white rounded-2xl shadow-md border border-gray-100 hover:shadow-xl hover:border-indigo-100 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full relative">
                                @if($profile->isFeatured())
                                <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1.5 rounded-bl-lg z-10 shadow-sm flex items-center gap-1">
                                    مميز ⭐
                                </div>
                                @endif
                                <div class="p-6 flex flex-col flex-1">
                                    {{-- Header: Avatar + Name + Verification --}}
                                    <div class="flex items-start justify-between mb-4 gap-4">
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            {{-- Avatar --}}
                                            <div class="flex-shrink-0 w-12 h-12 rounded-full overflow-hidden bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                                                @if($profile->user?->avatar)
                                                    <img src="{{ Storage::url($profile->user->avatar) }}" alt="{{ $profile->display_name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-lg font-bold text-indigo-600">{{ mb_substr($profile->display_name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            {{-- Name & Category --}}
                                            <div class="min-w-0">
                                                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $profile->display_name }}</h3>
                                                <p class="text-sm text-gray-500 mt-0.5">{{ $profile->category?->name ?? '—' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($profile->isVerified())
                                                <span class="flex-shrink-0 inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 border border-blue-100 shadow-sm">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    موثق
                                                </span>
                                            @endif
                                            
                                            <!-- Favorite Action -->
                                            <button wire:click.prevent="toggleFavorite({{ $profile->id }})" class="mr-2 p-1.5 rounded-full hover:bg-red-50 text-gray-400 hover:text-red-500 transition duration-300 focus:outline-none flex-shrink-0 relative group" title="أضف للمفضلة" wire:loading.attr="disabled">
                                                @if(in_array($profile->id, $this->favoritedProfileIds))
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-500 group-hover:scale-110 transition-transform">
                                                      <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                    </svg>
                                                @endif
                                                <span wire:loading wire:target="toggleFavorite({{ $profile->id }})" class="absolute inset-0 flex items-center justify-center bg-white/80 rounded-full">
                                                    <svg class="animate-spin h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Location --}}
                                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                        <span class="truncate">{{ $profile->city?->name ?? '—' }}</span>
                                    </div>

                                    {{-- Rating --}}
                                    <div class="flex items-center gap-1.5 mb-4">
                                        <div class="flex items-center gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= round($profile->rating_avg ?? 0) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm font-bold text-gray-700">{{ number_format($profile->rating_avg ?? 0, 1) }}</span>
                                    </div>

                                    {{-- Short Bio --}}
                                    @if($profile->description)
                                        <p class="text-sm text-gray-600 mb-6 line-clamp-2 leading-relaxed">
                                            {{ \Illuminate\Support\Str::limit($profile->description, 100) }}
                                        </p>
                                    @else
                                        <div class="mb-6"></div>
                                    @endif

                                    {{-- Footer: Availability + Action --}}
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-auto pt-5 border-t border-gray-100 gap-4 sm:gap-0">
                                        <div class="flex items-center">
                                            @if($profile->availability_status === 'available')
                                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 rounded-full px-3 py-1.5 border border-emerald-100">
                                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse outline outline-2 outline-emerald-100"></span>
                                                    متاح
                                                </span>
                                            @elseif($profile->availability_status === 'busy')
                                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-50 rounded-full px-3 py-1.5 border border-amber-100">
                                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                    مشغول
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-700 bg-gray-50 rounded-full px-3 py-1.5 border border-gray-200">
                                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                                    غير متاح
                                                </span>
                                            @endif
                                        </div>

                                        <a href="{{ route('profile.show', $profile->id) }}"
                                           class="inline-flex items-center justify-center gap-1.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 rounded-xl transition shadow-md w-full sm:w-auto">
                                            عرض الملف
                                            <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8" wire:loading.class="invisible">
                        {{ $this->results->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div wire:loading.class="invisible" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                        <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">لا يوجد نتائج، جرب تغيير الفلاتر</h3>
                        <div class="text-gray-500 text-sm mb-6 flex flex-wrap justify-center gap-2">
                            <span>اقتراحات:</span>
                            <button wire:click="$set('city_id', null)" class="text-indigo-600 hover:underline">تغيير المحافظة</button>
                            <span>|</span>
                            <button wire:click="clearFilters" class="text-indigo-600 hover:underline">إزالة الفلتر</button>
                            <span>|</span>
                            <button wire:click="$set('search', '')" class="text-indigo-600 hover:underline">البحث العام</button>
                        </div>
                        <button wire:click="clearFilters" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-indigo-700 transition transform hover:-translate-y-0.5">
                            مسح الفلاتر
                        </button>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 space-x-reverse md:order-2">
                <span class="text-gray-400 font-medium">MyMetier</span>
            </div>
            <div class="mt-8 md:order-1 md:mt-0">
                <p class="text-center text-xs leading-5 text-gray-500">&copy; {{ date('Y') }} MyMetier. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('scroll-to-top', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    @endscript
</div>
