<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon-siorek.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex items-center justify-center bg-gradient-to-b from-gray-200 to-blue-500">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
        <div class="text-center mb-6 flex flex-col items-center">
            <img src="{{asset('images/siorek.png')}}" alt="" class="w-48 ">
            <h2 class="text-gray-600 text-lg font-semibold mt-2">Login</h2>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <p class="font-bold">Login Gagal</p>
                    <p class="text-sm">{{ $errors->first('username') }}</p>
                </div>
            @endif

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" placeholder="example" required class="w-full px-3 py-2 rounded-md border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent bg-gray-50" value="{{ old('username') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="********" required class="w-full px-3 py-2 rounded-md border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent bg-gray-50">
            </div>

            <button type="submit" class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md transition">Login </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-5">Tidak Memiliki Akun?<span class="text-gray-700 font-medium"><br>Hubungi Rektorat Untuk Pengajuan Akun</span></p>
    </div>
</body>
</html>