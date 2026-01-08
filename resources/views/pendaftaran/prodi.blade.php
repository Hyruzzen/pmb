<x-app-layout>
    <div class="py-8 md:py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 md:p-10 rounded-xl shadow-md">

                {{-- STEP --}}
                <x-step-pmb step="2" />

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">
                        Pilih Program Studi
                    </h1>
                    <p class="text-gray-600">
                        Pilih fakultas terlebih dahulu untuk menampilkan program studi
                    </p>
                </div>

                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('pendaftaran.prodi.store') }}">
                    @csrf

                    <div class="space-y-6">

                        {{-- Fakultas --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Fakultas <span class="text-red-500">*</span>
                            </label>
                            <select id="fakultas" name="fakultas" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                       focus:border-blue-600 focus:ring-2 focus:ring-blue-600">
                                <option value="">-- Pilih Fakultas --</option>
                                @if(isset($fakultas) && $fakultas->isNotEmpty())
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                                    @endforeach
                                @else
                                    <option value="komputer">Fakultas Ilmu Komputer</option>
                                    <option value="ekonomi">Fakultas Ekonomi</option>
                                @endif
                            </select>
                        </div>

                        {{-- Program Studi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Program Studi <span class="text-red-500">*</span>
                            </label>
                            <select id="prodi" name="prodi" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                       bg-gray-100 pointer-events-none">
                                <option value="">-- Pilih Program Studi --</option>
                            </select>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="mt-10 pt-6 border-t border-gray-100
                                flex flex-col sm:flex-row justify-between items-center gap-4">

                        <a href="{{ route('pendaftaran.create') }}"
                           class="text-gray-600 hover:text-gray-900 hover:underline">
                            ← Kembali ke Data Diri
                        </a>

                        <button type="submit"
                            class="bg-blue-800 hover:bg-blue-900 text-white
                                   px-8 py-3 rounded-lg font-semibold transition
                                   shadow-md hover:shadow-lg w-full sm:w-auto">
                            Simpan & Lanjutkan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        const fakultas = document.getElementById('fakultas');
        const prodi = document.getElementById('prodi');

        const dataProdi = {
            @if(isset($fakultas) && $fakultas->isNotEmpty())
                @foreach($fakultas as $f)
                    {{ $f->id }}: [
                        @foreach($f->programStudis as $p)
                            { id: {{ $p->id }}, name: "{!! addslashes($p->nama_prodi) !!}" },
                        @endforeach
                    ],
                @endforeach
            @else
                komputer: [
                    { id: 'si', name: "Sistem Informasi" },
                    { id: 'ka', name: "Komputerisasi Akuntansi" },
                    { id: 'bd', name: "Bisnis Digital" },
                ],
                ekonomi: [
                    { id: 'man', name: "Manajemen" },
                    { id: 'ak', name: "Akuntansi" },
                    { id: 'ekp', name: "Ekonomi Pembangunan" },
                ],
            @endif
        };

        fakultas.addEventListener('change', function () {
            prodi.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
            prodi.classList.add('bg-gray-100', 'pointer-events-none');

            if (dataProdi[this.value]) {
                dataProdi[this.value].forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.name;
                    prodi.appendChild(opt);
                });

                prodi.classList.remove('bg-gray-100', 'pointer-events-none');
            }
        });
    </script>
</x-app-layout>
