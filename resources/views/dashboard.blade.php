<x-app-layout>
    <div class="py-8 md:py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-900">Halo, {{ Auth::user()->name }}</h1>
                <p class="text-blue-600 mt-2">Dashboard Pendaftaran Calon Mahasiswa • Tahun Akademik 2026/2027</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Status Pendaftaran</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">{{ auth()->user()->status_pendaftaran ?? 'Belum Dimulai' }}</p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Nama Lengkap</p>
                            <p class="text-xl font-bold text-gray-900 mt-2">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Email Terdaftar</p>
                            <p class="text-sm font-semibold text-gray-900 mt-2 break-all">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-xl font-bold text-blue-900 mb-6">Progress Pendaftaran</h2>
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center gap-3 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium text-green-900">Data Diri</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-300">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9a2 2 0 104 0A2 2 0 005 9z"></path></svg>
                        <span class="font-medium text-gray-600">Program Studi</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-300">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9a2 2 0 104 0A2 2 0 005 9z"></path></svg>
                        <span class="font-medium text-gray-600">Upload Berkas</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-300">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9a2 2 0 104 0A2 2 0 005 9z"></path></svg>
                        <span class="font-medium text-gray-600">Konfirmasi</span>
                    </div>
                </div>

                @if(auth()->user()->status_pendaftaran === 'selesai')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 flex items-start gap-4 mb-6">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <div>
                            <p class="font-semibold text-green-900">Pendaftaran Selesai!</p>
                            <p class="text-green-700 text-sm mt-1">Terima kasih telah menyelesaikan proses pendaftaran. Silakan tunggu pengumuman hasil seleksi.</p>
                        </div>
                    </div>
                @elseif(auth()->user()->status_pendaftaran)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <p class="text-gray-700">Anda sedang berada di tahap <strong class="text-blue-600">{{ auth()->user()->status_pendaftaran }}</strong>.</p>
                        <a href="{{ route('pendaftaran.create') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">Lanjutkan Pendaftaran</a>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <p class="text-gray-700 mb-4">Mulai proses pendaftaran calon mahasiswa Anda sekarang.</p>
                        <a href="{{ route('pendaftaran.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold text-lg transition transform hover:scale-105">Mulai Pendaftaran</a>
                    </div>
                @endif
            </div>

        </div>

        {{-- Informasi Penting --}}
        <div class="bg-white rounded-lg shadow-lg p-8 mt-8">
            <h2 class="text-xl font-bold text-blue-900 mb-4">Informasi Penting</h2>

            <ul class="text-gray-600 space-y-2 text-sm">
                <li>📅 Pendaftaran Gelombang 1: 10 Jan – 30 Mar 2026</li>
                <li>📢 Pengumuman hasil seleksi akan diinformasikan melalui dashboard</li>
                <li class="text-gray-700">📞 Kontak PMB: 0834-1234-1234</li>
            </ul>
        </div>
        </div>
    </div>
</x-app-layout>