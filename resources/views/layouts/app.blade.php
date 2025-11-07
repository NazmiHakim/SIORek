<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | SIOREK</title>    
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon-siorek.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/a3c61f64a4.js" crossorigin="anonymous"></script>
</head>
<body class="bg-[#E9E9E9] font-sans">
    
    <div class="relative min-h-screen lg:flex" x-data="{ isSidebarOpen: true }" x-cloak>
        
        @include('layouts.sidebar')
        <div class="flex-1 transition-all duration-300 " :class="isSidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">
            <header class= "bg-white p-2 flex justify-between items-center sticky top-0 z-30">

            <!-- tombol buka dan tutup  -->
            <button @click="isSidebarOpen = !isSidebarOpen" class="text-gray-700 hover:text-blue-600 p-2 rounded-md">
                <i class="fa-solid fa-bars fa-xl"></i>
            </button>

            <!-- dropdown profil -->
            <div x-data="{ isProfileOpen: false }" class="relative">
                
                <!-- tombol buka dropdown -->
                <button @click="isProfileOpen = !isProfileOpen" class="flex items-center gap-4">
                    <div class="text-end">
                        <!-- mengambil nama user login -->
                        <h3 class="text-sm font-semibold">{{ Auth::user()->username }}</h3> 
                        <!-- juga mengambil role user login -->
                        <p class="text-sm text-gray-600 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}&background=random" alt="{{ Auth::user()->username }}" class="w-10 h-10 rounded-full">
                </button>

                <!-- konten dropdownnya -->
                <div x-show="isProfileOpen"
                     @click.away="isProfileOpen = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     style="display: none;"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                    
                    <!-- link profil (buatkah ni?) -->
                    <!-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profil Saya
                    </a> -->

                    <!-- tombol logout (ini form) -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>
            <main class="  p-8">
    
                @yield('content')
    
            </main>

        </div>

        <div x-show="isSidebarOpen" @click="isSidebarOpen = false" 
             class="fixed inset-0 z-10 bg-black bg-opacity-50 transition-opacity lg:hidden"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>
    </div>
</body>
</html>