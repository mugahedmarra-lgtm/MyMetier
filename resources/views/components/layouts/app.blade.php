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
        
        <style>
            body { font-family: 'Tajawal', sans-serif; }
        </style>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="antialiased bg-gray-50 text-gray-900">
        <!-- Navigation Bar -->
        <nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow relative z-50 mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Right side / Logo & Main Links -->
                    <div class="flex items-center gap-8">
                        <a href="/" class="text-2xl font-extrabold text-blue-600 tracking-tight">MyMetier</a>
                        
                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center gap-6 h-16">
                            <a href="/" class="inline-flex items-center px-1 pt-1 h-full text-sm font-medium transition duration-200 border-b-2 {{ request()->is('/') ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-blue-500 hover:border-blue-300' }}">الرئيسية</a>
                            <a href="/search" class="inline-flex items-center px-1 pt-1 h-full text-sm font-medium transition duration-200 border-b-2 {{ request()->is('search') ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-blue-500 hover:border-blue-300' }}">البحث</a>
                            <a href="/requests" class="inline-flex items-center px-1 pt-1 h-full text-sm font-medium transition duration-200 border-b-2 {{ request()->is('requests') ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-blue-500 hover:border-blue-300' }}">الطلبات</a>
                        </div>
                    </div>

                    <!-- Left side / Auth & User (Desktop) -->
                    <div class="hidden md:flex items-center gap-4">
                        @guest
                            <a href="/login" class="text-sm font-medium transition duration-200 {{ request()->is('login') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-500' }}">تسجيل الدخول</a>
                            <a href="/register" class="bg-blue-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm ml-2">حساب جديد</a>
                        @endguest

                        @auth
                            <div class="relative ml-3">
                                <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition duration-200 focus:outline-none">
                                    <span>👤</span>
                                    <span>{{ auth()->user()?->name ?? 'Guest' }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" style="display: none;" class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100 z-50">
                                    <a href="/dashboard" class="block px-4 py-2 text-sm transition duration-150 ease-in-out {{ request()->is('dashboard') || request()->is('pro-dashboard') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">لوحة التحكم</a>
                                    <form method="POST" action="/logout" class="block w-full m-0 p-0">
                                        @csrf
                                        <button type="submit" class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-150 ease-in-out focus:outline-none cursor-pointer border-0 bg-transparent">تسجيل الخروج</button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-blue-600 focus:outline-none transition duration-150">
                            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="mobileMenuOpen" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition style="display: none;" class="md:hidden border-t border-gray-100 bg-white shadow-inner absolute w-full z-40">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="/" class="block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->is('/') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">الرئيسية</a>
                    <a href="/search" class="block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->is('search') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">البحث</a>
                    <a href="/requests" class="block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->is('requests') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">الطلبات</a>
                </div>
                
                <div class="pt-4 pb-3 border-t border-gray-200">
                    @guest
                        <div class="px-5 flex flex-col gap-2">
                            <a href="/login" class="block w-full text-center px-4 py-2 border border-blue-600 rounded-md shadow-sm text-base font-medium text-blue-600 bg-white hover:bg-blue-50 transition duration-150">تسجيل الدخول</a>
                            <a href="/register" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150">حساب جديد</a>
                        </div>
                    @endguest
                    
                    @auth
                        <div class="px-5 flex items-center gap-3 mb-3">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">👤</span>
                            </div>
                            <div>
                                <div class="text-base font-medium text-gray-800">{{ auth()->user()?->name ?? 'Guest' }}</div>
                            </div>
                        </div>
                        <div class="px-2 space-y-1">
                            <a href="/dashboard" class="block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->is('dashboard') || request()->is('pro-dashboard') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">لوحة التحكم</a>
                            <form method="POST" action="/logout" class="block m-0 p-0">
                                @csrf
                                <button type="submit" class="w-full text-right px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 transition duration-150 focus:outline-none cursor-pointer border-0 bg-transparent">تسجيل الخروج</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>
        
        @livewireScripts
    </body>
</html>
