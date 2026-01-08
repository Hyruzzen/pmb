index.blade.pmb

@extends('layouts.app')

@section('title', 'PMB Masoem University')

@section('content')
<section class="flex flex-col items-center text-center py-20 px-6">
    
    <img src="{{ asset('images/logo-utama.png') }}" class="h-20 mb-6" alt="Logo">

    <h1 class="text-3xl font-semibold mb-8">
        Masoem University
    </h1>

    <p class="max-w-3xl text-lg leading-relaxed text-gray-700">
        Hallo para calon mahasiswa bahasiswa baru Universitas Ma’soem!
        Kami mengundang anda untuk bergabung dengan kami, disini tersedia 5 Fakultas
        dengan 11 Program Study yang siap kamu pilih sesuai dengan minat dan bakat.
        Pendaftaran untuk gelombang pertama akan dimulai pada tanggal 10 Januari 2026.
        Pantau terus Media Sosial kami untuk info menarik lainnya.
    </p>

    <div class="mt-16 flex items-center gap-6">
        <span class="text-gray-600">
            Belum punya akun? Register disini!
        </span>

        <a href="/register"
           class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold">
            Register
        </a>
    </div>

</section>
@endsection
