<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-20">
        
        <!-- Welcome Header -->
        <div class="bg-indigo-600 rounded-2xl shadow-md border border-indigo-700 p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -ml-20 -mt-20 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                <div class="w-20 h-20 bg-indigo-500 rounded-full flex items-center justify-center border-4 border-indigo-400 shadow-inner">
                    <span class="text-3xl font-bold"><?php echo e(mb_substr($user?->name ?? 'G', 0, 1)); ?></span>
                </div>
                <div class="text-center md:text-right">
                    <h1 class="text-3xl font-extrabold tracking-tight mb-1">أهلاً بك، <?php echo e($user?->name ?? 'Guest'); ?></h1>
                    <p class="text-indigo-200">هنا يمكنك إدارة قوائمك، طلباتك، وتقييماتك في مكان واحد.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Navigation Tabs -->
            <aside class="w-full lg:w-1/4 shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3 lg:sticky lg:top-24 flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar">
                    <button wire:click="setTab('favorites')" class="flex items-center gap-3 px-5 py-4 rounded-xl text-right font-medium transition whitespace-nowrap lg:whitespace-normal <?php echo e($activeTab === 'favorites' ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100' : 'text-gray-600 hover:bg-gray-50'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 <?php echo e($activeTab === 'favorites' ? 'text-indigo-600' : 'text-gray-400'); ?>" fill="<?php echo e($activeTab === 'favorites' ? 'currentColor' : 'none'); ?>" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        المفضلة
                        <span class="mr-auto bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full"><?php echo e($favorites->count()); ?></span>
                    </button>
                    
                    <button wire:click="setTab('requests')" class="flex items-center gap-3 px-5 py-4 rounded-xl text-right font-medium transition whitespace-nowrap lg:whitespace-normal <?php echo e($activeTab === 'requests' ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100' : 'text-gray-600 hover:bg-gray-50'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 <?php echo e($activeTab === 'requests' ? 'text-indigo-600' : 'text-gray-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        طلباتي
                        <span class="mr-auto bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full"><?php echo e($requests->count()); ?></span>
                    </button>
                    
                    <button wire:click="setTab('reviews')" class="flex items-center gap-3 px-5 py-4 rounded-xl text-right font-medium transition whitespace-nowrap lg:whitespace-normal <?php echo e($activeTab === 'reviews' ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100' : 'text-gray-600 hover:bg-gray-50'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 <?php echo e($activeTab === 'reviews' ? 'text-indigo-600' : 'text-gray-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                        تقييماتي
                        <span class="mr-auto bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full"><?php echo e($reviews->count()); ?></span>
                    </button>
                </div>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->isAdmin()): ?>
                    <div class="mt-6 bg-purple-50 rounded-2xl p-5 border border-purple-100 text-center">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-purple-100 text-purple-600 mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </span>
                        <h3 class="font-bold text-purple-900 mb-1">صلاحيات الإدارة</h3>
                        <p class="text-xs text-purple-700 mb-3">أنت مسجل الدخول كمدير للنظام.</p>
                        <a href="/admin" class="inline-block text-sm font-bold text-white bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg transition shadow-sm w-full">الدخول للوحة التحكم</a>
                    </div>
                <?php elseif(!$user->isProfessional() && !$user->isContractor()): ?>
                    <?php
                        $profile = $user->professionalProfile;
                        $profileStatus = $profile?->profile_status;
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profileStatus === 'pending_review'): ?>
                        
                        <div class="mt-6 bg-blue-50 rounded-2xl p-5 border border-blue-100 text-center">
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-blue-600 mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </span>
                            <h3 class="font-bold text-blue-900 mb-1">طلب الترقية قيد المراجعة</h3>
                            <p class="text-xs text-blue-700 mb-3">سيتم إشعارك عند اتخاذ قرار.</p>
                        </div>
                    <?php elseif($profileStatus === 'rejected'): ?>
                        
                        <div class="mt-6 bg-amber-50 rounded-2xl p-5 border border-amber-200 text-center">
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-600 mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                            </span>
                            <h3 class="font-bold text-amber-900 mb-1">تم رفض طلب الترقية</h3>
                            <p class="text-xs text-amber-700 mb-3">يمكنك تعديل بياناتك وإعادة الإرسال.</p>
                            <a href="<?php echo e(route('upgrade')); ?>" class="inline-block text-sm font-bold text-amber-700 bg-white border border-amber-200 hover:bg-amber-50 px-4 py-2 rounded-lg transition shadow-sm w-full">تعديل وإعادة الإرسال</a>
                        </div>
                    <?php else: ?>
                        
                        <div class="mt-6 bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-5 border border-indigo-100 shadow-sm relative overflow-hidden">
                            <h3 class="font-bold text-indigo-900 mb-2">هل تقدم خدمات؟</h3>
                            <p class="text-sm text-indigo-700 mb-4 leading-relaxed">قم بترقية حسابك الآن لتتمكن من تقديم خدماتك والوصول لآلاف العملاء.</p>
                            <div class="flex flex-col gap-2.5 relative z-10">
                                <a href="<?php echo e(route('upgrade', ['type' => 'professional'])); ?>" class="w-full flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-sm text-sm">التسجيل كمهني</a>
                                <a href="<?php echo e(route('upgrade', ['type' => 'contractor'])); ?>" class="w-full flex justify-center items-center bg-white hover:bg-gray-50 text-indigo-700 border border-indigo-200 font-bold py-2.5 px-4 rounded-xl transition shadow-sm text-sm">التسجيل كمقاول</a>
                            </div>
                            <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-indigo-100 rounded-full opacity-50 blur-xl"></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php elseif($user->isProfessional()): ?>
                    <div class="mt-6 bg-emerald-50 rounded-2xl p-5 border border-emerald-100 text-center">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </span>
                        <h3 class="font-bold text-emerald-900 mb-1">حسابك مهني</h3>
                        <p class="text-xs text-emerald-700 mb-3">يمكنك إدارة خدماتك من لوحة المهنيين.</p>
                        <a href="<?php echo e(route('pro.dashboard')); ?>" class="inline-block text-sm font-bold text-emerald-700 bg-white border border-emerald-200 hover:bg-emerald-50 px-4 py-2 rounded-lg transition shadow-sm w-full">الانتقال للوحة المهنيين</a>
                    </div>
                <?php elseif($user->isContractor()): ?>
                    <div class="mt-6 bg-blue-50 rounded-2xl p-5 border border-blue-100 text-center">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-blue-600 mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </span>
                        <h3 class="font-bold text-blue-900 mb-1">حسابك مقاول</h3>
                        <p class="text-xs text-blue-700 mb-3">يمكنك استعراض لوحة التحكم كمقاول.</p>
                        <a href="<?php echo e(route('pro.dashboard')); ?>" class="inline-block text-sm font-bold text-blue-700 bg-white border border-blue-200 hover:bg-blue-50 px-4 py-2 rounded-lg transition shadow-sm w-full">الانتقال للوحة المقاولين</a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </aside>

            <!-- Main Content Area -->
            <section class="flex-1">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'favorites'): ?>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">المهنيون المفضلون</h2>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($favorites->isEmpty()): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                                <div class="mx-auto w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">لا توجد بيانات</h3>
                                <p class="text-gray-500 text-sm">لم يتم العثور على نتائج، حاول تغيير الفلاتر أو إضافة بيانات جديدة</p>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <?php $profile = $fav->professionalProfile; ?>
                                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 hover:shadow-xl hover:border-indigo-100 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full relative">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profile->isFeatured()): ?>
                                        <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1.5 rounded-bl-lg z-10 shadow-sm flex items-center gap-1">
                                            مميز ⭐
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="p-6 flex flex-col flex-1">
                                            
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="min-w-0 flex-1">
                                                    <h3 class="text-lg font-bold text-gray-900 truncate"><?php echo e($profile->display_name); ?></h3>
                                                    <p class="text-sm text-gray-500 mt-1"><?php echo e($profile->category?->name ?? '—'); ?></p>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profile->isVerified()): ?>
                                                        <span class="flex-shrink-0 inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 border border-blue-100 shadow-sm hidden sm:inline-flex">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                            موثق
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    
                                                    <!-- Remove Favorite Action -->
                                                    <button wire:click.prevent="removeFavorite(<?php echo e($fav->id); ?>)" class="p-1.5 rounded-full hover:bg-red-50 text-red-500 transition duration-300 focus:outline-none flex-shrink-0 relative group" title="إزالة من المفضلة" wire:loading.attr="disabled">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                                                          <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                                        </svg>
                                                        <span wire:loading wire:target="removeFavorite(<?php echo e($fav->id); ?>)" class="absolute inset-0 flex items-center justify-center bg-white/80 rounded-full">
                                                            <svg class="animate-spin h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>

                                            
                                            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                                </svg>
                                                <span class="truncate"><?php echo e($profile->city?->name ?? '—'); ?></span>
                                            </div>

                                            
                                            <div class="flex items-center gap-1.5 mb-6">
                                                <div class="flex items-center gap-0.5">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                                        <svg class="w-5 h-5 <?php echo e($i <= round($profile->rating_avg ?? 0) ? 'text-amber-400' : 'text-gray-200'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <span class="text-sm font-bold text-gray-700"><?php echo e(number_format($profile->rating_avg ?? 0, 1)); ?></span>
                                            </div>

                                            
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-auto pt-5 border-t border-gray-100 gap-4 sm:gap-0">
                                                <div class="flex items-center">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profile->availability_status === 'available'): ?>
                                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 rounded-full px-3 py-1.5 border border-emerald-100">
                                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse outline outline-2 outline-emerald-100"></span>
                                                            متاح
                                                        </span>
                                                    <?php elseif($profile->availability_status === 'busy'): ?>
                                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-50 rounded-full px-3 py-1.5 border border-amber-100">
                                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                            مشغول
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-700 bg-gray-50 rounded-full px-3 py-1.5 border border-gray-200">
                                                            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                                            غير متاح
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>

                                                <a href="<?php echo e(route('profile.show', $profile->id)); ?>"
                                                   class="inline-flex items-center justify-center gap-1.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 rounded-xl transition shadow-md w-full sm:w-auto">
                                                    عرض الملف
                                                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'requests'): ?>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">طلباتي العامة</h2>
                        </div>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requests->isEmpty()): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                                <div class="mx-auto w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">لا توجد بيانات</h3>
                                <p class="text-gray-500 text-sm">لم يتم العثور على نتائج، حاول تغيير الفلاتر أو إضافة بيانات جديدة</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative">
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingRequestId === $req->id): ?>
                                            <!-- EDIT FORM -->
                                            <form wire:submit="updateRequest" class="space-y-5">
                                                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                                                    <h3 class="font-bold text-indigo-600">تعديل الطلب</h3>
                                                    <button type="button" wire:click="cancelEditRequest" class="text-gray-400 hover:text-gray-600 text-sm">إلغاء</button>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">عنوان الطلب</label>
                                                    <input wire:model="requestTitle" type="text" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">التصنيف</label>
                                                    <select wire:model="requestCategoryId" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500">
                                                        <option value="">اختر التصنيف</option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?> <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </select>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">المحافظة</label>
                                                        <select wire:model.live="requestCityId" required class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500">
                                                            <option value="">اختر المحافظة</option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?> <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">المديرية</label>
                                                        <select wire:model="requestDistrictId" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500">
                                                            <option value="">اختر المديرية</option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?> <option value="<?php echo e($d->id); ?>"><?php echo e($d->name); ?></option> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">التفاصيل</label>
                                                    <textarea wire:model="requestDescription" required rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500"></textarea>
                                                </div>

                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-sm w-full sm:w-auto">حفظ التعديلات</button>
                                            </form>
                                        <?php else: ?>
                                            <!-- VIEW CARD -->
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <h3 class="font-bold text-gray-900 text-lg mb-1"><?php echo e($req->title); ?></h3>
                                                    <div class="flex gap-2 text-sm text-gray-500">
                                                        <span><?php echo e(optional($req->category)->name); ?></span>
                                                        <span>•</span>
                                                        <span><?php echo e(optional($req->city)->name); ?></span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->status === 'open'): ?>
                                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> مفتوح
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> مغلق
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>

                                            <p class="text-gray-600 text-sm whitespace-pre-line mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100"><?php echo e($req->description); ?></p>

                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-400 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <?php echo e($req->created_at->diffForHumans()); ?>

                                                </span>
                                                
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->status === 'open'): ?>
                                                    <div class="flex gap-2">
                                                        <button wire:click="editRequest(<?php echo e($req->id); ?>)" class="text-indigo-600 hover:bg-indigo-50 font-medium px-4 py-2 rounded-lg transition border border-transparent hover:border-indigo-100">
                                                            تعديل
                                                        </button>
                                                        <button wire:click="closeRequest(<?php echo e($req->id); ?>)" wire:confirm="هل أنت متأكد من إغلاق هذا الطلب نهائياً؟" class="text-red-600 hover:bg-red-50 font-medium px-4 py-2 rounded-lg transition border border-transparent hover:border-red-100">
                                                            إغلاق الطلب
                                                        </button>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'reviews'): ?>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">تقييماتي</h2>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviews->isEmpty()): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                                <div class="mx-auto w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">لا توجد بيانات</h3>
                                <p class="text-gray-500 text-sm">لم يتم العثور على نتائج، حاول تغيير الفلاتر أو إضافة بيانات جديدة</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                                    <?php echo e(mb_substr($rev->professionalProfile?->display_name ?? 'U', 0, 1)); ?>

                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900"><?php echo e($rev->professionalProfile?->display_name ?? 'غير معروف'); ?></h3>
                                                    <a href="<?php echo e(route('profile.show', $rev->professional_profile_id)); ?>" class="text-xs text-indigo-500 hover:underline">عرض الملف</a>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">
                                                <?php echo e($rev->created_at->format('Y-m-d')); ?>

                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-1 mb-3 text-amber-400">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?php echo e($i <= $rev->rating ? 'currentColor' : 'none'); ?>" stroke="currentColor" stroke-width="1.5" class="w-4 h-4">
                                                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                </svg>
                                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rev->comment): ?>
                                            <p class="text-gray-600 text-sm italic border-r-4 border-gray-200 pr-3">"<?php echo e($rev->comment); ?>"</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
            </section>
        </div>
</div>
<?php /**PATH C:\Users\Mugahed\Desktop\MyMetier\resources\views/livewire/user-dashboard.blade.php ENDPATH**/ ?>