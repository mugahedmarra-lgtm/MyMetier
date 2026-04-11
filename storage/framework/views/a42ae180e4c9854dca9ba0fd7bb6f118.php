<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-20" dir="rtl">

        
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPending): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 mb-3">طلبك قيد المراجعة</h1>
                <p class="text-gray-500 mb-6 max-w-md mx-auto leading-relaxed">تم إرسال طلب ترقية حسابك بنجاح وهو الآن قيد المراجعة من قبل الإدارة. سيتم إشعارك عند اتخاذ قرار.</p>

                <div class="bg-gray-50 rounded-xl border border-gray-100 p-6 text-right max-w-md mx-auto space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">نوع الحساب:</span>
                        <span class="font-bold text-gray-900"><?php echo e($provider_type === 'contractor' ? 'مقاول' : 'مهني'); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">الاسم:</span>
                        <span class="font-bold text-gray-900"><?php echo e($name); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">التصنيف:</span>
                        <span class="font-bold text-gray-900"><?php echo e($display_name); ?></span>
                    </div>
                </div>

                <a href="<?php echo e(route('dashboard')); ?>" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-sm">
                    العودة للوحة التحكم
                </a>
            </div>

        
        
        
        <?php else: ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isResubmission): ?>
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-amber-900 mb-1">تم رفض طلبك السابق</h3>
                        <p class="text-sm text-amber-700">يمكنك تعديل بياناتك وإعادة إرسال الطلب. بياناتك السابقة محملة أدناه.</p>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="bg-indigo-600 rounded-2xl shadow-md border border-indigo-700 p-8 mb-8 text-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -ml-20 -mt-20 pointer-events-none"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2"><?php echo e($isResubmission ? 'تعديل وإعادة إرسال الطلب' : 'ترقية حسابك'); ?></h1>
                    <p class="text-indigo-200 leading-relaxed">أكمل بياناتك لتصبح مقدم خدمات على المنصة. سيتم مراجعة طلبك من قبل الإدارة قبل النشر.</p>
                </div>
            </div>

            <form wire:submit="submit" class="space-y-8">

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                        نوع الحساب
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="cursor-pointer block">
                            <input wire:model.live="provider_type" type="radio" value="professional" class="peer hidden">
                            <div class="peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:ring-2 peer-checked:ring-indigo-200 border-2 border-gray-200 rounded-xl p-5 text-center transition hover:border-indigo-300">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">مهني</h3>
                                <p class="text-xs text-gray-500">مقدم خدمات فردي</p>
                            </div>
                        </label>

                        <label class="cursor-pointer block">
                            <input wire:model.live="provider_type" type="radio" value="contractor" class="peer hidden">
                            <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 border-2 border-gray-200 rounded-xl p-5 text-center transition hover:border-blue-300">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">مقاول</h3>
                                <p class="text-xs text-gray-500">شركة أو فريق عمل</p>
                            </div>
                        </label>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['provider_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-2 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                        البيانات الشخصية
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-400 mb-2">اسمك الحقيقي كما هو في حسابك</p>
                            <input wire:model="name" type="text" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="اسمك الكامل">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم الجوال <span class="text-red-500">*</span></label>
                            <input wire:model="phone" type="text" dir="ltr" class="w-full text-left bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="5XXXXXXXX">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">اسم العرض <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-400 mb-2">الاسم التجاري أو الاسم الظاهر للعملاء</p>
                            <input wire:model="display_name" type="text" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="مثال: ورشة الأمان، أبو محمد للسباكة...">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['display_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">الجنس <span class="text-red-500">*</span></label>
                            <div class="flex gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 py-3 px-5 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 transition">
                                    <input wire:model="gender" type="radio" value="male" class="text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                    <span class="text-gray-700 font-medium text-sm">ذكر</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 py-3 px-5 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 transition">
                                    <input wire:model="gender" type="radio" value="female" class="text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                    <span class="text-gray-700 font-medium text-sm">أنثى</span>
                                </label>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">3</span>
                        البيانات المهنية
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">التصنيف المهني <span class="text-red-500">*</span></label>
                            <select wire:model="category_id" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                <option value="">اختر التصنيف</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?> <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم الواتساب <span class="text-red-500">*</span></label>
                            <input wire:model="whatsapp_number" type="text" dir="ltr" class="w-full text-left bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="966500000000">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['whatsapp_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم إضافي <span class="text-gray-400 font-normal">(اختياري)</span></label>
                            <input wire:model="secondary_phone" type="text" dir="ltr" class="w-full text-left bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['secondary_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">حالة التواجد <span class="text-red-500">*</span></label>
                            <select wire:model="availability_status" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                <option value="available">متاح</option>
                                <option value="busy">مشغول</option>
                                <option value="offline">غير متاح</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['availability_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">المحافظة <span class="text-red-500">*</span></label>
                            <select wire:model.live="city_id" class="w-full text-right bg-white border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition <?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">اختر المحافظة</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?> <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">المديرية <span class="text-gray-400 font-normal">(اختياري)</span></label>
                            <select wire:model.live="district_id" class="w-full text-right bg-white border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition <?php $__errorArgs = ['district_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" <?php echo e(empty($districts) ? 'disabled' : ''); ?>>
                                <option value="">اختر المديرية</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?> <option value="<?php echo e($d->id); ?>"><?php echo e($d->name); ?></option> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['district_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">نبذة عنك وعن خدماتك <span class="text-red-500">*</span></label>
                        <textarea wire:model="description" rows="4" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="اكتب وصفاً مختصراً عن خبرتك والخدمات التي تقدمها..."></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($provider_type === 'contractor'): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6 md:p-8 ring-1 ring-blue-50">
                        <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <span class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">4</span>
                            بيانات المقاول
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">اسم المنشأة / الشركة <span class="text-red-500">*</span></label>
                                <input wire:model="business_name" type="text" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition" placeholder="اسم الشركة أو الورشة">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">نوع الكيان / المقاول <span class="text-red-500">*</span></label>
                                <select wire:model="contractor_type" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                    <option value="">اختر نوع الكيان</option>
                                    <option value="individual">فرد</option>
                                    <option value="company">شركة</option>
                                    <option value="team">فريق</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['contractor_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">حجم الفريق <span class="text-gray-400 font-normal">(اختياري)</span></label>
                                <input wire:model="team_size" type="text" class="w-full text-right bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition" placeholder="مثال: 5-10 أشخاص">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold"><?php echo e($provider_type === 'contractor' ? '5' : '4'); ?></span>
                        التحقق من الهوية
                    </h2>

                    
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <div>
                            <p class="text-sm text-blue-800 font-bold mb-0.5">خصوصية وأمان</p>
                            <p class="text-xs text-blue-600">بيانات الهوية تُستخدم فقط للتحقق الداخلي ولن يتم مشاركتها أو عرضها علنياً أبداً.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهوية / الإقامة <span class="text-red-500">*</span></label>
                            <input wire:model="identity_number" type="text" dir="ltr" class="w-full text-left bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="1XXXXXXXXX">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['identity_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                صورة الهوية <span class="text-red-500">*</span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isResubmission && $existingIdentityPath): ?>
                                    <span class="text-green-600 text-xs font-normal">(موجودة — ارفع صورة جديدة فقط إذا أردت التحديث)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="identity-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition relative overflow-hidden">

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($identity_image): ?>
                                        <div class="absolute inset-0 z-10 bg-indigo-50/90 flex flex-col items-center justify-center">
                                            <p class="text-sm font-bold text-indigo-700 mb-1">تم إرفاق الملف:</p>
                                            <p class="text-xs text-indigo-500 font-mono" dir="ltr"><?php echo e($identity_image->getClientOriginalName()); ?></p>
                                        </div>
                                    <?php elseif($isResubmission && $existingIdentityPath): ?>
                                        <div class="absolute inset-0 z-10 bg-green-50/90 flex flex-col items-center justify-center">
                                            <svg class="w-6 h-6 text-green-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <p class="text-xs font-bold text-green-700">صورة هوية موجودة</p>
                                            <p class="text-xs text-green-600">اضغط لاستبدالها</p>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="flex flex-col items-center justify-center pt-4 pb-4">
                                        <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-sm text-gray-500 font-bold">اضغط لرفع صورة الهوية</p>
                                        <p class="text-xs text-gray-400">PNG, JPG حتى 5MB</p>
                                    </div>
                                    <input wire:model="identity_image" id="identity-upload" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                            <div wire:loading wire:target="identity_image" class="text-sm text-indigo-600 font-bold mt-2">جاري رفع الصورة...</div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['identity_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 mb-6 text-sm text-gray-600 space-y-1">
                        <p>• سيتم مراجعة طلبك من قبل الإدارة قبل نشر ملفك.</p>
                        <p>• الترقية لا تعني التوثيق — التوثيق خطوة منفصلة.</p>
                        <p>• لن يظهر ملفك في البحث حتى تتم الموافقة عليه.</p>
                    </div>

                    <button type="submit"
                        wire:loading.attr="disabled"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-xl transition shadow-md flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed text-lg">
                        <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="submit"><?php echo e($isResubmission ? 'إعادة إرسال الطلب' : 'إرسال طلب الترقية'); ?></span>
                        <span wire:loading wire:target="submit">جاري الإرسال...</span>
                    </button>
                </div>

            </form>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php /**PATH C:\Users\Mugahed\Desktop\MyMetier\resources\views/livewire/upgrade-page.blade.php ENDPATH**/ ?>