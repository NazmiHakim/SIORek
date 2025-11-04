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
            <header class= "bg-white p-2 flex justify-between sticky top-0 ">

                <button @click="isSidebarOpen = !isSidebarOpen" class="text-gray-700 hover:text-blue-600 p-2 rounded-md"><i class="fa-solid fa-bars fa-xl"></i></button>

                <div class="flex gap-4">
                    <div class="text-end">
                        <h3 class="text-sm font-semibold">Himpunan Mahasiswa Teknologi Informasi</h3>
                        <p class="text-sm text-gray-600">Himpunan Mahasiswa</p>
                    </div>
                    <img src="{{asset('images/Logo HMTI.png')}}" alt="" class="w-10">
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