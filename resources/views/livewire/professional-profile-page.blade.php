<div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        @if (session()->has('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-down">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-down">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
        @endif

        {{-- ===== 2-COLUMN GRID ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ===== LEFT SIDE (MAIN CONTENT — col-span-2) ===== --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- PROFILE HEADER CARD --}}
                <div class="bg-white rounded-xl shadow-sm p-6 relative overflow-hidden">
                    <!-- Decorative Background blob -->
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                    <div class="flex flex-col sm:flex-row gap-6 relative z-10">

                        <!-- Avatar block -->
                        <div class="flex flex-col items-center shrink-0">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 bg-gradient-to-tr from-indigo-100 to-white border-2 border-indigo-200 rounded-full flex items-center justify-center shadow-lg shadow-indigo-100/50 mb-3">
                                <span class="text-3xl sm:text-4xl font-bold text-indigo-600">
                                    {{ mb_substr($profile->display_name, 0, 1) }}
                                </span>
                            </div>

                            @if($profile->verification_status === 'verified')
                                <div class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm flex items-center gap-1.5 -mt-5 border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                    </svg>
                                    ✔ حساب موثّق
                                </div>
                            @elseif($profile->verification_status === 'unverified')
                                <div class="bg-gray-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm flex items-center gap-1.5 -mt-5 border-2 border-white">
                                    غير موثق
                                </div>
                            @endif
                        </div>

                        <!-- Info Block -->
                        <div class="flex-1 text-center sm:text-right">
                            <div class="flex items-center justify-center sm:justify-start gap-3 mb-2 flex-wrap">
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">{{ $profile->display_name }}</h1>
                                @if($profile->isFeatured())
                                    <span class="inline-flex items-center gap-1 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                        مميز ⭐
                                    </span>
                                @endif
                                <!-- Favorite Heart Button -->
                                <button wire:click.prevent="toggleFavorite" class="p-2 rounded-full hover:bg-red-50 text-gray-400 hover:text-red-500 transition duration-300 focus:outline-none flex-shrink-0 relative group" title="المفضلة" wire:loading.attr="disabled">
                                    @if($isFavorited)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-red-500 group-hover:scale-110 transition-transform">
                                          <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 group-hover:scale-110 transition-transform">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    @endif
                                    <!-- Spinner layer -->
                                    <span wire:loading wire:target="toggleFavorite" class="absolute inset-0 flex items-center justify-center bg-white/80 rounded-full">
                                        <svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>

                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 text-gray-600 font-medium mb-3">
                                <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-sm">{{ optional($profile->category)->name }}</span>
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center gap-1 text-sm bg-gray-50 px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-400">
                                      <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ optional($profile->city)->name }}{{ $profile->district ? ' ، ' . optional($profile->district)->name : '' }}
                                </span>
                            </div>

                            <!-- Inline rating + availability -->
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                                <div class="flex items-center gap-1.5">
                                    <div class="flex items-center text-amber-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                          <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-900">{{ number_format($profile->rating_avg, 1) }}</span>
                                    <a href="#reviews" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition underline underline-offset-4">({{ $profile->rating_count }} تقييم)</a>
                                </div>

                                <span class="text-gray-200">|</span>

                                @if($profile->availability_status === 'available')
                                    <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5 animate-pulse"></span> ✔ متاح الآن
                                    </div>
                                @elseif($profile->availability_status === 'busy')
                                    <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-1.5"></span> مشغول
                                    </div>
                                @elseif($profile->availability_status === 'offline' || $profile->availability_status === 'out_of_service')
                                    <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        <span class="w-2 h-2 rounded-full bg-gray-400 mr-1.5"></span> غير متاح
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DESCRIPTION CARD --}}
                @if($profile->description)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        نبذة عن المهني
                    </h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base">
                        {{ $profile->description }}
                    </div>
                </div>
                @endif

                {{-- GALLERY CARD --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        معرض الأعمال
                    </h2>

                    @if($profile->gallery->isNotEmpty())
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($profile->gallery as $image)
                                <div class="aspect-square rounded-xl overflow-hidden bg-gray-50 border border-gray-100 group relative shadow-sm">
                                    <img src="{{ !empty($image->image_path) ? asset('storage/' . $image->image_path) : asset('/images/default-profile.png') }}" alt="{{ $image->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500 cursor-pointer">
                                    @if($image->title)
                                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-3 pt-10 text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition truncate">
                                            {{ $image->title }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <svg class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="font-bold text-gray-900 text-base mb-1">لا يوجد معرض أعمال</h3>
                            <p class="text-gray-500 text-sm">لم يقم المهني بإضافة صور لمعرض أعماله بعد.</p>
                        </div>
                    @endif
                </div>

            </div>
            {{-- END LEFT SIDE --}}

            {{-- ===== RIGHT SIDE (SIDEBAR — col-span-1) ===== --}}
            <div class="space-y-6 lg:sticky lg:top-24 self-start">

                {{-- STATS CARD --}}
                @if(isset($profile->views_count) || isset($profile->reviews_count))
                <div class="bg-white rounded-xl shadow-sm p-4 text-center grid grid-cols-2 divide-x divide-x-reverse divide-gray-100">
                    @if(isset($profile->views_count))
                    <div class="px-2">
                        <div class="text-sm text-gray-500 mb-1">المشاهدات</div>
                        <div class="font-bold text-gray-900">شوهد {{ number_format($profile->views_count) }} مرة</div>
                    </div>
                    @endif
                    @if($profile->rating_count > 0)
                    <div class="px-2">
                        <div class="text-sm text-gray-500 mb-1">التقييمات</div>
                        <div class="font-bold text-gray-900">{{ number_format($profile->rating_count) }} تقييم</div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- WHATSAPP CTA CARD --}}
                @if(!empty($profile->whatsapp_number))
                <div class="bg-white rounded-xl shadow-sm p-4">
                    @auth
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp_number) }}?text={{ urlencode('السلام عليكم، شاهدت ملفك في منصة MyMetier وأحتاج خدمتك.') }}" target="_blank" wire:click="trackWhatsappClick" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition duration-200 shadow-md shadow-green-200 hover:shadow-lg hover:shadow-green-300">
                            <span class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                تواصل عبر واتساب
                            </span>
                        </a>
                        <p class="text-xs text-center text-gray-500 mt-2">سيتم فتح محادثة مباشرة مع المهني</p>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition duration-200 border border-gray-200">
                            <span class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                سجل الدخول للتواصل
                            </span>
                        </a>
                        <p class="text-xs text-center text-gray-500 mt-2">يجب تسجيل الدخول للتواصل عبر واتساب</p>
                    @endauth
                </div>
                @endif

                {{-- MOBILE-ONLY STICKY WHATSAPP --}}
                @if(!empty($profile->whatsapp_number))
                <div class="lg:hidden fixed pb-4 bottom-20 inset-x-4 z-50 pointer-events-none">
                    <div class="pointer-events-auto">
                    @auth
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp_number) }}?text={{ urlencode('السلام عليكم، شاهدت ملفك في منصة MyMetier وأحتاج خدمتك.') }}" target="_blank" wire:click="trackWhatsappClick" class="w-full flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20BE5A] text-white font-bold py-4 rounded-xl transition duration-300 shadow-2xl shadow-green-500/40 text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            تواصل عبر واتساب
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-900 text-white font-bold py-4 rounded-xl transition duration-300 shadow-xl shadow-gray-900/40 text-lg border border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-gray-300">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            سجل الدخول للتواصل
                        </a>
                    @endauth
                    </div>
                </div>
                @endif

                {{-- RATING OVERVIEW CARD --}}
                <div class="bg-indigo-600 rounded-xl shadow-sm p-6 text-white text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-8 -mt-8 pointer-events-none"></div>
                    <div class="absolute bottom-0 right-0 w-20 h-20 bg-indigo-800/20 rounded-full -mr-6 -mb-6 pointer-events-none"></div>

                    <h3 class="text-indigo-100 font-medium mb-3 text-sm">التقييم العام</h3>
                    <div class="text-5xl font-extrabold tracking-tighter mb-2">{{ number_format($profile->rating_avg, 1) }}</div>

                    <div class="flex items-center justify-center gap-0.5 mb-2 text-amber-300">
                        @for($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $i <= round($profile->rating_avg) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" class="w-5 h-5">
                              <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                        @endfor
                    </div>

                    <div class="text-indigo-100/80 font-medium text-sm">بناءً على {{ $profile->rating_count }} تقييم</div>
                </div>

                {{-- REVIEWS CARD --}}
                <div id="reviews" class="bg-white rounded-xl shadow-sm p-6 scroll-mt-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                        التقييمات و الآراء
                    </h2>

                    @auth
                        @if(Auth::id() !== $this->profile->user_id)
                            @if(!$this->hasReviewed)
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6">
                                    <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-indigo-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                        أضف تقييمك
                                    </h3>

                                    <form wire:submit.prevent="submitReview" class="space-y-3">
                                        <!-- Stars selector -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">تقييمك للمهني <span class="text-red-500">*</span></label>
                                            <div class="flex items-center gap-1 flex-row-reverse justify-end w-max" x-data="{ hoverRating: 0 }">
                                                @for($i = 5; $i >= 1; $i--)
                                                    <button type="button"
                                                        wire:click="$set('reviewRating', {{ $i }})"
                                                        @mouseenter="hoverRating = {{ $i }}"
                                                        @mouseleave="hoverRating = 0"
                                                        class="focus:outline-none transition"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            :class="{'text-amber-400': hoverRating >= {{ $i }} || (hoverRating === 0 && $wire.reviewRating >= {{ $i }}), 'text-gray-200': !(hoverRating >= {{ $i }} || (hoverRating === 0 && $wire.reviewRating >= {{ $i }}))}"
                                                            viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 hover:scale-110 transition-transform">
                                                          <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                @endfor
                                            </div>
                                            @error('reviewRating') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Comment textarea -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">تعليقك (اختياري)</label>
                                            <textarea wire:model="reviewComment" rows="2" class="w-full bg-white border border-gray-200 text-gray-900 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="شارك تجربتك مع هذا المهني..."></textarea>
                                            @error('reviewComment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" wire:loading.attr="disabled" class="bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white font-bold py-2 px-5 rounded-lg transition shadow-sm flex items-center gap-2 text-sm">
                                                <span wire:loading.remove wire:target="submitReview">إرسال التقييم</span>
                                                <span wire:loading wire:target="submitReview">جاري الإرسال...</span>
                                                <svg wire:loading wire:target="submitReview" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="bg-indigo-50 rounded-xl p-3 border border-indigo-100 flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-indigo-900 text-sm">لقد قمت بتقييم هذا المهني مسبقاً</p>
                                        <p class="text-xs text-indigo-700 mt-0.5">شكراً لمشاركتك رأيك معنا.</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endauth

                    @if($profile->reviews->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <svg class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <h3 class="font-bold text-gray-900 text-base mb-1">لا توجد تقييمات بعد</h3>
                            <p class="text-gray-500 text-sm">كن أول من يقيم هذا المهني</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($profile->reviews as $review)
                                <div class="border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="font-bold text-gray-900 text-sm">{{ optional($review->user)->name ?: 'زائر' }}</div>
                                        <div class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>

                                    <div class="flex items-center gap-0.5 mb-1.5 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" class="w-3.5 h-3.5 {{ $i > $review->rating ? 'text-gray-200' : '' }}">
                                              <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                            </svg>
                                        @endfor
                                    </div>

                                    @if($review->comment)
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            {{ $review->comment }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
            {{-- END RIGHT SIDE --}}

        </div>
        {{-- END 2-COLUMN GRID --}}

</div>
