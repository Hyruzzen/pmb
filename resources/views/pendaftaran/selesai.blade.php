<x-app-layout>
    <div class="py-10 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white p-8 md:p-12 rounded-2xl shadow text-center">

                {{-- Step Indicator --}}
                <x-step-pmb step="4" />

                {{-- Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 flex items-center justify-center
                                rounded-full bg-green-100 text-green-700 text-3xl">
                        ✓
                    </div>
                </div>

                {{-- Title --}}
                <h1 class="text-2xl font-bold text-gray-800 mb-3">
                    Pendaftaran Berhasil
                </h1>

                {{-- Description --}}
                <p class="text-gray-600 max-w-xl mx-auto mb-8">
                    Terima kasih telah melengkapi seluruh tahapan pendaftaran.
                    Data kamu telah kami terima dan akan diproses oleh panitia PMB.
                </p>

                {{-- Info Box --}}
                <div class="bg-gray-50 p-6 rounded-lg text-left mb-8">
                    <h2 class="font-semibold text-gray-800 mb-3">
                        Informasi Selanjutnya
                    </h2>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>📢 Pengumuman akan ditampilkan di dashboard</li>
                        <li>📧 Pastikan email aktif untuk notifikasi</li>
                        <li>☎️ Hubungi panitia PMB jika mengalami kendala</li>
                    </ul>
                </div>

                {{-- CTA --}}
                <a href="{{ route('dashboard') }}"
                   class="inline-block bg-blue-800 hover:bg-blue-900
                          text-white px-10 py-3 rounded-full font-semibold
                          transition shadow hover:shadow-lg">
                    Kembali ke Dashboard
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
