<div class="min-h-screen bg-white">


    <main>
        <!-- Hero section -->
        <div class="relative isolate pt-14">
            <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                    <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
                </svg>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
            </svg>
            <div class="py-24 sm:py-32 lg:pb-40">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-3xl text-center">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-6xl mb-6">
                            ابحث عن مهني قريب منك
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 mb-10">
                            منصة تجمعك بأفضل المهنيين والحرفيين الموثوقين في محافظتك لإنجاز أعمالك بسهولة وبأعلى جودة.
                        </p>

                        <!-- Search Form -->
                        <div class="bg-white p-3 rounded-2xl shadow-xl border border-gray-100 flex flex-col md:flex-row gap-3 relative z-20">
                            
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.492-3.053c.204-.25.316-.54.331-.867L15 4h-2m-3 11.17l-3.053 2.492c-.25.204-.54.316-.867.331L4 15v-2m11.17-3l2.492-3.053c.204-.25.316-.54.331-.867L15 4h-2M4.83 8.83l3.053-2.492c.25-.204.54-.316.867-.331L15 4h-2" />
                                    </svg>
                                </div>
                                <select wire:model="categoryId" class="w-full text-right appearance-none bg-gray-50 border border-gray-100 text-gray-900 rounded-xl pr-11 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm">
                                    <option value="">جميع التخصصات</option>
                                    @foreach($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                                <select wire:model.live="cityId" class="w-full text-right appearance-none bg-gray-50 border border-gray-100 text-gray-900 rounded-xl pr-11 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm">
                                    <option value="">جميع المحافظات</option>
                                    @foreach($this->cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                                    </svg>
                                </div>
                                <select wire:model="districtId" @if(empty($cityId)) disabled @endif class="w-full text-right appearance-none disabled:opacity-50 disabled:bg-gray-100 bg-gray-50 border border-gray-100 text-gray-900 rounded-xl pr-11 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm cursor-pointer disabled:cursor-not-allowed">
                                    <option value="">جميع المديريات</option>
                                    @foreach($this->districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button wire:click="search" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-sm shadow-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                <span>بحث</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Professionals Section -->
        @if(count($this->featuredProfessionals) > 0)
        <div class="bg-indigo-50 py-16 sm:py-24 border-y border-indigo-100">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 flex items-center gap-3">
                            <span class="text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </span>
                            المميزون
                        </h2>
                        <p class="mt-2 text-gray-600">نخبة من أفضل المهنيين المستعدين لخدمتك</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-right">
                    @foreach($this->featuredProfessionals as $profile)
                        <a href="{{ route('profile.show', $profile['id']) }}" class="bg-white rounded-2xl shadow-sm border border-indigo-200 p-6 flex flex-col hover:shadow-xl hover:-translate-y-1 transition duration-300 relative group overflow-hidden">
                            <!-- Featured Badge -->
                            <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1.5 rounded-bl-lg z-10 shadow-sm flex items-center gap-1">
                                مميز ⭐
                            </div>
                            
                            <div class="flex items-center gap-4 mb-4 mt-2">
                                <div class="w-14 h-14 bg-indigo-50 border border-indigo-200 rounded-full flex items-center justify-center text-indigo-600 font-bold text-xl shrink-0 shadow-inner">
                                    {{ mb_substr($profile['display_name'], 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $profile['display_name'] }}</h3>
                                    <p class="text-sm text-indigo-600 font-medium">{{ $profile['category_name'] }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-gray-50 flex items-baseline justify-between">
                                <div class="flex items-center text-sm text-gray-500 gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $profile['city_name'] }}
                                </div>
                                <div class="flex items-center gap-1 bg-yellow-50 px-2 py-1 rounded-md border border-yellow-200">
                                    <span class="text-sm font-bold text-yellow-700">{{ number_format($profile['rating_avg'], 1) }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Categories Section -->
        <div class="bg-gray-50 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">التصنيفات</h2>
                    <p class="mt-4 text-lg leading-8 text-gray-600">اختر نوع الخدمة التي تبحث عنها بكل سهولة</p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-2 gap-x-8 gap-y-10 sm:grid-cols-3 lg:mx-0 lg:max-w-none lg:grid-cols-6 pl-4 pr-4">
                    @foreach($this->categories as $category)
                        <a href="/search?category={{ $category->id }}" class="group flex flex-col items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-indigo-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 mb-4 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm border border-indigo-100">
                                @if($category->icon)
                                    <span class="w-8 h-8 flex items-center justify-center {!! str_contains($category->icon, '<svg') ? '' : 'text-3xl' !!}">{!! $category->icon !!}</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 text-center">{{ $category->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Popular Section Placeholder -->
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-4">الأكثر طلباً</h2>
                <p class="mt-4 text-lg leading-8 text-gray-600 mb-16">أفضل المهنيين المقيّمين من قبل العملاء</p>
                
                @if(count($this->popularProfessionals) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-right">
                        @foreach($this->popularProfessionals as $profile)
                            <a href="{{ route('profile.show', $profile['id']) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-xl hover:-translate-y-1 transition duration-300 relative group overflow-hidden">
                                <!-- Badge -->
                                @if($profile['is_featured'] ?? false)
                                <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1.5 rounded-bl-lg z-10 shadow-sm flex items-center gap-1">
                                    مميز ⭐
                                </div>
                                @else
                                <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-4 py-1.5 rounded-bl-lg z-10 shadow-sm">
                                    الأكثر طلبًا
                                </div>
                                @endif
                                
                                <div class="flex items-center gap-4 mb-4 mt-2">
                                    <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center text-indigo-500 font-bold text-xl shrink-0">
                                        {{ mb_substr($profile['display_name'], 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $profile['display_name'] }}</h3>
                                        <p class="text-sm text-indigo-600">{{ $profile['category_name'] }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-auto pt-4 border-t border-gray-50 flex items-baseline justify-between">
                                    <div class="flex items-center text-sm text-gray-500 gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $profile['city_name'] }}
                                    </div>
                                    <div class="flex items-center gap-1 bg-yellow-50 px-2 py-1 rounded-md border border-yellow-100">
                                        <span class="text-sm font-bold text-yellow-700">{{ number_format($profile['rating_avg'], 1) }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-3xl p-12 border border-gray-200 text-gray-500 flex flex-col items-center justify-center min-h-[300px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-medium text-lg">لم يتم العثور على مهنيين مميزين في الوقت الحالي</span>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 space-x-reverse md:order-2">
                <span class="text-gray-400 font-medium">MyMetier</span>
            </div>
            <div class="mt-8 md:order-1 md:mt-0">
                <p class="text-center text-xs leading-5 text-gray-500">&copy; {{ date('Y') }} MyMetier. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>
</div>
