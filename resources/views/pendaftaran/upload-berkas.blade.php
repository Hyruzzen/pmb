<x-app-layout>
    <div class="py-8 md:py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white p-6 md:p-10 rounded-xl shadow-md">

                <!-- Step Indicator -->
                <x-step-pmb step="3" />

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">
                        Upload Berkas
                    </h1>
                    <p class="text-gray-600">
                        Unggah dokumen yang dibutuhkan untuk pendaftaran
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('pendaftaran.upload.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">

                        <!-- KTP -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                KTP <span class="text-red-500">*</span>
                            </label>
                            <input type="file"
                                   name="ktp"
                                   required
                                   class="w-full rounded-lg border border-gray-300
                                          focus:border-blue-600 focus:ring-2 focus:ring-blue-600">
                        </div>

                        <!-- Ijazah -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Ijazah / Surat Keterangan Lulus <span class="text-red-500">*</span>
                            </label>
                            <input type="file"
                                   name="ijazah"
                                   required
                                   class="w-full rounded-lg border border-gray-300
                                          focus:border-blue-600 focus:ring-2 focus:ring-blue-600">
                        </div>

                        <!-- Pas Foto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pas Foto <span class="text-red-500">*</span>
                            </label>
                            <input type="file"
                                   name="pas_foto"
                                   required
                                   accept="image/*"
                                   class="w-full rounded-lg border border-gray-300
                                          focus:border-blue-600 focus:ring-2 focus:ring-blue-600">
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="mt-10 pt-6 border-t border-gray-100
                                flex flex-col sm:flex-row justify-between items-center gap-4">

                        <a href="{{ route('pendaftaran.prodi') }}"
                           class="text-gray-600 hover:text-gray-900 hover:underline">
                            ← Kembali ke Program Studi
                        </a>

                        <button type="submit"
                                class="bg-blue-800 hover:bg-blue-900 text-white
                                       px-8 py-3 rounded-lg font-semibold transition
                                       shadow-md hover:shadow-lg">
                            Simpan & Lanjutkan
                        </button>

                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
