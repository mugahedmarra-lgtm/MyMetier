<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'MyMetier - Service Marketplace' }}</title>
        @if(isset($metaDescription))
            <meta name="description" content="{{ $metaDescription }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            body { font-family: 'Tajawal', sans-serif; }

            /* ── Sidebar Transition ── */
            .shell-sidebar {
                transition: width 0.25s cubic-bezier(.4,0,.2,1), transform 0.3s cubic-bezier(.4,0,.2,1);
            }

            /* ── Scrollbar ── */
            .shell-sidebar::-webkit-scrollbar { width: 3px; }
            .shell-sidebar::-webkit-scrollbar-track { background: transparent; }
            .shell-sidebar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 9999px; }

            /* ── Nav link active indicator ── */
            .nav-link-active {
                background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
                color: #4338ca;
                font-weight: 700;
                border-right: 3px solid #6366f1;
            }

            /* ── Collapsed sidebar: hide text, center icons ── */
            .sidebar-collapsed .nav-label,
            .sidebar-collapsed .nav-section-label,
            .sidebar-collapsed .sidebar-branding-text,
            .sidebar-collapsed .sidebar-ad-slot,
            .sidebar-collapsed .sidebar-footer-details,
            .sidebar-collapsed .sidebar-cta-btn { display: none; }

            .sidebar-collapsed .nav-icon-box { margin: 0 auto; }
            .sidebar-collapsed nav a,
            .sidebar-collapsed nav > div { justify-content: center; padding-left: 0; padding-right: 0; gap: 0; }
            .sidebar-collapsed nav hr { margin-left: 8px; margin-right: 8px; }
            .sidebar-collapsed .sidebar-footer { justify-content: center; }

            /* ── Collapsed header: stack logo + toggle vertically ── */
            .sidebar-collapsed .sidebar-header { flex-direction: column; align-items: center; gap: 6px; padding: 12px 8px; }
            .sidebar-collapsed .sidebar-toggle-btn { margin-right: 0 !important; }
        </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-900">

        {{-- ═══════════════════════════════════════════════════════
             LAYOUT CONTAINER — single x-data scope
        ═══════════════════════════════════════════════════════ --}}
        <div x-data="{
                 mobileOpen: false,
                 collapsed: localStorage.getItem('sidebar_collapsed') === 'true',
                 toggleCollapse() {
                     this.collapsed = !this.collapsed;
                     localStorage.setItem('sidebar_collapsed', this.collapsed);
                 }
             }"
             @keydown.escape.window="mobileOpen = false"
             class="min-h-screen flex flex-row-reverse">

            {{-- ──────────────────────────────────────
                 MOBILE OVERLAY BACKDROP
            ────────────────────────────────────── --}}
            <div x-show="mobileOpen"
                 x-transition.opacity.duration.200ms
                 @click="mobileOpen = false"
                 class="fixed inset-0 z-40 bg-gray-900/40 backdrop-blur-sm lg:hidden"
                 style="display:none;"></div>

            {{-- ──────────────────────────────────────
                 SIDEBAR
            ────────────────────────────────────── --}}
            <aside :class="{
                       'translate-x-0': mobileOpen,
                       'translate-x-full lg:translate-x-0': !mobileOpen,
                       'lg:w-72': !collapsed,
                       'lg:w-[68px]': collapsed,
                       'sidebar-collapsed': collapsed
                   }"
                   class="shell-sidebar fixed lg:sticky top-0 right-0 z-50 lg:z-30 w-72 h-screen bg-white border-l border-gray-200/80 shadow-xl lg:shadow-none flex flex-col overflow-y-auto overflow-x-hidden">

                {{-- ── Header ── --}}
                <div class="sidebar-header flex items-center gap-3 px-5 pt-5 pb-3">
                    {{-- Logo icon — always visible --}}
                    <a href="/" class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-indigo-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md shadow-indigo-200 flex-shrink-0">M</a>
                    {{-- Text — hidden when collapsed --}}
                    <div class="sidebar-branding-text min-w-0">
                        <span class="text-xl font-extrabold text-gray-900 tracking-tight">My<span class="text-indigo-600">Metier</span></span>
                        <p class="text-[11px] text-gray-400 font-medium -mt-0.5 truncate">منصة الخدمات المهنية</p>
                    </div>
                    {{-- Desktop collapse toggle — always visible, mr-auto pushes it left when expanded --}}
                    <button @click="toggleCollapse()"
                            class="sidebar-toggle-btn hidden lg:flex mr-auto w-8 h-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:text-indigo-600 hover:bg-indigo-100 transition flex-shrink-0 border border-gray-200"
                            :title="collapsed ? 'توسيع القائمة' : 'طي القائمة'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 transition-transform duration-200" :class="collapsed ? 'rotate-180' : ''">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                        </svg>
                    </button>
                    {{-- Mobile close --}}
                    <button @click="mobileOpen = false"
                            class="lg:hidden mr-auto w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- ── Ad Slot (desktop expanded only) ── --}}
                <div class="sidebar-ad-slot hidden lg:block px-5 pb-4">
                    <div class="w-full h-24 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center">
                        <span class="text-xs text-gray-400 font-medium select-none">مساحة إعلانية</span>
                    </div>
                </div>

                <hr class="border-gray-100 mx-4">

                {{-- ── Navigation ── --}}
                <nav class="flex-1 px-3 pt-4 pb-4 space-y-1">

                    <p class="nav-section-label text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 px-3 mb-2 select-none">التصفح</p>

                    {{-- Home --}}
                    <a href="{{ route('home') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group
                              {{ request()->is('/') ? 'nav-link-active' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}"
                       title="الرئيسية">
                        <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center transition duration-200 flex-shrink-0
                                     {{ request()->is('/') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-500' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                        </span>
                        <span class="nav-label">الرئيسية</span>
                    </a>

                    {{-- Search --}}
                    <a href="{{ route('search') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group
                              {{ request()->is('search*') ? 'nav-link-active' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}"
                       title="البحث">
                        <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center transition duration-200 flex-shrink-0
                                     {{ request()->is('search*') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-500' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </span>
                        <span class="nav-label">البحث</span>
                    </a>

                    {{-- Requests --}}
                    <a href="{{ route('requests.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group
                              {{ request()->is('requests') ? 'nav-link-active' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}"
                       title="الطلبات">
                        <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center transition duration-200 flex-shrink-0
                                     {{ request()->is('requests') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-500' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                        </span>
                        <span class="nav-label">الطلبات</span>
                    </a>

                    {{-- ── Account Section ── --}}
                    <hr class="border-gray-100 my-3">
                    <p class="nav-section-label text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 px-3 mb-2 select-none">حسابي</p>

                    @guest
                        <a href="{{ route('login') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group text-gray-600 hover:bg-gray-50 hover:text-indigo-600"
                           title="تسجيل الدخول">
                            <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center bg-gray-100 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition duration-200 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                </svg>
                            </span>
                            <span class="nav-label">تسجيل الدخول</span>
                        </a>
                        <a href="{{ route('register') }}"
                           class="sidebar-cta-btn flex items-center gap-3 mx-3 mt-2 px-4 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 text-white hover:bg-indigo-700 transition duration-200 shadow-sm shadow-indigo-200 justify-center">
                            حساب جديد
                        </a>
                    @endguest

                    @auth
                        @php
                            $user = auth()->user();
                            $isPro = $user->isProfessional() || $user->isContractor();
                        @endphp

                        {{-- Dashboard --}}
                        <a href="{{ $isPro ? route('pro.dashboard') : route('dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group
                                  {{ request()->is('dashboard') || request()->is('pro-dashboard') ? 'nav-link-active' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}"
                           title="لوحة التحكم">
                            <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center transition duration-200 flex-shrink-0
                                         {{ request()->is('dashboard') || request()->is('pro-dashboard') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-2.25-2.25v-2.25z"/>
                                </svg>
                            </span>
                            <span class="nav-label">لوحة التحكم</span>
                        </a>

                        @if($isPro)
                            @if($user->professionalProfile)
                                @if($user->professionalProfile->isActive())
                                    <a href="{{ route('profile.show', $user->professionalProfile->id) }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group text-gray-600 hover:bg-gray-50 hover:text-indigo-600"
                                       title="ملفي المهني">
                                        <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center bg-gray-100 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition duration-200 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                            </svg>
                                        </span>
                                        <span class="nav-label">ملفي المهني</span>
                                    </a>
                                @elseif($user->professionalProfile->profile_status === 'pending_review')
                                    <div class="px-3 py-1" title="قيد المراجعة">
                                        <div class="flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-2.5 rounded-xl text-[12px] font-bold border border-blue-100 sidebar-collapsed:justify-center">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse flex-shrink-0"></span>
                                            <span class="nav-label truncate">ملفك قيد المراجعة</span>
                                        </div>
                                    </div>
                                @elseif($user->professionalProfile->profile_status === 'rejected')
                                    <div class="px-3 py-1" title="مرفوض - يتطلب تعديل">
                                        <div class="flex items-center gap-2 bg-amber-50 text-amber-700 px-3 py-2.5 rounded-xl text-[12px] font-bold border border-amber-200 sidebar-collapsed:justify-center">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                                            <span class="nav-label truncate">مرفوض (يتطلب تعديل)</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('upgrade') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group
                                      {{ request()->is('upgrade') ? 'nav-link-active' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}"
                               title="ترقية لمهني">
                                <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center transition duration-200 flex-shrink-0
                                             {{ request()->is('upgrade') ? 'bg-amber-100 text-amber-600' : 'bg-amber-50 text-amber-500 group-hover:bg-amber-100 group-hover:text-amber-600' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                                    </svg>
                                </span>
                                <span class="nav-label">ترقية لمهني</span>
                            </a>
                        @endif

                        {{-- Settings --}}
                        <a href="{{ route('settings') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group
                                  {{ request()->is('settings*') ? 'nav-link-active' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}"
                           title="الإعدادات">
                            <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center transition duration-200 flex-shrink-0
                                         {{ request()->is('settings*') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </span>
                            <span class="nav-label">الإعدادات</span>
                        </a>

                        {{-- Logout --}}
                        <div class="pt-1">
                            <a href="{{ route('logout') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 transition duration-200 group"
                               title="تسجيل الخروج">
                                <span class="nav-icon-box w-8 h-8 rounded-lg flex items-center justify-center bg-red-50 text-red-400 group-hover:bg-red-100 group-hover:text-red-500 transition duration-200 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                                    </svg>
                                </span>
                                <span class="nav-label">تسجيل الخروج</span>
                            </a>
                        </div>
                    @endauth

                </nav>

                {{-- ── Sidebar Footer ── --}}
                <div class="sidebar-footer flex items-center gap-3 px-5 py-4 border-t border-gray-100 mt-auto">
                    @auth
                        <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm shadow-inner flex-shrink-0">
                            {{ mb_substr(auth()->user()->name ?? 'M', 0, 1) }}
                        </div>
                        <div class="sidebar-footer-details min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-400 truncate">{{ auth()->user()->phone ?? '' }}</p>
                        </div>
                    @endauth
                </div>

            </aside>

            {{-- ──────────────────────────────────────
                 MOBILE BOTTOM BAR — visible < lg only
            ────────────────────────────────────── --}}
            <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-gray-200/80 h-16 flex items-center justify-around px-2 shadow-[0_-2px_10px_rgba(0,0,0,0.06)]">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-lg transition {{ request()->is('/') ? 'text-indigo-600' : 'text-gray-400 hover:text-indigo-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    <span class="text-[10px] font-bold">الرئيسية</span>
                </a>
                <a href="{{ route('search') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-lg transition {{ request()->is('search*') ? 'text-indigo-600' : 'text-gray-400 hover:text-indigo-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <span class="text-[10px] font-bold">البحث</span>
                </a>
                <a href="{{ route('requests.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-lg transition {{ request()->is('requests') ? 'text-indigo-600' : 'text-gray-400 hover:text-indigo-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <span class="text-[10px] font-bold">الطلبات</span>
                </a>
                <button @click="mobileOpen = !mobileOpen" class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-lg transition" :class="mobileOpen ? 'text-indigo-600' : 'text-gray-400 hover:text-indigo-500'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    <span class="text-[10px] font-bold">المزيد</span>
                </button>
            </div>

            {{-- ──────────────────────────────────────
                 MAIN CONTENT AREA
            ────────────────────────────────────── --}}
            <main class="flex-1 min-w-0 pb-20 lg:pb-0">
                {{ $slot }}
            </main>

        </div>

        @livewireScripts
    </body>
</html>
