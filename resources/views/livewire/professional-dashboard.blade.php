<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-20">
        
        @if(!$profile)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-16 text-center max-w-2xl mx-auto mt-10">
                <div class="w-24 h-24 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-amber-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">يجب إكمال الملف المهني أولاً</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">للبدء في تلقي الطلبات وعرض أعمالك، يرجى إكمال بياناتك.</p>
                <a href="{{ route('home') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-sm inline-block">
                    العودة للرئيسية
                </a>
            </div>
        @else
            {{-- Status Banners --}}
            @if($profile->profile_status === 'pending_review')
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-6 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-0.5">ملفك قيد المراجعة</h3>
                        <p class="text-sm text-blue-700">طلب ترقيتك قيد المراجعة من قبل الإدارة. لن يظهر ملفك في البحث حتى الموافقة.</p>
                    </div>
                </div>
            @endif

            @if($profile->profile_status === 'rejected')
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-amber-900 mb-0.5">تم رفض ملفك</h3>
                        <p class="text-sm text-amber-700 mb-2">يمكنك تعديل بياناتك وإعادة إرسال الطلب.</p>
                        <a href="{{ route('upgrade') }}" class="inline-block text-sm font-bold text-amber-700 bg-white border border-amber-200 hover:bg-amber-50 px-4 py-2 rounded-lg transition shadow-sm">تعديل وإعادة الإرسال</a>
                    </div>
                </div>
            @endif

            @if($profile->profile_status === 'suspended')
                <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-6 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-red-900 mb-0.5">تم إيقاف حسابك مؤقتاً</h3>
                        <p class="text-sm text-red-700">يرجى التواصل مع الإدارة لمزيد من المعلومات.</p>
                    </div>
                </div>
            @endif

            @if(session()->has('upgrade_success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <p class="font-bold">{{ session('upgrade_success') }}</p>
                </div>
            @endif
            <!-- Dashboard Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                
                <div class="flex items-center gap-5 relative z-10 w-full md:w-auto">
                    <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center border-4 border-indigo-50 shadow-sm shrink-0">
                        <span class="text-3xl font-bold text-white">{{ mb_substr($profile->display_name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900 mb-2">{{ $profile->display_name }}</h1>
                        <div class="flex flex-wrap items-center gap-2">
                            @if($profile->verification_status === 'verified')
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 border border-green-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>
                                    موثوق
                                </span>
                            @elseif($profile->profile_status === 'active')
                                <a href="{{ route('verification.request') }}" class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 border border-indigo-200 hover:bg-indigo-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                                    طلب التوثيق
                                </a>
                            @endif
                            @if($profile->availability_status === 'available')
                                <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full border border-emerald-100 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>متاح</span>
                            @elseif($profile->availability_status === 'busy')
                                <span class="bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-100 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>مشغول</span>
                            @else
                                <span class="bg-gray-50 text-gray-700 text-xs font-bold px-3 py-1 rounded-full border border-gray-200 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>غير متاح</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 w-full md:w-auto mt-4 md:mt-0 relative z-10">
                    <div class="bg-gray-50 border border-gray-100 rounded-xl px-5 py-3 text-center flex-1 md:flex-none">
                        <p class="text-xs text-gray-500 font-medium mb-1">المشاهدات</p>
                        <p class="text-xl font-bold text-gray-900">{{ $profile->views_count }}</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl px-5 py-3 text-center flex-1 md:flex-none">
                        <p class="text-xs text-gray-500 font-medium mb-1">التقييم</p>
                        <p class="text-xl font-bold text-amber-500 flex items-center justify-center gap-1">
                            {{ number_format($profile->rating_avg, 1) }}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Navigation Sidebar -->
                <aside class="w-full lg:w-1/4 shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3 lg:sticky lg:top-24 flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar">
                        <button wire:click="setTab('profile')" class="flex items-center gap-3 px-5 py-4 rounded-xl text-right font-medium transition whitespace-nowrap lg:whitespace-normal {{ $activeTab === 'profile' ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 {{ $activeTab === 'profile' ? 'text-indigo-600' : 'text-gray-400' }}">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            الملف الشخصي
                        </button>
                        
                        <button wire:click="setTab('gallery')" class="flex items-center gap-3 px-5 py-4 rounded-xl text-right font-medium transition whitespace-nowrap lg:whitespace-normal {{ $activeTab === 'gallery' ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 {{ $activeTab === 'gallery' ? 'text-indigo-600' : 'text-gray-400' }}">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            معرض الأعمال
                        </button>

                        <button wire:click="setTab('increase-limit')" class="flex items-center gap-3 px-5 py-4 rounded-xl text-right font-medium transition whitespace-nowrap lg:whitespace-normal {{ $activeTab === 'increase-limit' ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 {{ $activeTab === 'increase-limit' ? 'text-indigo-600' : 'text-gray-400' }}">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            زيادة سعة المعرض
                        </button>
                    </div>
                </aside>

                <!-- Context Area -->
                <section class="flex-1">
                    
                    @if($activeTab === 'profile')
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">المعلومات الأساسية ومناطق التغطية</h2>
                            
                            @if (session()->has('profile_success'))
                                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    {{ session('profile_success') }}
                                </div>
                            @endif

                            <form wire:submit="updateProfile" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم العرض</label>
                                        <input wire:model="display_name" type="text" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                        @error('display_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">رقم الواتساب <span class="text-gray-400 font-normal">(مثل: 966500000000)</span></label>
                                        <input wire:model="whatsapp_number" type="text" dir="ltr" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                        @error('whatsapp_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">حالة التواجد</label>
                                    <div class="flex flex-wrap gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 py-3 px-5 rounded-xl hover:bg-green-50 hover:border-green-200 transition focus-within:ring-2 focus-within:ring-green-500 focus-within:bg-green-50 focus-within:border-green-200">
                                            <input wire:model="availability_status" type="radio" value="available" class="text-green-600 focus:ring-green-500 w-4 h-4">
                                            <span class="text-gray-700 font-medium text-sm">متاح</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 py-3 px-5 rounded-xl hover:bg-amber-50 hover:border-amber-200 transition focus-within:ring-2 focus-within:ring-amber-500 focus-within:bg-amber-50 focus-within:border-amber-200">
                                            <input wire:model="availability_status" type="radio" value="busy" class="text-amber-600 focus:ring-amber-500 w-4 h-4">
                                            <span class="text-gray-700 font-medium text-sm">مشغول حالياً</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 py-3 px-5 rounded-xl hover:bg-gray-100 transition focus-within:ring-2 focus-within:ring-gray-400 focus-within:bg-gray-100 focus-within:border-gray-300">
                                            <input wire:model="availability_status" type="radio" value="offline" class="text-gray-600 focus:ring-gray-500 w-4 h-4">
                                            <span class="text-gray-700 font-medium text-sm">غير متاح</span>
                                        </label>
                                    </div>
                                    @error('availability_status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">التصنيف المهني</label>
                                        <select wire:model="category_id" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                            <option value="">اختر التصنيف</option>
                                            @foreach($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                                        </select>
                                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">المحافظة</label>
                                        <select wire:model.live="city_id" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                            <option value="">اختر المحافظة</option>
                                            @foreach($cities as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                                        </select>
                                        @error('city_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="md:col-span-2 lg:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">المديرية (للتمركز الرئيسي)</label>
                                        <select wire:model="district_id" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                            <option value="">اختر المديرية</option>
                                            @foreach($districts as $d) <option value="{{ $d->id }}">{{ $d->name }}</option> @endforeach
                                        </select>
                                        @error('district_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">نبذة مختصرة وموهبتك</label>
                                    <textarea wire:model="description" rows="5" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"></textarea>
                                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="pt-2 border-t border-gray-100 flex justify-end">
                                    <button type="submit" wire:loading.attr="disabled" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md w-full sm:w-auto flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg wire:loading wire:target="updateProfile" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span wire:loading.remove wire:target="updateProfile">حفظ التغييرات</span>
                                        <span wire:loading wire:target="updateProfile">جاري التنفيذ...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if($activeTab === 'gallery')
                        <div class="space-y-6">
                            
                            <!-- UPLOAD FORM -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center flex-wrap gap-2 border-b border-gray-100 pb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-indigo-500">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    إضافة أعمال جديدة
                                    
                                    <span class="mr-auto text-sm font-medium px-4 py-1.5 rounded-full {{ $canUpload ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                        الاستهلاك: <span class="font-bold font-mono" dir="ltr">{{ $currentGalleryCount }} / {{ $galleryLimit }}</span> صورة
                                    </span>
                                </h2>
                                
                                @if (session()->has('gallery_success'))
                                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        {{ session('gallery_success') }}
                                    </div>
                                @endif

                                @if(!$canUpload)
                                    <div class="bg-red-50 border border-red-200 text-red-700 p-6 rounded-2xl flex items-start gap-4 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <div>
                                            <h3 class="font-bold text-red-900 mb-2 text-lg">عذراً، وصلت للحد الأقصى للصور</h3>
                                            <p class="text-sm text-red-700 leading-relaxed font-medium">
                                                لا يمكنك إضافة المزيد من الصور لأنك بلغت الحد الأقصى المسموح به لملفك الشخصي. 
                                                لإضافة صور جديدة، يرجى حذف بعض الصور القديمة من معرض الأعمال بالأسفل.
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <form wire:submit="uploadImage" class="space-y-5">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">إرفاق صورة</label>
                                                <div class="flex items-center justify-center w-full">
                                                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition relative overflow-hidden">
                                                        
                                                        @if($newImage)
                                                            <div class="absolute inset-0 z-10 bg-indigo-50/90 flex flex-col items-center justify-center">
                                                                <p class="text-sm font-bold text-indigo-700 mb-1">تم إرفاق ملف جاهز للرفع:</p>
                                                                <p class="text-xs text-indigo-500 font-mono" dir="ltr">{{ $newImage->getClientOriginalName() }}</p>
                                                            </div>
                                                        @endif

                                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                            <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                            <p class="mb-1 text-sm text-gray-500 font-bold">اضغط لاختيار صورة</p>
                                                            <p class="text-xs text-gray-400">PNG, JPG أقصى حجم 2MB</p>
                                                        </div>
                                                        <input wire:model="newImage" id="dropzone-file" type="file" class="hidden" accept="image/*" />
                                                    </label>
                                                </div>
                                                <div wire:loading wire:target="newImage" class="text-sm text-indigo-600 font-bold mt-2">جاري المعالجة...</div>
                                                @error('newImage') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">وصف قصير للصورة (اختياري)</label>
                                                <input wire:model="imageTitle" type="text" placeholder="مثال: مطبخ تم تصميمه بمحافظة كذا" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                                @error('imageTitle') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">الترتيب</label>
                                                <input wire:model="imageSortOrder" type="number" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="0">
                                                @error('imageSortOrder') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="flex justify-end border-t border-gray-100 pt-5">
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md w-full sm:w-auto flex items-center justify-center gap-2 disabled:bg-indigo-300 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="uploadImage">رفع وحفظ</span>
                                                <span wire:loading wire:target="uploadImage">جاري الرفع الحقيقي...</span>
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>

                            <!-- GALLERY GRID -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">صور معرضي الحالية</h2>
                                
                                @if($gallery->isEmpty())
                                    <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500">لا توجد صور مضافة لمعرضك.</p>
                                    </div>
                                @else
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($gallery as $img)
                                            <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-sm">
                                                <img src="{{ !empty($img->image_path) ? asset('storage/' . $img->image_path) : asset('/images/default-profile.png') }}" alt="{{ $img->title }}" class="w-full h-full object-cover">
                                                
                                                <!-- Overlay Controls -->
                                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center p-4">
                                                    @if($img->title)
                                                        <p class="text-white text-sm font-bold text-center mb-4 truncate w-full">{{ $img->title }}</p>
                                                    @endif
                                                    
                                                    <button wire:click="deleteImage({{ $img->id }})" wire:confirm="هل أنت متأكد من حذف هذه الصورة نهائياً؟" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2.5 shadow-md transform hover:scale-110 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Order Badge -->
                                                <div class="absolute top-2 right-2 bg-white/90 text-gray-800 text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center shadow-sm">
                                                    {{ $img->sort_order }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($activeTab === 'increase-limit')
                        <div class="space-y-6">
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-indigo-500">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    طلب زيادة سعة المعرض
                                </h2>

                                @if (session()->has('limit_request_success'))
                                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        {{ session('limit_request_success') }}
                                    </div>
                                @endif

                                @if($hasPendingLimitRequest)
                                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-6 rounded-2xl flex items-start gap-4 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-blue-500 flex-shrink-0">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                        </svg>
                                        <div>
                                            <h3 class="font-bold text-blue-900 mb-2 text-lg">طلبك قيد المراجعة</h3>
                                            <p class="text-sm text-blue-700 leading-relaxed font-medium">
                                                لقد قمت بإرسال طلب لزيادة سعة المعرض مؤخراً وهو الآن قيد المراجعة من قبل الإدارة. يرجى الانتظار حتى يتم الرد على طلبك الحالي قبل إرسال طلب جديد.
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 mb-8">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">تعليمات الدفع والتحويل</h3>
                                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                                            لزيادة الحد الأقصى لعدد الصور المسموح بها في معرض أعمالك، يرجى اختيار السعة المطلوبة ثم إيداع أو تحويل المبلغ إلى أحد الحسابات البنكية التالية:
                                        </p>
                                        <ul class="space-y-2 mb-4">
                                            <li class="flex items-center gap-2 text-gray-800"><span class="font-bold text-indigo-700 min-w-16">كريمي:</span> <span class="font-mono bg-white border border-gray-200 px-3 py-1 rounded text-sm whitespace-nowrap shadow-sm">300300400500</span></li>
                                            <li class="flex items-center gap-2 text-gray-800"><span class="font-bold text-indigo-700 min-w-16">شرق:</span> <span class="font-mono bg-white border border-gray-200 px-3 py-1 rounded text-sm whitespace-nowrap shadow-sm">411177394499</span></li>
                                            <li class="flex items-center gap-2 text-gray-800"><span class="font-bold text-indigo-700 min-w-16">قطيبي:</span> <span class="font-mono bg-white border border-gray-200 px-3 py-1 rounded text-sm whitespace-nowrap shadow-sm">100200300115</span></li>
                                            <li class="flex items-center gap-2 text-gray-800"><span class="font-bold text-indigo-700 min-w-16">سلام:</span> <span class="font-mono bg-white border border-gray-200 px-3 py-1 rounded text-sm whitespace-nowrap shadow-sm">400200600565</span></li>
                                        </ul>
                                        <p class="text-sm border-t border-gray-200 pt-3 text-red-600 font-bold">
                                            هام: بعد إتمام التحويل، يرجى إرفاق صورة واضحة من سند التحويل لتأكيد الطلب.
                                        </p>
                                    </div>

                                    <form wire:submit="submitLimitIncreaseRequest" class="space-y-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-3">السعة المطلوبة (عدد الصور النهائي)</label>
                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                                <label class="cursor-pointer relative">
                                                    <input wire:model="requestedLimit" type="radio" value="15" class="peer sr-only" name="requested_limit">
                                                    <div class="rounded-xl border-2 border-gray-200 bg-white p-5 text-center hover:bg-gray-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition">
                                                        <span class="block text-2xl font-black text-gray-900 peer-checked:text-indigo-700">15</span>
                                                        <span class="block mt-1 text-sm font-medium text-gray-500 peer-checked:text-indigo-600">صورة كحد أقصى</span>
                                                    </div>
                                                </label>

                                                <label class="cursor-pointer relative">
                                                    <input wire:model="requestedLimit" type="radio" value="25" class="peer sr-only" name="requested_limit">
                                                    <div class="rounded-xl border-2 border-gray-200 bg-white p-5 text-center hover:bg-gray-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition">
                                                        <span class="block text-2xl font-black text-gray-900 peer-checked:text-indigo-700">25</span>
                                                        <span class="block mt-1 text-sm font-medium text-gray-500 peer-checked:text-indigo-600">صورة كحد أقصى</span>
                                                    </div>
                                                </label>

                                                <label class="cursor-pointer relative">
                                                    <input wire:model="requestedLimit" type="radio" value="40" class="peer sr-only" name="requested_limit">
                                                    <div class="rounded-xl border-2 border-gray-200 bg-white p-5 text-center hover:bg-gray-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition">
                                                        <span class="block text-2xl font-black text-gray-900 peer-checked:text-indigo-700">40</span>
                                                        <span class="block mt-1 text-sm font-medium text-gray-500 peer-checked:text-indigo-600">صورة كحد أقصى</span>
                                                    </div>
                                                </label>
                                            </div>
                                            @error('requestedLimit') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="pt-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">إرفاق سند التحويل</label>
                                            <div class="flex flex-col items-center justify-center w-full">
                                                <label for="proof-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition relative overflow-hidden">
                                                    
                                                    @if($paymentProofImage)
                                                        <div class="absolute inset-0 z-10 bg-indigo-50/90 flex flex-col items-center justify-center">
                                                            <p class="text-sm font-bold text-indigo-700 mb-1">تم إرفاق الملف:</p>
                                                            <p class="text-xs text-indigo-500 font-mono" dir="ltr">{{ $paymentProofImage->getClientOriginalName() }}</p>
                                                        </div>
                                                    @endif

                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                        <p class="mb-1 text-sm text-gray-500 font-bold">اضغط لاختيار صورة السند</p>
                                                        <p class="text-xs text-gray-400">PNG, JPG أقصى حجم 5MB</p>
                                                    </div>
                                                    <input wire:model="paymentProofImage" id="proof-file" type="file" class="hidden" accept="image/*" />
                                                </label>
                                            </div>
                                            <div wire:loading wire:target="paymentProofImage" class="text-sm text-indigo-600 font-bold mt-2">جاري المعالجة...</div>
                                            @error('paymentProofImage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="flex justify-end border-t border-gray-100 pt-5 mt-6">
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md w-full sm:w-auto flex items-center justify-center gap-2 disabled:bg-indigo-300 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="submitLimitIncreaseRequest">تأكيد وإرسال الطلب</span>
                                                <span wire:loading wire:target="submitLimitIncreaseRequest">جاري الإرسال...</span>
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        @endif
</div>
