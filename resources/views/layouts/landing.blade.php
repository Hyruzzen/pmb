<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PMB Online</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-800 shadow">
        <div class="max-w-6xl mx-auto px-8 py-4 flex justify-between items-center">

            <div class="flex items-center gap-3 text-white font-semibold">
                <img src="{{ asset('images/logo.png') }}" class="h-8">
                PMB Online
            </div>

            <div class="flex gap-3">
                <a href="{{ route('register') }}"
                   class="bg-white text-blue-800 px-4 py-1 rounded-full">
                    Register
                </a>

                <a href="{{ route('login') }}"
                   class="border border-white text-white px-4 py-1 rounded-full">
                    Login
                </a>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

</body>
</html>
