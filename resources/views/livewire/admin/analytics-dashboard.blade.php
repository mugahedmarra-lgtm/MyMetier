<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" dir="rtl">
    <div class="mb-8 border-b border-gray-200 pb-5">
        <h2 class="text-3xl font-bold leading-tight text-gray-900">לוحة التحليلات</h2>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">نظرة عامة على نشاط المستخدمين وتفاعلهم مع المنصة.</p>
    </div>

    <!-- Metrics Cards -->
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <!-- Profile Views Card -->
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col p-6">
            <dt class="truncate text-sm font-medium text-gray-500">مشاهدات الملفات الشخصية</dt>
            <dd class="mt-3 text-3xl font-semibold tracking-tight text-indigo-600">{{ number_format($this->metrics['profile_views']) }}</dd>
        </div>

        <!-- WhatsApp Clicks Card -->
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col p-6">
            <dt class="truncate text-sm font-medium text-gray-500">نقرات واتساب</dt>
            <dd class="mt-3 text-3xl font-semibold tracking-tight text-green-600">{{ number_format($this->metrics['whatsapp_clicks']) }}</dd>
        </div>

        <!-- Searches Card -->
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col p-6">
            <dt class="truncate text-sm font-medium text-gray-500">عمليات البحث</dt>
            <dd class="mt-3 text-3xl font-semibold tracking-tight text-blue-600">{{ number_format($this->metrics['searches']) }}</dd>
        </div>
    </dl>

    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Top Profiles -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-900">أكثر المهنيين مشاهدة</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-100 px-6">
                @forelse($this->topProfiles as $profile)
                    <li class="flex justify-between gap-x-6 py-4">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">
                                    <a href="{{ route('profile.show', $profile->id) }}" target="_blank" class="hover:underline text-indigo-600">
                                        {{ $profile->name }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <p class="text-sm leading-6 text-gray-900"><span class="font-bold">{{ number_format($profile->views) }}</span> مشاهدة</p>
                        </div>
                    </li>
                @empty
                    <li class="py-6 text-center text-sm text-gray-500">لا توجد بيانات متاحة بعد</li>
                @endforelse
            </ul>
        </div>

        <!-- Top Searches -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-900">أكثر عمليات البحث</h3>
            </div>
            
            <div class="p-6 flex-1 flex flex-col justify-center space-y-6">
                
                <div>
                    <h4 class="text-xs uppercase tracking-wider text-gray-500 mb-2 font-semibold">التخصص الأكثر طلباً</h4>
                    <div class="flex items-end gap-3 text-gray-900">
                        <span class="text-2xl font-bold">{{ $this->topSearches->category_name }}</span>
                        @if($this->topSearches->category_count > 0)
                            <span class="text-sm text-gray-500 mb-1">({{ number_format($this->topSearches->category_count) }} عملية بحث)</span>
                        @endif
                    </div>
                </div>
                
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-xs uppercase tracking-wider text-gray-500 mb-2 font-semibold">المحافظة الأكثر نشاطاً</h4>
                    <div class="flex items-end gap-3 text-gray-900">
                        <span class="text-2xl font-bold">{{ $this->topSearches->city_name }}</span>
                        @if($this->topSearches->city_count > 0)
                            <span class="text-sm text-gray-500 mb-1">({{ number_format($this->topSearches->city_count) }} عملية بحث)</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
