<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h1 class="text-2xl font-semibold text-gray-800">
                Halo, {{ Auth::user()->name }}
            </h1>
            <p class="text-gray-600 mt-1">
                Tahun Akademik 2026 / 2027
            </p>
            <p class="mt-4">
                <x-status-pendaftaran />
            </p>
        </div>

        {{-- Progress Pendaftaran --}}
       

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Progress Pendaftaran
            </h2>
             
            <ul class="space-y-3">
                <li class="flex items-center gap-3">
                    <span class="text-green-600 font-bold">✔</span>
                    Isi Data Diri
                </li>
                <li class="flex items-center gap-3 text-gray-400">
                    <span>○</span>
                    Pilih Program Studi
                </li>
                <li class="flex items-center gap-3 text-gray-400">
                    <span>○</span>
                    Upload Berkas
                </li>
                <li class="flex items-center gap-3 text-gray-400">
                    <span>○</span>
                    Submit Pendaftaran
                </li>
            </ul>
        </div>

        {{-- CTA Utama --}}
        <div class="bg-blue-800 p-6 rounded-lg shadow text-white">
            <h2 class="text-xl font-semibold mb-2">
                Lengkapi Formulir Pendaftaran
            </h2>
            <p class="mb-4 text-blue-100">
                Silakan lengkapi data pendaftaran untuk melanjutkan proses PMB.
            </p>

            <a href="{{ route('pendaftaran.create') }}"
                class="inline-block bg-white text-blue-800 px-6 py-2 rounded-full
                font-semibold hover:bg-gray-100 transition">
                Lanjutkan Pendaftaran
            </a>


        </div>

        {{-- Informasi PMB --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">
                Informasi Penting
            </h2>

            <ul class="text-gray-600 space-y-2 text-sm">
                <li>📅 Pendaftaran Gelombang 1: 10 Jan – 30 Mar 2026</li>
                <li>📢 Pengumuman hasil seleksi akan diinformasikan melalui dashboard</li>
                <li>☎️ Kontak PMB: 0834-1234-1234</li>
            </ul>
        </div>

        </div>
    </div>
</x-app-layout>