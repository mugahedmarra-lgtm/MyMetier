<div class="max-w-4xl w-full mx-auto px-4 sm:px-6 py-8">
    <div class="bg-white rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-100 p-8 md:p-12">
        
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight mb-4">{{ $request->title }}</h1>
                
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 font-medium font-mono">
                    <span class="bg-indigo-50 text-indigo-700 px-4 py-1.5 rounded-full border border-indigo-100 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                        {{ optional($request->category)->name }}
                    </span>
                    <span class="bg-gray-100 text-gray-700 px-4 py-1.5 rounded-full border border-gray-200">
                        {{ optional($request->city)->name }} • {{ optional($request->district)->name }}
                    </span>
                    <span class="text-gray-400 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-300">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $request->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <hr class="border-gray-100 my-8">

        <div class="prose prose-lg prose-indigo text-gray-700 max-w-none mb-12 whitespace-pre-line leading-relaxed">
            {{ $request->description }}
        </div>

        <div class="bg-gradient-to-l from-indigo-50 to-white border border-indigo-100 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
            <div class="text-center md:text-right">
                <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">صاحب الطلب</p>
                <h3 class="text-lg font-bold text-gray-900">{{ optional($request->user)->name }}</h3>
                <p class="text-sm text-gray-500">تم نشر الطلب للبحث عن مهنيين متخصصين</p>
            </div>
            
            @php
                $phone = $request->user->phone ?? '';
                $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
                // Standard MA code prefixing logic fallback if needed, but keeping exact for now
                if(!str_starts_with($cleanPhone, '212') && !str_starts_with($cleanPhone, '966') && strlen($cleanPhone) > 0) {
                    // Assuming MA prefix if none is explicitly set but dropping '0' safely
                    if (str_starts_with($cleanPhone, '0')) {
                       $cleanPhone = ltrim($cleanPhone, '0');
                    }
                }
                $message = urlencode("السلام عليكم، بخصوص الطلب الذي نشرته في تطبيق MyMetier: \n*{$request->title}*\n\n");
                $waLink = "https://wa.me/{$cleanPhone}?text={$message}";
            @endphp

            <a href="{{ $waLink }}" target="_blank" class="w-full md:w-auto flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-xl transition shadow-md transform hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                </svg>
                تواصل عبر الواتساب
            </a>
        </div>

    </div>
</div>
