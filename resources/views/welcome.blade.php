<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>PMB Masoem University</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-blue-800 shadow">
        <div class="max-w-6xl mx-auto px-8 py-4 flex justify-between items-center">

            <div class="flex items-center gap-3 text-white font-semibold text-lg">
                <img src="{{ asset('images/logo-utama.png') }}" class="h-8" alt="Logo">
                PMB Masoem University
            </div>

            <div class="flex gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-white text-blue-800 px-4 py-1 rounded-full">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-white border border-white px-4 py-1 rounded-full">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-white text-blue-800 px-4 py-1 rounded-full">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="min-h-screen flex flex-col justify-center items-center text-center px-6">

        <img src="{{ asset('images/logo-utama.png') }}"
             class="h-20 mb-6"
             alt="Logo Masoem University">

        <h1 class="text-3xl md:text-4xl font-semibold mb-6 text-gray-800">
            Penerimaan Mahasiswa Baru
        </h1>

        <p class="max-w-3xl text-base md:text-lg leading-relaxed text-gray-700">
            Hallo para calon mahasiswa bahasiswa baru Universitas Ma’soem!
            Kami mengundang anda untuk bergabung dengan kami, disini tersedia 5 Fakultas
            dengan 11 Program Study yang siap kamu pilih sesuai dengan minat dan bakat.
            Pendaftaran untuk gelombang pertama akan dimulai pada tanggal 
            <span class="font-semibold">10 Januari 2026.</span>.
            Pantau terus Media Sosial kami untuk info menarik lainnya.
        </p>

        <div class="mt-14 flex items-center gap-4">
            <p class="text-gray-600 text-lg">
              Belum punya akun?
            </p>

         <a href="{{ route('register') }}"
                 class="bg-blue-800 hover:bg-blue-900 transition
              text-white px-8 py-3 rounded-full
              text-lg font-semibold shadow">
              Daftar Sekarang
          </a>
        </div>
        <div class="mt-14 flex flex-col sm:flex-row items-center gap-4">



    </section>

</body>
</html>
